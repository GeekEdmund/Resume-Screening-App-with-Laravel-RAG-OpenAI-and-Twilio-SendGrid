<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OpenAIService;
use App\Services\RAGService;
use App\Services\SendGridService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Smalot\PdfParser\Parser;

class ResumeController extends Controller
{
    protected $openAIService;
    protected $ragService;
    protected $sendGridService;

    public function __construct(OpenAIService $openAIService, RAGService $ragService, SendGridService $sendGridService)
    {
        $this->openAIService = $openAIService;
        $this->ragService = $ragService;
        $this->sendGridService = $sendGridService;
    }

    public function uploadResume(Request $request)
    {
        try {
            $request->validate([
                'resume' => 'required|file|mimes:pdf|max:2048',
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
            ]);

            $resume = $request->file('resume');
            $path = $resume->store('resumes');

            $applicantData = [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'resume_path' => $path,
            ];

            $assessment = $this->screenResume($applicantData);

            return redirect()->back()->with('success', 'Thank you for applying with us at OldFactor. We\'ll get back to you soon!');
        } catch (\Exception $e) {
            Log::error('Resume upload failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to process resume. Please try again later.'], 500);
        }
    }

    private function screenResume($applicantData)
    {
        try {
            $resumeContent = $this->extractTextFromPdf($applicantData['resume_path']);

            $assessment = $this->ragService->processResume($resumeContent);

            // Determine if the applicant meets the requirements
            $isSuccessful = strpos(strtolower($assessment), 'meets the requirements') !== false;

            if ($isSuccessful) {
                // Forward successful applicant to recruiter
                $this->sendGridService->forwardSuccessfulApplicant(env('RECRUITER_EMAIL'), $applicantData, $assessment);
            } else {
                // Send rejection email to applicant
                $this->sendGridService->sendRejectionEmail($applicantData['email'], $applicantData['name']);
            }

            return $assessment;
        } catch (\Exception $e) {
            Log::error('Resume screening error: ' . $e->getMessage());
            return 'Unable to complete resume screening due to an error.';
        }
    }

    private function extractTextFromPdf($path)
    {
        try {
            $parser = new Parser();
            $pdf = $parser->parseFile(Storage::path($path));
            $text = $pdf->getText();

            if (empty($text)) {
                throw new \Exception("Failed to extract text from PDF");
            }

            // Basic cleaning: remove excess whitespace and non-printable characters
            $text = preg_replace('/\s+/', ' ', $text);
            $text = preg_replace('/[^\P{C}\n]+/u', '', $text);

            return mb_substr($text, 0, 15000); // Limit to 15000 characters to avoid token limits
        } catch (\Exception $e) {
            Log::error('PDF extraction failed: ' . $e->getMessage());
            return 'Failed to extract text from resume.';
        }
    }
}
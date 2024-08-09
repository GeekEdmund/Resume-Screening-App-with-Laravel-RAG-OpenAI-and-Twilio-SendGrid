<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class RAGService
{
    protected $openAIService;
    protected $jobRequirements;

    public function __construct(OpenAIService $openAIService)
    {
        $this->openAIService = $openAIService;
        $this->jobRequirements = 
            "Education: Bachelor's or Master's degree in computer science, engineering, mathematics, or related fields; coursework in machine learning or data science is preferred.\n" .
            "Programming: 2+ years of experience with Python, R, or similar languages; proficiency in TensorFlow, PyTorch, or other ML frameworks.\n" .
            "Machine Learning: 2+ years of practical experience with ML algorithms, model deployment, and optimization.\n" .
            "Software Engineering: Familiarity with Git, Agile methodologies, and collaborative tools; experience in software development teams for at least 2-3 years.\n" .
            "Problem-Solving: Strong analytical skills, with a track record of solving complex problems using machine learning techniques.\n" .
            "Communication: Effective communicator across technical and non-technical audiences; experience working in cross-functional teams.\n" .
            "Portfolio: Demonstrated projects in machine learning through work experience, academic research, or personal projects; contributions to open-source projects or participation in hackathons.";
    }

    public function processResume($resumeText)
    {
        try {
            // Combine the resume text with the job requirements
            $context = $this->combineContext($resumeText);

            // Generate the final assessment using the combined context
            $assessment = $this->generateAssessment($context);

            return $assessment;
        } catch (\Exception $e) {
            Log::error('RAG processing failed: ' . $e->getMessage());
            return 'Unable to complete resume assessment due to an error.';
        }
    }

    private function combineContext($resumeText)
    {
        $context = "Job Requirements:\n{$this->jobRequirements}\n\n";
        $context .= "Applicant's Resume:\n$resumeText\n\n";
        return $context;
    }

    private function generateAssessment($context)
    {
        $messages = [
            ['role' => 'system', 'content' => 'You are an AI assistant that evaluates job applicants based on their resumes and job requirements for a machine learning engineer position.'],
            ['role' => 'user', 'content' => $context . "Based on the job requirements and the applicant's resume, evaluate if the applicant meets the requirements for the machine learning engineer position. Provide a detailed analysis, addressing each requirement separately and giving an overall assessment at the end."]
        ];

        $response = $this->openAIService->generateChatCompletion($messages);
        
        if (isset($response['choices'][0]['message']['content'])) {
            return $response['choices'][0]['message']['content'];
        } else {
            throw new \Exception('Unexpected response format from OpenAI API');
        }
    }
}
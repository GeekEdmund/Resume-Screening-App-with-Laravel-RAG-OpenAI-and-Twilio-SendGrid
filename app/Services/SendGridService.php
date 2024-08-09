<?php

namespace App\Services;

use SendGrid\Mail\Mail;
use Illuminate\Support\Facades\Log;

class SendGridService
{
    protected $sendgrid;

    public function __construct()
    {
        $this->sendgrid = new \SendGrid(env('SENDGRID_API_KEY'));
    }

    public function sendRejectionEmail($to, $name)
    {
        $email = new Mail();
        $email->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        $email->setSubject("Application Status Update");
        $email->addTo($to, $name);
        $email->addContent("text/plain", "Dear $name,\n\nThank you for your interest in our company. After careful consideration, we regret to inform you that we will not be moving forward with your application at this time. We appreciate your time and effort in applying.\n\nBest regards,\nRecruitment Team");

        try {
            $response = $this->sendgrid->send($email);
            Log::info('Rejection email sent to ' . $to . '. Status: ' . $response->statusCode());
            return $response->statusCode();
        } catch (\Exception $e) {
            Log::error('Failed to send rejection email: ' . $e->getMessage());
            return false;
        }
    }

    public function forwardSuccessfulApplicant($to, $applicantData, $assessment)
    {
        $email = new Mail();
        $email->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        $email->setSubject("Successful Applicant: " . $applicantData['name']);
        $email->addTo($to);
        
        $contentHtml = "<p>Name: " . htmlspecialchars($applicantData['name']) . "</p>";
        $contentHtml .= "<p>Email: " . htmlspecialchars($applicantData['email']) . "</p>";
        $contentHtml .= "<p>Resume Path: <a href=\"" . htmlspecialchars($applicantData['resume_path']) . "\">View Resume</a></p>";
        $contentHtml .= "<p>Assessment:</p><p>" . nl2br(htmlspecialchars($assessment)) . "</p>";

        $contentPlain = "Name: " . $applicantData['name'] . "\n";
        $contentPlain .= "Email: " . $applicantData['email'] . "\n";
        $contentPlain .= "Resume Path: " . $applicantData['resume_path'] . "\n\n";
        $contentPlain .= "Assessment:\n" . $assessment;

        $email->addContent("text/plain", $contentPlain);
        $email->addContent("text/html", $contentHtml);
        
        try {
            $response = $this->sendgrid->send($email);
            Log::info('Successful applicant email sent to ' . $to . '. Status: ' . $response->statusCode());
            return $response->statusCode();
        } catch (\Exception $e) {
            Log::error('Failed to send successful applicant email: ' . $e->getMessage());
            return false;
        }
    }
}
# Resume Screening Application

This Laravel application provides an automated resume screening process for job applications. It uses AI-powered services to assess resumes and manage the application workflow.

## Features

- Resume upload and storage
- PDF text extraction
- AI-powered resume screening
- Automated email notifications for successful and rejected applicants
- Integration with OpenAI and SendGrid services

## Requirements

- PHP 7.4+
- Laravel 8.x+
- Composer
- OpenAI API key
- SendGrid API key

## Installation

1. Clone the repository:
   ```
   git clone https://github.com/yourusername/resume-screening-app.git
   ```

2. Install dependencies:
   ```
   composer install
   ```

3. Copy `.env.example` to `.env` and configure your environment variables:
   ```
   cp .env.example .env
   ```

4. Generate application key:
   ```
   php artisan key:generate
   ```

5. Configure your database in the `.env` file.

6. Run migrations:
   ```
   php artisan migrate
   ```

## Running the Application

To start the Laravel development server, run the following command in your terminal:

```
php artisan serve
```

This will start the server, typically at `http://localhost:8000`. You can now access the application by visiting this URL in your web browser.

## Configuration

Ensure you set the following environment variables in your `.env` file:

- `OPENAI_API_KEY`: Your OpenAI API key
- `SENDGRID_API_KEY`: Your SendGrid API key
- `RECRUITER_EMAIL`: Email address of the recruiter to receive successful applications

## Usage

The main functionality is handled by the `ResumeController`. Here's a brief overview of its methods:

- `uploadResume`: Handles the resume upload process
- `screenResume`: Processes the uploaded resume using AI services
- `extractTextFromPdf`: Extracts text content from uploaded PDF resumes

## Services

The application uses the following services:

- `OpenAIService`: Interacts with the OpenAI API
- `RAGService`: Implements the Retrieval-Augmented Generation (RAG) process for resume screening
- `SendGridService`: Manages email notifications using SendGrid

## Error Handling

Errors are logged using Laravel's built-in logging system. Check the Laravel log files for any issues during the resume screening process.

## Contributing

Please read [CONTRIBUTING.md](CONTRIBUTING.md) for details on our code of conduct and the process for submitting pull requests.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.

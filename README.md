# Contact Me API

A Laravel-based REST API that processes contact form submissions and sends emails. This API is designed to handle contact form data from portfolio websites and forward messages via email with proper formatting and CC functionality.

## Features

-   Simple REST API endpoint for contact form submissions
-   Automatic email forwarding with custom formatting
-   CC functionality to include the sender in email communications
-   Built-in security with Laravel's validation system

## API Endpoint

### POST `/api/`

Processes contact form submissions and sends formatted emails.

**Request Body:**

```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "subject": "Inquiry about services",
    "message": "Hello, I'm interested in your services..."
}
```

**Response (Success):**

```json
{
    "message": "Email sent successfully"
}
```

**Response (Validation Error):**

```json
{
    "error": "Validation failed",
    "messages": {
        "email": ["The email field is required."]
    }
}
```

## Installation & Setup

1. **Clone the repository**

    ```bash
    git clone <repository-url>
    cd contact-me-api
    ```

2. **Install dependencies**

    ```bash
    composer install
    ```

3. **Configure environment**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Set up email configuration**

    Edit `.env` file:

    ```env
    CONTACT_EMAIL="your-email@example.com"
    REQUEST_DOMAIN="yourfrontenddomain.com"

    # For production, configure your mail driver:
    MAIL_MAILER=smtp
    MAIL_HOST=smtp.mailtrap.io
    MAIL_PORT=2525
    MAIL_USERNAME=your_username
    MAIL_PASSWORD=your_password
    MAIL_FROM_ADDRESS="noreply@yoursite.com"
    MAIL_FROM_NAME="Contact Form"
    ```

5. **Run the application**

    ```bash
    php artisan serve
    ```

    The API will be available at `http://localhost:8000/api/`

## Email Format

When a contact form is submitted, the API sends an email with:

-   **To:** Your configured contact email
-   **CC:** The sender's email address
-   **Subject:** `{Name}: {Subject}` (e.g., "John Doe: Inquiry about services")
-   **Reply-To:** Sender's email for easy replies
-   **Body:** The message content as provided

## Validation Rules

-   `name`: Required, string, max 255 characters
-   `email`: Required, valid email format, max 255 characters
-   `subject`: Optional, string, max 255 characters
-   `message`: Required, string, max 5000 characters

## Development

**Start development server:**

```bash
php artisan serve
```

**Test the API:**

```bash
curl -X POST http://localhost:8000/api \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "subject": "Test Subject",
    "message": "This is a test message."
  }'
```

## Under the Hood

### Architecture Overview

This API is built using Laravel 12 and follows a clean, modular architecture:

**1. Routing (`routes/api.php`)**

-   Defines a single POST route that maps to the ContactController
-   Uses Laravel's built-in API routing with automatic `/api/` prefix

**2. Controller Layer (`app/Http/Controllers/ContactController.php`)**

-   Handles HTTP request processing and response formatting
-   Implements form validation using Laravel's Validator facade
-   Manages email sending logic with error handling
-   Returns structured JSON responses for API consumers

**3. CORS Configuration (`config/cors.php`)**

-   Uses Laravel's built-in CORS middleware for handling Cross-Origin Resource Sharing
-   Configured with environment-based allowed origins via REQUEST_DOMAIN
-   Processes preflight OPTIONS requests automatically
-   Supports credentials and custom headers

**4. Email Integration**

-   Uses Laravel's Mail facade for email functionality
-   Leverages Laravel's built-in mail drivers (SMTP, log, etc.)
-   Implements proper email formatting with CC and Reply-To headers
-   Supports configurable recipient via environment variables

### Request Flow

1. **Request Reception**: Laravel receives the POST request and routes it through the API middleware stack
2. **CORS Processing**: Laravel's built-in CORS middleware adds necessary headers for cross-origin requests
3. **Controller Processing**: ContactController validates the incoming JSON data
4. **Email Composition**: If validation passes, the controller formats and sends the email
5. **Response Generation**: Returns appropriate JSON response (success or error)

### Key Design Decisions

**Email Formatting**: The subject line uses the format `Name: Subject` to make it immediately clear who sent the message and what it's about. If no subject is provided, it defaults to "Contact Form".

**CC Implementation**: The sender is CC'd on the email to create a paper trail and allow them to reference their original message.

**Validation Strategy**: Server-side validation ensures data integrity and provides detailed error messages for frontend handling.

**CORS Configuration**: Environment-based origin configuration allows specific frontend domains to use the API while maintaining security.

**Error Handling**: Comprehensive try-catch blocks ensure graceful failure and meaningful error responses.

### Security Considerations

-   Input validation prevents malicious data injection
-   Laravel's built-in CSRF protection (disabled for API routes)
-   Email content is treated as plain text to prevent HTML injection
-   Rate limiting can be added for production use
-   Environment-based configuration keeps sensitive data secure

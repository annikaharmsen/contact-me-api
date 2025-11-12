# Contact Me API

A Laravel REST API that processes contact form submissions and delivers emails to both the recipient and sender. Built for portfolio websites and client projects requiring reliable, secure contact form handling with professional email notifications.

## Features

- **Dual Email System** - Sends confirmation to sender and notification to recipient
- **Smart Email Headers** - Configures Reply-To headers for seamless communication flow
- **Request Validation** - Server-side validation with detailed error responses
- **CORS Support** - Environment-based origin configuration for frontend integration
- **Error Logging** - Comprehensive logging to both file and email channels
- **Professional Templates** - Clean, formatted email templates for both notification types

## Tech stack

- **Backend**: Laravel 12.x
- **Runtime**: PHP 8.2+
- **Email**: Laravel Mail with SMTP support
- **Frontend Assets**: Vite 7, Tailwind CSS 4
- **Package Manager**: Composer 2.x

## Installation

**Prerequisites:**
- PHP 8.2 or higher
- Composer
- SMTP server credentials (Gmail, SendGrid, Mailgun, etc.)

**Setup:**

```bash
# Clone the repository
git clone <repository-url>
cd contact-me-api

# Install dependencies
composer install

# Create environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Create SQLite database (optional, for sessions/cache)
touch database/database.sqlite
```

## Configuration

Edit your `.env` file with the following required values:

```env
# Contact API Configuration
CONTACT_ADDRESS="your-email@example.com"
CONTACT_NAME="Your Name"
REQUEST_DOMAIN="yourfrontenddomain.com"

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=sender-email@example.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=sender-email@example.com
MAIL_FROM_NAME="Your Name"
```

**Configuration details:**

- `CONTACT_ADDRESS` - Your email where contact form messages are sent
- `CONTACT_NAME` - Your name for email personalization
- `REQUEST_DOMAIN` - Frontend domain allowed for CORS (without protocol)
- Mail settings - Your SMTP provider credentials

## Usage

**Start the development server:**

```bash
php artisan serve
```

The API will be available at `http://localhost:8000`

**API endpoint:**

```
POST /api/
```

**Request format:**

```json
{
    "name": "Jane Smith",
    "email": "jane@example.com",
    "subject": "Project inquiry",
    "message": "I'd like to discuss a potential project..."
}
```

**Success response (200):**

```json
{
    "message": "Email sent successfully"
}
```

**Validation error response (422):**

```json
{
    "error": "Validation failed",
    "messages": {
        "email": ["The email field must be a valid email address."],
        "message": ["The message field is required."]
    }
}
```

**Testing with cURL:**

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

## How it works

When a contact form is submitted, the API sends two emails:

**1. Contact notification (to you)**
- **To**: Your configured email (CONTACT_ADDRESS)
- **From**: Mail system (MAIL_FROM_ADDRESS) with sender's name
- **Reply-To**: Sender's email for easy replies
- **Subject**: Form subject or "Contact Form"
- **Body**: Message content with sender details

**2. Confirmation email (to sender)**
- **To**: Sender's email address
- **From**: Mail system (MAIL_FROM_ADDRESS)
- **Reply-To**: Your contact email (CONTACT_ADDRESS)
- **Subject**: "Confirmation: your message to [Your Name] has been sent"
- **Body**: Thank you message confirming receipt

This dual email system creates a communication trail and provides better user experience.

## Validation rules

| Field | Rules |
|-------|-------|
| name | Required, string, max 255 characters |
| email | Required, valid email format, max 255 characters |
| subject | Optional, string, max 255 characters |
| message | Required, string, max 5000 characters |

## Architecture

**Request flow:**

1. Laravel receives POST request and routes through API middleware
2. CORS middleware validates origin against REQUEST_DOMAIN
3. ContactController validates incoming JSON data
4. If validation passes, two emails are composed and sent
5. JSON response returned (success or error)

**Key files:**

- `routes/api.php` - API route definition
- `app/Http/Controllers/ContactController.php` - Request handling and validation
- `app/Mail/ContactFormMail.php` - Contact notification mailable
- `app/Mail/ConfirmationMail.php` - Sender confirmation mailable
- `config/cors.php` - CORS configuration

## Security

- Input validation prevents malicious data injection
- Email content treated as plain text to prevent HTML injection
- Environment-based CORS configuration restricts allowed origins
- Laravel's built-in security features (SQL injection protection, XSS filtering)
- Rate limiting recommended for production deployment

## License

This project is licensed under the MIT License.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request. For major changes, please open an issue first to discuss what you would like to change.

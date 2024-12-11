# Laravel Exception to Discord

This open-source Laravel project automatically sends detailed exception information to a Discord channel. It serves two main purposes:

1. **Global Exception Handling**  
   Automatically captures all unhandled exceptions in the application and sends a detailed report to Discord.

2. **Custom Exception Reporting**  
   Allows developers to send custom exception messages from `try-catch` blocks, including class name, method, line number, and more.

### Example 
```php
try {
    // Your code here
} catch (\Exception $e) {
    $this->dataLogger->logException($e, __CLASS__, __METHOD__, __LINE__);
}
```

---

## Features

- Real-time exception alerts sent to a Discord channel.
- Supports both global exception handling and custom `try-catch` exception reporting.
- Provides detailed information such as the exception message, file, line number, and stack trace.

---

## Getting Started

### 1. Clone the Repository

Clone the project to your local environment:

```bash
git https://github.com/engbeekin/Laravel-Discord-Exception-Handler.git
cd laravel-exception-to-discord
```
### 2. Set Up the Environment
Copy the .env.example file to .env:
```bash
Copy the .env.example file to .env:
```
Add your Discord webhook URL to the .env file:
```bash
DISCORD_WEBHOOK_URL=https://discord.com/api/webhooks/your-webhook-id/your-webhook-token
```
### 3. Install Dependencies
Run the following commands to install Laravel dependencies:

```bash
composer install
php artisan key:generate
```
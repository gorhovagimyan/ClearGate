# Laravel API Authentication Project

## Overview

This project is a Laravel-based API authentication system that uses token-based authentication instead of traditional CSRF tokens. It provides a secure way to authenticate users and protect API routes.

## Features

- Token-based API authentication
- Stateless authentication for API clients
- Secure token generation and validation
- Protected routes with middleware
- API endpoints for login, logout, and user information
- Support for multiple client applications

## Requirements

- PHP 8.1+
- Laravel 10.x
- MySQL/PostgreSQL database
- Composer

## Installation

1. Clone the repository:
   ```
   git clone https://github.com/yourusername/your-project-name.git
   cd your-project-name
   ```

2. Install dependencies:
   ```
   composer install
   ```

3. Create and configure your environment file:
   ```
   cp .env.example .env
   php artisan key:generate
   ```

4. Configure your database connection in the `.env` file:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. Run migrations:
   ```
   php artisan migrate
   ```

7. Start the development server:
   ```
   php artisan serve
   npm run dev
   ```

## API Endpoints

### Authentication

| Method | Endpoint | Description | Parameters |
|--------|----------|-------------|------------|
| POST | `/login` | Authenticate user and get token | email, password |
| POST | `/logout` | Invalidate token (requires authentication) | - |
| GET | `/user` | Get authenticated user info (requires authentication) | - |

## Authentication Flow

1. Client sends credentials to `/login`
2. Server validates credentials and returns an API token
3. Client includes the token in subsequent requests as a Bearer token
4. Server validates the token for each protected request
5. Client can invalidate the token by calling `/logout`

## Testing with Postman

### Login

1. Create a POST request to `http://your-app-url/login`
2. Set the request body to raw JSON:
   ```json
   {
       "email": "user@example.com",
       "password": "password"
   }
   ```
3. Send the request
4. Save the token from the response

### Accessing Protected Routes

1. Create a request to a protected endpoint (e.g., GET `http://your-app-url/user`)
2. In the Authorization tab, select "Bearer Token"
3. Paste your saved token
4. Send the request

### Logout

1. Create a POST request to `http://your-app-url/logout`
2. Add your token as a Bearer token in the Authorization tab
3. Send the request

## Security Considerations

- Tokens are randomly generated using Laravel's secure `Str::random()` method
- Tokens are stored in the database and can be revoked at any time
- Protected routes are secured with middleware that validates tokens
- Failed authentication attempts return appropriate error messages

## Extending the Project

### Adding New Protected Routes

1. Create your controller:
   ```
   php artisan make:controller Api/YourController
   ```

2. Add your methods to the controller

3. Register routes in `routes/api.php` or `routes/web.php` within the auth.token middleware group:
   ```php
   Route::middleware('auth.token')->group(function () {
       Route::get('/your-endpoint', [YourController::class, 'yourMethod']);
   });
   ```

### Multiple Devices/Sessions

To allow users to be logged in on multiple devices:

1. Create a new `api_tokens` table to store multiple tokens per user
2. Create an ApiToken model and update the authentication logic accordingly

### Error Handling

Customize API error responses by creating an exception handler in `app/Exceptions/Handler.php`

### Rate Limiting

Protect your API from abuse by implementing rate limiting:

### Common Issues

- **"Token not provided" error**: Ensure you're including the token in the Authorization header
- **"Invalid token" error**: The token may be incorrect or has been invalidated
- **Database connection issues**: Check your database configuration in the `.env` file

### Logs

Check Laravel logs for detailed error information:
```
tail -f storage/logs/laravel.log
```

## Contributing

1. Fork the repository
2. Create your feature branch: `git checkout -b feature/my-new-feature`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Push to the branch: `git push origin feature/my-new-feature`
5. Submit a pull request

## License

This project is licensed under the MIT License - see the LICENSE file for details.
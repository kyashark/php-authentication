# PHP Authentication System

This PHP Authentication System allows users to register, log in, and log out securely.

- Uses a MySQL database to store user credentials.
- Employs secure password handling with `password_hash` and `password_verify`.
- Prevents SQL injection using prepared statements.
- Implements basic input validation for username, email, and password fields.
- Manages user sessions to keep users logged in after authentication.
- Allows users to log out, destroying their session.

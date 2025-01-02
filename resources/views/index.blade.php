<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Issues</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .button-container {
            display: flex;
            gap: 20px;
        }

        .button {
            text-decoration: none;
            padding: 15px 30px;
            border: 2px solid #fff;
            border-radius: 25px;
            color: #2575fc;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            font-size: 18px;
            font-weight: bold;
            background: transparent;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        .button:hover {
            background: linear-gradient(135deg, #cf0e0e, #eb0707);
            color: #fff;
            transform: scale(1.1);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body>
    <div class="button-container">
        <a href="{{ url('/stored-xss') }}" class="button">XSS (Cross-Site Scripting)</a>
        <a href="{{ route('security.csrf') }}" class="button">CSRF (Cross-Site Request Forgery)</a>
        <a href="{{ url('/api/documentation') }}" class="button">SQL Injection</a>
    </div>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Test Email</title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #dddddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding: 20px;
            background-color: #007BFF;
            color: #ffffff;
            border-radius: 5px 5px 0 0;
        }
        .content {
            padding: 20px;
        }
        .content h1 {
            font-size: 24px;
            color: #333333;
        }
        .content p {
            font-size: 16px;
            color: #666666;
        }
        .footer {
            text-align: center;
            padding: 10px;
            background-color: #f4f4f4;
            color: #666666;
            border-top: 1px solid #dddddd;
            border-radius: 0 0 5px 5px;
        }
    </style>
</head>
<body>
<div class="email-container">
    <div class="header">
        <h1>{{ __('validation.answer_question_sharia') }}</h1>
    </div>
    <div class="content">
        <h1>{{ $shariaQuestion->answer }}</h1>
        <p>{{ $shariaQuestion->user_full_name }}</p>
    </div>
    <div class="footer">
        <p>&copy; {{ date('Y') }} Your Mull Platform. All rights reserved.</p>
    </div>
</div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Access Denied</title>
  <style>
    body {
      background: #f8f9fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
      height: 100vh;
      justify-content: center;
      align-items: center;
    }

    .card {
      background: white;
      padding: 40px 50px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      text-align: center;
      max-width: 500px;
      width: 100%;
    }

    .card h1 {
      font-size: 28px;
      color: #dc3545;
      margin-bottom: 15px;
    }

    .card p {
      font-size: 16px;
      color: #555;
    }

    .btn {
      display: inline-block;
      margin-top: 25px;
      padding: 10px 20px;
      background: #8d6e63;
      color: white;
      border-radius: 6px;
      text-decoration: none;
      font-weight: 500;
      transition: background 0.3s;
    }

    .btn:hover {
      background: #6d4c41;
    }
  </style>
</head>
<body>
  <div class="card">
    <h1>Access Denied</h1>
    <p>You do not have permission to access the system.<br>Please contact the system administrator for role assignment or access rights.</p>
    <a href="login.php" class="btn">Back to Login</a>
  </div>
</body>
</html>

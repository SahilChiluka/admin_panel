<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            background: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 90vh;
        }

        h1 {
            font-size: 30px;
        }
        .login {
            width: 300px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .login form {
            display: flex;
            flex-direction: column;
        } 

        label {
            margin-bottom: 5px;
            font-weight: bold;
        }   

        input[type="email"],
        input[type="password"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #007BFF;
            outline: none;
        }

        button {
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }  
    </style>
</head>
<body>
    <div class="login">
        <h1>Login</h1>
        <h3 style="color:red; text-align:center;">
            <?php echo session()->getFlashdata("error"); ?>
        </h3>
        <form action="<?= base_url('Home/loginuser') ?>" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required> 
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
    </div>
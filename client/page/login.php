<?php 

require "config.php";
if(isset($_POST["submit"])){
    $tel = $_POST["tel"];
    $rusult=tel_existe($tel);
    if(empty($rusult)){
        header("Location:register.php");
    }else{
        $_SESSION["client"]=$rusult;
        header("Location:../index.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
        body {
            background-color: #ffeadb;
            box-sizing: border-box;
            height: 80vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
        }
        form {
            margin:0 auto;
            background: #ff7700;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        label {
            color: #fff;
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
        }
        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: none;
            border-radius: 5px;
            outline: none;
        }
        button {
            background: #cc5500;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background: #a04000;
        }
    </style>
</head>
<body>
    <form method="POST">
        <label for="tel">Enter Phone Number:</label>
        <input type="tel" id="tel" name="tel" required>
        <button name="submit">Log In</button>
        <a href="register.php"> <button type="button">register</button></a>
    </form>
</body>
</html>

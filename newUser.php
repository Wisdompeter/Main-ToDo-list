<?php
    include("database.php");
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create account</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Create An Account</h2>
   <?php
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST["create_account"])) {
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
            $password = $_POST["password"];
            $confirm_password = $_POST["confirm_password"];

        ?>
        <div class="error">
            <?php
                if(empty($username)) {
                    echo "Please input a username";
                } elseif (!preg_match('/^[a-zA-Z0-9]+$/', $username)) {
                echo  "Username can only contain letters and numbers.";
            }
                 elseif (empty($password)) {
                    echo "Type in your password";
                } elseif (empty($confirm_password)) {
                    echo "Retype your password";
                } else {
                   $password = password_hash($password, PASSWORD_DEFAULT);
                    if (password_verify($confirm_password, $password)) {
                       $sql = "SELECT * FROM users WHERE username = '$username'";
                       $result = mysqli_query($conn, $sql);

                       if(mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            if($row['username'] == $username) {
                                echo "Username Taken";
                            }
                       } else {
                                echo "Username available";
                            $_SESSION["username"] = $username;
                            $_SESSION["password"] = $password;
                            header("Location: process.php");
                            }
                       
                    } else {
                        echo "password Mismatch";
                    }
                }
            ?>
        </div>
        <?php
        }
    }
?>
    <form action="newUser.php" method="post">
        <label>Enter A Username: </label>
        <input type="text" name="username" >
        <br>
        <br>
        <label>Enter A Password :</label>
        <input type="password" name="password" >
        <br>
        <br>
        <label>Confirm the password :</label>
         <input type="password" name="confirm_password" >
         <br>
         <br>

         <input type="submit" value="CREATE ACCOUNT" name="create_account">
    </form>
</body>
</html>


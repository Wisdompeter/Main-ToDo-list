    <?php    
    include("database.php");
        session_start();
    
        $username = $_SESSION["username"];
        $password = password_hash($_SESSION["username"], PASSWORD_DEFAULT);


        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
            mysqli_query($conn, $sql);

            mysqli_close($conn);

            ?>

            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>PROCESS</title>
            </head>
            <body>
                <h3>ACCOUNT CREATED SUCCESSFULLY</h3>
            </body>
            </html>
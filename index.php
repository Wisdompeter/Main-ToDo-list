<?php
    include("./DATABASE/database.php");
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes App - Login</title>
    <link rel="stylesheet" href="STYLES/login.css">
</head>
<body>
    <div class="login-container">
        <div class="app-icon">
            <i>📝</i>
        </div>
        <h2>Welcome to Siru X</h2>

            <?php
        if($_SERVER["REQUEST_METHOD"] == "POST") {
           ?>
    <div class="error">
        <?php
         if(isset($_POST["login"])) {
                $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
                $password = $_POST["password"];
                  
                 $sql = "SELECT * FROM users WHERE username = '$username'";
                 $result = mysqli_query($conn, $sql);

                 if(mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $hashed = $row['password'];
                    
                    if(password_verify($password, $hashed)) {
                        $_SESSION['user_id'] = $row['id'];
                        $_SESSION['username'] = $row['username'];
                       $_SESSION['username'] = $row['username'];
                      header("Location: home");
                      exit();
                    } else {
                        
                        ?>
                        <div class="error">
                            <?php echo "Wrong Password"; ?>
                        </div>
                        <?php
                    }

                 } else {
                      ?>
                        <div class="error">
                            <?php echo "Username not found"; ?>
                        </div>
                        <?php
                 }
            }
        ?>
    </div>
           <?php
           mysqli_close($conn);
        }
    ?>

        <form action="login" method="POST">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required placeholder="Enter your username">
            </div>
            
            <div class="input-group">
                <label for="password">Password</label>
                <div class="password-container">
                    <input type="password" id="password" name="password" required placeholder="Enter your password">
                    <button type="button" class="toggle-password" onclick="togglePassword()">👁️</button>
                </div>
            </div>
            
            <button type="submit" class="login-btn" name="login">Log In</button>
        </form>
        
        <div class="signup-link">
            Don't have an account? <a href="signup">Sign up</a>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleButton = document.querySelector('.toggle-password');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleButton.textContent = '🔒';
            } else {
                passwordField.type = 'password';
                toggleButton.textContent = '👁️';
            }
        }
    </script>
</body>
</html>
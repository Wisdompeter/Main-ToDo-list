<?php
    include("./DATABASE/database.php");
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes App - Sign Up</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="STYLES/signup.css">
</head>
<body>
    <div class="signup-container">
        <div class="app-icon">
            <i class="fas fa-sticky-note"></i>
        </div>
        <h2>Create Your Account</h2>
        <p class="tagline">Join thousands of users who organize their thoughts with Notes</p>
        
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
                     ?>
                        <div class="error">
                            <?php echo "Please Input a username"; ?>
                        </div>
                        <?php
                } elseif (!preg_match('/^[a-zA-Z0-9]+$/', $username)) {
                 ?>
                        <div class="error">
                            <?php echo "Username can only contain letters and Numbers."; ?>
                        </div>
                        <?php
            }
                 elseif (empty($password)) {
                     ?>
                        <div class="error">
                            <?php echo "Type in your password"; ?>
                        </div>
                        <?php
                } elseif (empty($confirm_password)) {
                     ?>
                        <div class="error">
                            <?php echo "Please re-enter your password"; ?>
                        </div>
                        <?php
                } elseif (strlen($password) < 6) {
                  echo "<div class='error'>Password must be at least 6 characters long.</div>";
                          } 
                     else {
                   
                    if ($password == $confirm_password) {
                        $password = password_hash($password, PASSWORD_DEFAULT);
                       $sql = "SELECT * FROM users WHERE username = '$username'";
                       $result = mysqli_query($conn, $sql);

                       if(mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            if($row['username'] == $username) {
                                 ?>
                        <div class="error">
                            <?php echo "Username Taken"; ?>
                        </div>
                        <?php
                            }
                       } else {
                            $_SESSION["username"] = $username;
                            $_SESSION["password"] = $password;
                            header("Location: process");
                            exit();
                            }
                       
                    } else {
                         ?>
                        <div class="error">
                            <?php echo "Password Mismatch"; ?>
                        </div>
                        <?php
                    }
                }
            ?>
        </div>
        <?php
        }
    }
?>

        <form action="signup.php" method="POST" onsubmit="return validateForm()">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required placeholder="Choose a username">
                <i class="fas fa-user input-icon"></i>
                <div class="error-message" id="username-error">Username must be at least 4 characters</div>
            </div>
            
            
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="Create a strong password" oninput="checkPasswordStrength()">
                <i class="fas fa-lock input-icon"></i>
                <div class="password-strength">
                    <div class="strength-meter" id="strength-meter"></div>
                </div>
                <div class="password-rules">
                    Use at least 8 characters with a mix of letters, numbers & symbols
                </div>
                <div class="error-message" id="password-error">Password must be at least 8 characters</div>
            </div>
            
            <div class="input-group">
                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" name="confirm_password" required placeholder="Re-enter your password" oninput="checkPasswordMatch()">
                <i class="fas fa-lock input-icon"></i>
                <div class="error-message" id="confirm-password-error">Passwords do not match</div>
            </div>
            
            <button type="submit" class="signup-btn" name="create_account">Create Account</button>
        </form>
        
        <div class="login-link">
            Already have an account? <a href="index.php">Log in</a>
        </div>
        
        <div class="terms">
            By signing up, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
        </div>
    </div>

    <script>
        function checkPasswordStrength() {
            const password = document.getElementById('password').value;
            const strengthMeter = document.getElementById('strength-meter');
            const strengthText = document.getElementById('password-error');
            let strength = 0;
            
            if (password.length >= 8) strength += 25;
            if (password.match(/[a-z]+/)) strength += 25;
            if (password.match(/[A-Z]+/)) strength += 25;
            if (password.match(/[0-9]+/)) strength += 25;
            
            strengthMeter.style.width = strength + '%';
            
            if (strength < 50) {
                strengthMeter.style.background = '#e74c3c';
            } else if (strength < 75) {
                strengthMeter.style.background = '#f39c12';
            } else {
                strengthMeter.style.background = '#2ecc71';
            }
        }
        
        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm-password').value;
            const errorElement = document.getElementById('confirm-password-error');
            
            if (confirmPassword && password !== confirmPassword) {
                errorElement.style.display = 'block';
            } else {
                errorElement.style.display = 'none';
            }
        }
        
        function validateForm() {
            const username = document.getElementById('username').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm-password').value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            let isValid = true;
            
            if (username.length < 4) {
                document.getElementById('username-error').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('username-error').style.display = 'none';
            }
            
            if (!emailRegex.test(email)) {
                document.getElementById('email-error').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('email-error').style.display = 'none';
            }
            
            if (password.length < 8) {
                document.getElementById('password-error').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('password-error').style.display = 'none';
            }
            
            if (password !== confirmPassword) {
                document.getElementById('confirm-password-error').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('confirm-password-error').style.display = 'none';
            }
            
            return isValid;
        }
    </script>
</body>
</html>
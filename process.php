    <?php    
    include("./DATABASE/database.php");
        session_start();
    
        $username = $_SESSION["username"];
        $password = $_SESSION["password"];

        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
            mysqli_query($conn, $sql);

            mysqli_close($conn);

            ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Created Successfully</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="STYLES/process.css">
</head>
<body>
    <div class="success-container">
        <div class="success-icon">
            <i class="fas fa-check"></i>
        </div>
        
        <h1>Account Created Successfully!</h1>
        
        <div class="success-message">
            <p>Congratulations! Your account has been successfully created and you're now part of our community.</p>
        </div>
        
        <div class="username-display">
            Your username: <span><?php echo htmlspecialchars($username); ?></span>
        </div>
        
        <p>You can now log in to your account and start using our services.</p>
        
        <a href="login" class="btn">
            <i class="fas fa-arrow-left"></i> Back to Login
        </a>
        
        <div class="footer">
            <p>© 2025 Notes App. All rights reserved.</p>
        </div>
    </div>

    <script>
        // Create confetti effect
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.success-container');
            const colors = ['#6a11cb', '#2575fc', '#4cd964', '#ff9500', '#ff3b30'];
            
            for (let i = 0; i < 30; i++) {
                const confetti = document.createElement('div');
                confetti.className = 'confetti';
                confetti.style.left = Math.random() * 100 + '%';
                confetti.style.top = Math.random() * 100 + '%';
                confetti.style.transform = 'rotate(' + (Math.random() * 360) + 'deg)';
                confetti.style.background = colors[Math.floor(Math.random() * colors.length)];
                confetti.style.opacity = Math.random() * 0.5 + 0.3;
                confetti.style.width = (Math.random() * 10 + 5) + 'px';
                confetti.style.height = (Math.random() * 10 + 5) + 'px';
                container.appendChild(confetti);
            }
        });
    </script>
</body>
</html>
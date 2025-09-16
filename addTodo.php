<?php
        session_start();
    include("./DATABASE/database.php");

        if(empty($_SESSION['username'])) {
            header("Location: login");
            exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes App</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="STYLES/addTodo.css?v=3">

</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="app-header">
            <div class="app-brand">
                <i class="fas fa-sticky-note"></i>
                <h1>SIRU X</h1>
            </div>
            
            <div class="user-info">
                <div class="user-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <span> <?php echo $_SESSION['username']; ?></span>
            </div>
        </div>
        
       <form action="home" method="post">
         <div class="note-editor">
            <div class="editor-header">
                <h2>Create New Note</h2>
            </div>
            
            
<?php

               if(isset($_SESSION['tupdate'])) {
                  ?>
                <div class="green">
                    <?php echo "Note Updated"; ?>
                </div>
                <?php
                unset($_SESSION['tupdate']);
        }

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        if(isset($_POST["add"])) {
            $user_id = $_SESSION['user_id'];
            $title = $_POST['title'];
            $body = $_POST['body'];
        ?>
            <div class="">
            <?php
                if(empty($title)) {
                    ?>
                        <div class="error">
                            <?php echo "Please input your Title"; ?>
                        </div>
                        <?php
                } elseif (empty($body)) {
                   ?>
                        <div class="error">
                            <?php echo "Please enter your NOTES"; ?>
                        </div>
                        <?php
                }elseif(trim($title) === '' || trim($body) === '') {
                     ?>
                        <div class="error">
                            <?php  echo "Title and content cannot be Empty"; ?>
                        </div>
                        <?php
                }
                 else {

                     ?>
                        <div class="green">
                            <?php echo "Note Added"; ?>
                        </div>
                        <?php

                        $unique_key = bin2hex(random_bytes(16));

                    $sql = "INSERT INTO notes (unique_key, user_id, title, body) VALUES ('$unique_key',  '$user_id', '$title', '$body');";
                    mysqli_query($conn, $sql);
                }
            ?>
            </div>
        <?php
        }
    }

    if (isset($_POST['unique_key'])) {
        $unique_key = mysqli_real_escape_string($conn, $_POST['unique_key']);
        $user_id = $_SESSION['user_id'];
        $sql = "DELETE FROM notes WHERE unique_key = $unique_key AND user_id = $user_id";
        mysqli_query($conn, $sql);

         ?>
                        <div class="error">
                            <?php echo "NOTE DELETED"; ?>
                        </div>
                        <?php

    }

    if(isset($_POST['logout'])) {
        $_SESSION = [];        // Clear session array
        session_destroy();     // Destroy session file
        header("Location: login");
        exit();
    }
?>

            <div class="input-group">
                <label for="note-title">Title</label>
                <input type="text" id="note-title" placeholder="Note title" name="title">
            </div>
            
            <div class="input-group">
                <label for="note-body">Content</label>
                <textarea id="note-body" placeholder="Start typing your note here..." name="body"></textarea>
            </div>
            
            <button class="add-note-btn" name="add">Add Note</button>
        </div>
       </form>
        
        <!-- Notes List -->
       <div class="notes-container">
           <div class="notes-header">
                <h2>Your Notes</h2>
            </div>
                      <div class="notes-list">
             
                <div class="note-card">
             
    <?php
        $user_id = $_SESSION['user_id'];
        $username = $_SESSION['username'];
        $sql = "SELECT * FROM notes WHERE user_id = $user_id ORDER BY created_at DESC";
        $result = mysqli_query($conn, $sql);

        while($row = mysqli_fetch_assoc($result)) {
            ?>
                <div class="separate">
                <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                <p><?php echo htmlspecialchars($row['body']); ?></p>
                 <div class="note-date">
                        <i class="far fa-clock"></i> Created today at <?php echo $row['created_at']; ?>
                    </div>
                <div class="space">
                    <button class="edit-space">
                        <a href="edit/<?php echo $row['unique_key']; ?>">Edit Note</a>

                    </button>
                <form action="" method="post">
                    <input type="hidden" name="unique_key" value="<?php echo $row['unique_key']; ?>">

                    <input class="del-space" name="delete" type="submit" value="DELETE">
                </form>
                </div>
                </div>
            <?php
        }
    ?>

                </div>
                
            </div>
        </div>

    </div>
   <form action="" method="post">
     <button class="add-note-btn" name="logout">LOG OUT</button>
   </form>
     <div class="app-footer">
        <p>© 2025 Notes App. All rights reserved.</p>
    </div>

    <script src="SCRIPT/addTodo.js"></script>
</body>
</html>
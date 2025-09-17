<?php
session_start();
include("./DATABASE/database.php");

// ✅ Dynamic base path
if ($_SERVER['HTTP_HOST'] === 'localhost') {
    $base = '/CLONE/Main-ToDo-list/';
} else {
    $base = '/';
}

// ✅ Check login
if (empty($_SESSION['username'])) {
    header("Location: " . $base . "login");
    exit();
}

if (empty($_SESSION['user_id'])) {
    header("Location: " . $base . "login");
    exit();
}

$unique_key = isset($_GET['key']) ? mysqli_real_escape_string($conn, $_GET['key']) : '';
$user_id = $_SESSION['user_id'];

// ✅ Handle update
if (isset($_POST['update'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $body  = mysqli_real_escape_string($conn, $_POST['body']);

    $sql = "UPDATE notes 
            SET title = '$title', body = '$body' 
            WHERE unique_key = '$unique_key' AND user_id = $user_id";
    mysqli_query($conn, $sql);

    $_SESSION['tupdate'] = 'update';
    header("Location: " . $base . "home");
    exit();
}

// ✅ Fetch note
$sql = "SELECT * FROM notes WHERE unique_key = '$unique_key' AND user_id = $user_id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Note</title>

    <!-- ✅ Universal CSS path -->
    <link rel="stylesheet" href="<?= $base ?>STYLES/addTodo.css">
</head>
<body>
    <?php if (!empty($row)) : ?>
      <form action="" method="post">
         <div class="note-editor">
            <div class="editor-header">
                <h2>Update Your Notes</h2>
            </div>
            <div class="input-group">
                <label for="note-title">Title</label>
                <input type="text" id="note-title" placeholder="Note title" name="title" value="<?php echo $row['title']; ?>">
            </div>
            
            <div class="input-group">
                <label for="note-body">Content</label>
                <textarea id="note-body" placeholder="Start typing your note here..." name="body"><?php echo $row['body']; ?></textarea>
            </div>
            
            <button class="add-note-btn" name="update">UPDATE</button>
        </div>
       </form>
    <?php else: ?>
        <p>Note not found.</p>
    <?php endif; ?>
</body>
</html>

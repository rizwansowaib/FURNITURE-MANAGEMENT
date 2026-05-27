<?php
include('../Login/config.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM users WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);
}

if (isset($_POST['update'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];

    $query = "UPDATE users SET username='$username', email='$email' WHERE id=$id";
    if (mysqli_query($conn, $query)) {
        header('Location: user.php');
        exit();
    } else {
        echo "Error updating user.";
    }
}
?>

<form method="POST">
    <input type="text" name="username" value="<?php echo $user['username']; ?>" required>
    <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
    <button type="submit" name="update">Update</button>
</form>

<?php
session_start();
include('dbcon.php');

$page_title = "login form";

if (isset($_POST['login_btn'])) {
    $email    = mysqli_real_escape_string($con, $_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $query_run = mysqli_query($con, $query);

    if (mysqli_num_rows($query_run) == 1) {
        $user = mysqli_fetch_assoc($query_run);

        if (password_verify($password, $user['password'])) { 
            $_SESSION['auth'] = true;
            $_SESSION['auth_user'] = [
                'user_id'    => $user['id'],
                'user_name'  => $user['name'],
                'user_email' => $user['email'],
            ];
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['status'] = "Invalid email or password";
        }
    } else {
        $_SESSION['status'] = "Invalid email or password";
    }
}
?>
<?php
include('./include/navbar.php');
include('./include/header.php');
?>

<form action="" method="POST">
    <div class="mb-3">
        <label class="form-label">Email Address</label>
        <input
            type="email"
            name="email"
            class="form-control"
            required
        />
    </div>

    <div class="mb-3">
        <label class="form-label">Password</label>
        <input
            type="password"
            name="password"
            class="form-control"
            required
        />
    </div>

    <button type="submit" name="login_btn" class="mt-4 btn btn-primary w-100">
        Login
    </button>
</form>
<?php include('./include/footer.php'); ?> 


<?php if(isset($_SESSION['status'])): ?>
    <div class="alert alert-danger">
        <?php echo $_SESSION['status']; unset($_SESSION['status']); ?>
    </div>
<?php endif; ?>

<?php
session_start();
include('./dbcon.php');

$page_title = "Registration Form";

include('./include/navbar.php');
include('./include/header.php');

// معالجة الفورم
if (isset($_POST['register_btn'])) {
    $name             = mysqli_real_escape_string($con, $_POST['name']);
    $phone            = mysqli_real_escape_string($con, $_POST['phone']);
    $email            = mysqli_real_escape_string($con, $_POST['email']);
    $password         = mysqli_real_escape_string($con, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($con, $_POST['confirm_password']);

    if ($password !== $confirm_password) {
        $_SESSION['status'] = "Passwords do not match";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // [web:106][web:118]

        // هل الإيميل موجود؟
        $check = "SELECT id FROM users WHERE email = '$email' LIMIT 1";
        $check_run = mysqli_query($con, $check);

        if (mysqli_num_rows($check_run) > 0) {
            $_SESSION['status'] = "Email already exists";
        } else {
            $insert = "INSERT INTO users (name, phone, email, password) 
                       VALUES ('$name', '$phone', '$email', '$hashed_password')";
            if (mysqli_query($con, $insert)) {
                $_SESSION['status'] = "Registration successful";
            } else {
                $_SESSION['status'] = "Registration failed: " . mysqli_error($con);
            }
        }
    }

    header("Location: register.php");
    exit();
}
?>

<div class="py-5">
    <div class="container">

        <?php if(isset($_SESSION['status'])): ?>
            <div class="alert alert-info">
                <?php echo $_SESSION['status']; unset($_SESSION['status']); ?>
            </div>
        <?php endif; ?>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header">
                        <h5>Registration Form</h5>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" required />
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Phone number</label>
                                <input type="text" name="phone" class="form-control" required />
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control" required />
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required />
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" name="confirm_password" class="form-control" required />
                            </div>

                            <button type="submit" name="register_btn" class="mt-3 btn btn-primary w-100">
                                Register now
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('./include/footer.php'); ?>

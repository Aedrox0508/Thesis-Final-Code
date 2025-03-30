<?php
session_start();
require "./classes/user.class.php";
require "./tools/functions.php";

$user = new User();

if($_SERVER["REQUEST_METHOD"]=="POST"){
    if(isset($_POST['login'])){
        $user->username = htmlentities($_POST['username']);
        $user->password = htmlentities($_POST['password']);

        if(validate_field($user->username)&&(validate_field($user->password))){
            if ($userData = $user->signinUser($user->username, $user->password)) {
                if ($userData) {
                    $_SESSION['user_id'] = $userData['user_id'];
                    $_SESSION['username'] = $userData['username'];
                    echo '<script>
                            window.location.href = "presets.php";
                        </script>';
                    exit();
                }
            } else {
                echo '<script> alert("Invalid Credentials");</script>';
            }
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets//images/movewave_logo.png" type="image/x-icon">
    <title>Move Wave</title>
    <?php include "./inlcude/header.php"; ?>
</head>
<body>
    <!-- Move Wave Login Page -->

    <main class="vh-100 w-100 d-flex justify-content-center align-items-center font-roboto">
        <form id="loginForm" method="POST" action="" class="shadow border d-flex flex-column align-items-center justify-content-center rounded-3 p-5" >
            <div class="movewave-logo text-center">
                <img src="./assets/images/movewave_logo.png"  alt="">
                <span class="d-block fs-5" ><span class="me-2" style="color: #211C84;" >Move</span><span style="color: #693382;" >Wave</span></span>
            </div>
            
            <!-- Invalid credentials alert -->
            <?php if (!empty($login_error)): ?>
                <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between align-items-center p-2" role="alert">
                    <div class="d-flex"><i class="fi fi-rr-triangle-warning d-block mt-1 me-3 text-danger fw-bold"></i> <?php echo $login_error; ?></div>
                    <button type="button" class="border-0 bg-transparent" data-bs-dismiss="alert" aria-label="Close"><i class="fi fi-rr-cross-small d-block mt-1"></i></button>
                </div>
            <?php endif; ?>

            <!-- Form Fields -->
            <div class="mt-3 w-100" >
                <label class="d-block" for="Username">Username</label>
                <input type="text" name="username" class="rounded-1 p-2 border w-100 form-control" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" >

                <?php if(isset($_POST['username']) && !validate_field($_POST['username'])): ?>
                    <span class="text-danger text-xs">Please input your username</span>
                <?php endif ?>

                <label class="d-block mt-3" for="Password">Password</label>
                <input type="password" name="password" class="rounded-1 p-2 border w-100 form-control" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>" >

                <?php if(isset($_POST['password']) && !validate_field($_POST['password'])): ?>
                    <span class="text-danger text-xs">Please input your password</span>
                <?php endif ?>

                <span class="d-block mt-2 text-sm text-center" >Don't have an account yet? <a class="text-decoration-none" href="signup.php">Sign Up</a> here </span>

                <button type="submit" name="login" class="w-100 text-center border-0 rounded-1 p-2 mt-4" >Log in</button>
            </div>

        </form>
    </main>

    
    <?php include "./inlcude/footer.php"; ?>
</body>
</html>
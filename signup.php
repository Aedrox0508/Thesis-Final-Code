<?php
session_start();
require "./classes/user.class.php";
require "./tools/functions.php";

$user = new User();

if($_SERVER["REQUEST_METHOD"]=="POST"){
    if(isset($_POST['signup'])){
        $user->username = htmlentities($_POST['username']);
        $user->password = htmlentities($_POST['password']);

        if(validate_field($user->username)&&(validate_field($user->password))){
            if ($user->signupUser()) {
                echo '<script>
                    alert("Account Created");
                    window.location.href = "index.php";
                </script>';
                exit(); 
            }
            else{
                error_log("Database error");
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

                <span class="d-block mt-2 text-sm text-center" >Do you have an account?<a class="text-decoration-none" href="index.php">Sign in</a> here </span>

                <button type="submit" name="signup" class="w-100 text-center border-0 rounded-1 p-2 mt-4" >Sign up</button>
            </div>

        </form>
    </main>

    
    <?php include "./inlcude/footer.php"; ?>
</body>
</html>
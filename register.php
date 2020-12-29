<?php
require_once 'init.php';
// Xử lý logic ở đây

$title = "Register";
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])) {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $passwordCf = $_POST['passwordConfirm'];
    $email = $_POST['email'];
    $number_phone = $_POST['number_phone'];
    $user = findUserByUsername($username);
    if ($user) {
        $error = 'Account already exists!';
    } else if ($password != $passwordCf) {
        $error = 'Confirm password does not match!';
    } elseif (findUserByEmail($email)) {
        $error = 'Email already exists!';
    } else {
        //Assign the user to session
        //addUser($users,$username,$password,$email);

        $code = strtoupper(bin2hex(random_bytes(10)));
        $user = createUser($fullname, $username, password_hash($password, PASSWORD_DEFAULT), $email, $phone, $code);
        $contentMail = 'Thanks for signing up with Heroku! You must follow this link to activate your account: http://localhost/doan/activate.php?id=' . $user["id"] . '&code=' . $code;
        sendMail($email, 'Confirm your account on LTWeb1', $contentMail);
        header('Location: registerSuccess.php');
        exit();
    }
}


?>


<?php include 'header.php'; ?>
<div id="content" class="mb-4">
    <div class="container pt-3">
        <h1 class="display-4 text-center font-weight-normal mb-4"><?php echo $title ?></h1>
        <?php if (isset($error)) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
            <?php include 'formRegister.php'; ?>
        <?php else : include 'formRegister.php'; ?>


        <?php endif; ?>

        <?php include 'footer.php'; ?>
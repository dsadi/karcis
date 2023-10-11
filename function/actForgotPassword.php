<?php
include "../conn.php";

$errors = array();
$email = @$_POST['email'];

if (!empty($email)) {
    $errors['email'] = "Email is Required";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors["email"] = "Invalid email format";
}


if (empty($errors)) {
    $hash = sha1($email);
    $link = $host . "resetPassword.php?hash=" . $hash;


    $sql = "INSERT INTO forgot_password (email, hash, link)
    VALUES ('$email', '$hash', '$link')";

    if ($conn->query($sql) === TRUE) {
        header('location:' . $host . 'confirmation.php?hash=' . $hash);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "";
    header('location:' . $host . 'forgotPassword.php?err=' . $errors['email']);
}

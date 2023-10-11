<?php
include "../conn.php";
@session_start();
$id = @$_POST['id_user'];
$fullname = @$_POST['fullname'];
$fullname = strip_tags(mysql_real_escape_string(trim($fullname)));
$email = @$_POST['email'];

$phone = 0;
if(@$_POST['phone'] != '' || @$_POST['phone'] != null){
    $phone = @$_POST['phone'];
}
$email_regex = "/([a-zA-Z0-9!#$%&’?^_`~-])+@([a-zA-Z0-9-])+(.com)+/";
$myemail = "abc@gmail.com";
if(preg_match($email_regex,$myemail)){
$email = @$_POST['email'];
}
else{
echo "An Email with a .com domain is acceptable only.";
}

// mitra
$fileName = $_FILES['userfile']['name'];
$namaDir = '../files/';

if ($fileName) {
    $newFileName = $namaDir.$fileName;
    if(move_uploaded_file($_FILES['userfile']['tmp_name'], $newFileName)){
        // update data
        $user = "UPDATE users SET email = '$email' WHERE id = $id";
        $conn->query($user);

        $userProfile = "UPDATE user_profile SET fullname = '$fullname', phone = '$phone', identity_card = '$newFileName' WHERE id_user = $id ";
        $conn->query($userProfile);

        if($conn->query($user) === FALSE && $conn->query($userProfile) === FALSE){
            echo("Error description: " . mysqli_error($conn));
        }

        header('Location: '.$host.'profile.php?status=success');
    }else{
        echo "File gagal diupload."; 
    }

    // proses upload file dari temporary ke path file
    // if (move_uploaded_file($_FILES['userfile']['tmp_name'], $pathFile)) {
    //     // update data
    //     $user = "UPDATE users SET email = '$email' WHERE id = $id";
    //     $conn->query($user);

    //     $userProfile = "UPDATE user_profile SET fullname = '$fullname', phone = '$phone', identity_card = '$newfilename' WHERE id_user = $id ";
    //     $conn->query($userProfile);

    //     if($conn->query($user) === FALSE && $conn->query($userProfile) === FALSE){
    //         echo("Error description: " . mysqli_error($conn));
    //     }

    //     header('Location: '.$host.'profile.php?status=success');
    // } else {
    //     var_dump($_FILES['userfile']['error']);
    //     echo "File gagal diupload.";
    // }
} else {
    // update data
    $user = "UPDATE users SET email = '$email' WHERE id = $id";
    $conn->query($user);

    $userProfile = "UPDATE user_profile SET fullname = '$fullname', phone = '$phone' WHERE id_user = $id";
    $conn->query($userProfile);

    if($conn->query($user) === FALSE && $conn->query($userProfile) === FALSE){
        echo("Error description: " . mysqli_error($conn));
    }

    header('Location: '.$host.'profile.php?status=success');
}



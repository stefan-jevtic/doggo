<?php
session_start();
include("../server/connection.php");
include("../server/model.php");


    if(isset($_POST['signin'])){
         $email = $_POST['email'];
         $username = $_POST['username'];
         $password = md5($_POST['password']);
         $avatar = 'public/images/default_user.png';

        $res = registerUser($conn, $username, $email, $password, $avatar);

        if($res)
            echo 'Success';
        else
            echo 'Failure';
    }

    if(isset($_POST['login'])){
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        $res = loginUser($conn, $username, $password);

        if($res){
            $row = mysqli_fetch_array($res);
            $_SESSION['id'] = $row['id'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['username'] = $row['name'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['avatar'] = $row['avatar'];
            $_SESSION['date'] = $row['date'];

            echo 'redirect';
        }
        else{
            echo "Login failed";
        }
    }

    if(isset($_POST['checkUsername'])){
        $username = $_POST['username'];

        $res = checkUsername($conn, $username);

        if($res)
            echo 'Free';
        else
            echo 'Used';
    }

    if(isset($_POST['changeUser'])){
        $username = $_POST['username'];

        $res = updateUsername($conn, $username);

        if($res){
            echo 'Success';
            $_SESSION['username'] = $username;
        }  
        else
            echo 'Failure';
    }

    if(isset($_POST['changeEmail'])){
        $email = $_POST['email'];

        $res = updateEmail($conn, $email);

        if($res){
            echo 'Success';
            $_SESSION['email'] = $email;
        }  
        else
            echo 'Failure';
    }

    if(isset($_POST['btnUpdateAvatar'])){
        $photo_name = $_FILES['tbChangeAvatar']['name'];
        $tmp = $_FILES['tbChangeAvatar']['tmp_name'];
        $folder = '../public/images/';
        $array = explode(".", $photo_name);
        $extension = $array[count($array)-1];

        $regExtension = "/^(jpe?g|png)$/";

        if(preg_match($regExtension, $extension)){

            $res = updatePicture($conn, $tmp, $folder.$photo_name);

            if($res == 'Successfully changed!'){
                $_SESSION['avatar'] = substr($folder, 3).$photo_name;
                header('Location: http://localhost/doggo/index.php?id=6');
            }
        }
        else{
            echo "Wrong format! Only jpg, jpeg or png are supported!";
        }
    }

    if(isset($_POST['changeProfile'])){
        $href = $_POST['href'];

        $res = changeProfile($conn, $href, $_SESSION['id']);

        if($res == 'both'){
            $_SESSION['avatar'] = $href;
            echo 'both';
        }
        elseif($res == 'one')
        {
            $_SESSION['avatar'] = $href;
            echo 'one';
        }
        else
            echo 'Failure';
    }
?>
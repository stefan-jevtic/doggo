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
            $_SESSION['abu'] = [];

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

    if(isset($_POST['adminUpdateUser'])){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $id = $_POST['id'];

        $res = adminUpdateUser($conn, $username, $email, $role, $id);

        if($res)
            echo 'Success';
        else
            echo 'Failure';
    }

    if(isset($_POST['adminDeleteUser'])){
        $id = $_POST['id'];

        $res = adminDeleteUser($conn, $id);

        if($res)
            echo 'Success';
        else
            echo 'Failure';
    }

    if(isset($_POST['tbDoggoTitle'])){
        $title = $_POST['tbDoggoTitle'];
        $desc = $_POST['taDoggoDescription'];
        $category = (int)$_POST['ddlDoggoCategory'];
        $photo_name = $_FILES['flDoggo']['name'];
        $tmp = $_FILES['flDoggo']['tmp_name'];
        $folder = '../public/images/';
        $id = $_SESSION['id'];

        $res = uploadDoggo($conn, $title, $desc, $category, $tmp, $folder.$photo_name, $id);

        if($res)
            header("Location: http://localhost/doggo/index.php?id=8");
        else
            echo 'doggo not uploaded';
    }

    if(isset($_POST['insertComment'])){
        $id_doggo = $_POST['id_doggo'];
        $id_user = $_POST['id_user'];
        $comment = $_POST['text'];

        $res = insertComment($conn, $id_doggo, $id_user, $comment);

        if($res)
            echo json_encode($res);
    }

    if(isset($_POST['likedPost'])){
        $id_user = (int)$_POST['id_user'];
        $id_doggo = (int)$_POST['id_doggo'];
        $like = $_POST['like'];

        $res = insertLike($conn, $id_doggo, $id_user, $like);

        if($res)
            echo true;
        else
            echo false;
    }

    if(isset($_POST['dislikedPost'])){
        $id_user = (int)$_POST['id_user'];
        $id_doggo = (int)$_POST['id_doggo'];
        $dislike = $_POST['dislike'];
        var_dump($id_doggo . ' '. $id_user);
        $res = insertDislike($conn, $id_doggo, $id_user, $dislike);

        if($res)
            echo true;
        else
            echo false;
    }

    if(isset($_POST['all_comments'])){
        $res = listAllComments($conn);
        
        if($res)
            echo json_encode($res);
        else
            echo false;
    }

    if(isset($_POST['updateDoggoInfo'])){
        $id = $_POST['id'];
        $title = $_POST['title'];
        $desc = $_POST['desc'];

        $res = updateDoggoInfo($conn, $id, $title, $desc);

        if($res)
            echo true;
        else
            echo false;
    }

    if(isset($_POST['deleteDoggo'])){
        $id = $_POST['id'];
        $res = deleteDoggo($conn, $id);

        if($res)
            echo true;
        else
            echo false;
    }

    if(isset($_POST['pagginate'])){
        $num = $_POST['num'];

        $res = pagginateDoggos($num);

        // if($res)
        //     echo $res;
        // else
        //     echo false;
        echo $res;
    }

?>
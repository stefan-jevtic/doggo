<?php

    function getLinks($conn){
        $query = 'SELECT * FROM links';
        $res = mysqli_query($conn, $query);

        return $res;
    }

    function getPage($id, $conn){
        $query = 'SELECT href FROM links WHERE id='.$id;
        $res = mysqli_query($conn, $query);
        $page = mysqli_fetch_array($res);
        
        return $page['href'];
    }

    function registerUser($conn, $username, $email, $password, $avatar){
        $date = date("Y-m-d H:i:s");

        $query = 'INSERT INTO users(name, pass, email, role, avatar, date) VALUES ("'.$username.'", "'.$password.'", "'.$email.'", "user", "'.$avatar.'", "'.$date.'")';
        $res = mysqli_query($conn, $query);

        if($res)
            return true;
        else
            return false;
    }

    function loginUser($conn, $username, $password){
        $query = 'SELECT * FROM users WHERE name = "'.$username.'" AND pass = "'.$password.'"';
        $res = mysqli_query($conn, $query);

        if(mysqli_num_rows($res) == 1)
            return $res;
        else
            return false;
    }

    function checkUsername($conn, $username){
        $query = 'SELECT * FROM users WHERE name = "'.$username.'"';
        $res = mysqli_query($conn, $query);

        if(mysqli_num_rows($res) == 0)
            return true;
        else
            return false;
    }

    function updateUsername($conn, $username){
        $query = 'UPDATE users SET name="'.$username.'" WHERE id='.$_SESSION['id'];

        $res = mysqli_query($conn, $query);

        if($res)
            return true;
        else
            return false;
    }

    function updateEmail($conn, $email){
        $query = 'UPDATE users SET email="'.$email.'" WHERE id='.$_SESSION['id'];

        $res = mysqli_query($conn, $query);

        if($res)
            return true;
        else
            return false;
    }

    function updatePicture($conn, $tmp_name, $href){
        $query1 = 'SELECT * FROM users WHERE id='.$_SESSION['id'];
        $res1 = mysqli_query($conn, $query1);
        $row = mysqli_fetch_array($res1);
        $current = $row['avatar'];

        if(move_uploaded_file($tmp_name, $href)){

            $query2 = 'UPDATE users SET avatar="'.substr($href, 3).'" WHERE id='.$_SESSION['id'];
            $res2 = mysqli_query($conn, $query2);

            if($res2){
                $query3 = 'INSERT INTO profile_pictures(id_user, path) VALUES("'.$_SESSION['id'].'", "'.$current.'")';
                $res3 = mysqli_query($conn, $query3);

                if($res3)
                    return 'Successfully changed!';
            }
            else{
                return "Uploading failed inner!";
            }
        }
        else{
            return "Uploading failed outer!";
        }
    }

    function getProfilePictures($conn, $id){
        $query = 'SELECT * FROM profile_pictures WHERE id_user = '.$id;
        $res = mysqli_query($conn, $query);

        if(mysqli_num_rows($res) > 0){
            return $res;
        }
    }

    function changeProfile($conn, $href, $id){

        $query = 'SELECT * FROM profile_pictures WHERE path = (SELECT avatar FROM users WHERE id='.$id.') AND id_user = '.$id;
        $res = mysqli_query($conn, $query);

        if(mysqli_num_rows($res) == 0){
            $query2 = 'INSERT INTO profile_pictures(id_user, path) VALUES ('.$id.', (SELECT avatar from users WHERE id='.$id.'))';
            $res2 = mysqli_query($conn, $query2);

            if($res2){
                $query3 = 'UPDATE users SET avatar = "'.$href.'" WHERE id ='.$id;
                $res3 = mysqli_query($conn, $query3);

                if($res3)
                    return 'both';
                else
                    return false;
            }
        }
        else{
            $query4 = 'UPDATE users SET avatar = "'.$href.'" WHERE id ='.$id;
            $res4 = mysqli_query($conn, $query4);

            if($res4)
                return 'one';
            else
                return false;
        }
    }
?>
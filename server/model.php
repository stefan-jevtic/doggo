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

    function listUsers($conn){
        $query = 'SELECT * FROM users';
        $res = mysqli_query($conn, $query);

        if(mysqli_num_rows($res) > 0)
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

    function adminUpdateUser($conn, $username, $email, $role, $id){
        $query = 'UPDATE users SET name="'.$username.'", email="'.$email.'", role="'.$role.'" WHERE id='.$id;
        $res = mysqli_query($conn, $query);

        if($res)
            return true;
        else
            return false;
    }

    function adminDeleteUser($conn, $id){
        $query = 'DELETE from users WHERE id='.$id;
        $res = mysqli_query($conn, $query);

        if($res)
            return true;
        else
            return false;
    }

    function listCategories($conn){
        $query = 'SELECT * FROM category';
        $res = mysqli_query($conn, $query);
        
        if($res)
            return $res;
        else
            return false;
    }

    function uploadDoggo($conn, $title, $description, $category, $tmp, $href, $id){

        $date = date("Y-m-d H:i:s");

        if(move_uploaded_file($tmp, $href)){

            $query = 'INSERT INTO doggos(title, description, photo, id_user, id_category, date) VALUES ("'.$title.'", "'.$description.'", "'.substr($href, 3).'", '.$id.', '.$category.', "'.$date.'")';
            $res = mysqli_query($conn, $query);

            if($res)
                return true;
            else 
                return false;
        }
    }

    function listAllDoggos($conn){
        $query = 'SELECT * FROM doggos';
        $res = mysqli_query($conn, $query);

        if(mysqli_num_rows($res)>0){
            return $res;
        }
    }

    function listCommentsForDoggo($conn, $id_doggo){
        $query = 'SELECT * FROM comments c INNER JOIN users u ON c.id_user = u.id WHERE id_doggo='.$id_doggo;
        $res = mysqli_query($conn, $query);

        if(mysqli_num_rows($res)>0){
            return $res;
        }
        else 
            return 'No comments yet';
    }

    function insertComment($conn, $id_doggo, $id_user, $comment){
        $date = date("Y-m-d H:i:s");

        $query = 'INSERT INTO comments (id_user, id_doggo, comment, date_commented) VALUES ('.$id_user.', '.$id_doggo.', "'.$comment.'", "'.$date.'")';
        $res = mysqli_query($conn, $query);

        if($res){
            $query1 = 'SELECT * FROM users WHERE id='.$id_user;
            $res1 = mysqli_query($conn, $query1);
            $row = mysqli_fetch_array($res1);
return $row;
           
                
        }
    }

    function insertLike($conn, $id_doggo, $id_user, $lajk){
        $q = 'SELECT * FROM likes WHERE id_user='.$id_user.' AND id_doggo='.$id_doggo.'';
        $r = mysqli_query($conn, $q);

        if(mysqli_num_rows($r) == 0){
            
            $q1 = 'INSERT INTO likes(id_user, id_doggo, lajk, dislike) VALUES('.$id_user.', '.$id_doggo.', '.$lajk.', 0)';
            $r1 = mysqli_query($conn, $q1);
            
            if($r1)
                return true;
            else
                return false;
        }
        else {
            $q2 = 'UPDATE likes SET lajk = '.$lajk.', dislike = 0 WHERE id_user = '.$id_user.' AND id_doggo = '.$id_doggo;
            $r2 = mysqli_query($conn, $q2);

            if($r2)
                return true;
            else 
                return false;
        }
    }

    function insertDislike($conn, $id_doggo, $id_user, $dislike){
        $q = 'SELECT * FROM likes WHERE id_user='.$id_user.' AND id_doggo='.$id_doggo.'';
        $r = mysqli_query($conn, $q);

        if(mysqli_num_rows($r) == 0){
            $q1 = 'INSERT INTO likes (id_user, id_doggo, lajk, dislike) VALUES ('.$id_user.', '.$id_doggo.', 0, '.$dislike.')';
            $r1 = mysqli_query($conn, $q1);

            if($r1)
                return true;
            else
                return false;
        }
        else {
            $q2 = 'UPDATE likes SET lajk = 0, dislike = '.$dislike.' WHERE id_user = '.$id_user.' AND id_doggo = '.$id_doggo;
            $r2 = mysqli_query($conn, $q2);

            if($r2)
                return true;
            else 
                return false;
        }
    }

    function countComments($conn, $id_doggo){
        $query = 'SELECT COUNT(*) as num_comm FROM comments WHERE id_doggo='.$id_doggo;
        $res = mysqli_query($conn, $query);
        $num = mysqli_fetch_array($res);

        return $num;
    }

    function countLikes($conn, $id_doggo){
        $query = 'SELECT COUNT(*) as num_likes FROM likes WHERE id_doggo='.$id_doggo.' AND lajk = 1';
        $res = mysqli_query($conn, $query);
        $num = mysqli_fetch_array($res);

        return $num;
    }

    function countDislikes($conn, $id_doggo){
        $query = 'SELECT COUNT(*) as num_dislikes FROM likes WHERE id_doggo='.$id_doggo.' AND dislike = 1';
        $res = mysqli_query($conn, $query);
        $num = mysqli_fetch_array($res);

        return $num;
    }

    function checkLike($conn, $id_u, $id_d){
        $q = 'SELECT * FROM likes WHERE id_user = '.$id_u.' AND id_doggo = '.$id_d.' AND lajk = 1';
        $r = mysqli_query($conn, $q);

        if(mysqli_num_rows($r) == 1)
            return true;
        else
            return false;
    }

    function checkDislike($conn, $id_u, $id_d){
        $q = 'SELECT * FROM likes WHERE id_user = '.$id_u.' AND id_doggo = '.$id_d.' AND dislike = 1';
        $r = mysqli_query($conn, $q);

        if(mysqli_num_rows($r) == 1)
            return true;
        else
            return false;
    }

    function listAllComments($conn){
        $q = 'SELECT c.*, u.avatar, u.name FROM comments c INNER JOIN users u ON u.id = c.id_user';
        $r = mysqli_query($conn, $q);

        $records = [];
        while($row = mysqli_fetch_array($r)){
            array_push($records, ["id_user"=>$row['id_user'], "id_doggo"=>$row['id_doggo'], "comment" => $row['comment'], "date" => $row['date_commented'], "username" => $row['name'], "avatar" => $row['avatar']]);
        }

        if($r)
            return $records;
        else
            return false;
    }

    function listUploadedDoggos($conn, $user_id){
        $q = 'SELECT * FROM doggos WHERE id_user='.$user_id;
        $r = mysqli_query($conn, $q);

        if($r)
            return $r;
    }

    function listLikedDoggos($conn, $user_id){
        $q = 'SELECT d.* FROM doggos d INNER JOIN likes l ON d.id = l.id_doggo WHERE l.id_user='.$user_id.' AND l.lajk = 1';
        $r = mysqli_query($conn, $q);

        if($r)
            return $r;
    }
    // select count(lajk) as lajkovi, id_doggo from likes where lajk = 1 and id_doggo in (1,4,9) group by id_doggo;

    function listAllDoggosAndUsers($conn){

        $q = 'SELECT d.*, u.name as username FROM doggos d INNER JOIN users u on u.id = d.id_user';
        $r = mysqli_query($conn, $q);
        
        $num = mysqli_num_rows($r);

        while($row = mysqli_fetch_array($r)){
            array_push($_SESSION['abu'], ["photo" => $row['photo'], "title" => $row['title'], "id" => $row['id'], "username" => $row['username'], "date" => $row['date'], "desc" => $row['description'], "num" => $num]);
        }
        
        if(mysqli_num_rows($r) > 0){
            return array_slice($_SESSION['abu'], 0, 5);
        }
        else
            return false;
    }

    function updateDoggoInfo($conn, $id, $title, $desc){
        $q = 'UPDATE doggos SET title = "'.$title.'", description = "'.$desc.'" WHERE id = '.$id;
        $r = mysqli_query($conn, $q);

        if($r)
            return true;
        else 
            return false;
    }

    function deleteDoggo($conn, $id){
        $q = 'DELETE FROM doggos WHERE id ='.$id;
        $r = mysqli_query($conn, $q);

        if($r)
            return true;
        else
            return false;
    }

    function pagginateDoggos($num){
        $arr = array_slice($_SESSION['abu'], 5*(int)$num-5, 5);
        return $arr;
    }

    function listAllCategories($conn){
        $q = 'SELECT * FROM category';
        $r = mysqli_query($conn, $q);

        if($r)
            return $r;
    }

    function deleteCategories($conn, $ids){
        $q = 'DELETE FROM category WHERE id IN ('.$ids.')';
        $r = mysqli_query($conn, $q);

        if($r)
            return true;
        else
            return false;
    }

    function addCategory($conn, $cat){
        $q = 'INSERT INTO category VALUES (null, "'.$cat.'")';
        $r = mysqli_query($conn, $q);

        if($r){
            $q1 = 'SELECT * FROM category WHERE name="'.$cat.'"';
            $r1 = mysqli_query($conn, $q1);
            if(mysqli_num_rows($r1) == 1){
                $row = mysqli_fetch_array($r1);
                $id = $row['id'];
                return $id; 
            }
            else
                return false;
        }
        else
            return false;
    }

?>
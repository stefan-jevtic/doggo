<?php
    if($_SESSION['role']){
        session_destroy();
        header('Location: http://localhost/doggo/index.php');
    }
?>
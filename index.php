<?php
session_start();
include("server/connection.php");
include("server/model.php");

?>

<html>
    <head>
        <script defer src="https://use.fontawesome.com/releases/v5.0.4/js/all.js"></script>
        <script type="text/javascript" src="public/javascripts/jquery-3.2.1.js"></script>
        <script type="text/javascript" src="public/javascripts/main.js"></script>
        <script type="text/javascript" src="public/javascripts/adminpanel.js"></script>
        <script type="text/javascript" src="public/javascripts/upload.js"></script>
        <script type="text/javascript" src="public/javascripts/explorefeed.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
        <link rel="stylesheet" href="public/css/style.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="row">
            <div class="col-md-12">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <a class="navbar-brand" href="#">DOGGO</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav">
                        <?php

                            $links = getLinks($conn);
                            $links1 = getLinks($conn);
                            
                            while($row = mysqli_fetch_array($links)){

                                if($row['dropdown']==0){
                                    if($row['name'] == 'home'){
                                        ?>
                                        <li class="nav-item active">
                                            <a class="nav-link" href="index.php?id=<?php echo $row['id'];?>"><span class="sr-only">(current)</span><?php echo $row['name']; ?></a>
                                        </li>
                                        <?php
                                    }
                                    else{
                                        if($row['name'] == 'admin panel'){
                                            if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'){
                                        ?>      
                                                      
                                    <li class="nav-item">
                                        <a class="nav-link" href="index.php?id=<?php echo $row['id'];?>"><?php echo $row['name']; ?></a>
                                    </li>
                                
                                    <?php
                                            }
                                        }
                                        else{
                                            ?>
                                            <li class="nav-item">
                                        <a class="nav-link" href="index.php?id=<?php echo $row['id'];?>"><?php echo $row['name']; ?></a>
                                    </li>
                                            <?php
                                        }
                                    }
                                }
                            }
                        ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            More actions
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <?php
                                while($row1 = mysqli_fetch_array($links1)){
                                    if($row1['dropdown'] == 1){
                                        if(isset($_SESSION['username']) && ($row1['name'] == 'logout' || $row1['name'] == 'my profile' || $row1['name'] == 'upload doggo')){
                                ?>
                                    <a class="dropdown-item" href="index.php?id=<?php echo $row1['id'];?>"><?php echo $row1['name']; ?></a>
                                <?php
                                        }
                                        elseif(!$_SESSION['username'] && ($row1['name'] == 'sign up' || $row1['name'] == 'login')){
                                            ?>
                                                <a class="dropdown-item" href="index.php?id=<?php echo $row1['id'];?>"><?php echo $row1['name']; ?></a>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </div>
                        </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
            <div class="container">
                <?php
                    if(isset($_GET['id'])){
                    
                        $href = getPage($_GET['id'], $conn);
                       
                        include("includes/".$href);
                    }
                    else{
                        include("includes/home.php");
                    }
                ?>
            </div>
    </body>
</html>
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
        <link href="https://fonts.googleapis.com/css?family=Ubuntu+Mono" rel="stylesheet">
        <!-- FANCYBOX -->
        <link  href="public/javascripts/fancybox/dist/jquery.fancybox.min.css" rel="stylesheet">
        <script src="public/javascripts/fancybox/dist/jquery.fancybox.min.js"></script>
        <!-- END -->
        <script type="text/javascript" src="public/javascripts/adminpanel.js"></script>
        <script type="text/javascript" src="public/javascripts/upload.js"></script>
        <script type="text/javascript" src="public/javascripts/explorefeed.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
        <link rel="stylesheet" href="public/css/style.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
    </head>
    <body>
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
        <footer>
            <div class="footerHeader" ></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-4" >
                    <h3>Disclaimer!</h3>
                    <p>
                    I do not own most of the images posted here and it is not my intention to profit from this website in any way. This website is simply for educational purposes. All rights go to their respectful owners.
                    </p>
                </div>
                
                <div class="col-md-4">
                    <h3>Our Location </h3>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d181152.8874797972!2d20.2965498!3d44.811095!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x475a7aa3d7b53fbd%3A0x1db8645cf2177ee4!2z0JHQtdC-0LPRgNCw0LQ!5e0!3m2!1ssr!2srs!4v1518209229801" sytle="" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
                <div class="col-md-4" >
                    <h3>Contact Us</h3>
                    <ul>
                        <li>Phone : 123 - 456 - 789</li>
                        <li>E-mail : info@comapyn.com</li>
                        <li>Fax : 123 - 456 - 789</li>
                        <li>Author: <a href="http://jevticstefan.herokuapp.com/">Stefan Jevtic 45/15</a></li>
                        <li>Documentation: <a href="">docs</a></li>
                    </ul>
                    <ul class="sm">
                        <li><a href="https://www.facebook.com/hidoggo/" target="_blank"><img src="https://www.facebook.com/images/fb_icon_325x325.png" class="img-responsive"></a></li>
                        <li><a href="https://www.linkedin.com/nhome/?trk=" target="_blank"><img src="https://lh3.googleusercontent.com/00APBMVQh3yraN704gKCeM63KzeQ-zHUi5wK6E9TjRQ26McyqYBt-zy__4i8GXDAfeys=w300" class="img-responsive" ></a></li>
                        <li><a href="#" ><img src="http://playbookathlete.com/wp-content/uploads/2016/10/twitter-logo-4.png" class="img-responsive"  ></a></li>
                    </ul>
                </div>
                </div>
                
            </div>
        </footer>
    </body>
</html>
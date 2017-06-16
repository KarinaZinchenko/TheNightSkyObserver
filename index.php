<?php
session_start();
if(isset($_SESSION["autenticato"]))
{
    $loggato=true;
    include("navbar.php");
}
else
{
    $loggato=false;
}

?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>The Nignt Sky Observer</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">

    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-responsive.css">

    <link rel="stylesheet" href="css/custom-styles.css">

    <link rel="stylesheet" href="css/font-awesome.css">
    <link rel="stylesheet" href="css/font-awesome-ie7.css">

    <script src="js/modernizr-2.6.2-respond-1.1.0.min.js"></script>
</head>
<body>
<!--[if lt IE 7]>
<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
<![endif]-->


<div class="container">

    <div class="row-fluid">

        <div class="span10 offset1">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="index.php">
                            <div class="item">
                                <img src="img/logo.png" alt="">
                                <span id="saluto"></span>
                            </div>
                        </a>
                    </div>
                    <?php
                    if($loggato!=true)
                    {

                    ?>
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="login.php">Login</a></li>
                            <li id ="profilo"></li>
                            <li><a href="contact.php">Contattaci</a></li>
                            <li><a href="logout.php" id="logout" style="display: none">Log-out</a></li>
                        </ul>
                    </div>
                    <?php
                        }
                        else
                        {
                            ?>
                                   <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="index.php">Home</a></li>
                            <li id ="profilo"></li>
                            <li><a href="contact.php">Contattaci</a></li>
                            <li><a href="logout.php" id="logout" >Log-out</a></li>
                        </ul>
                    </div>
                             
                            <?php
                        }
                    ?>
                </div>
            </nav>

            <div class="banner-shadow">
                <div class="banner">
                    <div class="carousel slide" id="myCarousel" data-ride="carousel">
                        <!-- Carousel items -->
                        <div class="carousel-inner">
                            <div class="item active">
                                <img src="img/1.jpg" alt="">
                            </div>
                            <div class="item">
                                <img src="img/2.jpg" alt="">
                            </div>
                            <div class="item">
                                <img src="img/3.jpg" alt="">
                            </div>
                        </div>

                        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                        </a>
                        <a class="right carousel-control" href="#myCarousel" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                        </a>
                        <ol class="carousel-indicators">
                            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                            <li data-target="#myCarousel" data-slide-to="1"></li>
                            <li data-target="#myCarousel" data-slide-to="2"></li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="featured-heading">
                <div class="row-fluid">
                    <div class="span10 offset1">
                        <h1>Benvenuti!</h1>
                        <h2>Questo &egrave; il sito dell'osservatorio astronomico amatoriale <br>
                            <strong>The Night Sky Observer</strong> <br>
                            <?php
                            if($loggato!=true)
                                {?>
                            Per accedere ai contenuti &egrave; necessario effettuare il login</h2>
                        <a href="login.php" class="btn">login</a>
                        <?php
                               }
                        ?>
                    </div>
                </div>
            </div>
            <div class="portfolio-block">
                <div class="portfolio-title">
                    <h1>portfolio</h1>
                    <h2>Ecco alcune delle foto dei nostri soci</h2>
                </div>
                <div class="row-fluid">
                    <ul class="thumbnails">
                        <li class="no-space">
                            <a href="#" class="circle"><img src="img/a.png" alt=""></a>
                        </li>
                        <li>
                            <a href="#" class="circle"><img src="img/b.png" alt=""></a>
                        </li>
                        <li>
                            <a href="#" class="circle"><img src="img/c.png" alt=""></a>
                        </li>
                        <li>
                            <a href="#" class="circle"><img src="img/h.png" alt=""></a>
                        </li>
                        <li>
                            <a href="#" class="circle"><img src="img/e.png" alt=""></a>
                        </li>
                        <li>
                            <a href="#" class="circle"><img src="img/f.png" alt=""></a>
                        </li>
                        <li>
                            <a href="#" class="circle"><img src="img/g.png" alt=""></a>
                        </li>
                        <li>
                            <a href="#" class="circle"><img src="img/d.png" alt=""></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include ("footer.php");
?>


<script src="js/jquery-1.9.1.js"></script>
<script src="js/bootstrap.js"></script>
<script>
    $('#myCarousel').carousel({
        interval: 2000
    });
</script>

</body>
</html>

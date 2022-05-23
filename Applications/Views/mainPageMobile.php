<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../../Public/Styles/style.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Frisbee</title>
</head>
<body class="background">

<!--md - параметр указыввающий границу коллапса-->
<?php
include __DIR__ . "/Navbar/NavbarIfYouAut.php";
?>
<main>

    <div>
        <div class="carousel-inner">
            <div class="carousel-item active " >
                <img src="/Public/Images/www.png " class=" d-block w-100" alt="...">
                <div class="carousel-caption intro1">
                    <p>Don't know what to start talking about with recent colleagues or people you have frequent contact with? This site will help you do just that!</p>
                </div>
            </div>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active " >
                <img src="/Public/Images/lala.png" class="d-block w-100" alt="...">
                <div class="carousel-caption text-start col-4 intro1">
                    <!--                    <h5>Метка второго слайда</h5>-->
                    <p>Statistically, teams that communicate well are more effective at getting work done together. Our service provides effective tools for team building! </p>

                </div>
            </div>
        </div>

        <div class="carousel-inner">
            <div class="carousel-item active ">
                <img src="/Public/Images/qqq.png" class="d-block w-100" alt="...">
                <div class="carousel-caption text-start col-4 intro1">
                    <!--                    <h5>Метка третьего слайда</h5>-->
                    <p>Often forget your friends' birthdays? We'll remind you of that and advise you on what your friend might like!</p>

                </div>
            </div>
        </div>

        <div class="text-center">
            <a href="login">
                <button class="btn-lg btn-dark border border-white my-5 py-4 w-50" href="profile">Sign up today</button>
            </a>

        </div>
    </div>

</main>


</body>
</html>


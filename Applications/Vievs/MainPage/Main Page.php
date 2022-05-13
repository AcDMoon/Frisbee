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
    include __DIR__ . "/../Navbar/Navbar.php";
    ?>

    <main>

        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active " data-bs-interval="7500">
                    <img src="/Public/Images/www.png " class=" d-block w-100" alt="...">
                    <div class="carousel-caption intro1">
                        <p>Don't know what to start talking about with recent colleagues or people you have frequent contact with? This site will help you do just that!</p>
                        <button class="btn btn-dark border border-white" href="#">Sign up today</button>
                    </div>
                </div>
                <div class="carousel-item" data-bs-interval="7500">
                    <img src="/Public/Images/lala.png" class="d-block w-100" alt="...">
                    <div class="carousel-caption text-start col-4 intro1">
    <!--                    <h5>Метка второго слайда</h5>-->
                        <p>Statistically, teams that communicate well are more effective at getting work done together. Our service provides effective tools for team building! </p>
                        <button class="btn btn-dark border border-white" href="#">Sign up today</button>
                    </div>
                </div>
                <div class="carousel-item" data-bs-interval="7500">
                    <img src="/Public/Images/qqq.png" class="d-block w-100" alt="...">
                    <div class="carousel-caption text-start col-4 intro1">
    <!--                    <h5>Метка третьего слайда</h5>-->
                        <p>Often forget your friends' birthdays? We'll remind you of that and advise you on what your friend might like!</p>
                        <button class="btn btn-dark border border-white" href="#">Sign up today</button>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"  data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Предыдущий</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"  data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Следующий</span>
            </button>
        </div>
    </main>





</body>
</html>


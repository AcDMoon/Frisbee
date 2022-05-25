<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../Public/Styles/style.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Frisbee - Support</title>
</head>
<body class="background">

<?php
include __DIR__ . "/Navbar/Navbar.php";
?>

<main class="container my-5">
    <h1>Contacts</h1>
        <p class="fs-3">
            Email:
            <a class="fs-3" href="../../index.php">myemail@site.com</a>
        </p>
    <p class="fs-3">If you encounter a problem or have suggestions for improving the site, email us:</p>

    <form action="support" method="post">

    <textarea class="form-control" rows="10"></textarea>
    <button class="mt-4 w-25 btn btn-lg btn-dark" type="submit">Send</button>

    </form>
</main>

</body>
</html>

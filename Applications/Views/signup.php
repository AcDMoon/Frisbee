<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link  href="../../../Public/Styles/sign%20up.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Frisbee - Sign Up</title>
</head>
<body class="background text-center">

<main>
    <form class="border border-dark p-5 pb-1 radius" action="signup" method="post">

        <h1 class="mb-3 ">Sign up</h1>

        <div class="form-floating">
            <input type="email" class="form-control form-control-lg" name="E-mail" id="floatingEmail" placeholder="email" value="<?=$_POST['E-mail']?>">
            <label for="floatingEmail">Enter your email</label>
        </div>

        <p class="my-1 text-danger"><?=$result['Email_Error']?></p>

        <div class="form-floating">
            <input type="password" class="form-control form-control-lg" name="password" id="floatingPassword" placeholder="pass" >
            <label for="floatingPassword">Enter password</label>
        </div>

        <p class="my-1 text-danger"><?=$result['Password_Error']?></p>

        <div class="form-floating">
            <input type="text" class="form-control form-control-lg" name="name" id="floatingName" placeholder="name" value="<?=$_POST['name']?>">
            <label for="floatingName">Enter your full name</label>
        </div>

        <p class="my-1 text-danger"><?=$result['Name_Error']?></p>

        <div class="form-floating">
            <input type="date" class="form-control form-control-lg" name="date of birth" id="floatingDate" placeholder="date" value="<?=$_POST['date_of_birth']?>">
            <label for="floatingDate">Enter your date of birth</label>
        </div>

        <p class="my-1 text-danger"><?=$result['Date_Error']?></p>

        <button class="mt-4 w-100 btn btn-lg btn-dark" type="submit">Sign up</button>

        <div class="my-3">
            <a class="" href="login" >Do you already have an account?</a>
        </div>


    </form>
</main>

</body>
</html>
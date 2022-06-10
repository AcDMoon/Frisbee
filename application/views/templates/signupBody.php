<body class="background text-center">

<main>
    <form class="border border-dark p-5 pb-1 radius" action="signup" method="post">

        <h1 class="mb-3 ">Sign up</h1>

        <?php if (!isset($_POST['email'])) {
            $_POST['email'] = '';
        } ?>
        <div class="form-floating">
            <input type="email" class="form-control form-control-lg" name="email" id="floatingEmail" placeholder="email" value="<?=$_POST['email']?>">
            <label for="floatingEmail">Enter your email</label>
        </div>

        <ul class="text-start my-2">
            <?=$emailErrors?>
        </ul>

        <div class="form-floating">
            <input type="password" class="form-control form-control-lg" name="password" id="floatingPassword" placeholder="pass" >
            <label for="floatingPassword">Enter password</label>
        </div>

        <ul class="text-start my-2">
            <?=$passwordErrors?>
        </ul>

        <?php if (!isset($_POST['name'])) {
            $_POST['name'] = '';
        } ?>
        <div class="form-floating">
            <input type="text" class="form-control form-control-lg" name="name" id="floatingName" placeholder="name" value="<?=$_POST['name']?>">
            <label for="floatingName">Enter your full name</label>
        </div>

        <ul class="text-start my-2">
            <?=$nameErrors?>
        </ul>

        <?php if (!isset($_POST['date'])) {
            $_POST['date'] = '';
        } ?>
        <div class="form-floating">
            <input type="date" class="form-control form-control-lg" name="date" id="floatingDate" placeholder="date" value="<?=$_POST['date']?>">
            <label for="floatingDate">Enter your date of birth</label>
        </div>

        <ul class="text-start my-2">
            <?=$dateErrors?>
        </ul>

        <button class="mt-4 w-100 btn btn-lg btn-dark" type="submit">Sign up</button>

        <div class="my-3">
            <a class="" href="login" >Do you already have an account?</a>
        </div>

        <input type="hidden" name="push" value="true">

    </form>
</main>

</body>
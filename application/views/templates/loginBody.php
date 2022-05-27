<body class="background text-center">

<main>
    <?php if ($destination) {
        $destination = '?destination='.$destination;
    }?>
    <form class="border border-dark p-5 pb-1 radius" action="<?='Login'.$destination?>" method="post">

        <h1 class="mb-3 ">Log In</h1>

        <?php if (!isset($_POST['email'])) {
            $_POST['email'] = '';
        } ?>
        <div class="form-floating">
            <input type="email" class="form-control form-control-lg" id="floatingEmail" name="email" placeholder="email" value="<?=$_POST['email']?>">
            <label for="floatingEmail">Enter your email</label>
        </div>

        <?php if (!isset($warnings['email_error'])) {
            $warnings['email_error'] = '';
        } ?>
        <p class="my-1 text-danger my-2"><?=$warnings['email_error']?></p>

        <div class="form-floating">
            <input type="password" class="form-control form-control-lg" id="floatingPassword" name="password" placeholder="pass" >
            <label for="floatingPassword">Enter password</label>
        </div>

        <?php if (!isset($warnings['password_error'])) {
            $warnings['password_error'] = '';
        } ?>
        <p class="my-1 text-danger my-2"><?=$warnings['password_error']?></p>



        <button class="mt-2 w-100 btn btn-lg btn-dark" type="submit">Log In</button>

        <div class="mt-2 mb-1">
            <a class="" href="frisbee.com" >Forgot your password?</a>
        </div>

        <div class="mb-2">
            <a class="" href="signup" >Sign Up</a>
        </div>

        <input type="hidden" name="push" value="true">

    </form>
</main>
</body>
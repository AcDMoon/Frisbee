<body class="background text-center">

<main>

    <form class="border border-dark p-5 pb-1 radius" action="restore" method="post">

        <h1 class="mb-3 ">Restore password</h1>

        <?php if (!isset($data['email'])) {$data['email'] = '';} ?>
        <div class="form-floating">
            <input type="email" class="form-control form-control-lg" id="floatingEmail" name="email" placeholder="email" value="<?=$data['email']?>">
            <label for="floatingEmail">Enter your email</label>
        </div>

        <?php if (!isset($data['emailWarnings'])) {$data['emailWarnings'] = '';} ?>
        <p class="my-1 text-danger my-2"><?=$data['emailWarnings']?></p>



        <button class="mt-2 w-100 btn btn-lg btn-dark" type="submit">Restore</button>

        <div class="mt-2 mb-1">
            <a class="" href="login" >Log In</a>
        </div>

        <input type="hidden" name="push" value="true">

    </form>
</main>
</body>
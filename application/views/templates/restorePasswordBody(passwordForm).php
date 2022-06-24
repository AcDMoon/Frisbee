
<main>

    <form class="border border-dark p-5 pb-1 radius" id="formPassword" action="restore" method="post">

        <h1 class="mb-3 ">Restore password</h1>


        <div class="form-floating">
            <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="password" value="">
            <label for="floatingEmail">Enter new password</label>
        </div>

        <ul class="text-start my-2" id="passwordErrors">
        </ul>



        <button class="mt-2 w-100 btn btn-lg btn-dark" type="submit">Set password</button>

        <div class="mt-2 mb-1">
            <a class="" href="login" >Log In</a>
        </div>

        <input type="hidden" name="emailFromHash" value=<?=$data['emailFromHash']?> >

    </form>
</main>

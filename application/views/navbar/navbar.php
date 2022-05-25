

<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark py-0" aria-label="Fourth navbar example">
    <div class="container-fluid">

        <a class="navbar-brand py-0 text-warning me-auto" href="\ ">Frisbee</a>

        <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbars" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Переключить навигацию">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse " id="navbars">

            <ul class="navbar-nav ms-auto">

                <li class="nav-item px-3">
                    <a class="nav-link active " aria-current="page" href="AboutUs">About Us</a>
                </li>

                <li class="nav-item px-3">
                    <a class="nav-link active" aria-current="page" href="Support">Support</a>
                </li>

                <li class="nav-item px-3">
                    <a class="nav-link active" aria-current="page" href="Donation">Donation</a>
                </li>

                <?php if (!isset($name)) {
                    include __DIR__ . '/unreg-navbar.php';
                } else {
                    include __DIR__ . '/reg-navbar.php';
                }?>



            </ul>
        </div>
    </div>
</nav>





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

                <?php if (!$name){include __DIR__.'/NonReg.php';}else {include __DIR__.'/Reg.php';}?>

<!--                <li class="nav-item dropdown px-3 ">-->
<!--                    <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">-->
<!--                        Profile-->
<!--                    </a>-->
<!---->
<!--                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">-->
<!--                        <li><img class="p-1 border border-dark group-image col-7 my-auto" src="/Public/Images/avatar.jpg"></li>-->
<!--                        <li><p>Джозев джостар Абдулович</p></li>-->
<!--                        <li><hr class="dropdown-divider"></li>-->
<!--                        <li><a class="dropdown-item" href="#">Go to profile</a></li>-->
<!--                        <li><hr class="dropdown-divider"></li>-->
<!--                        <li><a class="dropdown-item" href="#">Log Out</a></li>-->
<!--                    </ul>-->
<!--                </li>-->

            </ul>
        </div>
    </div>
</nav>


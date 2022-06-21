<body class="background">

<?=$navbar?>

<div class="modal fade" id="downloadAvatar" tabindex="-1" aria-hidden="true" aria-labelledby="downloadAvatarLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="profileRedactor" method="post" id="formAvatar" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="downloadAvatarLabel">Download avatar</h5>
                </div>
                <div class="modal-body row justify-content-center mx-auto mt-3">
                    <input type="file" name="avatar" id="avatar" class="form-control">
                </div>

                <ul id="avatarErrors">
                </ul>

                <input type="hidden" name="primalEmail" value="<?=$email?>">

                <div class="modal-footer">
                    <button class="btn btn-primary profile_info me-auto" type="submit">Set image</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade " id="createGroup" tabindex="-1" aria-hidden="true" aria-labelledby="createGroupLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="profileRedactor" method="post" id="formGroup" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="createGroupLabel">Create your group</h5>
                </div>
                <div class="modal-body row justify-content-center form-floating mx-auto mt-3">
                    <input type="text" class="form-control" id="group" name="newGroup" placeholder="Name">
                    <label class="mx-3 mt-3" for="GroupName">Enter name of your future group</label>
                </div>

                <ul id="groupErrors">
                </ul>

                <input type="hidden" name="primalEmail" value="<?=$email?>">

                <div class="modal-footer">
                    <button class="btn btn-primary profile_info mx-auto" type="submit">Create</button>

                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade " id="changeData" tabindex="-1" aria-hidden="true" aria-labelledby="changeDataLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="profileRedactor" method="post" enctype="multipart/form-data" id="formData">
                <div class="modal-header">
                    <h4 class="modal-title" id="changeDataLabel">Change profile details</h4>
                </div>

                <h5 class="modal-title m-0 p-0 ms-3 pt-2" id="changeDataLabel">Change Full Name</h5>

                <div class="modal-body row justify-content-center form-floating mx-auto mt-3 pb-0">
                    <input type="text" class="form-control p-0 ps-2" name="name" id="name" placeholder="name" value="<?=$name?>">
                </div>

                <ul id="nameErrors">
                </ul>

                <h5 class="modal-title m-0 p-0 ms-3 pt-2" id="changeDataLabel">Change Date of Birth</h5>

                <div class="modal-body row justify-content-center form-floating mx-auto mt-3 pb-0">
                    <input type="date" class="form-control p-0 ps-2" name="date" id="date" placeholder="date" value="<?=$date?>">
                </div>

                <ul id="dateErrors">
                </ul>

                <input type="hidden" name="primalEmail" value="<?=$email?>">

                <div class="modal-footer">
                    <button class="btn btn-primary profile_info mx-auto" type="submit">Change</button>
                </div>
            </form>
        </div>
    </div>
</div>


<main class="container">




    <div class="container mt-5">
        <div class="d-flex gap-2">
            <div class="col-9">

                <div class="row justify-content-center">


                    <div class="col-5 text-center p-0 mx-2">
                        <img class="img-fluid border border-dark avatar d-block mx-auto" src="<?=$avatar?>" alt="X_X">
                        <div class="my-1" style="background-color: rgba(0,118,247,0.2)">
                            <button class="btn btn-outline-primary w-100 profile_info" data-bs-toggle="modal" data-bs-target="#downloadAvatar">set image</button>
                        </div>
                    </div>

                    <?php if (!isset($email)) {
                        $email = '';
                    } ?>
                    <div class="col-md-6 col-sm-12 profile_info mx-2">
                        <div class="mb-3 ps-1">
                            <p class="bg-light p-1 mb-0 border border-dark" id="primalEmail">Email: <?=$email?></p>

                        </div>

                        <?php if (!isset($name)) {
                            $name = '';
                        } ?>
                        <div class="mb-3 ps-1">
                            <p class="bg-light p-1 mb-0 border border-dark" id="primalName">Full name: <?=$name?></p>

                        </div>

                        <?php if (!isset($date)) {
                            $date = '';
                        } ?>
                        <div class="mb-3 ps-1">
                            <p class=" bg-light p-1 mb-0 border border-dark" id="primalDate">Date of birth: <?=$date?></p>

                        </div>

                        <div class="mb-3 ps-1 text-center">
                            <a href="" data-bs-toggle="modal" data-bs-target="#changeData">Change profile details</a>
                        </div>

                        <div class="ps-0 mt-3 text-center">
                            <a class="" href="#">
                                <button class="sm-button mt-2 btn admin-btn btn-dark profile_info w-75" type="adminpage">Admin page</button>
                            </a>
                        </div>
                    </div>
                </div>


                <div>
                    <h3 class="fw-bold text-center border-bottom border-dark p-3 mt-4">My groups</h3>
                </div>

                <div class="row justify-content-center text-center mx-2 d-flex justify-content-evenly">

                    <?=$groups?>

                    <button class="row justify-content-center col-12 col-sm-9 col-md-7 col-lg-5 bg-light radius mx-4 mb-4" data-bs-toggle="modal" data-bs-target="#createGroup">
                        <img class="p-1 img-fluid col-3 my-auto" src="/images/plus.webp">
                        <p class="col fw-bold fs-6 no_wrap my-auto pe-0">Create new group</p>
                    </button>

                </div>
            </div>



            <div class="row col-3 border border-dark mx-1 mb-5 radius profile_info bg-light">

                <div class="col-12 no_wrap border-bottom text-center border-dark">
                    Upcoming birthdays
                </div>

                <div class="col-12 no_wrap border-bottom text-center border-dark bg-warning">
                    Find
                </div>

                <div class="col-12 no_wrap border-bottom border-dark p-0 ps-2 ">
                    <p class="m-0 fw-bold">Джозеф Джостар Абдулович</p>
                    <p class="m-0 fst-italic">Мои лучшие друзья</p>
                    <p class="m-0 fst-normal">1 Апреля</p>
                </div>

                <div class="col-12 no_wrap border-bottom border-dark p-0 ps-2">
                    <p class="m-0 fw-bold">Джозеф Джостар Абдулович</p>
                    <p class="m-0 fst-italic">Мои лучшие друзья</p>
                    <p class="m-0 fst-normal">1 Апреля</p>
                </div>
                <div class="col-12 no_wrap border-bottom border-dark p-0 ps-2">
                    <p class="m-0 fw-bold">Джозеф Джостар Абдулович</p>
                    <p class="m-0 fst-italic">Мои лучшие друзья</p>
                    <p class="m-0 fst-normal">1 Апреля</p>
                </div>
                <div class="col-12 no_wrap border-bottom border-dark p-0 ps-2">
                    <p class="m-0 fw-bold">Джозеф Джостар Абдулович</p>
                    <p class="m-0 fst-italic">Мои лучшие друзья</p>
                    <p class="m-0 fst-normal">1 Апреля</p>
                </div>
                <div class="col-12 no_wrap border-bottom border-dark p-0 ps-2">
                    <p class="m-0 fw-bold">Джозеф Джостар Абдулович</p>
                    <p class="m-0 fst-italic">Мои лучшие друзья</p>
                    <p class="m-0 fst-normal">1 Апреля</p>
                </div>
                <div class="col-12 no_wrap border-bottom border-dark p-0 ps-2">
                    <p class="m-0 fw-bold">Джозеф Джостар Абдулович</p>
                    <p class="m-0 fst-italic">Мои лучшие друзья</p>
                    <p class="m-0 fst-normal">1 Апреля</p>
                </div>
                <div class="col-12 no_wrap border-bottom border-dark p-0 ps-2">
                    <p class="m-0 fw-bold">Джозеф Джостар Абдулович</p>
                    <p class="m-0 fst-italic">Мои лучшие друзья</p>
                    <p class="m-0 fst-normal">1 Апреля</p>
                </div>
                <div class="col-12 no_wrap border-bottom border-dark p-0 ps-2">
                    <p class="m-0 fw-bold">Джозеф Джостар Абдулович</p>
                    <p class="m-0 fst-italic">Мои лучшие друзья</p>
                    <p class="m-0 fst-normal">1 Апреля</p>
                </div>
                <div class="col-12 no_wrap border-bottom border-dark p-0 ps-2">
                    <p class="m-0 fw-bold">Джозеф Джостар Абдулович</p>
                    <p class="m-0 fst-italic">Мои лучшие друзья</p>
                    <p class="m-0 fst-normal">1 Апреля</p>
                </div>
                <div class="col-12 no_wrap border-bottom border-dark p-0 ps-2">
                    <p class="m-0 fw-bold">Джозеф Джостар Абдулович</p>
                    <p class="m-0 fst-italic">Мои лучшие друзья</p>
                    <p class="m-0 fst-normal">1 Апреля</p>
                </div>
            </div>
        </div>
    </div>


</main>
<?=$script?>
</body>

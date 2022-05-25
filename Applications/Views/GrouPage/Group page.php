<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../../Public/Styles/GroupPageStyle.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Frisbee - My firs group</title>
</head>
<body class="background">

<!--Модальное окно приглашения-->

<div class="modal fade " id="addMember" tabindex="-1" aria-hidden="true" aria-labelledby="addMemberLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="#" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMemberLabel">Add member</h5>
                </div>
                <div class="modal-body row justify-content-center form-floating ">
                    <input type="email" class="form-control ms-1" id="GroupName" placeholder="Email">
                    <label class="mx-3 mt-3" for="GroupName">Enter email</label>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary profile_info mx-auto" type="submit" data-bs-toggle="modal" data-bs-target="#addMember2">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Модальное окно удаления участника-->
<div class="modal fade" id="deleteMembers" tabindex="-1" aria-labelledby="deleteMembersLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="#" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Select members</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row d-flex ">
                            <div class="col-3 mb-2">
                                <input type="checkbox" class="btn-check" id="btn-check-outlined1" autocomplete="off">
                                <label class="btn col-12 no_wrap btn-outline-primary" for="btn-check-outlined1">Качан Бахтынович Кулич</label>
                            </div>
                            <div class="col-3 mb-2">
                                <input type="checkbox" class="btn-check" id="btn-check-outlined2" autocomplete="off">
                                <label class="btn col-12 no_wrap btn-outline-primary" for="btn-check-outlined2">Качан Бахтынович Кулич</label>
                            </div>
                            <div class="col-3 mb-2">
                                <input type="checkbox" class="btn-check" id="btn-check-outlined3" autocomplete="off">
                                <label class="btn col-12 no_wrap btn-outline-primary" for="btn-check-outlined3">Качан Бахтынович Кулич</label>
                            </div>
                            <div class="col-3 mb-2">
                                <input type="checkbox" class="btn-check" id="btn-check-outlined4" autocomplete="off">
                                <label class="btn col-12 no_wrap btn-outline-primary" for="btn-check-outlined4">Качан Бахтынович Кулич</label>
                            </div>
                            <div class="col-3 mb-2">
                                <input type="checkbox" class="btn-check" id="btn-check-outlined5" autocomplete="off">
                                <label class="btn col-12 no_wrap btn-outline-primary" for="btn-check-outlined5">Качан Бахтынович Кулич</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary profile_info mx-auto" type="submit" data-bs-toggle="modal" data-bs-target="#addMember2">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>




<!--md - параметр указыввающий границу коллапса-->
<?php
include __DIR__ . "/../Navbar/Navbar.php";
?>



<main class="container ">

    <!--  If пользователь модератор:  -->
    <div class="dropdown dropend ms-4">
        <button class="dropdown-toggle sm-button mt-2 btn btn-dark" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">Moderation</button>
        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton1">
            <li><a class="fs-5 dropdown-item" data-bs-toggle="modal" data-bs-target="#deleteMembers">Delete member</a></li>
            <li><a class="fs-5  dropdown-item" href="#">Add moderators</a></li>
            <li><a class="fs-5  dropdown-item" href="#">Set group avatar</a></li>
            <li><a class="fs-5  dropdown-item" href="#">Rename group</a></li>
            <li><a class="fs-5  dropdown-item" href="#">Delete group</a></li>
        </ul>
    </div>



    <!--контейнер для всего функционала профиля кроме админки-->
    <div class="container mt-3 ">
        <div class="d-flex gap-2 ">
            <div class="col-9 ">
<!--                Сведения о юзере-->
                <div class="row justify-content-center">
<!--                    Аватарка-->
                    <div class="col-5  text-center p-0 mx-2">
                        <img class="img-fluid border border-dark avatar d-block mx-auto" src="../../../Public/Images/да.jpg" alt="">
                    </div>
<!--                        Сами данные-->
                    <div class="row col-md-6 col-sm-12 profile_info mx-2">

                        <div class="mb-1 ps-1">
                            <h2 class="p-1 mb-0 fw-bold text-center group_name_family">My first group</h2>
                        </div>



                        <div class="col align-self-end">
                            <p class="profile_info text-center alert-link mb-1">Birthday Tracker</p>
                            <button type="button"  class="col-12 btn btn-outline-success profile_info my-1">Enable all </button>
                            <button type="button" class="col-12 btn btn-outline-danger profile_info my-1">Disable everything</button>
                        </div>

                    </div>
                </div>



<!--                Панель групп-->

                    <div>
                        <h3 class="fw-bold text-center border-bottom border-dark p-3 mt-4">Group members</h3>
                    </div>

                    <div class="row text-center mx-2 d-flex justify-content-evenly">



                    <button class="row justify-content-evenly col-12 col-sm-9 col-md-7 col-lg-5 bg-custom radius mx-4 mb-4">
                        <img class="p-1 border border-dark group-image img-fluid col-2 my-auto" src="../../../Public/Images/avatar.jpg">
                        <p class="col-6 fw-bold fs-6 no_wrap my-auto pe-0">Джозеф Джостар Абдулович</p>
                        <div class="col form-switch my-auto pe-0">
                            <input class="form-check-input" type="checkbox" role="switch">
                        </div>
                    </button>





                    <button class="row justify-content-evenly col-12 col-sm-9 col-md-7 col-lg-5 bg-custom radius mx-4 mb-4">
                        <img class="p-1 border border-dark group-image img-fluid col-2 my-auto" src="../../../Public/Images/avatar.jpg">
                        <p class="col-6 fw-bold fs-6 no_wrap my-auto pe-0">Джозеф Джостар Абдулович</p>
                        <div class="col form-switch my-auto pe-0">
                            <input class="form-check-input" type="checkbox" role="switch">
                        </div>
                    </button>

                    <button class="row justify-content-evenly col-12 col-sm-9 col-md-7 col-lg-5 bg-custom radius mx-4 mb-4">
                        <img class="p-1 border border-dark group-image img-fluid col-2 my-auto" src="../../../Public/Images/avatar.jpg">
                        <p class="col-6 fw-bold fs-6 no_wrap my-auto pe-0">Джозеф Джостар Абдулович</p>
                        <div class="col form-switch my-auto pe-0">
                            <input class="form-check-input" type="checkbox" role="switch" checked>
                        </div>
                    </button>

                    <button class="row justify-content-evenly col-12 col-sm-9 col-md-7 col-lg-5 bg-custom radius mx-4 mb-4">
                        <img class="p-1 border border-dark group-image img-fluid col-2 my-auto" src="../../../Public/Images/avatar.jpg">
                        <p class="col-6 fw-bold fs-6 no_wrap my-auto pe-0">Джозеф Джостар Абдулович</p>
                        <div class="col form-switch my-auto pe-0">
                            <input class="form-check-input" type="checkbox" role="switch" checked>
                        </div>
                    </button>

                    <button class="row justify-content-center col-12 col-sm-9 col-md-7 col-lg-5 bg-light radius mx-4 mb-4" data-bs-toggle="modal" data-bs-target="#addMember">
                        <img class="p-1 img-fluid col-2 group-image my-auto" src="../../../Public/Images/plus.webp">
                        <p class="col fw-bold fs-6 no_wrap my-auto pe-0">Add new member</p>
                    </button>


                </div>
            </div>


<!--                Боковой интерфейс с поисковиком и фильтром-->
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

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../../public/styles/style.css"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Frisbee - Profile</title>
</head>
<body class="background">

<?php
include __DIR__ . "/navbar/navbar.php";
?>


<div class="modal fade" id="downloadAvatar" tabindex="-1" aria-hidden="true" aria-labelledby="downloadAvatarLabel">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="#" method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="downloadAvatarLabel">Download avatar</h5>
        </div>
        <div class="modal-body row justify-content-center">

          <input type="file" class="form-control ms-1">
        </div>

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
      <form action="#" method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="createGroupLabel">Create your group</h5>
        </div>
        <div class="modal-body row justify-content-center form-floating ">
          <input type="text" class="form-control ms-1" id="GroupName" placeholder="Name">
          <label class="mx-3 mt-3" for="GroupName">Enter name of your future group</label>
        </div>

        <div class="modal-footer">
          <button class="btn btn-primary profile_info mx-auto" type="submit">Create</button>

        </div>
      </form>
    </div>
  </div>
</div>

<main class="container">


  <div class="container ps-0 mt-3">
    <a class="" href="https://www.google.ru/">

      <button class="sm-button mt-2 btn admin-btn btn-dark" type="adminpage">Admin page</button>

    </a>
  </div>

  <div class="container mt-3">
    <div class="d-flex gap-2">
      <div class="col-9">

        <div class="row justify-content-center">

          <div class="col-5 text-center p-0 mx-2">
            <img class="img-fluid border border-dark avatar d-block mx-auto" src="../../public/images/avatar.jpg" alt="">
            <button class="btn btn-outline-primary my-1 w-100 profile_info" data-bs-toggle="modal" data-bs-target="#downloadAvatar">set image</button>
          </div>

            <?php if (!isset($email)) {
                $email = '';
            } ?>
          <div class="col-md-6 col-sm-12 profile_info mx-2">
            <div class="mb-3 ps-1">
                <p class="bg-light p-1 mb-0 border border-dark">Email: <?=$email?></p>

            </div>

              <?php if (!isset($FullName)) {
                    $FullName = '';
              } ?>
            <div class="mb-3 ps-1">
              <p class="bg-light p-1 mb-0 border border-dark">Full name: <?=$FullName?></p>

            </div>

              <?php if (!isset($DateOfBirth)) {
                    $DateOfBirth = '';
              } ?>
            <div class="mb-3 ps-1">
              <p class=" bg-light p-1 mb-0 border border-dark">Date of birth: <?=$DateOfBirth?></p>

            </div>

              <div class="mb-3 ps-1 text-center">
                  <a href="">Change profile details</a>
              </div>
          </div>
        </div>




        <div>
          <h3 class="fw-bold text-center border-bottom border-dark p-3 mt-4">My groups</h3>
        </div>

        <div class="row justify-content-center text-center mx-2 d-flex justify-content-evenly">

          <button class="row justify-content-center col-12 col-sm-9 col-md-7 col-lg-5 bg-custom radius mx-4 mb-4">
            <img class="p-1 border border-dark group-image img-fluid col-3 my-auto" src="../../public/images/avatar.jpg">
            <p class="col fw-bold fs-6 no_wrap my-auto pe-0">my best group ever ever ever ever ever ever ever ever ever ever ever ever ever ever</p>
          </button>

          <button class="row justify-content-center col-12 col-sm-9 col-md-7 col-lg-5 bg-custom radius mx-4 mb-4">
            <img class="p-1 border border-dark group-image img-fluid col-3 my-auto" src="../../public/images/avatar.jpg">
            <p class="col fw-bold fs-6 no_wrap my-auto pe-0">my group 2</p>
          </button>

          <button class="row justify-content-center col-12 col-sm-9 col-md-7 col-lg-5 bg-custom radius mx-4 mb-4">
            <img class="p-1 border border-dark group-image img-fluid col-3 my-auto" src="../../public/images/avatar.jpg">
            <p class="col fw-bold fs-6 no_wrap my-auto pe-0">my group 3</p>
          </button>

          <button class="row justify-content-center col-12 col-sm-9 col-md-7 col-lg-5 bg-light radius mx-4 mb-4" data-bs-toggle="modal" data-bs-target="#createGroup">
            <img class="p-1 img-fluid col-3 my-auto" src="../../public/images/plus.webp">
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

</body>
</html>

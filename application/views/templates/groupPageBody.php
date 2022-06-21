<body class="background">

<?=$navbar?>



<div class="modal fade" id="addMember" tabindex="-1" aria-hidden="true" aria-labelledby="addMemberLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?=$url . 'editGroup'?>" method="post" enctype="multipart/form-data" id="formInviteUser">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMemberLabel">Add member</h5>
                </div>

                <input type="hidden" name="groupId" id="groupId" value="<?=$groupId?>">

                <input type="hidden" name="addMember" value="true">

                <div class="modal-body row justify-content-center form-floating mx-auto pb-0">
                    <input type="email" class="form-control ms-1" name="newMemberEmail" id="userEmail" placeholder="Email">
                    <label class="mx-3 mt-3" for="userEmail">Enter email</label>
                </div>

                <ul id="emailErrors">
                </ul>

                <div class="modal-footer">
                    <button class="btn btn-primary profile_info mx-auto" type="submit">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteMembers" tabindex="-1" aria-labelledby="deleteMembersLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?=$url . 'editGroup'?>" method="post" enctype="multipart/form-data" id="formDeleteMembers">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Select members</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <input type="hidden" name="groupId" value="<?=$groupId?>">

                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row d-flex">

                            <?=$deleteList?>

                        </div>
                    </div>
                </div>

                <p class="text-center" style="color: red" id="deleteMemberWarning"></p>

                <div class="modal-footer">
                    <button class="btn btn-primary profile_info mx-auto" type="submit">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addModerators" tabindex="-1" aria-labelledby="addModeratorsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?=$url . 'editGroup'?>" method="post" enctype="multipart/form-data" id="formAddModerators">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Select members</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <input type="hidden" name="groupId" value="<?=$groupId?>">

                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row d-flex">

                            <?=$addModeratorsList?>

                        </div>
                    </div>
                </div>

                <p class="text-center" style="color: red" id="addModeratorsWarning"></p>

                <div class="modal-footer">
                    <button class="btn btn-primary profile_info mx-auto" type="submit">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="downloadGroupAvatar" tabindex="-1" aria-hidden="true" aria-labelledby="downloadGroupAvatarLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?=$url . 'editGroup'?>" method="post" id="formGroupAvatar" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="downloadGroupAvatarLabel">Download avatar</h5>
                </div>

                <input type="hidden" name="groupId" value="<?=$groupId?>">

                <div class="modal-body row justify-content-center mx-auto pb-0">
                    <input type="file" name="groupAvatar" id="avatar" class="form-control ms-1">
                </div>

                <ul id="avatarErrors">
                </ul>

                <div class="modal-footer">
                    <button class="btn btn-primary profile_info me-auto" type="submit">Set image</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="renameGroup" tabindex="-1" aria-hidden="true" aria-labelledby="renameGroupLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?=$url . 'editGroup'?>" method="post" enctype="multipart/form-data" id="formRenameGroup">
                <div class="modal-header">
                    <h5 class="modal-title" id="renameGroupLabel">Add member</h5>
                </div>

                <input type="hidden" name="groupId" id="groupId" value="<?=$groupId?>">

                <div class="modal-body row justify-content-center form-floating mx-auto pb-0">
                    <input type="text" class="form-control ms-1" name="newGroupName" id="groupName" placeholder="New group name">
                    <label class="mx-3 mt-3" for="groupName">Enter new group name</label>
                </div>

                <ul id="groupNameErrors">
                </ul>

                <div class="modal-footer">
                    <button class="btn btn-primary profile_info mx-auto" type="submit">Change</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteGroup" tabindex="-1" aria-hidden="true" aria-labelledby="deleteGroupLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?=$url . 'editGroup'?>" method="post" enctype="multipart/form-data" id="formDeleteGroup">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteGroupLabel">Delete group</h5>
                </div>

                <input type="hidden" name="groupId" id="groupId" value="<?=$groupId?>">

                <input type="hidden" name="deleteGroup" value="true">

                <div class="modal-body row justify-content-center form-floating ">
                    <h5 class="mx-3 mt-3 text-center bold" style="color: red">This action will completely remove this group. Are you sure you want to continue?</h5>

                </div>

                <p class="text-center" style="color: red" id="deleteGroupWarning"></p>

                <div class="modal-footer">
                    <button class="btn btn-primary profile_info mx-auto" type="submit">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<main class="container ">

    <?=$moderatorButton?>

    <div class="container mt-3 ">
        <div class="d-flex gap-2 ">
            <div class="col-9 ">

                <div class="row justify-content-center">

                    <div class="col-5  text-center p-0 mx-2">
                        <img class="img-fluid border border-dark avatar d-block mx-auto" src="<?=$groupAvatar?>" alt="">
                    </div>

                    <div class="row col-md-6 col-sm-12 profile_info mx-2">

                        <div class="mb-1 ps-1">
                            <h2 class="p-1 mb-0 fw-bold text-center group_name_family" id="primalName"> <?=$groupName?> </h2>
                        </div>

                        <div class="col align-self-end">
                            <p class="profile_info text-center alert-link mb-1">Birthday Tracker</p>
                            <button type="button"  class="col-12 btn btn-outline-success profile_info my-1" id="allChecked">Enable all</button>
                            <input type="hidden" name="usersId" id="usersId" value="<?=$usersId?>">
                            <input type="hidden" name="currentUserId" id="currentUserId" value="<?=$currentUserId?>">
                            <button type="button" class="col-12 btn btn-outline-danger profile_info my-1" id="allUnChecked">Disable everything</button>
                        </div>

                    </div>
                </div>

                <div>
                    <h3 class="fw-bold text-center border-bottom border-dark p-3 mt-4">Group members</h3>
                </div>

                <div class="row text-center mx-2 d-flex justify-content-evenly">

                    <?=$userList?>

                    <button class="row justify-content-center col-12 col-sm-9 col-md-7 col-lg-5 bg-light radius mx-4 mb-4" data-bs-toggle="modal" data-bs-target="#addMember">
                        <img class="p-1 img-fluid col-2 group-image my-auto" src="http://frisbee//images/plus.webp">
                        <p class="col fw-bold fs-6 no_wrap my-auto pe-0">Add new member</p>
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
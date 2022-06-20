<button class="row justify-content-evenly col-12 col-sm-9 col-md-7 col-lg-5 bg-custom radius mx-4 mb-4">
    <img class="p-1 border border-dark group-image img-fluid col-2 my-auto" src=" <?=$avatar?> ">
    <p class="col-6 fw-bold fs-6 no_wrap my-auto pe-0"> <?=$name?> </p>
    <div class="col form-switch my-auto pe-0">
        <?php $aa = 'checked' ?>
        <form action="" method="post" enctype="multipart/form-data" id="formGroupMember" name="formsGroupMembers">
            <input class="form-check-input" type="checkbox" role="switch" id="memberSwitch" name="memberSwitch" value="<?=$userIsTracked?>" <?=$isChecked?>>
            <input type="hidden" name="userId" id="userId" value="<?=$userId?>">
        </form>
    </div>
</button>


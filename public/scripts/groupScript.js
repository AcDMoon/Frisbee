"use strict"

document.addEventListener('DOMContentLoaded', function () {
    const formDeleteMembers = document.getElementById('formDeleteMembers'),
    deleteMembers = document.getElementById('deleteMembers'),
    formInviteUser = document.getElementById('formInviteUser'),
    formAddModerators = document.getElementById('formAddModerators'),
    addModerators = document.getElementById('addModerators'),
    formGroupAvatar = document.getElementById('formGroupAvatar'),
    formRenameGroup = document.getElementById('formRenameGroup'),
    formDeleteGroup = document.getElementById('formDeleteGroup'),
    deleteGroup = document.getElementById('deleteGroup'),
    formGroupMember = document.getElementById('formGroupMember');
    // formGroupMember = document.getElementsByName('formsGroupMembers');
    console.log(formGroupMember);


    deleteMembers.addEventListener('hidden.bs.modal', deleteMembersClose);
    formDeleteMembers.addEventListener('submit', formDeleteMembersSend);
    formInviteUser.addEventListener('submit', formInviteUserSend);
    formAddModerators.addEventListener('submit', formAddModeratorsSend);
    addModerators.addEventListener('hidden.bs.modal', addModeratorsClose);
    formGroupAvatar.addEventListener('submit', formGroupAvatarSend);
    formRenameGroup.addEventListener('submit', formRenameGroupSend);
    formDeleteGroup.addEventListener('submit', formDeleteGroupSend);
    deleteGroup.addEventListener('hidden.bs.modal', deleteGroupClose);
    formGroupMember.addEventListener('click', formGroupMemberFocus);

    async function formDeleteMembersSend(event)
    {
        const deleteMemberWarning = formDeleteMembers.querySelector('#deleteMemberWarning');
        if (deleteMemberWarning.innerHTML === '') {
            deleteMemberWarning.innerHTML = 'Do you really want to remove selected members? (Click "Delete" again to continue)';
            event.preventDefault();
        }
    }


    async function deleteMembersClose(event)
    {
        const deleteMemberWarning = formDeleteMembers.querySelector('#deleteMemberWarning');
        if (deleteMemberWarning.innerHTML !== '') {
            deleteMemberWarning.innerHTML = '';
        }
    }


    async function formInviteUserSend(event)
    {
        const email = formInviteUser.querySelector('#userEmail'),
        emailErrorsObject = formInviteUser.querySelector('#emailErrors'),
        groupId = formInviteUser.querySelector('#groupId');

        removeErrors(emailErrorsObject);

        let emailErrors = emailValidation(email, groupId);


        if (emailErrors.length !== 0) {
            emailErrors.forEach(element => addTag(emailErrorsObject, element));
            event.preventDefault();
        }

        const request = new XMLHttpRequest();
        const url = 'http://frisbee/editProfile';
        const params = 'addMember=true&email=' + email.value + '&groupId=' + groupId.value;
        request.open("POST", url, true);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.send(params);
    }


    async function formAddModeratorsSend(event)
    {
        const addModeratorsWarning = formAddModerators.querySelector('#addModeratorsWarning');
        if (addModeratorsWarning.innerHTML === '') {
            addModeratorsWarning.innerHTML = 'Are you sure you want to give these members moderator rights? (Click "Add" again to continue)';
            event.preventDefault();
        }
    }


    async function addModeratorsClose(event)
    {
        const addModeratorsWarning = formAddModerators.querySelector('#addModeratorsWarning');
        if (addModeratorsWarning.innerHTML !== '') {
            addModeratorsWarning.innerHTML = '';
        }
    }


    async function formGroupAvatarSend(event)
    {
        const avatar = formGroupAvatar.querySelector('#avatar'),
            avatarErrorsObject = formGroupAvatar.querySelector('#avatarErrors');

        removeErrors(avatarErrorsObject);

        if (avatar.files.length === 0) {
            event.preventDefault();
            return;
        }

        let avatarErrors = avatarValidation(avatar.files[0]);


        if (avatarErrors.length !== 0) {
            avatarErrors.forEach(element => addTag(avatarErrorsObject, element));
            event.preventDefault();
        }
    }


    async function formRenameGroupSend(event)
    {
        const group = formRenameGroup.querySelector('#groupName'),
            groupNameErrorsObject = formRenameGroup.querySelector('#groupNameErrors');

        removeErrors(groupNameErrorsObject);

        let groupErrors = groupValidation(group);

        if (groupErrors.length !== 0) {
            groupErrors.forEach(element => addTag(groupNameErrorsObject, element));
            event.preventDefault();
        }
    }


    async function formDeleteGroupSend(event)
    {
        const deleteGroupWarning = formDeleteGroup.querySelector('#deleteGroupWarning');
        if (deleteGroupWarning.innerHTML === '') {
            deleteGroupWarning.innerHTML = 'This is your last chance to change your mind. (click "Delete" again to continue)';
            event.preventDefault();
        }
    }


    async function deleteGroupClose(event)
    {
        const deleteGroupWarning = formDeleteGroup.querySelector('#deleteGroupWarning');
        if (deleteGroupWarning.innerHTML !== '') {
            deleteGroupWarning.innerHTML = '';
        }
    }


    async function formGroupMemberFocus(event)
    {
        const memberSwitch = formGroupMember.querySelector('#memberSwitch');
        if (memberSwitch.value === 'off') {
            memberSwitch.value = 'on';
        } else {
            memberSwitch.value = 'off';
        }
        console.log(memberSwitch.value);
    }



    function groupValidation(group)
    {
        let groupErrors = [];

        if (group.value === '') {
            groupErrors.push('The field must not be empty!');
        }

        if (group.value.length > 50) {
            groupErrors.push('Group name must not exceed 50 characters!');
        }
        return groupErrors;
    }


    function emailValidation(email, groupId)
    {
        let emailErrors = [];

        const request = new XMLHttpRequest();
        const url = 'http://frisbee/groupInviteCheck';

        const params = 'email=' + email.value + '&groupId=' + groupId.value;

        request.open("POST", url, false);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        request.addEventListener("readystatechange", () => {

            if (request.readyState === 4 && request.status === 200) {
                let requestResult = request.response;
                requestResult = requestResult.split(' ');
                let emailIsExist = requestResult[0];
                let userInGroup = requestResult[1];

                if (emailIsExist !== 'true') {
                    emailErrors.push('This email is already taken!');
                }

                if (userInGroup !== 'false') {
                    emailErrors.push('This user is already in the group!');
                }
            }
        });

        request.send(params);

        if (email.value === '') {
            emailErrors.push('This field is required!');
        }

        if ((/\ /.test(email.value))) {
            emailErrors.push('Email must not contain spaces!');
        }

        if ((/[а-яё]/iu.test(email.value))) {
            emailErrors.push('Email must not contain the Russian alphabet!');
        }

        if (email.value.length > 40) {
            emailErrors.push('Email must be less than or equal to 40 characters!');
        }

        return emailErrors;
    }


    function avatarValidation(avatarFile)
    {
        let avatarErrors = [];

        if (!['image/jpeg', 'image/png', 'image/jpg'].includes(avatarFile.type)) {
            avatarErrors.push('Allowed formats are jpg, jpeg, png!');
        }

        if (avatarFile.size > 2 * 1024 * 1024) {
            avatarErrors.push('Image size must be less than 2MB');
        }

        return avatarErrors;
    }


    function addTag(object, value)
    {
        let div = document.createElement('li');
        div.className = "m-0 p-0 ms-2";
        div.style = "color: red";
        div.innerHTML = value
        object.append(div)
    }


    function removeErrors(object)
    {
        while (object.firstChild) {
            object.removeChild(object.firstChild);
        }
    }
});
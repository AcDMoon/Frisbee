"use strict"

document.addEventListener('DOMContentLoaded', function () {
    const formDeleteMembers = document.getElementById('formDeleteMembers'),
    deleteMembers = document.getElementById('deleteMembers'),
    formInviteUser = document.getElementById('formInviteUser'),
    formAddModerators = document.getElementById('formAddModerators'),
    addModerators = document.getElementById('addModerators');

    deleteMembers.addEventListener('hidden.bs.modal', deleteMembersClose);
    formDeleteMembers.addEventListener('submit', formDeleteMembersSend);
    formInviteUser.addEventListener('submit', formInviteUserSend);
    formAddModerators.addEventListener('submit', formAddModeratorsSend);
    addModerators.addEventListener('hidden.bs.modal', addModeratorsClose);

    async function formDeleteMembersSend(event)
    {
        const deleteMemberWarning = formDeleteMembers.querySelector('#deleteMemberWarning');
        if (deleteMemberWarning.innerHTML === '') {
            deleteMemberWarning.innerHTML = 'Do you really want to remove selected members? (Click "Delete" again to continue)'
            event.preventDefault();
        }
    }


    async function deleteMembersClose(event)
    {
        const deleteMemberWarning = formDeleteMembers.querySelector('#deleteMemberWarning');
        if (deleteMemberWarning.innerHTML !== '') {
            deleteMemberWarning.innerHTML = ''
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
            addModeratorsWarning.innerHTML = 'Are you sure you want to give these members moderator rights? (Click "Add" again to continue)'
            event.preventDefault();
        }
    }


    async function addModeratorsClose(event)
    {
        const addModeratorsWarning = formAddModerators.querySelector('#addModeratorsWarning');
        if (addModeratorsWarning.innerHTML !== '') {
            addModeratorsWarning.innerHTML = ''
        }
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
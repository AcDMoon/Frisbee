"use strict"

document.addEventListener('DOMContentLoaded', function () {
    const formPassword = document.getElementById('formPassword');
    formPassword.addEventListener('submit', formPasswordSend);



    async function formPasswordSend(event)
    {
        const password = formPassword.querySelector('#password'),
            passwordErrorsObject = formPassword.querySelector('#passwordErrors');

        removeErrors(passwordErrorsObject);

        let passwordErrors = passwordValidation(password);


        if (passwordErrors.length !== 0) {
            passwordErrors.forEach(element => addTag(passwordErrorsObject, element));
            event.preventDefault();
        }
    }

    function passwordValidation(password)
    {
        let passwordErrors = [];

        if (password.value === '') {
            passwordErrors.push('Empty field!!');
        }

        if (password.value.length >= 40) {
            passwordErrors.push('Password must be less than 40 characters');
        }

        if (password.value.length <= 7) {
            passwordErrors.push('Password must be more than 7 characters');
        }

        return passwordErrors;
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



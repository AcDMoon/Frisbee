"use strict"

document.addEventListener('DOMContentLoaded', function () {
    const formData = document.getElementById('formData');
    const formAvatar = document.getElementById('formAvatar');
    const formGroup = document.getElementById('formGroup');
    formData.addEventListener('submit', formDataSend);
    formAvatar.addEventListener('submit', formAvatarSend);
    formGroup.addEventListener('submit', formGroupSend);


    async function formDataSend(event)
    {

        const name = formData.querySelector('#name'),
            date = formData.querySelector('#date'),
            nameErrorsObject = formData.querySelector('#nameErrors'),
            dateErrorsObject = formData.querySelector('#dateErrors');

        removeErrors(nameErrorsObject);
        removeErrors(dateErrorsObject);




        name.value = name.value.replace(/^(\s+)/g, ' ');
        if (name.value[0] === ' ') {
            name.value = setCharAt(name.value, 0, '')
        }

        let nameErrors = nameValidation(name.value),
            dateErrors = dateValidation(date);

        if (nameErrors.length !== 0) {
            nameErrors.forEach(element => addTag(nameErrorsObject, element));
            event.preventDefault();
        }

        if (dateErrors.length !== 0) {
            dateErrors.forEach(element => addTag(dateErrorsObject, element));
            event.preventDefault();
        }
    }

    function nameValidation(name)
    {
        let nameErrors = [];
        const primalNameObject = document.getElementById('primalName');
        let primalName = primalNameObject.innerHTML.split(': ')[1];


        if (name === primalName) {
            return [];
        }

        if (name === '' || name === ' ') {
            nameErrors.push('The field must not be empty!');
        }
        console.log(name.length)
        if (name.length > 40) {
            nameErrors.push('Name must not exceed 40 characters!');
        }

        if (/[^a-zа-яё ]/iu.test(name)) {
            nameErrors.push('The name must not contain anything but letters!');
        }
        return nameErrors;
    }

    function dateValidation(date)
    {
        let dateErrors = [];
        const primalDateObject = document.getElementById('primalDate');
        let primalDate = primalDateObject.innerHTML.split(': ')[1];

        if (date.value === primalDate) {
            return [];
        }

        if (!/\d{4}(\-\d{2})(\-\d{2})/.test(date.value)) {
            dateErrors.push('The field must not be empty');
        }
        return dateErrors;
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

    async function formAvatarSend(event)
    {
        const avatar = formAvatar.querySelector('#avatar'),
        avatarErrorsObject = formAvatar.querySelector('#avatarErrors');

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

    function formGroupSend(event)
    {
        const group = formGroup.querySelector('#group'),
        groupErrorsObject = formGroup.querySelector('#groupErrors');

        removeErrors(groupErrorsObject);

        let groupErrors = groupValidation(group);

        if (groupErrors.length !== 0) {
            groupErrors.forEach(element => addTag(groupErrorsObject, element));
            event.preventDefault();
        }
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

    function setCharAt(str,index,chr)
    {
        if (index > str.length - 1) {
            return str;
        }
        return str.substring(0,index) + chr + str.substring(index + 1);
    }
});



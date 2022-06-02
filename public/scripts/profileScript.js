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

        let nameErrors = nameValidation(name),
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

        if (name.value === primalName) {
            return [];
        }

        if (name.value === '') {
            nameErrors.push('Поле не должно быть пустым!');
        }

        if (name.value.length > 40) {
            nameErrors.push('Имя не должно превышать 40 символов!');
        }

        if (/[^a-zа-яё ]/iu.test(name.value)) {
            nameErrors.push('Имя не должно содержать ничего кроме букв!');
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
            dateErrors.push('Поле не должно быть пустым');
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
            avatarErrors.push('Разрешённые форматы jpg, jpeg, png!');
        }

        if (avatarFile.size > 2 * 1024 * 1024) {
            avatarErrors.push('Размер изображение должен быть меньше 2МБ');
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
            groupErrors.push('Поле не должно быть пустым!');
        }

        if (group.value.length > 50) {
            groupErrors.push('Название группы не должно превышать 50 символов!');
        }
        return groupErrors;
    }
});



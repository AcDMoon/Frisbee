<?php
namespace Applications\Vievs\SignUp;

use Applications\Vievs\SignUp\Registration;



$result = Registration::Reg($_POST['E-mail'], $_POST['password'], $_POST['name'],$_POST['date_of_birth']);
if (is_null($result)){
    var_dump('всё ок');
    //Viev::LogIn
}else {
    //Viev::Registration($result)
    var_dump('хуита');
}
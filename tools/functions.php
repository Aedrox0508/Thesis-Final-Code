<?php

function validate_password($password) {
    if (!isset($password) || trim($password) === '') {
        return false;
    } 
    return strlen($password) >= 8; // Return true if >= 8, otherwise false
}

function validate_cpw($password, $cpassword){
    return isset($password, $cpassword) && $password === $cpassword;
}

function validate_field($field){
    $field = htmlentities($field);
    return strlen(trim($field)) > 0;
}


?>
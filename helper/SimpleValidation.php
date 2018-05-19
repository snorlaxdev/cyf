<?php

namespace CodeYourFuture\Helper;

class SimpleValidation {

    public static function isUsernameValid($username) {
        return (preg_match('/^[a-z]+$/', $username) ? TRUE : FALSE);
    }

    public static function isEmailValid($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return FALSE;
        return (preg_match('/^[a-z@.]+$/', $email) ? TRUE : FALSE);
    }

    public static function isPhoneNumberValid($phoneNumber) {
        return (preg_match('/^[0-9+]+$/', $phoneNumber) ? TRUE : FALSE);
    }
}
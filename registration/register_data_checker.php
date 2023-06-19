<?php

    function validate_number($contact_num)
    {
        return (preg_match("/^(09)[0-9]{0,9}$/", $contact_num) && strlen($contact_num) == 11);
    }

    function validate_TIN($TIN)
    {
        return preg_match("/^\d{3}\-\d{3}\-\d{3}\-\d{3,4}$/", $TIN);
    }

    function check_age($birthday)
    {
        //explode the date to get month, day and year
        $currentDate = date("d-m-Y");

        $age = date_diff(date_create($birthday), date_create($currentDate));

        if($age->format("%y") >= 18)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function check_password($checking, $password, $cPassword)
    {
        if($checking == "valid")
        {
            return (preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_.])[A-Za-z\d!@#$%^&*()_.]{8,}$/", $password) || preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d!@#$%^&*()_.]{8,}$/", $password));
        }
        if($checking == "length")
        {
            return (strlen($password) >= 8 && strlen($cPassword) >= 8);
        }
        if($checking == "match")
        {
            return $password === $cPassword;
        }
    }
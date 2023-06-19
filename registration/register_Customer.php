<?php

    require 'register_data_checker.php';

    function customer_add($user_type, $lastname , $firstname, $middlename, $nickname,
    $email, $address, $birthday, $user_sex, $contact_num, $pfp_file, $password, $cPassword)
    {
        require_once 'myRegister.php';
        $myRegister = new myRegister();

        if($myRegister->checkIfDataExist("email", $email))
        {
            return "The email you've provided is already registered";
        }
        else
        {
            if(check_age($birthday))
            {
                if(validate_number($contact_num))
                {
                    if(check_password("length", $password, $cPassword))
                    {
                        if(check_password("match", $password, $cPassword))
                        {
                            if(check_password("valid", $password, $cPassword))
                            {
                                $v_code = bin2hex(random_bytes(16));
                                require_once 'email_verification.php';
                                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                                if($myRegister->insertCustomerData($user_type, $lastname , $firstname, $middlename, $nickname,
                                $email, $address, $birthday, $user_sex, $contact_num, $pfp_file, $hashed_password, $v_code) && sendMailCustomer($email, $v_code))
                                {
                                    return true;
                                }
                                else
                                {
                                    return "Registration Failed";
                                }
                            }
                            else
                            {
                                return "Password should be a mix of Uppercase, Lowercase, Number, and Special character";
                            }
                        }
                        else
                        {
                            return "Password does not match";
                        }
                    }
                    else
                    {
                        return "Password is too short";
                    }
                }
                else
                {
                    return "The contact number you provided is invalid";
                }
                
            }
            else
            {
                return "Your age has not met the minimum requirements";
            }
            
        }
    }
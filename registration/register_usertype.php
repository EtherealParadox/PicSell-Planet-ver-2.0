<?php

    session_start();

    if(isset($_POST['register']))
    {
        $user_type = preg_replace('/\s+/', '', $_POST['user_type']);
        $lastname = $_POST['lastname'];
        $firstname = $_POST['firstname'];
        $middlename = preg_replace('/\s+/', '', $_POST['middlename']);
        $nickname = $_POST['nickname'];
        $email = preg_replace('/\s+/', '', $_POST['email']);
        $address = $_POST['address'];
        $birthday = $_POST['birthday'];
        $user_sex = $_POST['user_sex'];
        $contact_num = $_POST['contact_num'];
        $pfp_upload = $_FILES['pfp_upload'];
        $pfp_upload_hidden = $_POST['pfp_upload_hidden'];
        $pfp_upload_name_hidden = $_POST['pfp_upload_name_hidden'];
        $password = preg_replace('/\s+/', '', $_POST['password']);
        $cPassword = preg_replace('/\s+/', '', $_POST['cPassword']);

        

        if($user_type=="Lensman")
        {
            $studio_name = $_POST['studio_name'];

            $id_upload_hidden = $_POST['id_upload_hidden'];
            $id_upload_name_hidden = $_POST['id_upload_name_hidden'];

            $permit_upload_hidden = $_POST['permit_upload_hidden'];
            $permit_upload_name_hidden = $_POST['permit_upload_name_hidden'];

            $tin = $_POST['tin'];

            $lat = $_POST['lat'];
            $lng = $_POST['lng'];

            $data_array = array("lastname" => $lastname, "firstname" => $firstname, "middlename" => $middlename, 
            "nickname" => $nickname, "email" => $email, "address" => $address, "birthday" => $birthday, 
            "studio_name" => $studio_name, "tin" => $tin, "contact_num" => $contact_num, 
            "id_upload_hidden" => $id_upload_hidden, "id_upload_name_hidden" => $id_upload_name_hidden,
            "permit_upload_hidden" => $permit_upload_hidden, "permit_upload_name_hidden" => $permit_upload_name_hidden,
            "pfp_upload_hidden" => $pfp_upload_hidden, "pfp_upload_name_hidden" => $pfp_upload_name_hidden,
            "lat" => $lat, "lng" => $lng);

            if(empty($lat) && empty($lng))
            {
                $_SESSION['alert_text_rg']="Please provide your location";
                $_SESSION['result_rg']=false;
                $_SESSION['user_type']="Lensman";
                foreach($data_array as $key => $value)
                {
                    if(!is_numeric($key))
                        $_SESSION['regis_'.$key] = $value;
                }
                header("location: ../registration.php");
            }
            else
            {
                if((isset($id_upload_hidden) && !empty($id_upload_hidden)))
                {
                    if((isset($permit_upload_hidden) && !empty($permit_upload_hidden)))
                    {
                        if((isset($pfp_upload_hidden) && !empty($pfp_upload_hidden)))
                        {
                            $files_base64 = array($id_upload_hidden, $permit_upload_hidden, $pfp_upload_hidden);
                            $foldernames = array("ID-images", "permit-images", "profile-images");
                            foreach($files_base64 as $index => $value)
                            {
                                //Process base64 to something that can be manageable to be inserted to their respective folders
                                list($type, $value) = explode(';', $value);
                                list(, $value)      = explode(',', $value);
                                $value = str_replace(' ', '+', $value);
                                $value = base64_decode($value);
                                
                                $f = finfo_open();
                                $mime_type = finfo_buffer($f, $value, FILEINFO_MIME_TYPE);
                                $split = explode( '/', $mime_type );
                                $type = $split[1];
                                //Check if pfp image is gif or not
                                ($index == 2 && $type == "gif") ? $new_img_name = uniqid("IMG-", true) . ".gif" : $new_img_name = uniqid("IMG-", true) . ".png";
                                
                                //This will be the ones that will be inserted to the database
                                $new_names[] = $new_img_name;

                                $path  = '../images/'. $foldernames[$index] ."/" . $new_img_name;
                                //Array for the paths so we can remove it from folders if ever the registration failed
                                $temp_paths[] = $path;
                                //Inserting the files to their respective folders
                                file_put_contents($path, $value);
                            }

                            $id_file = $new_names[0];
                            $permit_file = $new_names[1];
                            $pfp_file = $new_names[2];

                            require_once 'register_Lensman.php';

                            $a = lensman_add($user_type, $lastname , $firstname, $middlename, $nickname,
                            $email, $address, $birthday, $user_sex, $studio_name, $id_file, $permit_file, $tin,
                            $contact_num, $pfp_file, $password, $cPassword, $lat, $lng);
                            if ($a == 1) 
                            {
                                $_SESSION['alert_text_rg']="The System Sent a Mail to your Email";
                                $_SESSION['result_rg']=true;
                                $_SESSION['user_type']="Lensman";
                                header("location: ../registration.php");
                            } 
                            else 
                            {
                                foreach($temp_paths as $path)
                                {
                                    unlink($path);
                                }
                                $_SESSION['alert_text_rg']=$a;
                                $_SESSION['result_rg']=false;
                                $_SESSION['user_type']="Lensman";
                                foreach($data_array as $key => $value)
                                {
                                    if(!is_numeric($key))
                                        $_SESSION['regis_'.$key] = $value;
                                }
                                header("location: ../registration.php");
                            }
                        }
                        else
                        {
                            $_SESSION['alert_text_rg']="Profile image is missing";
                            $_SESSION['result_rg']=false;
                            $_SESSION['user_type']="Lensman";
                            foreach($data_array as $key => $value)
                            {
                                if(!is_numeric($key))
                                    $_SESSION['regis_'.$key] = $value;
                            }
                            header("location: ../registration.php");
                        }
                    }
                    else
                    {
                        $_SESSION['alert_text_rg']="Permit image is missing";
                        $_SESSION['result_rg']=false;
                        $_SESSION['user_type']="Lensman";
                        foreach($data_array as $key => $value)
                        {
                            if(!is_numeric($key))
                                $_SESSION['regis_'.$key] = $value;
                        }
                        header("location: ../registration.php");
                    }
                }
                else
                {
                    $_SESSION['alert_text_rg']="ID image is missing";
                    $_SESSION['result_rg']=false;
                    $_SESSION['user_type']="Lensman";
                    foreach($data_array as $key => $value)
                    {
                        if(!is_numeric($key))
                            $_SESSION['regis_'.$key] = $value;
                    }
                    header("location: ../registration.php");
                }
                /*
                require_once 'register_Lensman.php';

                $files = array($id_upload_hidden, $permit_upload_hidden, $pfp_upload_hidden);
                foreach($files as $f)
                {
                    $tmp[] = $f['tmp_name'];
                    $name[] = $f['name'];
                    $err[] = $f['error'];
                }

                if($err[0]===0 && $err[1]===0)
                {
                    $foldernames = array("ID-images", "permit-images", "profile-images");
                    foreach($tmp as $index => $f)
                    {
                        $ext = pathinfo($name[$index], PATHINFO_EXTENSION);
                        ($index == 1 && $ext == "gif") ? $new_img_name = uniqid("IMG-", true) . ".gif" : $new_img_name = uniqid("IMG-", true) . ".png"; 
                        $path  = '../images/'. $foldernames[$index] ."/" . $new_img_name;
                        $temp_paths[] = $path;
                        move_uploaded_file($f, $path);
                        $fPath= 'images/'. $foldernames[$index] ."/" . $new_img_name;
                        $new_paths[] = $fPath;
                    }

                    $id_file = $new_paths[0];
                    $pfp_file = $new_paths[1];

                    $a = lensman_add($user_type, $lastname , $firstname, $middlename, $nickname,
                    $email, $address, $birthday, $user_sex, $studio_name, $id_type, $id_file, $tin,
                    $contact_num, $pfp_file, $password, $cPassword, $lat, $lng);
                    if ($a == 1) 
                    {
                        $_SESSION['alert_text_rg']="Please wait for the admin confirmation (1-3 days)";
                        $_SESSION['result_rg']=true;
                        $_SESSION['user_type']="Lensman";
                        header("location: ../registration.php");
                    } 
                    else 
                    {
                        foreach($temp_paths as $path)
                        {
                            unlink($path);
                        }
                        $_SESSION['alert_text_rg']=$a;
                        $_SESSION['result_rg']=false;
                        $_SESSION['user_type']="Lensman";
                        foreach($data_array as $key => $value)
                        {
                            if(!is_numeric($key))
                                $_SESSION['regis_'.$key] = $value;
                        }
                        header("location: ../registration.php");
                    }
                    
                }
                else
                {
                    $_SESSION['alert_text_rg']="Something went wrong (Files)";
                    $_SESSION['result_rg']=false;
                    $_SESSION['user_type']="Lensman";
                    foreach($data_array as $key => $value)
                    {
                        if(!is_numeric($key))
                            $_SESSION['regis_'.$key] = $value;
                    }
                    header("location: ../registration.php");
                }*/
            }
        }
        if($user_type=="Customer")
        {
            $data_array = array("lastname" => $lastname, "firstname" => $firstname, "middlename" => $middlename, 
            "nickname" => $nickname, "email" => $email, "address" => $address, "birthday" => $birthday, 
            "contact_num" => $contact_num, "pfp_upload_hidden" => $pfp_upload_hidden, 
            "pfp_upload_name_hidden" => $pfp_upload_name_hidden);

            if((isset($pfp_upload_hidden) && !empty($pfp_upload_hidden)))
            {
                $value = $pfp_upload_hidden;

                //Process base64 to something that can be manageable to be inserted to their respective folders
                list($type, $value) = explode(';', $value);
                list(, $value)      = explode(',', $value);
                $value = str_replace(' ', '+', $value);
                $value = base64_decode($value);
                
                $f = finfo_open();
                $mime_type = finfo_buffer($f, $value, FILEINFO_MIME_TYPE);
                $split = explode( '/', $mime_type );
                $type = $split[1];
                //Check if image is gif or not
                ($type == "gif") ? $new_img_name = uniqid("IMG-", true) . ".gif" : $new_img_name = uniqid("IMG-", true) . ".png";
                
                $path  = '../images/profile-images/' . $new_img_name;
                //Path so we can remove it from the folder if ever the registration failed
                $new_path = $path;
                //Inserting the file to the pfp folder
                file_put_contents($path, $value);

                $pfp_file = $new_img_name;

                require_once 'register_Customer.php';

                $a = customer_add($user_type, $lastname , $firstname, $middlename, $nickname,
                $email, $address, $birthday, $user_sex, $contact_num, $pfp_file, $password, $cPassword);
                if ($a == 1) 
                {
                    $_SESSION['alert_text_rg']="Kindly check your email to verify your account";
                    $_SESSION['result_rg']=true;
                    $_SESSION['user_type']="Customer";
                    header("location: ../registration.php");
                } 
                else 
                {
                    unlink($new_path);
                    $_SESSION['alert_text_rg']=$a;
                    $_SESSION['result_rg']=false;
                    $_SESSION['user_type']="Customer";
                    foreach($data_array as $key => $value)
                    {
                        if(!is_numeric($key))
                            $_SESSION['regis_'.$key] = $value;
                    }
                    header("location: ../registration.php");
                }
            }
            else
            {
                $_SESSION['alert_text_rg']="Profile image is missing";
                $_SESSION['result_rg']=false;
                $_SESSION['user_type']="Customer";
                foreach($data_array as $key => $value)
                {
                    if(!is_numeric($key))
                        $_SESSION['regis_'.$key] = $value;
                }
                header("location: ../registration.php");
            }

            /*require_once 'register_Customer.php';

            $file_name = $pfp_upload['name'];
            $tmp_name = $pfp_upload['tmp_name'];
            $error = $_FILES['pfp_upload']['error'];

            if ($error === 0) 
            {
                $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                ($ext == "gif") ? $new_img_name = uniqid("IMG-", true) . ".gif" : $new_img_name = uniqid("IMG-", true) . ".png";
                $new_path = '../images/profile-images/' . $new_img_name;
                move_uploaded_file($tmp_name, $new_path);

                $pfp_file = 'images/profile-images/' . $new_img_name;

                $a = customer_add($user_type, $lastname , $firstname, $middlename, $nickname,
                $email, $address, $birthday, $user_sex, $contact_num, $pfp_file, $password, $cPassword);
                if ($a == 1) 
                {
                    $_SESSION['alert_text_rg']="Kindly check your email to verify your account";
                    $_SESSION['result_rg']=true;
                    $_SESSION['user_type']="Customer";
                    header("location: ../registration.php");
                } 
                else 
                {
                    unlink($new_path);
                    $_SESSION['alert_text_rg']=$a;
                    $_SESSION['result_rg']=false;
                    $_SESSION['user_type']="Customer";
                    foreach($data_array as $key => $value)
                    {
                        if(!is_numeric($key))
                            $_SESSION['regis_'.$key] = $value;
                    }
                    header("location: ../registration.php");
                }

            }
            else
            {
                $_SESSION['alert_text_rg']="Something went wrong (Files)";
                $_SESSION['result_rg']=false;
                $_SESSION['user_type']="Customer";
                foreach($data_array as $key => $value)
                {
                    if(!is_numeric($key))
                        $_SESSION['regis_'.$key] = $value;
                }
                header("location: ../registration.php");
            }*/
        }
    }
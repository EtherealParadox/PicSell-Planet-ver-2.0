<?php

    use \PHPMailer\PHPMailer\PHPMailer;
    use \PHPMailer\PHPMailer\Exception;

    function sendMailCustomer($email, $v_code)
    {
        require 'PHPMailer/vendor/autoload.php';

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.mail.yahoo.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'picsellplanet@yahoo.com';                     //SMTP username
            $mail->Password   = 'nvvnqmgjotyqaiqk';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            $mail->setFrom('picsellplanet@yahoo.com', 'Pic-Sell Planet');
            $mail->addAddress($email);     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Pic-Sell Planet Account Registration';
            $mail->Body    = "<h2 style='color:#114383;'>Thank you for registering your account at Pic-Sell Planet!</h2>
                <p>Please click the underlined word to verify your account and will be directed to Login Form <a href='http://localhost/PicSellPlanet/registration/user_verification.php?email=$email&v_code=$v_code'>Verify Account</a></p>
                <p>You can contact the admin \"picsellplanet@yahoo.com\" for your concern and questions.</p><br />
                <p>Thank you so much!</p>";
                
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function sendMailLensman($email, $v_code)
    {
        require 'PHPMailer/vendor/autoload.php';

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.mail.yahoo.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'picsellplanet@yahoo.com';                     //SMTP username
            $mail->Password   = 'nvvnqmgjotyqaiqk';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            $mail->setFrom('picsellplanet@yahoo.com', 'Pic-Sell Planet');
            $mail->addAddress($email);     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Pic-Sell Planet Account Registration';
            $mail->Body    = "<h2 style='color:#114383;'>Thank you for registering your account at Pic-Sell Planet!</h2>
            <p>Kindly wait for the admin to verify your account information at least 1-3 working days, you will receive an email to verify your own account.</p>
            <p>You can contact the admin \"picsellplanet@yahoo.com\" for your concern and questions.</p><br />
            <p>Thank you so much!</p>";
        
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function requestResendMailLensman($email, $v_code)
    {
        require 'PHPMailer/vendor/autoload.php';

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.mail.yahoo.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'picsellplanet@yahoo.com';                     //SMTP username
            $mail->Password   = 'nvvnqmgjotyqaiqk';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            $mail->setFrom('picsellplanet@yahoo.com', 'Pic-Sell Planet');
            $mail->addAddress($email);     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Pic-Sell Planet Account Verification Renewal';
            $mail->Body    = "<h2 style='color:#114383;'>The system resend you an email for you to verify your account at Pic-Sell Planet!</h2>
            <p>Please click the underlined word to renew the verification of your account and will be directed to Login Form <a href='http://localhost/PicSellPlanet/registration/user_verification.php?email=$email&v_code=$v_code'>Verify Account</a></p>
            <p>You can contact the admin \"picsellplanet@yahoo.com\" for your concern and questions.</p><br />
            <p>Thank you so much!</p>";
        
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function requestResendMailCustomer($email, $v_code)
    {
        require 'PHPMailer/vendor/autoload.php';

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.mail.yahoo.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'picsellplanet@yahoo.com';                     //SMTP username
            $mail->Password   = 'nvvnqmgjotyqaiqk';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            $mail->setFrom('picsellplanet@yahoo.com', 'Pic-Sell Planet');
            $mail->addAddress($email);     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Pic-Sell Planet Account Verification Renewal';
            $mail->Body    = "<h2 style='color:#114383;'>The system resend you an email for you to verify your account at Pic-Sell Planet!</h2>
            <p>Please click the underlined word to renew the verification of your account and will be directed to Login Form <a href='http://localhost/PicSellPlanet/registration/user_verification.php?email=$email&v_code=$v_code'>Verify Account</a></p>
            <p>You can contact the admin \"picsellplanet@yahoo.com\" for your concern and questions.</p><br />
            <p>Thank you so much!</p>";
        
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    
    function reactivateMailCustomer($email, $v_code)
    {
        require 'PHPMailer/vendor/autoload.php';

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.mail.yahoo.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'picsellplanet@yahoo.com';                     //SMTP username
            $mail->Password   = 'nvvnqmgjotyqaiqk';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            $mail->setFrom('picsellplanet@yahoo.com', 'Pic-Sell Planet');
            $mail->addAddress($email);     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Pic-Sell Planet Account Reactivation';
            $mail->Body    = "<h2 style='color:#114383;'>The system sent you an email for you to reactivate your account at Pic-Sell Planet!</h2>
            <p>Please click the underlined word to reactivate of your account and will be directed to Login Form <a href='http://localhost/PicSellPlanet/registration/user_verification.php?email=$email&v_code=$v_code'>Verify Account</a></p>
            <p>You can contact the admin \"picsellplanet@yahoo.com\" for your concern and questions.</p><br />
            <p>Thank you so much!</p>";
        
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function sendMailOfAdmin($email, $v_code)
    {
        require 'PHPMailer/vendor/autoload.php';

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.mail.yahoo.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'picsellplanet@yahoo.com';                     //SMTP username
            $mail->Password   = 'nvvnqmgjotyqaiqk';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            $mail->setFrom('picsellplanet@yahoo.com', 'Pic-Sell Planet');
            $mail->addAddress($email);     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Email Verification for Pic-Sell Planet Account';
            $mail->Body    = "<h2 style='color:#114383;'>Thank you for registering your account at Pic-Sell Planet!</h2>
            <p>Please click the underlined word to verify your account and will be directed to Login Form <a href='http://localhost/PicSellPlanet/registration/user_verification.php?email=$email&v_code=$v_code'>Verify Account</a></p>
            <p>You can contact the admin \"picsellplanet@yahoo.com\" for your concern and questions.</p><br />
            <p>Thank you so much!</p>";
        
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
<?php

session_start();

//CSRF Protection
function verifyToken()
{
    if (empty($_SESSION['token'])) {
        return false;
    }
    if (empty($_POST['CSRFToken'])) {
        return false;
    }
    if ($_SESSION['token'] !== $_POST['CSRFToken']) {
        return false;
    }
    return true;
}

// If Token verified - Perform database operation
if (verifyToken()):

    require_once ('config.php');
    require_once ('db/Database.php');


    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] === 'POST'):

        $clean_post = array();

        //XSS Protection
        if ($_POST) {
            // Trim POST values
            function trim_value(&$value)
            {
                $value = trim($value);
            }

            array_filter($_POST, 'trim_value');

            // Sanitize POST variables
            $post_filter = array(
                'name' => array('filter' => FILTER_SANITIZE_STRING),
                'email' => array('filter' => FILTER_SANITIZE_EMAIL),
                'confirm_email' => array('filter' => FILTER_SANITIZE_EMAIL),
                'pwd' => array('filter' => FILTER_SANITIZE_STRING),
                'confirm_pwd' => array('filter' => FILTER_SANITIZE_STRING),
                'address_one' => array('filter' => FILTER_SANITIZE_STRING),
                'address_two' => array('filter' => FILTER_SANITIZE_STRING),
                'country' => array('filter' => FILTER_SANITIZE_STRING),
                'phone' => array('filter' => FILTER_SANITIZE_STRING)
            );

            $clean_post = filter_var_array($_POST, $post_filter);
        }

        $name = $clean_post['name'];
        $email = $clean_post['email'];
        $confirm_email = $clean_post['confirm_email'];
        $password = $clean_post['pwd'];
        $confirm_pwd = $clean_post['confirm_pwd'];
        $address_one = $clean_post['address_one'];
        $address_two = $clean_post['address_two'];
        $country = $clean_post['country'];
        $phone = $clean_post['phone'];


        // Server Side Validation
        $errors = array();
        $validate = false;

        if (empty($name)) {
            $errors[] = 'Enter a name.';
        }
        if (empty($password)) {
            $errors[] = 'Enter a password.';
        }
        if (strlen($password) < 6) {
            $errors[] = 'Password must be minimum 6 characters';
        }
        if ($password != $confirm_pwd) {
            $errors[] = 'Passwords Dont Match';
        }
        if ($email != '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Enter a valid email address.';
        }
        if (empty($phone)) {
            $errors[] = 'Enter a phone number.';
        }

        if (empty($errors)) {
            $validate = true;
        } else {
            $errors = array_map(function ($val) {
                return '<li><strong>' . $val . '</strong></li>';
            }, $errors);
            $errors[] = '<strong>-- Please try again.</strong>';
            echo implode('', $errors);
        }


        // If validate true - try connect to database and insert data
        if ($validate):
            $success = false;
            if (function_exists('password_hash')) {
                $pass_hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 14]);
            } else { // Fallback for older PHP versions
                $blowfish_salt = bin2hex(openssl_random_pseudo_bytes(22));
                $pass_hash = crypt($password, "$2a$12$" . $blowfish_salt);
            }
            try {
                $db = new Database();
                $db->beginTransaction();

                $db->query('INSERT INTO gn_info(name, email, pass) values (:name, :email, :pass_hash)');
                $db->bind(':name', $name);
                $db->bind(':email', $email);
                $db->bind(':pass_hash', $pass_hash);

                $execute_a = $db->execute();
                $gn_info_id = $db->lastInsertId();

                if ($execute_a):
                    $db->query('INSERT INTO cn_info(gn_info_id, add_one, add_two, country, phone) values (:gn_info_id, :add_one, :add_two, :country, :phone)');
                    $db->bind(':gn_info_id', $gn_info_id);
                    $db->bind(':add_one', $address_one);
                    $db->bind(':add_two', $address_two);
                    $db->bind(':country', $country);
                    $db->bind(':phone', $phone);

                    $execute_b = $db->execute();

                    if ($execute_b) {
                        echo 'You have successfully submitted the form.';
                    }
                endif;

                $db->endTransaction();

            } catch (PDOException $e) {
                $db->cancelTransaction();
                throw $e;
            }

        endif;
    endif;

else:
    echo 'Token Mismatch!';
endif;
<?php
session_start();

$time = $_SERVER['REQUEST_TIME'];

// Set Timeout for 15 minutes
$timeout_duration = 900;

// If timeout passed destroy previous session and create new one.
if (isset($_SESSION['LAST_ACTIVITY']) && ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    session_unset();
    session_destroy();
    session_start();
}

// Update last activity
$_SESSION['LAST_ACTIVITY'] = $time;

// Generate CSRF Token
$token = hash("sha512", mt_rand(0, mt_getrandmax()));
$_SESSION['token'] = $token;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JoomShaper Project</title>

    <!-- Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<section class="signupSection">
    <div class="container">
        <div class="row">
            <div class="error_message">
                <div class="col-sm-12">
                    <div class="alert alert-danger" role="alert"><strong>Oops!</strong> Something went wrong. Please try
                        again. Thank you!
                    </div>
                </div>
            </div>

            <form class="form-horizontal signupForm" id="signupForm" role="form" method="post">

                <!-- General Info -->
                <fieldset id="gn_info">
                    <h2 class="col-sm-offset-4 col-sm-6">General Info</h2>

                    <div class="form-group required">
                        <label class="control-label col-sm-4" for="name">Name</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter name"
                                   required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="email">Email</label>
                        <div class="col-sm-6">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="confirm_email">Confirm Email</label>
                        <div class="col-sm-6">
                            <input type="email" class="form-control" id="confirm_email" name="confirm_email"
                                   placeholder="Enter email again">
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="control-label col-sm-4" for="pwd">Password</label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control" id="pwd" name="pwd"
                                   placeholder="Enter password" minlength="6" required>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="control-label col-sm-4" for="confirm_pwd">Confirm Password</label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control" id="confirm_pwd" name="confirm_pwd"
                                   placeholder="Enter password again" minlength="6" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10">
                            <a href="#" class="btn btn-info next pull-right">Next</a>
                        </div>
                    </div>
                </fieldset>

                <!-- Contact Info -->
                <fieldset id="cn_info">
                    <h2 class="col-sm-offset-4 col-sm-6">Contact Info</h2>

                    <div class="form-group">
                        <label class="control-label col-sm-4" for="address_one">Address 1</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="address_one" name="address_one"
                                   placeholder="Enter address 1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="address_two">Address 2</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="address_two" name="address_two"
                                   placeholder="Enter address 2">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="country">Country</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="country" name="country">
                                <option>Select Country</option>
                                <option>Bangladesh</option>
                                <option>USA</option>
                                <option>Australia</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="control-label col-sm-4" for="phone">Phone</label>
                        <div class="col-sm-6">
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter phone"
                                   required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 pull-left">
                            <a href="#" class="btn btn-info prev pull-right">Previous</a>
                        </div>
                        <div class="col-sm-6">
                            <div class="submit_btn">
                                <div class="loading_img" style="display: none"><img src="img/ajax-loader.gif"
                                                                                    alt="loading"></div>
                                <input type="hidden" name="CSRFToken" value="<?php echo $token; ?>">
                                <input type="submit" id="submit" name="submit" value="Submit" class="btn btn-success">
                            </div>
                        </div>
                    </div>
                </fieldset>

            </form>
        </div>
    </div>
</section>

<!-- JavaScript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/scripts.js"></script>
</body>
</html>
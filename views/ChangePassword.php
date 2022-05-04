<?php
if (isset($_SESSION["changeuser"])) {
    $crnt_date = date("Y-m-d H:i:s");
    $data = $_SESSION["changeuser"];
    if ($data["exp_date"] >= $crnt_date) {
        $_POST["Email"] = $data["Email"];
    } else { ?>
        <div class="alert alert-danger" role="alert">
            This forget password link has been expired
        </div>
<?php }
} else {
    $_SESSION["error"] = array("", "Reset Password link has been expired!!");
    header("Location: " . Config::BASE_URL . "?controller=Default&function=homepage&parameter=loginmodal");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Forgot Password</title>
    <style>
        .form-group {
            width: 240px;
            margin-top: 10px;
        }

        .form-group label {
            padding-bottom: 5px;
        }

        .form-group button {
            border-radius: 25px;
            background-color: #057377;
            border: none;
            padding: 6px 16px;
            opacity: 0.9;
        }

        .form-group button:hover {
            background-color: #057377;
            color: white;
            opacity: 1;
        }

        .error {
            color: red;
            margin-top: 2px;
            font-size: 13px;
        }
    </style>
</head>

<body style="background-color:azure">
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-2">
                <form action="<?= Config::BASE_URL . "?controller=Users&function=changepassword" ?>" id="form-changepassword" method="POST">
                    <div class="form-group">
                        <label for="New Password">New Password</label>
                        <input class="form-control" type="text" name="Password" id="password" placeholder="password" require>
                    </div>
                    <div class="form-group">
                        <label for="Re Password">Confirm Password</label>
                        <input class="form-control" type="text" name="RePassword" id="repassword" placeholder="confirm password" require>
                    </div>
                    <div class="form-group mt-3">
                        <button class="btn btn-primary" type="submit" id="changepassword" name="change">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="static/js/validation.js"></script>
</body>

</html>
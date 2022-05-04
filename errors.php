<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <title>Error</title>
</head>

<body>
    <div class="container mt-3">
        <div class="alert alert-danger" role="alert">
            <h2><?= isset($_SESSION["error_title"]) ? $_SESSION["error_title"] : ""?></h2>
                <?php
                if (isset($_SESSION["error_array"]) && count($_SESSION["error_array"]) > 0) {
                    $errors = $_SESSION["error_array"];
                    unset($_SESSION["error_array"]);
                    ?>
                    Reason can be:-
                    <ul>
                    <?php
                        foreach($errors as $key=>$value){
                            ?>
                                <li>*<?=$key?>=><?=$value?></li>
                            <?php
                        }
                    ?>
                    </ul>
                    <?php
                    }else{
                        echo "try again";
                    }
                ?>
        </div>
    <a href="<?=Config::BASE_URL."?controller=Default&function=homepage"?>">Back to the HomePage</a>
    </div>
</body>

</html>
<?php
    session_start();

    $_GET =  filter_input_array(
        INPUT_GET,
        array
        (
            "step" => array
                (
                    "filter" => FILTER_VALIDATE_INT,
                    "options" => array("min_range" => 1, "max_range" => 6)
                ),
            "error" => FILTER_SANITIZE_ENCODED
        )
    );

    $_POST =  filter_input_array(
        INPUT_POST,
        array
        (
            "web_host"          => FILTER_SANITIZE_STRING,
            "web_port"          => FILTER_SANITIZE_STRING,
            "web_user"          => FILTER_SANITIZE_STRING,
            "web_password"      => FILTER_SANITIZE_STRING,
            "web_database"      => FILTER_SANITIZE_STRING,

            "logon_host"        => FILTER_SANITIZE_STRING,
            "logon_port"        => FILTER_SANITIZE_STRING,
            "logon_user"        => FILTER_SANITIZE_STRING,
            "logon_password"    => FILTER_SANITIZE_STRING,
            "logon_database"    => FILTER_SANITIZE_STRING,
            "logon_checked"     => FILTER_SANITIZE_STRING,

            "characters_host"       => FILTER_SANITIZE_STRING,
            "characters_port"       => FILTER_SANITIZE_STRING,
            "characters_user"       => FILTER_SANITIZE_STRING,
            "characters_password"   => FILTER_SANITIZE_STRING,
            "characters_database"   => FILTER_SANITIZE_STRING,
            "characters_checked"    => FILTER_SANITIZE_STRING,

            "world_host"        => FILTER_SANITIZE_STRING,
            "world_port"        => FILTER_SANITIZE_STRING,
            "world_user"        => FILTER_SANITIZE_STRING,
            "world_password"    => FILTER_SANITIZE_STRING,
            "world_database"    => FILTER_SANITIZE_STRING,
            "world_checked"     => FILTER_SANITIZE_STRING,

            "realmlist"         => FILTER_SANITIZE_STRING,
            "title"             => FILTER_SANITIZE_STRING,
            "domain"            => FILTER_SANITIZE_STRING,
            "expansion"         => FILTER_SANITIZE_STRING,
            "paypal"            => FILTER_VALIDATE_EMAIL,
            "email"             => FILTER_VALIDATE_EMAIL,

            "submit"            => FILTER_SANITIZE_STRING
        )
    );

    if ( !isset($_GET['step']) || $_GET['step'] === false)
    {
        header("Location: index.php");
    }
    else
    {
        $step = $_GET['step'];
    }

    $steps = array
    (
        1 => 'Database Connection & General Info',
        2 => 'Configuration File',
        3 => 'Create database & Write configuration file',
        4 => 'Updates',
        5 => 'Adding your first realm',
        6 => 'Finished'
    );
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>CraftedCMS Installer</title>

    <!-- Boostrap Includes -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!--<link rel="stylesheet" type="text/css" href="main.css"> -->
</head>
<body>
<div class="container text-center centered">
    <h1>Installation &raquo; Step <?php echo $step; ?> ( <?php echo $steps[$step]; ?> )</h1>

    <?php include "./steps/". $step .".php"; ?>
</div>
</body>
</html>
<script type="text/javascript" src="scripts.js"></script>
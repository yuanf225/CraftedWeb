<?php

    session_start();

    if (!isset($_GET['step']))
    {
        header("Location: index.php");
    }

    if (file_exists("../core/includes/classes/validator.php"))
    {
        include_once "../core/includes/classes/validator.php";

        $validator = new Validator(array('step' => 'int'), array('step'), array('step'));

        $_GET = $validator->sanatize($_GET);
        $step = $_GET['step'];
    }
    elseif (is_numeric($_GET['step']))
    {
        $step = $_GET['step'];
    }
    else 
    {
        header("Location: ./index.php?error=url_error");
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
        <script type="text/javascript" src="other.js"></script>
        <meta charset="utf-8">
        <title>CraftedWeb Installer</title>

        <link rel="stylesheet" type="text/css" href="main.css">
    </head>
    <body>
    <center>
    <div id="main_box">
        <h1>Installation &raquo; Step <?php echo $step; ?> ( <?php echo $steps[$step]; ?> )</h1>

        <div id="content">
            <?php include "./steps/". $step .".php"; ?>

            <div id="info"></div>
        </div>
    </div>
    </center>
</body>
</html>
<script type="text/javascript" src="scripts.js"></script>
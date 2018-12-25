<?php
    /* ___           __ _           _ __    __     _     
      / __\ __ __ _ / _| |_ ___  __| / / /\ \ \___| |__
      / / | '__/ _` | |_| __/ _ \/ _` \ \/  \/ / _ \ '_ \
      / /__| | | (_| |  _| ||  __/ (_| |\  /\  /  __/ |_) |
      \____/_|  \__,_|_|  \__\___|\__,_| \/  \/ \___|_.__/

      -[ Created by �Nomsoft
      `-[ Original core by Anthony (Aka. CraftedDev)

      -CraftedWeb Generation II-
      __                           __ _
      /\ \ \___  _ __ ___  ___  ___  / _| |_
      /  \/ / _ \| '_ ` _ \/ __|/ _ \| |_| __|
      / /\  / (_) | | | | | \__ \ (_) |  _| |_
      \_\ \/ \___/|_| |_| |_|___/\___/|_|  \__|	- www.Nomsoftware.com -
      The policy of Nomsoftware states: Releasing our software
      or any other files are protected. You cannot re-release
      anywhere unless you were given permission.
      � Nomsoftware 'Nomsoft' 2011-2012. All rights reserved. */
?>
<!DOCTYPE>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>CraftedWeb Installation</title>
        <link rel="stylesheet" type="text/css" href="main.css">
        <!-- Boostrap Includes -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <style type="text/css">
      #main_box { width: 750px; }
    </style>
    <body>
    <center>
        <div id="main_box">
            <h1>Welcome To The CraftedWeb Installer!</h1>
            <div id="content">
                <p id="steps"><b>Introduction</b> &raquo; MySQL Info &raquo; Configure &raquo; Database &raquo; Realm Info &raquo; Finished<p>
                <hr/>
                <p>To install, just follow the onscreen instructions and enter your information correctly.</p> 
                <p>You will need a MySQL User login and Database along with your server information before you continue.<p>
                <p>Please CHMOD 777 <i>'includes/configuration.php'</i> AND <i>'install/sql/CraftedWeb_Base.sql'</i> ahead of time.</p>
                <p>When ready, start the installation process</p>
                <p><input type="submit" value="Start the installation" onclick="<?php echo htmlentities("window.location='install.php?step=1'"); ?>"></p>
            </div>
        </div>
    </center>
</body>
</html>
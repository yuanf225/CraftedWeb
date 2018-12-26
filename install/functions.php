<?php
    session_start();
    ini_set('display_errors', 1);

    if ( isset($_POST['step']) )
    {
        switch ($_POST['step'])
        {
            case 1: step1(); break;

            case 2: step2(); break;

            case 3: step3(); break;

            case 4: step4(); break;

            case 5: step5(); break;
        }
    }

    function step1()
    {
        if ( $_POST['submit'] != "step1" )
        {
            return NULL;
            exit;
        }

        if ( empty($_POST['realmlist']) ||
            empty($_POST['title']) ||
            empty($_POST['domain']) ||
            empty($_POST['expansion']) ||
            empty($_POST['paypal']) ||
            empty($_POST['email']) )
        {
            die("Please Enter All Fields!");
        }

        # Auth/Logon Server
        if ( $_POST['logon_checked'] == true )
        {
            $_SESSION['install']['logon']['database']['host']       = "127.0.0.1";
            $_SESSION['install']['logon']['database']['port']       = "3306";
            $_SESSION['install']['logon']['database']['username']   = "root";
            $_SESSION['install']['logon']['database']['password']   = "";

            # Host
            if ( !empty($_POST['logon_host']) ) $_SESSION['install']['logon']['database']['host'] = $_POST['logon_host'];

            # Port
            if ( !empty($_POST['logon_port']) ) $_SESSION['install']['logon']['database']['port'] = $_POST['logon_port'];

            # Username
            if ( !empty($_POST['logon_user']) ) $_SESSION['install']['logon']['database']['username'] = $_POST['logon_user'];

            # Password
            if ( !empty($_POST['logon_password']) ) $_SESSION['install']['logon']['database']['password'] = $_POST['logon_password'];
        }

        if ( $_POST['characters_checked'] == true )
        {
            $_SESSION['install']['characters']['database']['host']       = "127.0.0.1";
            $_SESSION['install']['characters']['database']['port']       = "3306";
            $_SESSION['install']['characters']['database']['username']   = "root";
            $_SESSION['install']['characters']['database']['password']   = "";

            # Host
            if (!empty($_POST['characters_host'])) $_SESSION['install']['characters']['database']['host'] = $_POST['characters_host'];

            # Port
            if (!empty($_POST['characters_port'])) $_SESSION['install']['characters']['database']['port'] = $_POST['characters_port'];

            # Username
            if (!empty($_POST['characters_user'])) $_SESSION['install']['characters']['database']['username'] = $_POST['characters_user'];

            # Password
            if (!empty($_POST['characters_password'])) $_SESSION['install']['characters']['database']['password'] = $_POST['characters_password'];
        }

        # World Server
        if ( $_POST['world_checked'] == true )
        {
            $_SESSION['install']['world']['database']['host']       = "127.0.0.1";
            $_SESSION['install']['world']['database']['port']       = "3306";
            $_SESSION['install']['world']['database']['username']   = "root";
            $_SESSION['install']['world']['database']['password']   = "";

            # Host
            if ( !empty($_POST['logon_host']) ) $_SESSION['install']['world']['database']['host'] = $_POST['logon_host'];

            # Port
            if ( !empty($_POST['logon_port']) ) $_SESSION['install']['world']['database']['port'] = $_POST['logon_port'];

            # Username
            if ( !empty($_POST['logon_user']) ) $_SESSION['install']['world']['database']['username'] = $_POST['logon_user'];

            # Password
            if ( !empty($_POST['logon_password']) ) $_SESSION['install']['world']['database']['password'] = $_POST['logon_password'];
        }

        # Web
        $_SESSION['install']['web']['database']['host']     = "127.0.0.1";
        $_SESSION['install']['web']['database']['port']     = "3306";
        $_SESSION['install']['web']['database']['username'] = "root";
        $_SESSION['install']['web']['database']['password'] = "";
        $_SESSION['install']['web']['database']['name']     = "craftedcms";

        # Database
        if ( !empty($_POST['web_database']) ) $_SESSION['install']['web']['database']['name'] = $_POST['web_database'];

        # Host
        if ( !empty($_POST['web_host']) ) $_SESSION['install']['web']['database']['port'] = $_POST['web_host'];

        # Port
        if ( !empty($_POST['web_port']) ) $_SESSION['install']['web']['database']['port'] = $_POST['web_port'];

        # Username
        if ( !empty($_POST['web_user']) ) $_SESSION['install']['web']['database']['username'] = $_POST['web_user'];

        # Password
        if ( !empty($_POST['web_password']) ) $_SESSION['install']['web']['database']['password'] = $_POST['web_password'];

        # Auth/Logon
        if ( $_POST['logon_checked'] == false && $_POST['world_checked'] == false && $_POST['characters_checked'] )
        {
            $_SESSION['install']['logon']['database']['host']       = $_SESSION['install']['web']['database']['host'];
            $_SESSION['install']['logon']['database']['port']       = $_SESSION['install']['web']['database']['port'];
            $_SESSION['install']['logon']['database']['username']   = $_SESSION['install']['web']['database']['username'];
            $_SESSION['install']['logon']['database']['password']   = $_SESSION['install']['web']['database']['password'];

            $_SESSION['install']['characters']['database']['host']  = $_SESSION['install']['web']['database']['host'];
            $_SESSION['install']['characters']['database']['port']  = $_SESSION['install']['web']['database']['port'];
            $_SESSION['install']['characters']['database']['username'] = $_SESSION['install']['web']['database']['username'];
            $_SESSION['install']['characters']['database']['password'] = $_SESSION['install']['web']['database']['password'];

            $_SESSION['install']['world']['database']['host']       = $_SESSION['install']['web']['database']['host'];
            $_SESSION['install']['world']['database']['port']       = $_SESSION['install']['web']['database']['port'];
            $_SESSION['install']['world']['database']['username']   = $_SESSION['install']['web']['database']['username'];
            $_SESSION['install']['world']['database']['password']   = $_SESSION['install']['web']['database']['password'];
        }

        # Check If Auth Database Value is empty or not
        if ( empty($_POST['logon_database']) )
        {
            $_SESSION['install']['logon']['database']['name'] = "auth";
        }
        else
        {
            $_SESSION['install']['logon']['database']['name'] = $_POST['logon_database'];
        }

        # Check If World Database Value is empty or not
        if ( empty($_POST['world_database']) )
        {
            $_SESSION['install']['world']['database']['name'] = "world";
        }
        else
        {
            $_SESSION['install']['world']['database']['name'] = $_POST['world_database'];
        }

        # Check If Characters Database Value is empty or not
        if ( empty($_POST['characters_database']) )
        {
            $_SESSION['install']['characters']['database']['name'] = "characters";
        }
        else
        {
            $_SESSION['install']['characters']['database']['name'] = $_POST['characters_database'];
        }

        # Set all of the session variables
        $_SESSION['install']['web']['realmlist']    = $_POST['realmlist'];
        $_SESSION['install']['web']['title']        = $_POST['title'];
        $_SESSION['install']['web']['domain']       = $_POST['domain'];
        $_SESSION['install']['web']['expansion']    = $_POST['expansion'];
        $_SESSION['install']['web']['paypal']       = $_POST['paypal'];
        $_SESSION['install']['web']['email']        = $_POST['email'];
            
        print true;
        exit;
    }
    

    function step2()
    {
    	$config = false;
    	$sql 	= false;

        if ( is_writable("../core/includes/configuration.php") )
            $config = true;

        if ( is_readable("sql/CraftedWeb_Base.sql") )
            $sql = true;

        if ( $sql == true && $config == true )
            exit("Both Configuration file & SQL file are write & readable. <a href=\"?step=3\">Click here to continue</a>");

        if ( $sql == true && $config == false )
            exit("SQL file <i>is</i> readable. Configuration file is <b>NOT</b> writeable. Please check the instructions above.");

        if ( $sql == false && $config == true )
        {
            exit("SQL file is <b>NOT</b> readable. Configuration file <i>is</i> writeable. Please check the instructions above.");
        }
        else
        {
            exit("Neither the SQL file or the Configuration file is writeable. Please check the instructions above.");
        }
        exit;
    }

    function step3()
    {
        if ( !isset( $_POST['submit'] ) || $_POST['submit'] != "step3" )
        {
            return NULL;
            exit;
        }


        echo "[Info] Connecting to database...";
        $conn = new mysqli(
            $_SESSION['install']['web']['database']['host'], 
            $_SESSION['install']['web']['database']['username'],
            $_SESSION['install']['web']['database']['password'],
            null,
            (int)$_SESSION['install']['web']['database']['port']);

        if ( $conn->connect_errno != 0 )
        {
            die("<br/>[FAILURE] Could not connect to the database. Please <a href=\"./index.php\">restart</a> the installation. ");
        }

        echo "<br>[Success] Connected to database.<br>[Info] Creating Website database...";

        if ( !$conn->query("CREATE DATABASE IF NOT EXISTS ". $conn->escape_string($_SESSION['install']['web']['database']['name']) .";") )
            die("<br>[FAILURE] Could not create the website database. ". $conn->error." .Please <a href=\"./index.php\">restart</a> the installation.");

        echo "<br>[Success] Created Website database.
        <br>[Info] Connecting to Website database";

        if ( !$conn->select_db($_SESSION['install']['web']['database']['name']) )
        	die("<br>[FAILURE] Could not connect to the Website database. Please <a href=\"./index.php\">restart</a> the installation.");

        echo "<br>[Success] Connected to Website database.
        <br>[Info] Creating tables & inserting data into Website database...";

        $f        = fopen("sql/CraftedWeb_Base.sql", "r+");
        $sqlFile  = fread($f, filesize("sql/CraftedWeb_Base.sql"));
        $sqlArray = explode(";", $sqlFile);

        if ( is_array($sqlArray) || is_object($sqlArray) )
        {
            foreach ($sqlArray as $stmt)
            {
                if ( strlen($stmt) > 3 )
                {
                    if ( !$conn->query($stmt) )
                        die("<br>[FAILURE] Could not run SQL file for the Website database. Please <a href=\"./index.php\"restart</a> the installation. (". $conn->error .")");
                }
            }
        }

        echo "<br>[Success] SQL file imported successfully!
        <br>[Info] (Optional) Trying to import <i>item_icons</i> into Website database.";

        $f        = fopen("sql/item_icons.sql", "r+");
        $sqlFile2 = fread($f, filesize("sql/item_icons.sql"));
        $sqlArray = explode(";", $sqlFile2);

        if ( is_array($sqlArray) || is_object($sqlArray) )
        {
            foreach ($sqlArray as $stmt)
            {
                if ( strlen($stmt) > 3 )
                {
                    if ( !$conn->query($stmt) ) $err = 1;
                }
            }
        }
        if ( !isset($err) )
        {
            echo "<br/>[Success] SQL file imported successfully!";
        }
        else
        {
            echo "<br/>[Info] <i>item_icons</i> was not imported. (". $conn->error .")";
        }

        echo "<br/>[Info] Writing configuration file...";


        $config = array
        (
            "maintainance" => array
                (
                    "state" => false,
                    "allowed_ips" => array("1.1.1.1", "127.0.0.1")
                ),
            "use" => array
                (
                    "slideshow" => true,
                    "cache" => true,
                    "debug" => false
                ),
            "website" => array
                (
                    "title" => $_SESSION['install']['web']['title'],
                    "domain" => $_SESSION['install']['web']['domain'],
                    "email" => $_SESSION['install']['web']['email'],
                    "show_load_time" => true,
                    "footer" => "Copyright &copy; ". $_SESSION['install']['web']['title'] ." ".date("Y")."<br/>All rights reserved.",
                    "timezone" => date_default_timezone_get(),
                    "expansion" => $_SESSION['install']['web']['expansion'],
                    "enable_plugins" => true,
                    "compression" => array
                        (
                            "gzip" => true,
                            "sanitize_output" => true
                        ),
                    "news" => array
                        (
                            "enable" => true,
                            "max_shown" => 5,
                            "enable_comments" => true,
                            "limit_home_characters" => false,
                        ),
                    "server_status" => array
                        (
                            "enable" => true,
                            "next_arena_flush" => false,
                            "uptime" => true,
                            "players_online" => true,
                            "faction_bar" => true
                        ),
                    "connection" => array
                        (
                            "host" => $_SESSION['install']['web']['database']['host'],
                            "port" => $_SESSION['install']['web']['database']['port'],
                            "username" => $_SESSION['install']['web']['database']['username'],
                            "password" => $_SESSION['install']['web']['database']['password'],
                            "name" => $_SESSION['install']['web']['database']['name']
                        ),
                    "realmlist" => $_SESSION['install']['web']['realmlist'],
                    "registration" => array
                        (
                            "user_max_length" => 16,
                            "user_min_length" => 3,
                            "pass_max_length" => 255,
                            "pass_min_length" => 5,
                            "validate_email" => false,
                            "captcha"       => true
                        ),
                    "vote" => array
                        (
                            "timer" => 43200,
                            "type" => "confirm",
                            "multiplier" => 2
                        ),
                    "donation" => array
                        (
                            "paypal_email"      => $_SESSION['install']['web']['paypal'],
                            "coins_name"        => "Donations Coins",
                            "currency"          => "EUR",
                            "email_response"     => true,
                            "send_response_copy"  => true,
                            "copy_to"            => $_SESSION['install']['web']['email'],
                            "response_subject"   => "Thanks for your support!",
                            "donation_type"      => 2
                        ),
                    "donation_list" => array
                        (
                            array("10 Donation Coins - 5€", 10, 5),
                            array("20 Donation Coins - 8€", 20, 8),
                            array("50 Donation Coins - 20€", 50, 20),
                            array("100 Donation Coins - 35€", 100, 35 ),
                            array("200 Donation Coins - 70€", 200, 70 )
                        ),
                    "shop" => array
                    (
                        "vote" => array
                            (
                                "enabled" => true,
                                "advanced_search" => true,
                                "type" => 1
                            ),
                        "donate" => array
                            (
                                "enabled" => true,
                                "advanced_search" => true,
                                "type" => 1
                            )
                    ),
                    "social" => array
                        (
                            "facebook_module" => false,
                            "facebook_group_url" => "http://www.facebook.com/YourServer"
                        ),
                    "forum" => array
                        (
                            "type" => "phpbb",
                            "auto_account_create" => false,
                            "path" => "/forum/",
                            "db" => "phpbb"
                        ),
                    "core_pages" => array
                        (
                            "account_panel"       => "account.php",
                            "shopping_cart"       => "cart.php", 
                            "change_password"     => "changepass.php",
                            "donate"              => "donate.php",
                            "donation_shop"       => "donateshop.php",
                            "forgot_password"     => "forgotpw.php",
                            "home"                => "home.php",
                            "logout"              => "logout.php",
                            "news"                => "news.php",
                            "refer_a_friend"      => "raf.php",
                            "register"            => "register.php", 
                            "character_revive"    => "revive.php",
                            "change_email"        => "settings.php",
                            "support"             => "support.php", 
                            "character_teleport"  => "teleport.php",    
                            "character_unstucker" => "unstuck.php",
                            "vote"                => "vote.php",
                            "vote_shop"           => "voteshop.php",
                            "confirm_service"     => "confirmservice.php"
                        ),
                    "item_level" => array
                        (
                            1 => 86,
                            2 => 146,
                            3 => 251,
                            4 => 397,
                            5 => 553,
                            6 => 621,
                            7 => 1000,
                            8 => 450,
                        ),
                ),
            "admin" => array("enabled" => true, "minlvl" => 4),
            "staff" => array
                (
                    "enabled" => true, 
                    "minlvl" => 3,
                    "permissions" => array
                        (
                            "Pages"                  => false,
                            "News"                   => false,
                            "Shop"                   => false,
                            "Donations"              => false,
                            "Logs"                   => true,
                            "Interface"              => false,
                            "Users"                  => true,
                            "Realms"                 => false,
                            "Services"               => false,
                            "Tools->Tickets"         => true,
                            "Tools->Account Access"  => false,
                            "editNewsComments"       => true,
                            "editShopItems"          => false,
                        )
                ),

            "logon" => array
                (
                    "host" => $_SESSION['install']['logon']['database']['host'],
                    "port" => $_SESSION['install']['logon']['database']['port'],
                    "user" => $_SESSION['install']['logon']['database']['username'],
                    "password" => $_SESSION['install']['logon']['database']['password'],
                    "database" => $_SESSION['install']['logon']['database']['name']
                ),
            "characters" => array
                (
                    "host"        => $_SESSION['install']['characters']['database']['host'],
                    "port"        => $_SESSION['install']['characters']['database']['port'],
                    "user"        => $_SESSION['install']['characters']['database']['username'],
                    "password"    => $_SESSION['install']['characters']['database']['password'],
                    "database"    => $_SESSION['install']['characters']['database']['name']
                ),
            "world" => array
                (
                    "host"        => $_SESSION['install']['world']['database']['host'],
                    "port"        => $_SESSION['install']['world']['database']['port'],
                    "user"        => $_SESSION['install']['world']['database']['username'],
                    "password"    => $_SESSION['install']['world']['database']['password'],
                    "database"    => $_SESSION['install']['world']['database']['name']
                ),
        );
        

        if ( !$fp = fopen("../core/includes/configuration.json", "w") )
        {
            die("<br/>[FAILURE] Could not write Configuration file. Please <a href=\"./index.php\">restart</a> the installation.");;
        }
        else
        {
            $json_config = json_encode($config);
            fwrite($fp, $json_config);
            fclose($fp);

            echo "<br>[Success] Configuration file was written!";

            echo "<hr>Installation proccess finished. <a href=\"?step=4\">Click here to continue</a>";
            exit;
        }
    }


    function step4()
    {
        if ( $_POST['submit'] != "step4" )
        {
            return NULL;
            exit;
        }

        $files = scandir("sql/updates/");
        if ( sizeof($files) === 3 )
        {
            echo "[Info] No Updated Avaiable. <a href=\"?step=5\">Click here to continue</a>";
            exit;
        }

        echo "[Info] Connecting to database...";
        $conn = mysqli_connect(
            $_SESSION['install']['web']['database']['host'], 
            $_SESSION['install']['web']['database']['username'], 
            $_SESSION['install']['web']['database']['password'],
            null,
            $_SESSION['install']['web']['database']['port']);

        if ( $conn->connect_errno != 0 )
        {
            die("<br/>[FAILURE] Could not connect to the database. Please <a href=\"./index.php\">restart</a> the installation. ");
        }

        echo "<br>[Success] Connected to database.
        <br>[Info] Connecting to Website database";

        if ( !$conn->select_db($_SESSION['install']['web']['database']['name']) )
        	die("<br>[FAILURE] Could not connect to the Website database. Please <a href=\"./index.php\">restart</a> the installation.");

        echo "<br>[Success] Connected to Website database
        <br>[Info] Now applying updates...";

        if ( is_array($files) || is_object($files) )
        {
            foreach ($files as $value)
            {
                if ( substr($value, -3, 3) == "sql" )
                {
                    echo "<br>[Info] Applying ". $value ."...";
                    if ( !$f = fopen("sql/updates/". $value, "r+") )
                    {
                        die ("<br/>[FAILURE] Could not open SQL file. Please set the CHMOD to 777 and try again.");
                    }
                    else
                    {
                        $sqlFile  = fread($f, filesize("sql/updates/". $value));
                        $sqlArray = explode(";", $sqlFile);

                        if ( is_array($sqlArray) || is_object($sqlArray) )
                        {
                            foreach ($sqlArray as $stmt)
                            {
                                if ( strlen($stmt) > 3 )
                                {
                                    if ( !$conn->query($stmt) )
                                    {
                                        die("<br/>[FAILURE] Could not run SQL file for the Website database. (". $conn->error .")");
                                    }
                                }
                            }
                            echo "<br>[Success] Update completed.";
                        }
                    }
                }
            }
            echo "<br>[Success] Updates completed. <a href=\"?step=5\">Click here to continue</a>";
        }
        exit;
    }

    function step5()
    {
        if ( !isset($_POST['submit']) || $_POST['submit'] != "step5" )
        {
            return NULL;
            exit;
        }

    	if ( empty( $_POST['realm_name'] ) || 
        	empty( $_POST['realm_access_username'] ) || 
        	empty( $_POST['realm_access_password'] ) || 
        	empty( $_POST['realm_sendtype'] ) || 
        	empty( $_POST['realm_port'] ) )
        {
            die('Please enter all fields.');
        }

        $step5 = array
        (
            "realm_name"                => $_POST['realm_name'],
            "realm_access_username"     => $_POST['realm_access_username'],
            "realm_access_password"     => $_POST['realm_access_password'],
            "realm_description"         => $_POST['realm_description'],
            "realm_sendtype"            => $_POST['realm_sendtype'],
            "realm_port"                => $_POST['realm_port']
        );

        
        if ( file_exists("../core/includes/classes/validator.php") )
        {
        	include "../core/includes/classes/validator.php";

        	$Validator = new Validator(null, $step5, $step5);

            # $_POST has been sanatized.
    		$_POST = $Validator->sanatize($_POST);

            $conn = new mysqli(
                $_SESSION['install']['web']['database']['host'], 
                $_SESSION['install']['web']['database']['username'], 
                $_SESSION['install']['web']['database']['password'],
                null,
                $_SESSION['install']['web']['database']['port']);

            if ( $conn->connect_errno != 0 )
                die("<br/>[FAILURE] Could not connect to the database. Please <a href=\"./index.php\">restart</a> the installation. ");

            $conn->select_db($_SESSION['install']['web']['database']['name']);

            $realm_name     = $conn->escape_string($step5['realm_name']);
            $admin_username = $conn->escape_string($step5['realm_access_username']);
            $admin_password = $conn->escape_string($step5['realm_access_password']);
            $description    = $conn->escape_string($step5['realm_description']);
            $sendtype       = $conn->escape_string($step5['realm_sendtype']);
            $port           = $conn->escape_string($step5['realm_port']);
            
            $conn->query("INSERT INTO realms 
            	(name, description, char_db, port, rank_user, rank_pass, ra_port, soap_port, host, sendType, mysqli_host, mysqli_user, mysqli_pass) 
            	VALUES
            	('". $realm_name ."', 
            	'". $description ."', 
            	'". $_SESSION['install']['characters']['database']['name'] ."', 
            	'". $port ."', 
            	'". $admin_username ."', 
            	'". $admin_password ."', 
            	'". $port ."', 
            	'". $port ."', 
            	'". $_SESSION['install']['characters']['database']['host'] ."', 
            	'". $sendtype ."', 
            	'". $_SESSION['install']['characters']['database']['host'] ."', 
            	'". $_SESSION['install']['characters']['database']['username'] ."', 
            	'". $_SESSION['install']['characters']['database']['password'] ."');")
            or die("Could not insert realm into database. (". $conn->error .")");

            echo "Realm successfully created. <a href=\"?step=6\">Finish Installation</a>";
            exit;
        }
    }
    
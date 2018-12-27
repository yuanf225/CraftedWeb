<?php

#   ___           __ _           _ __    __     _     
#  / __\ __ __ _ / _| |_ ___  __| / / /\ \ \___| |__  
# / / | '__/ _` | |_| __/ _ \/ _` \ \/  \/ / _ \ '_ \ 
#/ /__| | | (_| |  _| ||  __/ (_| |\  /\  /  __/ |_) |
#\____/_|  \__,_|_|  \__\___|\__,_| \/  \/ \___|_.__/ 
#
#		-[ Created by �Nomsoft
#		  `-[ Original core by Anthony (Aka. CraftedDev)
#
#				-CraftedWeb Generation II-                  
#			 __                           __ _   							   
#		  /\ \ \___  _ __ ___  ___  ___  / _| |_ 							   
#		 /  \/ / _ \| '_ ` _ \/ __|/ _ \| |_| __|							   
#		/ /\  / (_) | | | | | \__ \ (_) |  _| |_ 							   
#		\_\ \/ \___/|_| |_| |_|___/\___/|_|  \__|	- www.Nomsoftware.com -	   
#                  The policy of Nomsoftware states: Releasing our software   
#                  or any other files are protected. You cannot re-release    
#                  anywhere unless you were given permission.                 
#                  � Nomsoftware 'Nomsoft' 2011-2012. All rights reserved.    

    require_once "core/includes/classes/cache.php";
    //require_once "core/includes/misc/headers.php"; //Load sessions, error reporting & ob.

    if ( file_exists("install/index.php") )
    {
        header("Location: install/index.php");
        exit;
    }

    define('INIT_SITE', TRUE);
    require "core/includes/misc/connect.php"; //Load connection class

    $Database = new Database();


    ###LOAD MAXIMUM ITEM LEVEL DEPENDING ON EXPANSION###
    switch(DATA['website']['expansion']) 
    {
        case 0:
            $maxItemLevel = 100;
            break;

        case 1:
            $maxItemLevel = 175;
            break;

        default:
        case 2:
            $maxItemLevel = 284;
            break;

        case 3:
            $maxItemLevel = 416;
            break;

        case 4:
        case 5:
        case 6:
        case 7:
            break;
    }
    
    if( DATA['website']['expansion'] > 2 )
    {
        $tooltip_href = "www.wowhead.com/";
    }
    else
    {
        $tooltip_href = "www.openwow.com/?";
    }
    
    //Set the error handling.
    if( file_exists("core/includes/classes/error.php") )
    {
        require "core/includes/classes/error.php";
    }
    
    loadCustomErrors(); //Load custom errors

    if ( DATA['maintainance']['state'] == TRUE && !in_array($_SERVER['REMOTE_ADDR'], DATA['maintainance']['allowed_ips']) )
    {
        die("<center><h3>Website Maintainance</h3>". DATA['website']['title'] ." is currently undergoing some major maintainance and will be available as soon as possible.<br/><br/>Sincerely</center>");
    }

    //require "core/includes/misc/func_lib.php";
    //require "core/includes/misc/compress.php";

    require "core/includes/classes/account.php";
    require "core/includes/classes/character.php";
    require "core/includes/classes/plugins.php";
    require "core/includes/classes/server.php";
    require "core/includes/classes/shop.php";
    require "core/includes/classes/website.php";

    global $Plugins, $Account, $Website;
    $Plugins = new Plugins();

    /********** LOAD PLUGINS ***********/
    $Plugins->globalInit();

    $Plugins->init("classes");
    $Plugins->init("javascript");
    $Plugins->init("modules");
    $Plugins->init("styles");
    $Plugins->init("pages");

//Load configs.
    if ( DATA['website']['enable_plugins'] == true )
    {
        if ( $_SESSION['loaded_plugins'] != NULL )
        {
            if ( is_array($_SESSION['loaded_plugins']) || is_object($_SESSION['loaded_plugins']) )
            {
                foreach ($_SESSION['loaded_plugins'] as $folderName)
                {
                    if ( file_exists("core/plugins/". $folderName ."/config.php") )
                    {
                        include_once "core/plugins/". $folderName ."/config.php";
                    }
                }
            }
        }
    }

    $Account->getRemember(); //Remember thingy.
    
    //This is to prevent the error "Undefined index: p"
    if ( !isset($_GET['page']) )
    {
        $_GET['page'] = 'home';
    }

###VOTING SYSTEM####
    if ( isset($_SESSION['votingUrlID']) && $_SESSION['votingUrlID'] != 0 && DATA['website']['vote']['type'] == "confirm" )
    {
        if ( $Website->checkIfVoted($Database->conn->escape_string($_SESSION['votingUrlID'])) == TRUE )
        {
            die("?page=vote");
        }

        $accound_id = $Account->getAccountID($_SESSION['cw_user']);

        $next_vote = time() + DATA['website']['vote']['timer'];

        $Database->selectDB("webdb");

        $insert_values = array
        (
            "siteid" => $Database->conn->escape_string($_SESSION['votingUrlID']),
            "userid" => $accound_id,
            "timestamp" => time(),
            "next_vote" => $next_vote,
            "ip" => $_SERVER['REMOTE_ADDR']
        );

        $Database->insert("votelog", $insert_values);

        $statement = $Database->select("votingsites", "points, url", null, "id=". $Database->conn->escape_string($_SESSION['votingUrlID']));
        $siteData = $statement->get_result();
        $row = $siteData->fetch_assoc();

        if ( $siteData->num_rows == 0 )
        {
            header("Location: index.php");
            unset($_SESSION['votingUrlID']);
        }

        //Update the points table.
        $add = $row['points'] * DATA['website']['vote']['multiplier'];
        $Database->update("account_data", array("vp" => "vp+$add"), array("id"=>$accound_id));

        unset($_SESSION['votingUrlID']);

        header("Location: ?page=vote");
    }

###SESSION SECURITY###
    if ( !isset($_SESSION['last_ip']) && isset($_SESSION['cw_user']) )
    {
        $_SESSION['last_ip'] = $_SERVER['REMOTE_ADDR'];
    }
    elseif ( isset($_SESSION['last_ip']) && isset($_SESSION['cw_user']) )
    {
        if ( $_SESSION['last_ip'] != $_SERVER['REMOTE_ADDR'] )
        {
            header("Location: ?page=logout");
        }
        else
        {
            $_SESSION['last_ip'] = $_SERVER['REMOTE_ADDR'];
        }
    }

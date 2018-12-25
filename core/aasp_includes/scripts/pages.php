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

    define('INIT_SITE', TRUE);
    include "../../includes/misc/headers.php";
    include "../../includes/configuration.php";
    include "../functions.php";
    global $GameServer, $GameAccount;
    $conn = $GameServer->connect();

    $GameServer->selectDB("webdb", $conn);

    # Organized Alphabeticaly

    switch ($_POST['action'])
    {
        case "addVoteLink":
        {
            $title  = $Database->conn->escape_string($_POST['title']);
            $points = $Database->conn->escape_string($_POST['points']);
            $image  = $Database->conn->escape_string($_POST['image']);
            $url    = $Database->conn->escape_string($_POST['url']);

            if (!empty($title) && !empty($points) && !empty($image) && !empty($url))
            {
                $Database->conn->query("INSERT INTO votingsites (title, points, image, url) VALUES('". $title ."', '". $points ."', '". $image ."', '". $url ."');");
            }

            break;
        }

        case "delete":
        {
            $Database->conn->query("DELETE FROM custom_pages WHERE filename='". $Database->conn->escape_string($_POST['filename']) ."';");
            return;

            break;
        }

        case "removeVoteLink":
        {
            $id = $Database->conn->escape_string($_POST['id']);

            $Database->conn->query("DELETE FROM votingsites WHERE id=". $id .";");

            break;
        }

        case "saveServicePrice":
        {
            $service  = $Database->conn->escape_string($_POST['service']);
            $price    = $Database->conn->escape_string($_POST['price']);
            $currency = $Database->conn->escape_string($_POST['currency']);
            $enabled  = $Database->conn->escape_string($_POST['enabled']);

            $Database->conn->query("UPDATE service_prices SET price=". $price .", currency='". $currency ."', enabled='". $enabled ."' WHERE service='". $service ."';");

            break;
        }

        case "saveVoteLink":
        {
            $id     = $Database->conn->escape_string($_POST['id']);
            $title  = $Database->conn->escape_string($_POST['title']);
            $points = $Database->conn->escape_string($_POST['points']);
            $image  = $Database->conn->escape_string($_POST['image']);
            $url    = $Database->conn->escape_string($_POST['url']);

            if (!empty($id))
            {
                $Database->conn->query("UPDATE votingsites SET title='". $title ."', points='". $points ."', image='". $image ."', url='". $url ."' 
                    WHERE id=". $id .";");
            }

            break;
        }

        case "toggle":
        {
            if ($_POST['value'] == 1)
            {
                //Enable
                $Database->conn->query("DELETE FROM disabled_pages WHERE filename='". $Database->conn->escape_string($_POST['filename']) ."';");
            }
            elseif ($_POST['value'] == 2)
            {
                //Disable
                $Database->conn->query("INSERT INTO disabled_pages values('". $Database->conn->escape_string($_POST['filename']) ."');");
            }

            break;
        }

    }
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

    $GameServer->selectDB("logondb");

    # Organized Alphabeticaly

    switch ($_POST['action']) 
    {
        case "addAccA":
        {
            $user  = $Database->conn->escape_string($_POST['user']);
            $realm = $Database->conn->escape_string($_POST['realm']);
            $rank  = $Database->conn->escape_string($_POST['rank']);

            $guid = $GameAccount->getAccID($user);

            $Database->conn->query("INSERT INTO account_access VALUES(". $guid .", ". $rank .", ". $realm .");");
            $GameServer->logThis("Added GM Account Access For " . ucfirst(strtolower($GameAccount->getAccName($guid))));
            break;
        }
        
        case "edit":
        {
            $email    = $Database->conn->escape_string(trim($_POST['email']));
            $password = $Database->conn->escape_string(trim(strtoupper($_POST['password'])));
            $vp       = $Database->conn->escape_string($_POST['vp']);
            $dp       = $Database->conn->escape_string($_POST['dp']);
            $id       = $Database->conn->escape_string($_POST['id']);
            $extended = NULL;

            $chk1 = $Database->select("account", "COUNT(*)", null, "email='$email' AND id=$id")->get_result();
            if ($chk1->data_seek(0) > 1)
            {
                $extended .= "Changed email to". $email ."<br/>";
            }
            $Database->conn->query("UPDATE account SET email='". $email ."' WHERE id=$id");

            $GameServer->selectDB("webdb");

            $Database->conn->query("INSERT INTO account_data (id) VALUES(". $id .");");

            $chk2 = $Database->select("account_data", "COUNT(*)", null, "vp=$vp AND id=$id")->get_result();
            if ($chk2->data_seek(0) > 1)
            {
                $extended .= "Updated Vote Points to ". $vp ."<br/>";
            }

            $chk3 = $Database->select("account_data", "COUNT(*)", null, "dp=$dp AND id=$id")->get_result();
            if ($chk3->data_seek(0) > 1)
            {
                $extended .= "Updated Donation Coins to ". $dp ."<br/>";
            }

            $Database->conn->query("UPDATE account_data SET vp=". $vp .", dp =". $dp ." WHERE id=". $id .";");

            if (!empty($password))
            {
                $username = strtoupper(trim($GameAccount->getAccName($id)));

                $password = sha1("". $username .":". $password ."");
                $GameServer->selectDB("logondb");
                $Database->conn->query("UPDATE account SET sha_pass_hash='". $password ."' WHERE id=". $id .";");
                $Database->conn->query("UPDATE account SET v='0', s='0' WHERE id=". $id .";");
                $extended .= "Changed password<br/>";
            }


            $GameServer->logThis("Modified account information for " . ucfirst(strtolower($GameAccount->getAccName($id))), $extended);
            echo "Settings were saved.";
            break;
        }

        case "editChar":
        {
            $guid            = $Database->conn->escape_string($_POST['guid']);
            $rid             = $Database->conn->escape_string($_POST['rid']);
            $name            = $Database->conn->escape_string(trim(ucfirst(strtolower($_POST['name']))));
            $class           = $Database->conn->escape_string($_POST['class']);
            $race            = $Database->conn->escape_string($_POST['race']);
            $gender          = $Database->conn->escape_string($_POST['gender']);
            $money           = $Database->conn->escape_string($_POST['money']);
            $GameAccountname = $Database->conn->escape_string($_POST['account']);
            $GameAccountid   = $GameAccount->getAccID($GameAccountname);

            if (empty($guid) || empty($rid) || empty($name) || empty($class) || empty($race))
            {
                exit('Error');
            }

            $GameServer->realm($rid);

            $online = $Database->select("characters", "COUNT(*)", null, "guid=$guid AND online=1")->get_result();
            if ($online->data_seek(0) > 0)
            {
                exit('The character must be online for any change to take effect!');
            }

            $Database->conn->query("UPDATE characters SET name='". $name ."', class=". $class .", race=". $race .", gender=". $gender .", money=". $money .", account=". $GameAccountid ." WHERE guid=". $guid .";");

            echo 'The character was saved!';

            $chk = $Database->select("characters", "COUNT(*)", null, "name='$name'")->get_result();

            if ($chk->data_seek(0) > 1)
            {
                echo '<br/><b>NOTE:</b> It seems like there more than 1 character with this name, this might force them to rename when they log in.';
            }

            $GameServer->logThis("Modified character data for " . $name);

            break;
        }

        case "removeAccA":
        {
            $id = $Database->conn->escape_string($_POST['id']);

            $Database->conn->query("DELETE FROM account_access WHERE id=". $id .";");
            $GameServer->logThis("Modified GM account access for " . ucfirst(strtolower($GameAccount->getAccName($id))));

            break;
        }

        case "saveAccA":
        {
            $id    = $Database->conn->escape_string($_POST['id']);
            $rank  = $Database->conn->escape_string($_POST['rank']);
            $realm = $Database->conn->escape_string($_POST['realm']);

            $Database->conn->query("UPDATE account_access SET gmlevel=$rank , RealmID=$realm  WHERE id=$id;");
            $GameServer->logThis("Modified account access for " . ucfirst(strtolower($GameAccount->getAccName($id))));

            break;
        }

        default:
            exit;
            break;
    }
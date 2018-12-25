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
        case "addLink": 
        {
            $title     = $Database->conn->escape_string($_POST['title']);
            $url       = $Database->conn->escape_string($_POST['url']);
            $shownWhen = $Database->conn->escape_string($_POST['shownWhen']);

            if (empty($title) || empty($url) || empty($shownWhen))
            {
                die("Please enter all fields.");
            }

            if ($Database->conn->query("INSERT INTO site_links (title, url, shownWhen) VALUES('". $title ."', '". $url ."', '". $shownWhen ."');"))
            {
                $GameServer->logThis("Added ". $title ." to the menu");
            }
            else
            {
                $GameServer->logThis("Could Not Add The Menu - ". $Database->conn->error);
            }
            
            break;
        }
        
        case "deleteImage":
        {
            $id = $Database->conn->escape_string($_POST['id']);

            if ($Database->conn->query("DELETE FROM slider_images WHERE position=". $id .";"))
            {
                $GameServer->logThis("Removed a slideshow image");
            }
            else
            {
                $GameServer->logThis("Could Not Remove The Selected Slideshow Image - ". $Database->conn->error);
            }
            break;
        }

        case "deleteLink":
        {
            $id = $Database->conn->escape_string($_POST['id']);

            if($Database->conn->query("DELETE FROM site_links WHERE position=". $id .";"))
            {
                $GameServer->logThis("Removed a menu link");
            }
            else
            {
                $GameServer->logThis("Could Not Remove A Menu Link - ". $Database->conn->error);
            }
            break;
        }

        case "disablePlugin":
        {
            $foldername = $Database->conn->escape_string($_POST['foldername']);

            if ($Database->conn->query("INSERT INTO disabled_plugins VALUES('". $foldername ."');"))
            {
                include "../../core/plugins/" . $foldername . "/info.php";
                $GameServer->logThis("Disabled the plugin " . $title);
            }
            else
            {
                $GameServer->logThis("Could Not Disable The Plugin - ". $Database->conn->error);   
            }
            break;
        }

        case "enablePlugin":
        {
            $foldername = $Database->conn->escape_string($_POST['foldername']);

            if ($Database->conn->query("DELETE FROM disabled_plugins WHERE foldername='". $foldername ."';"))
            {
                include "../../core/plugins/" . $foldername . "/info.php";
                $GameServer->logThis("Enabled the plugin -" . $title);
            }
            else
            {
                $GameServer->logThis("Coud Not Enable The Plugin - ". $Database->conn->error);
            }
            break;
        }

        case "getMenuEditForm":
        {
            $id = $Database->conn->escape_string($_POST['id']);
            $result = $Database->select( * FROM site_links WHERE position=". $id .";");
            $rows   = $result->fetch_assoc();
            ?>
            Title<br/>
            <input type="text" id="editlink_title" value="<?php echo $rows['title']; ?>"><br/>
            URL<br/>
            <input type="text" id="editlink_url" value="<?php echo $rows['url']; ?>"><br/>
            Show when<br/>
            <select id="editlink_shownWhen">
                <option value="always" <?php 
                    if ($rows['shownWhen'] == "always")
                    {
                        echo "selected='selected'";
                    } ?>
                >Always</option>
                <option value="logged" <?php 
                    if ($rows['shownWhen'] == "logged")
                    {
                        echo "selected='selected'";
                    } ?>
                >The user is logged in</option>
                <option value="notlogged" <?php 
                    if ($rows['shownWhen'] == "notlogged")
                    {
                        echo "selected='selected'";
                    } ?>
                >The user is not logged in</option>
            </select><br/>
            <input type="submit" value="Save" onclick="saveMenuLink('<?php echo $rows['position']; ?>')">
            <?php
            break;
        }

        case "installTemplate":
        {
            $name = $Database->conn->escape_string(trim($_POST['name']));
            $path = $Database->conn->escape_string(trim($_POST['path']));
            if ($Database->conn->query("INSERT INTO template (`name`, `path`) VALUES('". $name ."', '". $path ."');"))
            {
                $GameServer->logThis("Installed the template ". $_POST['name']);
            }
            else
            {
                $GameServer->logThis("Error installing the template ". $Database->conn->error);
            }
            break;
        }

        case "saveMenu":
        {
            $title     = $Database->conn->escape_string($_POST['title']);
            $url       = $Database->conn->escape_string($_POST['url']);
            $shownWhen = $Database->conn->escape_string($_POST['shownWhen']);
            $id        = $Database->conn->escape_string($_POST['id']);

            if (empty($title) || empty($url) || empty($shownWhen))
            {
                die("Please enter all fields.");
            }

            if ($Database->conn->query("UPDATE site_links SET title='". $title ."', url='". $url ."', shownWhen='". $shownWhen ."' WHERE position=". $id .";"))
            {
                $GameServer->logThis("Modified the menu");
            }
            else
            {
                $GameServer->logThis("Could Not Modifie The Menu - ". $Database->conn->error);
            }

            echo TRUE;
            break;
        }

        case "setTemplate":
        {
            $templateId = $Database->conn->escape_string($_POST['id']);
            if ($Database->conn->query("UPDATE template SET applied='0' WHERE applied='1';") && 
                $Database->conn->query("UPDATE template SET applied='1' WHERE id=". $templateId .";"))
            {
                $result = $Database->select( name FROM template WHERE id=". $templateId .";");
                $GameServer->logThis("Template Changed To `". $result->fetch_assoc()['name'] ."`");
            }
            else
            {
                $GameServer->logThis("Could Not Change The Template - ". $Database->conn->error);
            }
            break;
        }

        case "uninstallTemplate":
        {
            $templateId = $Database->conn->escape_string($_POST['id']);
            $result = $Database->select( name FROM template WHERE id=". $templateId .";");

            if ($Database->conn->query("DELETE FROM template WHERE id=". $templateId .";") && 
                $Database->conn->query("UPDATE template SET applied='1' ORDER BY id ASC LIMIT 1;"))
            {
                $GameServer->logThis("Uninstalled Template - `". $result->fetch_assoc()['name'] ."`");
            }
            else
            {
                $GameServer->logThis("Could Not Uninstall The Template - ". $Database->conn->error);
            }
            break;
        }

        default:
        {
            header("Location: ../index.php");
            break;
        }
    }

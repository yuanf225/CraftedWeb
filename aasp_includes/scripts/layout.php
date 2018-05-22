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
    include('../../includes/misc/headers.php');
    include('../../includes/configuration.php');
    include('../functions.php');

    global $GameServer, $GameAccount;
    $conn = $GameServer->connect();

    $GameServer->selectDB("webdb", $conn);

    # Alphabetical

    switch ($_POST['action'])
    {
        case "addLink": 
        {
            $title     = mysqli_real_escape_string($conn, $_POST['title']);
            $url       = mysqli_real_escape_string($conn, $_POST['url']);
            $shownWhen = mysqli_real_escape_string($conn, $_POST['shownWhen']);

            if (empty($title) || empty($url) || empty($shownWhen))
            {
                die("Please enter all fields.");
            }

            if (mysqli_query($conn, "INSERT INTO site_links (title, url, shownWhen) VALUES('". $title ."', '". $url ."', '". $shownWhen ."');"))
            {
                $GameServer->logThis("Added ". $title ." to the menu");
            }
            else
            {
                $GameServer->logThis("Could Not Add The Menu - ". mysqli_error($conn));
            }
            
            break;
        }
        
        case "deleteImage":
        {
            $id = mysqli_real_escape_string($conn, $_POST['id']);

            if (mysqli_query($conn, "DELETE FROM slider_images WHERE position=". $id .";"))
            {
                $GameServer->logThis("Removed a slideshow image");
            }
            else
            {
                $GameServer->logThis("Could Not Remove The Selected Slideshow Image - ". mysqli_error($conn));
            }
            break;
        }

        case "deleteLink":
        {
            $id = mysqli_real_escape_string($conn, $_POST['id']);

            if(mysqli_query($conn, "DELETE FROM site_links WHERE position=". $id .";"))
            {
                $GameServer->logThis("Removed a menu link");
            }
            else
            {
                $GameServer->logThis("Could Not Remove A Menu Link - ". mysqli_error($conn));
            }
            break;
        }

        case "disablePlugin":
        {
            $foldername = mysqli_real_escape_string($conn, $_POST['foldername']);

            if (mysqli_query($conn, "INSERT INTO disabled_plugins VALUES('". $foldername ."');"))
            {
                include('../../plugins/' . $foldername . '/info.php');
                $GameServer->logThis("Disabled the plugin " . $title);
            }
            else
            {
                $GameServer->logThis("Could Not Disable The Plugin - ". mysqli_error($conn));   
            }
            break;
        }

        case "enablePlugin":
        {
            $foldername = mysqli_real_escape_string($conn, $_POST['foldername']);

            if (mysqli_query($conn, "DELETE FROM disabled_plugins WHERE foldername='". $foldername ."';"))
            {
                include('../../plugins/' . $foldername . '/info.php');
                $GameServer->logThis("Enabled the plugin -" . $title);
            }
            else
            {
                $GameServer->logThis("Coud Not Enable The Plugin - ". mysqli_error($conn));
            }
            break;
        }

        case "getMenuEditForm":
        {
            $id = mysqli_real_escape_string($conn, $_POST['id']);
            $result = mysqli_query($conn, "SELECT * FROM site_links WHERE position=". $id .";");
            $rows   = mysqli_fetch_assoc($result);
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
            $name = mysqli_real_escape_string($conn, trim($_POST['name']));
            $path = mysqli_real_escape_string($conn, trim($_POST['path']));
            if (mysqli_query($conn, "INSERT INTO template (`name`, `path`) VALUES('". $name ."', '". $path ."');"))
            {
                $GameServer->logThis("Installed the template ". $_POST['name']);
            }
            else
            {
                $GameServer->logThis("Error installing the template ". mysqli_error($conn));
            }
            break;
        }

        case "saveMenu":
        {
            $title     = mysqli_real_escape_string($conn, $_POST['title']);
            $url       = mysqli_real_escape_string($conn, $_POST['url']);
            $shownWhen = mysqli_real_escape_string($conn, $_POST['shownWhen']);
            $id        = mysqli_real_escape_string($conn, $_POST['id']);

            if (empty($title) || empty($url) || empty($shownWhen))
            {
                die("Please enter all fields.");
            }

            if (mysqli_query($conn, "UPDATE site_links SET title='". $title ."', url='". $url ."', shownWhen='". $shownWhen ."' WHERE position=". $id .";"))
            {
                $GameServer->logThis("Modified the menu");
            }
            else
            {
                $GameServer->logThis("Could Not Modifie The Menu - ". mysqli_error($conn));
            }

            echo TRUE;
            break;
        }

        case "setTemplate":
        {
            $templateId = mysqli_real_escape_string($conn, $_POST['id']);
            if (mysqli_query($conn, "UPDATE template SET applied='0' WHERE applied='1';") && 
                mysqli_query($conn, "UPDATE template SET applied='1' WHERE id=". $templateId .";"))
            {
                $result = mysqli_query($conn, "SELECT name FROM template WHERE id=". $templateId .";");
                $GameServer->logThis("Template Changed To `". mysqli_fetch_assoc($result)['name'] ."`");
            }
            else
            {
                $GameServer->logThis("Could Not Change The Template - ". mysqli_error($conn));
            }
            break;
        }

        case "uninstallTemplate":
        {
            $templateId = mysqli_real_escape_string($conn, $_POST['id']);
            $result = mysqli_query($conn, "SELECT name FROM template WHERE id=". $templateId .";");

            if (mysqli_query($conn, "DELETE FROM template WHERE id=". $templateId .";") && 
                mysqli_query($conn, "UPDATE template SET applied='1' ORDER BY id ASC LIMIT 1;"))
            {
                $GameServer->logThis("Uninstalled Template - `". mysqli_fetch_assoc($result)['name'] ."`");
            }
            else
            {
                $GameServer->logThis("Could Not Uninstall The Template - ". mysqli_error($conn));
            }
            break;
        }

        default:
        {
            header("Location: ../index.php");
            break;
        }
    }


/*
    #                                                                   #
        ############################################################
    #                                                                   #
    #if ($_POST['action'] == "setTemplate")
    {
        $templateId = mysqli_real_escape_string($conn, $_POST['id']);
        if(mysqli_query($conn, "UPDATE template SET applied=0 WHERE applied=1;") && $result = mysqli_query($conn, "UPDATE template SET applied=1 WHERE id=". $templateId .";"))
        {
            $GameServer->logThis("Template Changed To ". $templateId);
            if ($result) echo TRUE;
            else echo FALSE;
        }
        else
        {
            die("Error (". mysqli_error($conn) .").");
        }
        exit;
    }

    #                                                                   #
        ############################################################
    #                                                                   #
    #if ($_POST['action'] == "installTemplate")
    {
        $name = mysqli_real_escape_string($conn, trim($_POST['name']));
        $path = mysqli_real_escape_string($conn, trim($_POST['path']));
        mysqli_query($conn, "INSERT INTO template (`name`, `path`, `applied`) VALUES('". $name ."', '". $path ."', 0);");
        $GameServer->logThis("Installed the template " . $_POST['name']);
        exit;
    }

    #                                                                   #
        ############################################################
    #                                                                   #
    if ($_POST['action'] == "uninstallTemplate")
    {
        $templateId = mysqli_real_escape_string($conn, $_POST['id']);
        mysqli_query($conn, "DELETE FROM template WHERE id=". $templateId .";");
        mysqli_query($conn, "UPDATE template SET applied=1 ORDER BY id ASC LIMIT 1;");

        $GameServer->logThis("Uninstalled a template");
    }

    #                                                                   #
        ############################################################
    #                                                                   #
    #if ($_POST['action'] == "getMenuEditForm")
    {
        $result = mysqli_query($conn, "SELECT * FROM site_links WHERE position=". mysqli_real_escape_string($conn, $_POST['id']) .";");
        $rows   = mysqli_fetch_assoc($result);
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
    }

    #                                                                   #
        ############################################################
    #                                                                   #
    #if ($_POST['action'] == "saveMenu")
    {
        $title     = mysqli_real_escape_string($conn, $_POST['title']);
        $url       = mysqli_real_escape_string($conn, $_POST['url']);
        $shownWhen = mysqli_real_escape_string($conn, $_POST['shownWhen']);
        $id        = mysqli_real_escape_string($conn, $_POST['id']);

        if (empty($title) || empty($url) || empty($shownWhen))
        {
            die("Please enter all fields.");
        }

        mysqli_query($conn, "UPDATE site_links SET title='". $title ."', url='". $url ."', shownWhen='". $shownWhen ."' WHERE position=". $id .";");

        $GameServer->logThis("Modified the menu");

        echo TRUE;
    }
    
    #                                                                   #
        ############################################################
    #                                                                   #
    #if ($_POST['action'] == "deleteLink")
    {
        mysqli_query($conn, "DELETE FROM site_links WHERE position=". mysqli_real_escape_string($conn, $_POST['id']) .";");

        $GameServer->logThis("Removed a menu link");

        echo TRUE;
    }
    
    #                                                                   #
        ############################################################
    #                                                                   #
    if ($_POST['action'] == "addLink")
    {
        
    }
    
    #                                                                   #
        ############################################################
    #                                                                   #
    #if ($_POST['action'] == "deleteImage")
    {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        mysqli_query($conn, "DELETE FROM slider_images WHERE position=". $id .";");

        $GameServer->logThis("Removed a slideshow image");

        echo TRUE;
    }
    
    #                                                                   #
        ############################################################
    #                                                                   #
    #if ($_POST['action'] == "disablePlugin")
    {
        $foldername = mysqli_real_escape_string($conn, $_POST['foldername']);

        mysqli_query($conn, "INSERT INTO disabled_plugins VALUES('". $foldername ."');");

        include('../../plugins/' . $foldername . '/info.php');
        $GameServer->logThis("Disabled the plugin " . $title);
    }
    
    #                                                                   #
        ############################################################
    #                                                                   #
    #if ($_POST['action'] == "enablePlugin")
    {
        $foldername = mysqli_real_escape_string($conn, $_POST['foldername']);

        mysqli_query($conn, "DELETE FROM disabled_plugins WHERE foldername='". $foldername ."';");

        include('../../plugins/' . $foldername . '/info.php');
        $GameServer->logThis("Enabled the plugin " . $title);
    }
*/
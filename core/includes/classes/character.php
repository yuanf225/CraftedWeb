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

    class Character
    {

        public function unstuck ($guid, $char_db)
        {
            global $Database, $Account, $Server;

            $guId   = $Database->conn->escape_string($guid);
            $charDb = $Database->conn->escape_string($char_db);

            $rid  = $Server->getRealmId($charDb);

            $Database->realm($rid);

            if ( $this->isOnline($guId) == TRUE )
            {
                echo '<b class="red_text">Please log out your character before proceeding.';
            }
            else
            {
                if ( $GLOBALS['service']['unstuck']['currency'] == 'vp' )
                {
                    if ( $Account->hasVP($_SESSION['cw_user'], $GLOBALS['service']['unstuck']['price']) == FALSE )
                    {
                        die('<b class="red_text">Not enough Vote Points!</b>');
                    }
                    else
                    {
                        $Account->deductVP($Account->getAccountID($_SESSION['cw_user']), $GLOBALS['service']['unstuck']['price']);
                    }
                }

                if ( $GLOBALS['service']['unstuck']['currency'] == 'dp' )
                {
                    if ( $Account->hasDP($_SESSION['cw_user'], $GLOBALS['service']['unstuck']['price']) == FALSE )
                    {
                        die('<b class="red_text">Not enough ' . $GLOBALS['donation']['coins_name'] . '</b>');
                    }
                    else
                    {
                        $Account->deductDP($Account->getAccountID($_SESSION['cw_user']), $GLOBALS['service']['unstuck']['price']);
                    }
                }

                $statement = $Database->select("character_homebind", null, null, "guild=$guId");
                $getXYZ = $statement->get_result();
                $row    = $getXYZ->fetch_assoc();

                $new_x    = $row['posX'];
                $new_y    = $row['posY'];
                $new_z    = $row['posZ'];
                $new_zone = $row['zoneId'];
                $new_map  = $row['mapId'];

                $Database->update("characters", array("position_x","position_y","position_z","zone","map"), array($new_x, $new_y, $new_z, $new_zone, $new_map, $guId), "guid", $guId);

                $Account->logThis("Performed unstuck on " . $this->getCharName($guId, $rid), 'Unstuck', $rid);

                return TRUE;
                $statement->close();
            }
        }

        public function revive($guid, $char_db)
        {
            global $Database, $Server, $Account;

            $guId   = $Database->conn->escape_string($guid);
            $charDb = $Database->conn->escape_string($char_db);

            $rid  = $Server->getRealmId($charDb);

            $Database->realm($rid);

            if ( $this->isOnline($guId) == TRUE )
            {
                echo '<b class="red_text">Please log out your character before proceeding.';
            }
            else
            {
                if ( $GLOBALS['service']['revive']['currency'] == 'vp' )
                {
                    if ( $Account->hasVP($_SESSION['cw_user'], $GLOBALS['service']['unstuck']['price']) == FALSE )
                    {
                        die('<b class="red_text">Not enough Vote Points!</b>');
                    }
                    else
                    {
                        $Account->deductVP($Account->getAccountID($_SESSION['cw_user']), $GLOBALS['service']['revive']['price']);
                    }
                }

                if ( $GLOBALS['service']['revive']['currency'] == 'dp' )
                {
                    if ( $Account->hasDP($_SESSION['cw_user'], $GLOBALS['service']['unstuck']['price']) == FALSE )
                    {
                        die('<b class="red_text">Not enough ' . $GLOBALS['donation']['coins_name'] . '</b>');
                    }
                    else
                    {
                        $Account->deductDP($Account->getAccountID($_SESSION['cw_user']), $GLOBALS['service']['revive']['price']);
                    }
                }

                $Database->conn->query("DELETE FROM character_aura WHERE guid=". $guId ." AND spell=20584 OR guid=". $guId ." AND spell=8326;");

                $Account->logThis("Performed a revive on " . $this->getCharName($guId, $rid), 'Revive', $rid);

                return TRUE;
            }
        }

        public function instant80($values)
        {
            global $Database, $Account;

            die("This feature is disabled. <br/><i>Also, you shouldn't be here...</i>");

            $values = $Database->conn->escape_string($values);
            $values = explode("*", $values);

            $Database->realm($values[1]);

            if ( $this->isOnline($values[0]) == TRUE )
            {
                echo '<b class="red_text">Please log out your character before proceeding.';
            }
            else
            {
                $service_values = explode("*", $GLOBALS['service']['instant80']);
                if ( $service_values[1] == "dp" )
                {
                    if ( $Account->hasDP($_SESSION['cw_user'], $GLOBALS['service']['instant80']['price']) == FALSE )
                    {
                        echo '<b class="red_text">Not enough ' . $GLOBALS['donation']['coins_name'] . '</b>';
                        $error = TRUE;
                    }
                }
                elseif ( $service_values[1] == "vp" )
                {
                    if ( $Account->hasVP($_SESSION['cw_user'], $GLOBALS['service']['instant80']['price']) == FALSE )
                    {
                        echo '<b class="red_text">Not enough Vote Points.</b>';
                        $error = TRUE;
                    }
                }

                if ( $error != true )
                {
                    //User got coins. Boost them up to 80 :D
                    $Database->realm($values[1]);

                    $Database->update("characters", "level", 80, "guid", $values[0]);

                    $Account->logThis("Performed an instant max level on " . $this->getCharName($values[0], NULL), 'Instant', NULL);

                    echo '<h3 class="green_text">The character level was set to 80!</h3>';
                }
            }
        }

        public function isOnline($char_guid)
        {
            global $Database;

            $charGuid   = $Database->conn->escape_string($char_guid);
            $statement = $Database->select("characters", "COUNT('guid')", null, "guid=". $charGuid ." AND online=1"); #("SELECT COUNT('guid') FROM characters WHERE guid=". $charGuid ." AND online=1;");
            $result = $statement->get_result();
            if ( $result->data_seek( 0) == 0 )
            {
                return false;
            }
            else
            {
                return true;
            }
            $statement->close();
        }

        public function getRace($value)
        {
            switch ($value)
            {
                default:
                    return "Unknown";
                    break;
                #######
                case(1):
                    return "Human";
                    break;
                #######		 
                case(2):
                    return "Orc";
                    break;
                #######
                case(3):
                    return "Dwarf";
                    break;
                #######
                case(4):
                    return "Night Elf";
                    break;
                #######
                case(5):
                    return "Undead";
                    break;
                #######
                case(6):
                    return "Tauren";
                    break;
                #######
                case(7):
                    return "Gnome";
                    break;
                #######
                case(8):
                    return "Troll";
                    break;
                #######
                case(9):
                    return "Goblin";
                    break;
                #######
                case(10):
                    return "Blood Elf";
                    break;
                #######
                case(11):
                    return "Dranei";
                    break;
                #######
                case(22):
                    return "Worgen";
                    break;
                #######
            }
        }

        public function getGender($value)
        {
            if ( $value == 1 )
            {
                return 'Female';
            }
            elseif ($value == 0)
            {
                return 'Male';
            }
            else
            {
                return 'Unknown';
            }
        }

        public function getClass($value)
        {
            switch ($value)
            {
                default:
                    return "Unknown";
                    break;
                #######
                case(1):
                    return "Warrior";
                    break;
                #######
                case(2):
                    return "Paladin";
                    break;
                #######
                case(3):
                    return "Hunter";
                    break;
                #######
                case(4):
                    return "Rogue";
                    break;
                #######
                case(5):
                    return "Priest";
                    break;
                #######
                case(6):
                    return "Death Knight";
                    break;
                #######
                case(7):
                    return "Shaman";
                    break;
                #######
                case(8):
                    return "Mage";
                    break;
                #######
                case(9):
                    return "Warlock";
                    break;
                #######
                case(11):
                    return "Druid";
                    break;
                #######
                case(12):
                    return "Monk";
                    break;
                ####### 
            }
        }

        public function getClassIcon($value)
        {
            return '<img src="styles/global/images/icons/class/'. $value .'.gif" />';
        }

        public function getFactionIcon($value)
        {
            $a = array(1, 3, 4, 7, 11, 22);
            $h = array(2, 5, 6, 8, 9, 10);

            if ( in_array($value, $a) )
            {
                return '<img src="styles/global/images/icons/faction/0.gif" />';
            }
            elseif ( in_array($value, $h) )
            {
                return '<img src="styles/global/images/icons/faction/1.gif" />';
            }
        }

        public function getCharName($id, $realm_id)
        {
            global $Database;

            $ID      = $Database->conn->escape_string($id);
            $realmID = $Database->conn->escape_string($realm_id);

            $Database->realm($realmID);

            $statement = $Database->select("characters", "name", null, "guid=". $ID);
            $row    = $statement->get_result()->fetch_assoc();
            return $row['name'];
            $statement->close();
        }
    }

    $Character = new Character();
    
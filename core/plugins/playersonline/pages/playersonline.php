d<?php
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
    global $Database, $conn;
    if ($GLOBALS['playersOnline']['enablePage'] != TRUE)
    {
        header("Location: ?page=account");
    }
    $Database->selectDB("webdb", $conn);
    $result    = $Database->select("realms", "id,name", null, "id='" . $GLOBALS['playersOnline']['realm_id'] . "'");
    $row       = $result->get_result()->fetch_assoc();
    $rid       = $row['id'];
    $realmname = $row['name'];

    $Database->realm($rid);

    $statement = $Database->select("characters", "COUNT(*) AS online", null, "name!='' AND online=1");
    $count = $statement->get_result()->fetch_assoc()['online']; ?>
<div class="box_two_title">Online Players - <?php echo $realmname; ?></div>
<?php
    if ( $count == 0 )
    {
        echo '<b>No players are online right now!</b>';
    }
    else
    { ?>
        <table width="100%">
            <tr>
                <th>Name</th><th>Race</th><th>Class</th><th>Guild</th><th>Hk's</th><th>Level</th></tr>
            <?php
            if ( $GLOBALS['playersOnline']['pageResults'] > 0 )
            {
                if ($count > 10)
                    $count = $count - 10;

                $rand = rand(1, $count);

                $statement = $Database->select("characters", "guid, name, totalKills, level, race, class, gender, account", null, "name!='' AND online=1 LIMIT " . $rand . "," . $GLOBALS['playersOnline']['pageResults'] . "");
            }
            else
            {
                $statement = $Database->select("characters", "guid, name, totalKills, level, race, class, gender, account", null, "name!='' AND online=1");
            }
            $result = $statement->get_result();
            while ($row = $result->fetch_assoc())
            {
                $Database->realm($rid);
                $getGuild = $Database->select("guild_member", "guildid", null, "guid='" . $row['guid'] . "'")->get_result();
                if ( $getGuild->num_rows == 0 )
                {
                    $guild = "None";
                }
                else
                {
                    $g        = $getGuild->fetch_assoc();
                    $getGName = $Database->select("guild", "name", null, "guildid='" . $g['guildid'] . "'")->get_result();
                    $x        = $getGName->fetch_assoc();
                    $guild    = '&lt; ' . $x['name'] . ' &gt;';
                }

                if ( $GLOBALS['playersOnline']['display_GMS'] == false )
                {
                    //Check if GM.
                    $Database->selectDB("logondb", $conn);
                    $checkGM = $Database->select("account_access", "COUNT(*) AS gm", null, "id='" . $row['account'] . "' AND gmlevel >0")->get_result();
                    if ( $checkGM->fetch_assoc()['gm'] == 0 )
                    {
                        echo
                        '<tr style="text-align: center;">
        					<td>' . $row['name'] . '</td>
        					<td><img src="styles/global/images/icons/race/' . $row['race'] . '-' . $row['gender'] . '.gif" ></td>
        					<td><img src="styles/global/images/icons/class/' . $row['class'] . '.gif" ></td>
        					<td>' . $guild . '</td>
        					<td>' . $row['totalKills'] . '</td>
        					<td>' . $row['level'] . '</td>
        				</tr>';
                    }
                }
                else
                {
                    echo
                    '<tr style="text-align: center;">
					<td>' . $row['name'] . '</td>
					<td><img src="styles/global/images/icons/race/' . $row['race'] . '-' . $row['gender'] . '.gif" ></td>
					<td><img src="styles/global/images/icons/class/' . $row['class'] . '.gif" ></td>
					<td>' . $guild . '</td>
					<td>' . $row['totalKills'] . '</td>
					<td>' . $row['level'] . '</td>
				</tr>';
                }
            }
            ?>
        </table>
    <?php } ?>
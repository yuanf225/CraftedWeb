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


    global $GamePage, $GameServer, $GameAccount;

    $conn = $GameServer->connect();
    $GameServer->selectDB("logondb", $conn);

    $GamePage->validatePageAccess("Tools->Account Access");
?>
<div class="box_right_title">Account Access</div>
All GM Accounts Are Listed Below.
<br/>&nbsp;
<table>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Rank</th>
        <th>Realms</th>
        <th>Status</th>
        <th>Last Login</th>
        <th>Actions</th>
    </tr>
    <?php
        $result = $Database->select("account_access")->get_result();
        if ($result->num_rows == 0)
        {
            echo "<b>No GM Accounts Found!</b>";
        }
        else
        {
            while ($row = $result->fetch_assoc())
            {
                ?>
                <tr style="text-align:center;">
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $GameAccount->getAccName($row['id']); ?></td>
                    <td><?php echo $row['gmlevel']; ?></td>
                    <td>
                        <?php
                        if ($row['RealmID'] == "-1")
                        {
                            echo "All";
                        }
                        else
                        {
                            $getRealm = $Database->select("realmlist", "name", null, "id=". $row['RealmID'])->get_result();
                            #if ($getRealm->num_rows == 0) echo 'Unknown';
                            $rows     = $getRealm->fetch_assoc();
                            echo $rows['name'];
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        $getData = $Database->select("account", "last_login, online", null, "id=". $row['id'])->get_result();
                        $rows    = $getData->fetch_assoc();
                        if ($rows['online'] == 0)
                        {
                            echo '<font color="red">Offline</font>';
                        }
                        else
                        {
                            echo '<font color="green">Online</font>';
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $rows['last_login'];
                        ?>
                    </td>
                    <td>
                        <a href="#" onclick="editAccA(<?php echo $row['id']; ?>,<?php echo $row['gmlevel']; ?>,<?php echo $row['RealmID']; ?>)">Edit</a>
                        &nbsp;
                        <a href="#" onclick="removeAccA(<?php echo $row['id']; ?>)">Remove</a>
                    </td>
                </tr>
                <?php
            }
        }
    ?>
</table>
<hr/>
<a href="#" class="content_hider" onclick="addAccA()">Add Account</a>
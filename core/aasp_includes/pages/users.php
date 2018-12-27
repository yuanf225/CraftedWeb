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


    global $GameServer, $GamePage;
    $conn = $GameServer->connect();

    $GameServer->selectDB("webdb");

    $GamePage->validatePageAccess("Users");

    if ($GamePage->validateSubPage() == TRUE)
    {
      $GamePage->outputSubPage();
    }
    else
    {
        $GameServer->selectDB("logondb");
        $usersTotal       = $Database->select("account", "COUNT(*) AS totalUsers");
        $usersToday       = $Database->select("account", "COUNT(*) AS dailyUsers", null, "joindate LIKE '%". date("Y-m-d") ."%'");
        $usersMonth       = $Database->select("account", "COUNT(*) AS monthlyUsers", null, "joindate LIKE '%". date("Y-m") ."%'");
        $usersOnline      = $Database->select("account", "COUNT(*) AS onlineUsers", null, "online=1");
        $usersActive      = $Database->select("account", "COUNT(*) AS activeUsers", null, "last_login LIKE '%". date("Y-m") ."%'");
        $usersActiveToday = $Database->select("account", "COUNT(*) AS activeUsersToday", null, "last_login LIKE '%". date("Y-m-d") ."%'");
        ?>
        <div class="box_right_title">Users Overview</div>
        <table style="width: 100%;">
            <tr>
                <td><span class='blue_text'>Total Users</span></td>
                <td><?php echo round($usersTotal->fetch_assoc()['totalUsers']); ?></td>
                
                <td><span class='blue_text'>New Users Today</span></td>
                <td><?php echo round($usersToday->fetch_assoc()['dailyUsers']); ?></td>
            </tr>
            <tr>
                <td><span class='blue_text'>New Users This Month</span></td>
                <td><?php echo round($usersMonth->fetch_assoc()['monthlyUsers']); ?></td>
                
                <td><span class='blue_text'>Users Online</span></td>
                <td><?php echo round($usersOnline->fetch_assoc()['onlineUsers']); ?></td>
            </tr>
            <tr>
                <td><span class='blue_text'>Active Users (This Month)</span></td>
                <td><?php echo round($usersActive->fetch_assoc()['activeUsers']); ?></td>
                
                <td><span class='blue_text'>Users Logged In Today</span></td>
                <td><?php echo round($usersActiveToday->fetch_assoc()['activeUsersToday']); ?></td>
            </tr>
        </table>
        <hr/>
        <a href="?page=users&selected=manage" class="content_hider">Manage Users</a>
    <?php } ?>
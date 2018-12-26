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


    global $GameServer;
    $conn = $GameServer->connect();
    $GameServer->selectDB("webdb", $conn);
    $result = $Database->select("news", null, null, null, "ORDER BY id DESC")->get_result();
    if ($result->num_rows == 0)
    {
        echo "<span class='blue_text'>No News Has Been Posted Yet!</span>";
    }
    else
    {
        ?>
        <div class="box_right_title">News &raquo; Manage</div>
        <table width="100%">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Content</th>
                <th>Comments</th>
                <th>Actions</th>
            </tr>
            <?php
            while ($row = $result->fetch_assoc())
            {
                $comments = $Database->select("news_comments", "COUNT(id) AS comments", null, "newsid=". $row['id'])->get_result();
                echo "<tr class='center'>
                  			<td>". $row['id'] ."</td>
                  			<td>". $row['title'] ."</td>
                  			<td>". substr($row['body'], 0, 25) ."...</td>
                  			<td>". $comments->fetch_assoc()['comments'] ."</td>
                  			<td> <a onclick='editNews(". $row['id'] .")' href='#'>Edit</a> &nbsp;  
                  			<a onclick='deleteNews(". $row['id'] .")' href='#'>Delete</a></td>
                  	</tr>";
            }
            ?>
        </table><?php
}
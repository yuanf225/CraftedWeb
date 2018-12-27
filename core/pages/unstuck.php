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

    global $Account, $Website, $Database; ?>
<div class='box_two_title'>Character Unstuck</div>
Choose the character you wish to unstuck. The character will be teleported to your character's home location.<hr/>
<?php
    $service = "unstuck";

    if ( DATA['service'][$service]['price'] == 0 )
    {
        echo '<span class="attention">Unstuck is free of charge.</span>';
    }
    else
    { ?>
        <span class="attention">Unstuck costs 
            <?php echo DATA['service'][$service]['price'] . ' ' . $Website->convertCurrency(DATA['service'][$service]['currency']); ?></span>
        <?php
        if (DATA['service'][$service]['currency'] == "vp")
            echo "<span class='currency'>Vote Points: " . $Account->loadVP($_SESSION['cw_user']) . "</span>";
        elseif (DATA['service'][$service]['currency'] == "dp")
            echo "<span class='currency'>" . DATA['website']['donation']['coins_name'] . ": " . $Account->loadDP($_SESSION['cw_user']) . "</span>";
    }

    $Account->isNotLoggedIn();
    $Database->selectDB("webdb");
    $num    = 0;
    $result = $Database->select("realms", "char_db, name", null, null, "ORDER BY id ASC;")->get_result();
    while ($row = $result->fetch_assoc())
    {
        $acct_id = $Account->getAccountID($_SESSION['cw_user']);
        $realm   = $row['name'];
        $char_db = $row['char_db'];

        $Database->selectDB($char_db);
        $result = $Database->select("characters", "name, guid, gender, class, race, level, online", null, "account=". $acct_id .";")->get_result();
        while ($row = $result->fetch_assoc())
        {
            ?><div class='charBox'>
                <table width="100%">
                    <tr>
                        <td width="73">
                            <?php
                            if (!file_exists('styles/global/images/portraits/' . $row['gender'] . '-' . $row['race'] . '-' . $row['class'] . '.gif'))
                                echo '<img src="styles/' . DATA['website']['template']['path'] . '/images/unknown.png" />';
                            else
                            {
                                ?>
                                <img src="styles/global/images/portraits/<?php echo $row['gender'] . '-' . $row['race'] . '-' . $row['class']; ?>.gif" border="none"><?php } ?>
                        </td>

                        <td width="160">
                            <h3><?php echo $row['name']; ?></h3>
                            <?php echo $row['level'] . " " . $Character->getRace($row['race']) . " " . $Character->getGender($row['gender']) .
                            " " . $Character->getClass($row['class']);
                            ?>
                        </td>

                        <td>
                            Realm: <?php echo $realm; ?>
                            <?php if ($row['online'] == 1)
                                echo "<br/><span class='red_text'>Please log out before trying to unstuck.</span>";
                            ?>
                        </td>

                        <td align="right"> &nbsp; <input type="submit" value="Unstuck" <?php if ($row['online'] == 0){ ?> onclick='unstuck(<?php echo $row['guid']; ?>, "<?php echo $char_db; ?>")' <?php }
                        else
                        {
                            echo 'disabled="disabled"';
                        }
                            ?>>
                        </td>
                    </tr>                         
                </table>
            </div> <?php
        $num++;
    }
}
?>
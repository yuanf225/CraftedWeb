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

    global $Account, $Database, $Character, $Website;
    $service = $_GET['s'];

    $service_title = ucfirst($service . " Change");

    if ( DATA['service'][$service]['status'] != true )
    {
        echo "This page is currently unavailable.";
    }
    else
    {
        if (isset($_GET['service']) && $_GET['service'] == 'applied')
        {
            echo '<div class="box_two_title">Service applied!</div>';
            echo 'Your service has been applied to the character you just selected. You may have to relog your account to notice any changes.';
            echo '<p/>This action has been logged in our database incase you need any assistance.';
        }
        else
        {
            ?>
            <div class="box_two_title"><?php echo $service_title; ?></div>
            Choose which character you wish to apply this service to.
            <?php
            if ( DATA['service'][$service]['price'] == 0 )
            {
                echo '<span class="attention">' . $service_title . ' is free of charge.</span>';
            }
            else
            {
                ?>
                <span class="attention"><?php echo $service_title; ?> costs 
                    <?php echo DATA['service'][$service]['price'] . ' ' . $Website->convertCurrency(DATA['service'][$service]['currency']); ?></span>
                <?php
                if ( DATA['service'][$service]['currency'] == "vp" )
                {
                    echo "<span class='currency'>Vote Points: " . $Account->loadVP($_SESSION['cw_user']) . "</span>";
                }
                elseif ( DATA['service'][$service]['currency'] == "dp" )
                {
                    echo "<span class='currency'>" . DATA['website']['donation']['coins_name'] . ": " . $Account->loadDP($_SESSION['cw_user']) . "</span>";
                }
            }

            $Account->isNotLoggedIn();
            $Database->selectDB("webdb");
            $num    = 0;
            $result = $Database->select("realms", "char_db, name, id", null, null, "ORDER BY id ASC")->get_result();
            while ($row    = $result->fetch_assoc())
            {
                $acct_id  = $Account->getAccountID($_SESSION['cw_user']);
                $realm    = $row['name'];
                $char_db  = $row['char_db'];
                $realm_id = $row['id'];

                $Database->selectDB($char_db);
                $result = $Database->select("characters", null, null, "account='$acct_id'")->get_result();
                while ($row = $result->fetch_assoc())
                { ?>
                    <div class='charBox'>
                    <table width="100%">
                    <tr>
                        <td width="73">
                            <?php
                            if ( !file_exists("styles/global/images/portraits/". $row['gender'] ."-". $row['race'] ."-". $row['class'] .".gif") )
                            {
                                echo "<img src=\"styles/". DATA['template']['path'] ."/images/unknown.png\" />";
                            }
                            else
                            { ?>
                                <img src="styles/global/images/portraits/<?php echo $row['gender'] ."-". $row['race'] ."-". $row['class']; ?>.gif" border="none"><?php
                            } ?>
                        </td>

                        <td width="160">
                            <h3><?php echo $row['name']; ?></h3>
                            <?php echo $row['level'] ." ". $Character->getRace($row['race']) ." ". $Character->getGender($row['gender']) ." ". $Character->getClass($row['class']);?>
                        </td>

                        <td>
                            Realm: <?php echo $realm;
                            if ( $row['online'] == 1 )
                            {
                                echo "<br/><span class='red_text'>Please log out before applying this service.</span>";
                            } ?>
                        </td>

                        <td align="right">
                            &nbsp; 
                            <input type="submit" value="Select" <?php 
                                if ($row['online'] == 0)
                                { ?> 
                                    onclick='nstepService(
                                        <?php echo $row['guid']; ?>,<?php echo $realm_id; ?>, "<?php echo $service; ?>", "<?php echo $service_title; ?>", "<?php echo $row['name']; ?>")' <?php 
                                }
                                else
                                {
                                    echo 'disabled="disabled"';
                                } ?>>
                        </td>
                    </tr>                         
                    </table>
                    </div> 
                    <?php
                    $num++;
                }
            }
        }
    }
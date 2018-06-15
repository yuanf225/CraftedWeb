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
?>

    <p id="steps">Introduction &raquo; <b>MySQL Info</b> &raquo; Configure &raquo; Database &raquo; Realm Info &raquo; Finished<p>
    <hr/>
    <table cellpadding="10" cellspacing="5">
        <tr>
            <td>MySQL Host:</td>
            <td><input type="text" placeholder="Default: 127.0.0.1" name="step1_host"></td>

            <td>Realmlist:</td>
            <td><input type="text" placeholder="Default: logon.yourserver.com" name="step1_realmlist"></td>

            <td>Website Title:</td>
            <td><input type="text" placeholder="Default: YourServer" name="step1_title"></td>
        </tr>
        <tr>   
            <td>MySQL User:</td>
            <td><input type="text" placeholder="Default: root" name="step1_user"></td> 

            <td>Logon Database:</td>
            <td><input type="text" placeholder="Default: auth" name="step1_logondb"></td>

            <td>Website Domain:</td>
            <td><input type="text" placeholder="Default: http://yourserver.com" name="step1_domain"></td>
        </tr>
        <tr>   
            <td>MySQL Password:</td>
            <td><input type="password" placeholder="Default: ascent" name="step1_pass"></td>  

            <td>World Database:</td>
            <td><input type="text" placeholder="Default: world" name="step1_worlddb"></td>

            <td>Core Expansion:</td>
            <td>
                <select name="step1_exp">
                    <option value="0">Vanilla (No expansion)</option>
                    <option value="1">The Burning Crusade</option>
                    <option value="2" selected>Wrath of the Lich King (TrinityCore)</option>
                    <option value="3">Cataclysm (SkyfireEMU)</option>
                    <option value="4">Mists of Pandaria</option>
                    <option value="5">Legion</option>
                </select>
            </td>
        </tr>
        <tr>    
            <td>PayPal Email:</td>
            <td><input type="text" placeholder="Default: youremail@gmail.com" name="step1_paypal" required></td>  

            <td>Website Database:</td>
            <td><input type="text" placeholder="Default: craftedweb" name="step1_webdb" required></td>   

            <td>Default Email:</td>
            <td><input type="text" placeholder="Default: noreply@yourserver.com" name="step1_email" required></td>        
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="Procceed to Step 2" onclick="step1()"></td>
        </tr>
    </table>
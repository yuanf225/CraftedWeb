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

    $GamePage->validatePageAccess('Logs');

    if ($GamePage->validateSubPage() == TRUE)
    {
      $GamePage->outputSubPage();
    }
    else
    {
      ?>
      <div class='box_right_title'>Hey! You Shouldn't Be Here!</div>

      <pre>The Script Might Have Redirected You Wrong. Or... Did You Try To HACK!? Anyways, Good Luck..</pre>

      <a href="?page=logs&selected=voteshop" class="content_hider">Vote Shop logs</a>
      <a href="?page=logs&selected=donateshop" class="content_hider">Donation Shop logs</a>
      <?php
    }
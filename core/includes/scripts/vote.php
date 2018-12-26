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


require "../ext_scripts_class_loader.php";

if ( isset($_POST['siteid']) )
{

  global $Database, $Account, $Website;

  $siteid = $Database->conn->escape_string($_POST['siteid']);

  $Database->selectDB("webdb");

  if ( $Website->checkIfVoted($siteid))
  {
    die("?page=vote");
  }

  $Database->selectDB("webdb");
  $statement = $Database->select("votingsites", "COUNT(*) AS total", null, "id=$siteid");
  $check = $statement->get_result();
  if ( $check->fetch_assoc()['total'] == 0 )
  {
    die("?page=vote");
  }
  $statement->close();

  if ( DATA['website']['vote']['type'] == "instant" )
  {
    $account_id = $Account->getAccountID($_SESSION['cw_user']);

    if ( empty($account_id) )
    {
      exit();
    }

    $next_vote = time() + DATA['website']['vote']['timer'];

    $Database->selectDB("webdb");

    $Database->insert("votelog", array("siteid", "userid", "timestamp", "next_vote", "ip"), array($siteid, $account_id, time(), $next_vote, $_SERVER['REMOTE_ADDR']));

    $statement = $Database->select("votingsites", "points, url", null, "id=$siteid");
    $getSiteData = $statement->get_result();
    $row         = $getSiteData->fetch_assoc($getSiteData);

    //Update the points table.
    $add = $row['points'] * DATA['website']['vote']['multiplier'];
    $Database->update("account_data", array("vp"=>"vp + $add"), array("id"=>$account_id));

    echo $row['url'];
    $statement->close();
  }
  elseif ( DATA['website']['vote']['type'] == 'confirm' )
  {
    $Database->selectDB("webdb");
    $statement = $Database->select("votingsites", "points, url", null, "id=$siteid");
    $getSiteData = $statement->get_result();
    $row = $getSiteData->fetch_assoc();


    $_SESSION['votingUrlID'] = $Database->conn->escape_string($_POST['siteid']);

    echo $row['url'];
    $statement->close();
  }
  else
  {
    die("Error!");
  }
}
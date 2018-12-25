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

    define('INIT_SITE', TRUE);
    require "../configuration.php";
    require "connect.php";

    global $Database;
    $conn = $Database->connect();

    $send = 'cmd=_notify-validate';

    if (is_array($_POST) || is_object($_POST))
    {
        foreach ($_POST as $key => $value)
        {
            if (get_magic_quotes_gpc() == 1)
            {
                $value = urlencode(stripslashes($value));
            }
            else
            {
                $value = urlencode($value);
            }

            $send .= "&$key=$value";
        }
    }


    $head .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
    $head .= "Content-Type: application/x-www-form-urlencoded\r\n";
    $head .= 'Content-Length: ' . strlen($send) . "\r\n\r\n";

    $fp   = fsockopen('www.paypal.com', 80, $errno, $errstr, 30);

    $Database->selectDB("webdb");

    if ( $fp !== false )
    {
        fwrite($fp, $head . $send);
        $resp = stream_get_contents($fp);

        $resp = end(explode("\n", $resp));

        $item_number = $Database->conn->escape_string($_POST['item_number']);
        $reciever = $Database->conn->escape_string($_POST['receiver_email']);

        $values = array
        (
            "item_name"       => $Database->conn->escape_string($item_number['0']),
            "mc_gross"        => $Database->conn->escape_string($_POST['mc_gross']),
            "txn_id"          => $Database->conn->escape_string($_POST['txn_id']),
            "payment_date"    => $Database->conn->escape_string($_POST['payment_date']),
            "first_name"      => $Database->conn->escape_string($_POST['first_name']),
            "last_name"       => $Database->conn->escape_string($_POST['last_name']),
            "payment_type"    => $Database->conn->escape_string($_POST['payment_type']),
            "payer_email"     => $Database->conn->escape_string($_POST['payer_email']),
            "address_city"    => $Database->conn->escape_string($_POST['address_city']),
            "address_country" => $Database->conn->escape_string($_POST['address_country']),
            "custom"          => $Database->conn->escape_string($_POST['custom']),
            "mc_fee"          => $Database->conn->escape_string($_POST['mc_fee']),
            "fecha"           => date("Y-m-d"),
            "payment_status"  => $Database->conn->escape_string($_POST['payment_status'])
        );

        if ($resp == 'VERIFIED')
        {
            if ( $reciever != $GLOBALS['donation']['paypal_email'] )
            {
                exit();
            }

            $Database->insert("payments_log", $values, array_keys($values));

            $to      = $values['payer_email'];
            $subject = $GLOBALS['donation']['emailResponse'];
            $message = 
                'Hello '. $values['first_name'] .'
        		We would like to inform you that the recent payment you did was successfull.
        		
        		If you require further assistance, please contact us via the forums.
        		------------------------------------------
        		Payment email: '. $values['payer_email'] .'
        		Payment amount: '. $values['mc_gross'] .'
        		Buyer name: '. $values['first_name'] .' '. $values['last_name'] .'
        		Payment date: '. $values['payment_date'] .'
        		Account ID: '. $values['custom'] .'
        		------------------------------------------
        		This payment is saved in our logs.
        		
        		Thank you, the Management.';

            $headers = 'From: ' . $GLOBALS['default_email'] . '' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

            if ($GLOBALS['donation']['emailResponse'] == TRUE)
            {
                mail($to, $subject, $message, $headers);
                if ($GLOBALS['donation']['sendResponseCopy'] == TRUE)
                {
                    mail($GLOBALS['donation']['copyTo'], $subject, $message, $headers);
                }
            }

            $res = fgets($fp, 1024);
            if ( $value['payment_status'] == "Completed" )
            {
                if ($GLOBALS['donation']['donationType'] == 2)
                {
                    $variables = array($values['custom'], $values['mc_gross'], $values['payer_email'], $values['first_name'], $values['last_name'], $values['mc_gross'], $values['payment_date'], $values['fecha']);
                    $columns = array("userid", "paymentstatus", "buyer_email", "firstname", "lastname", "mc_gross", "paymentdate", "datecreation");
                    $Database->insert("payments_log", $variables, $columns);

                    for ($row = 0; $row < count($GLOBALS['donationList']); $row++)
                    {
                        $coins = $values['mc_gross'];
                        if ($coins == $GLOBALS['donationList'][$row][2])
                        {

                            $Database->update("account_data", array("dp" =>"dp +".$GLOBALS['donationList'][$row][1]), array("id" => $values['custom']));
                        }
                    }
                }
                elseif ($GLOBALS['donation']['donationType'] == 2)
                {
                    $coins = ceil($mc_gross);
                    $Database->update("account_data", array("dp"=>"dp +".$values['coins']), array("id"=> $values['custom']));
                }
            }
        }
        else if ($resp == 'INVALID')
        {
            if ($GLOBALS['donation']['donationType'] == 2)
            {
                $variables = array($values['custom'], $values['payment_status'], $values['payment_status'] . " - INVALID FUUUU " . $values['mc_gross'], $values['payer_email'], $values['first_name'], $values['last_name'], $values['mc_gross'], $values['payment_date'], $values['fecha']);
                $columns = array("userid", "paymentstatus", "buyer_email", "firstname", "lastname", "mc_gross", "paymentdate", "datecreation");
                $Database->insert("payments_log", $variables, $columns);
            }

            mail($GLOBALS['donation']['copyTo'], "INVALID Donation", "A payment was invalid. Information is shown below: <br/>
			User ID : " . $values['custom'] . "
			Buyer Email: " . $values['payer_email'] . "
			Amount: " . $values['mc_gross'] . " USD
			Date: " . $values['payment_date'] . "
			First name: " . $values['first_name'] . "
			Last name: " . $values['last_name'] . "
			", "From: " . $GLOBALS['donation']['responseFrom'] . "");

            mail($values['payer_email'], "Hello there. Unfortunately, the latest payment you did was invalid. Please contact us for more information. 
		  
			Best regards.
			The Management");


            $variables = array($values['custom'],$values['payment_status'] . " - INVALID",$values['payer_email'],$values['first_name'],$values['last_name'],$values['mc_gross'],$values['payment_date'],$values['fecha']);
            $columns = array("userid", "paymentstatus", "buyer_email", "firstname", "lastname", "mc_gross", "paymentdate", "datecreation");
            $Database->insert("payments_log", $variables, $columns);
        }
    }

    fclose($fp);
    
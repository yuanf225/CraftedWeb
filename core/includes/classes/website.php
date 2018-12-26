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

########################
## Scripts containing website functions will be added here. News for example.
#######################

    class Website
    {

        public function getNews()
        {
            
            global $Cache, $Database, $Website;
            $conn = $Database->database();

            if ( DATA['website']['news']['enable'] == TRUE )
            {
                echo "<div class='box_two_title'>Latest News</div>";

                if ($Cache->exists("news") == TRUE)
                {
                    $Cache->loadCache("news");
                }
                else
                {
                    $Database->selectDB("webdb", $conn);

                    $result = $Database->select("news", null, null, null, "ORDER BY id DESC LIMIT ". DATA['website']['news']['max_shown'])->get_result();

                    if ($result->num_rows == 0)
                    {
                        echo "No News Were Found.";
                    }
                    else
                    {
                        $output = null;
                        while ($row = $result->fetch_assoc())
                        {
                            if (file_exists($row['image']))
                            {
                                echo $newsPT1 = "
						       <table class='news' width='100%'>
							        <tr>
									    <td>
                                            <h3 class='yellow_text'>". 
                                                $row['title'] 
                                            ."</h3>
                                        </td>
								    </tr>
							   </table>

	                           <table class='news_content' cellpadding='4'> 
							       <tr>
							          <td><img src='". $row['image'] ."' alt=''/></td> 
							          <td>";
                            }
                            else
                            {
                                echo $newsPT1 = "
						       <table class='news' width='100%'> 
							        <tr>
									    <td>
                                            <h3 class='yellow_text'>". 
                                                $row['title'] 
                                            ."</h3>
                                        </td>
								    </tr>
							   </table>";
                            }
                            $output .= $newsPT1;
                            unset($newsPT1);

                            if (file_exists("core/includes/classes/validator.php"))
                            {
                                include "core/includes/classes/validator.php";

                                $Validator = new Validator(array(), array($row['body']), array($row['body']));
                                $sanatized_text = $Validator->sanatize($row['body'], "string");

                                if ( DATA['website']['news']['limit_home_characters'] == TRUE )
                                {
                                    echo $Website->limit_characters($sanatized_text, 200);
                                    $output .= $Website->limit_characters($row['body'], 200);
                                }
                                else
                                {
                                    echo nl2br("<br>".$sanatized_text);
                                    $output .= nl2br($row['body']);
                                }

                                $result = $Database->select("news_comments", "COUNT(id)", null, "newsid=". $row['id'])->get_result();
                                $commentsNum = $result->fetch_row();

                                if ( DATA['website']['news']['enable_comments'] == true )
                                {
                                    $comments = '| <a href="?page=news&amp;newsid=' . $row['id'] . '">Comments ('. $commentsNum[0] .')</a>';
                                }
                                else
                                {
                                    $comments = "";
                                }

                                echo $newsPT2 = "<br/><br/><br/>
                                    <i class='gray_text'>Written by ". $row['author'] ." | ". $row['date'] ." ". $comments ."</i>
                                    </td> 
                                    </tr>
                                    </table";
                                $output  .= $newsPT2;
                                unset($newsPT2);
                            }
                        }
                        echo "<br><hr/><a href='?page=news'>View older news...</a>";
                        $Cache->buildCache("news", $output);
                    }
                }
            }

        }

        public function getSlideShowImages()
        {
            global $Cache, $Database;
            $conn = $Database->database();

            if ($Cache->exists("slideshow") == TRUE)
            {
                $Cache->loadCache("slideshow");
            }
            else
            {
                $Database->selectDB("webdb", $conn);
                $result = $Database->select("slider_images", "path,link", null, null, "ORDER BY position ASC")->get_result();
                while ($row = $result->fetch_assoc())
                {
                    echo $outPutPT = '<a href="'. htmlspecialchars($row['link']) .'"><img border="none" src="core/'. htmlspecialchars($row['path']) .'" alt="" class="slideshow_image"></a>';
                    $output   .= $outPutPT;
                }
                $Cache->buildCache('slideshow', $output);
            }
        }

        public function getSlideShowImageNumbers()
        {
            global $Database;
            $conn = $Database->database();
            $Database->selectDB("webdb", $conn);

            $result = $Database->select( `position` FROM slider_images ORDER BY position ASC;");
            $x      = 1;

            while ($row = $result->fetch_assoc())
            {
                echo '<a href="#" rel="'. htmlspecialchars($x) .'">'. htmlspecialchars($x) .'</a>';
                $x++;
            }
            
            unset($x);
        }

        public function limit_characters($str, $n)
        {
            $str = preg_replace("/<img[^>]+\>/i", "(image)", $str);

            if (strlen($str) <= $n)
            {
                return $str;
            }
            else
            {
                return substr($str, 0, $n) . '...';
            }
        }

        public function loadVotingLinks()
        {
            global $Database, $Account, $Website;
            $conn = $Database->database();
            $Database->selectDB("webdb", $conn);

            $result = $Database->select("votingsites", null, null, null, "ORDER BY id DESC")->get_result();

            if ($result->num_rows == 0)
            {
                buildError("Couldnt Fetch Any Voting Links From The Database. ". $Database->conn->error);
            }
            else
            {
                while ($row = $result->fetch_assoc())
                { ?>
                    <div class="votelink">
                        <table width="100%">
                            <tr>
                                <td width="20%"><img src="<?php echo $row['image']; ?>" /></td>
                                <td width="50%"><strong><?php echo $row['title']; ?></strong> (<?php echo $row['points']; ?> Vote Points)<td>
                                <td width="40%">
                                    <?php
                                    if ($Website->checkIfVoted($row['id']) == false)
                                    { 
                                        ?><input type='submit' value='Vote'  onclick="vote('<?php echo $row['id']; ?>', this)"><?php
                                    }
                                    else
                                    {
                                        $getNext = $Database->select(DATA['website']['connection']['name'].".votelog", "next_vote", null, " WHERE userid=". $Account->getAccountID($_SESSION['cw_user']) ." AND siteid=". $row['id'] ." ORDER BY id DESC LIMIT 1;")->get_result();

                                        $row  = $getNext->fetch_assoc();
                                        $time = $row['next_vote'] - time();

                                        if (gmp_sign($time) == -1)
                                        {
                                            $time = 43200;
                                        }

                                        echo "Time until reset: ". convTime($time);
                                    }
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div><?php
                }
            }
        }

        public function checkIfVoted($siteid)
        {
            global $Account, $Database;
            $conn = $Database->database();

            $siteId  = $Database->conn->escape_string($siteid);

            $acct_id = $Account->getAccountID($_SESSION['cw_user']);
            $Database->selectDB("webdb", $conn);

            $result = $Database->select("votelog", "COUNT(id) AS voted", null, "userid=". $acct_id ." AND siteid=". $siteId ." AND next_vote > ". time())->get_result();

            if ($result->fetch_assoc()['voted'] == 0)
            {
                return false;
            }
            else
            {
                return TRUE;
            }
        }

        public function sendEmail($to, $from, $subject, $body)
        {
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
            $headers .= 'From: ' . $from . "\r\n";

            mail($to, $subject, $body, $headers);
        }

        public function convertCurrency($currency)
        {
            if ($currency == "dp") return DATA['website']['donation']['coins_name'];
            elseif ($currency == "vp") return "Vote Points";
        }

    }
    $Website = new Website();
    
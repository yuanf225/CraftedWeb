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
if ( !isset($_SESSION['cw_user']) )
{ ?>
    <h4>Account Management</h4><?php
    if ( isset($_POST['login']) )
    {
        global $Account;
        $Account->logIn($_POST['login_username'], $_POST['login_password'], $_SERVER['REQUEST_URI'], $_POST['login_remember']);
    }
    ?><form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <input class="form-control" type="text" placeholder="Username..." name="login_username" /><br/>
        </div>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <input class="form-control" type="password" placeholder="Password..." name="login_password" /><br/>
        </div>
        <div class="form-group">
            <input class="form-control btn btn-default" type="submit" value="Log In" name="login" /> 
        </div>
        <div class="form-group">
            <label><input type="checkbox" name="login_remember" checked="checked"/> Remember me</label>
        </div>
        <small><a href="?page=register">Create an account</a></small><br>
        <small><a href="?page=forgotpw">Forgot your Password?</a></small>
    </form><?php
} ?>

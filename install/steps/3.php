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
<p id="steps" class="text-center">Introduction &raquo; MySQL Info &raquo; Configure &raquo; <b>Database</b> &raquo; Realm Info &raquo; Finished<p>
<hr>

<h3>
	Now is the time to actually create something. The script will now:<br>
	<small>
		- Create the Website Database if it does not exist<br>
		- Create all tables in the Website Database<br>
		- Insert default data into the Website Database<br>
		- Write the configuration file
	</small><br><br>
	To prevent any database errors, please make sure that the MySQL user your specified has access to the following commands:<br>
	<small>
		- INSERT<br>
		- INSERT IGNORE<br>
		- UPDATE<br>
		- ALTER<br>
		- DELETE<br>
		- DROP<br>
		- CREATE
	</small><br><br>
	You may remove some of these after the installation proccess has finished as they are not needed when running the CMS.
</h3>
<div class="text-center">
	<div id="info"></div>
	<input type="submit" class="btn btn-default" value="Start the proccess!" onclick="step3()">
</div>
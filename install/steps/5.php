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
<p id="steps" class="text-center">Introduction &raquo; MySQL Info &raquo; Configure &raquo; Database &raquo; <b>Realm Info</b> &raquo; Finished<p>

<hr>

<table style="margin: 0 auto;" class="text-center">
	<tr>
		<td>
			<label>Realm Name:</label>
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Default: Sample Realm" id="realm_name" required>
			</div>
		</td>

		<td>
			<label>Administrator Username:</label>
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Default: admin" id="realm_access_username" required>
			</div>
		</td> 

		<td>
			<label>Administrator Password:</label>
			<div class="form-group">
				<input type="password" class="form-control" placeholder="Default: adminpass" id="realm_access_password" required>
			</div>
		</td>
	</tr>

	<tr>
		<td>
			<label>Description:</label>
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Default: Blizzlike 1x" id="realm_description" required>
			</div>
		</td>

		<td>
			<div class="form-group">
				<label>Remote Console:</label>
				<select class="form-control" id="realm_sendtype">
					<option value="none" selected></option>
					<option value="RA">RA</option>
					<option value="SOAP">SOAP</option>
				</select>
			</div>
		</td>

		<td id="realm_ra">
			<label>RA Port:</label>
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Default: 3443" id="realm_ra_port" required>
			</div>
		</td>

		<td id="realm_soap">
			<label>SOAP Port:</label>
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Default: 7878" id="realm_soap_port">
			</div>
		</td>
	</tr>

	<tr>
		<td colspan="8"><hr></td>
	</tr>

	<tr>
		<td colspan="4">
			<div id="info"></div>
		</td>
	</tr>

	<tr>
		<td colspan="4">
			<div style="margin: 0 auto;">
				<input type="submit" class="btn btn-default" value="Finished" onclick="step5()">
			</div>
		</td>
	</tr>
</table>
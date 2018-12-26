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

<p id="steps" class="text-center">Introduction &raquo; <b>MySQL Info</b> &raquo; Configure &raquo; Database &raquo; Realm Info &raquo; Finished</p>
<hr/>
<h4>
	Select the Checkbox if your auth and/or world server database is not in the same database as your website.<br>
	Default means that you can leave the field blank and it will be given the value infront of the word "Default", E.g: "Default: root".<br>
</h4>
<hr/>
<table>
	<tr>
		<td>
			<div class="checkbox">
				<label><input type="checkbox" disabled checked></label>
			</div>
		</td>

		<td>
			<label for="website_host">Website Host:</label>
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Default: 127.0.0.1" id="website_host">
			</div>
		</td>        

		<td>
			<label>Website Port:</label>
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Default: 3306" id="website_port">
			</div>
		</td>

		<td>
			<label>Website User:</label>
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Default: root" id="website_user">
			</div>
		</td>

		<td>
			<label>Website Password:</label>
			<div class="form-group">
				<input type="password" class="form-control" placeholder="Default: `blank`" id="website_password">
			</div>
		</td>
	</tr>


	<tr>
		<td>
			<div class="checkbox">
				<label><input id="checkbox_logon" type="checkbox"></label>
			</div>
		</td>

		<td>
			<label>Logon Host:</label>
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Default: 127.0.0.1" id="logon_host" disabled>
			</div>
		</td>

		<td>
			<label>Logon Port:</label>
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Default: 3306" id="logon_port" disabled>
			</div>
		</td>

		<td>
			<label>Logon User:</label>
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Default: root" id="logon_user" disabled>
			</div>
		</td>

		<td>
			<label>Logon Password:</label>
			<div class="form-group">
				<input type="password" class="form-control" id="logon_password" placeholder="Default: `blank`" id="logon_password" disabled>
			</div>
		</td>
	</tr>

	<tr>
		<td>
			<div class="checkbox">
				<label><input id="checkbox_characters" type="checkbox"></label>
			</div>
		</td>

		<td>
			<label>Characters Host:</label>
			<div class="form-group">
				<input type="text" class="form-control"  placeholder="Default: 127.0.0.1" id="characters_host" disabled>
			</div>
		</td>

		<td>
			<label>Characters Port:</label>
			<div class="form-group">
				<input type="text" class="form-control"  placeholder="Default: 3306" id="characters_port" disabled>
			</div>
		</td>

		<td>
			<label>Characters User:</label>
			<div class="form-group">
				<input type="text" class="form-control"  placeholder="Default: root" id="characters_user" disabled>
			</div>
		</td>

		<td>
			<label>Characters Password:</label>
			<div class="form-group">
				<input type="password" class="form-control" placeholder="Default: `blank`" id="characters_password" disabled>
			</div>
		</td>
	</tr>

	<tr>
		<td>
			<div class="checkbox">
				<label><input id="checkbox_world" type="checkbox"></label>
			</div>
		</td>

		<td>
			<label>World Host:</label>
			<div class="form-group">
				<input type="text" class="form-control"  placeholder="Default: 127.0.0.1" id="world_host" disabled>
			</div>
		</td>

		<td>
			<label>World Port:</label>
			<div class="form-group">
				<input type="text" class="form-control"  placeholder="Default: 3306" id="world_port" disabled>
			</div>
		</td>

		<td>
			<label>World User:</label>
			<div class="form-group">
				<input type="text" class="form-control"  placeholder="Default: root" id="world_user" disabled>
			</div>
		</td>

		<td>
			<label>World Password:</label>
			<div class="form-group">
				<input type="password" class="form-control" placeholder="Default: `blank`" id="world_password" disabled>
			</div>
		</td>
	</tr>


	<tr><td colspan="8"> <hr> </td></tr>

	<tr>
		<td>
			<label>Realmlist:</label>
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Default: logon.yourserver.com" id="realmlist" required>
			</div>
		</td>

		<td>
			<label>Website Domain:</label>
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Default: http://yourserver.com" id="domain" required>
			</div>
		</td>

		<td>
			<label>Website Title:</label>
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Default: YourServer" id="title" required>
			</div>
		</td>

		<td>
			<div class="form-group">
				<label for="expansion">Core Expansion:</label>
				<select class="form-control" id="expansion">
					<option value="0">Vanilla (No expansion)</option>
					<option value="1">The Burning Crusade</option>
					<option value="2" selected>Wrath of the Lich King (TrinityCore)</option>
					<option value="3">Cataclysm (SkyfireEMU)</option>
					<option value="4">Mists of Pandaria</option>
					<option value="5">Legion</option>
				</select>
			</div>
		</td>

		<td>
			<label>PayPal Email:</label>
			<div class="form-group">
				<input type="email" class="form-control" placeholder="Default: youremail@gmail.com" id="paypal" required>
			</div>
		</td>
	</tr>

	<tr>
		<td>
			<label>Website Database:</label>
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Default: craftedcms" id="website_database" required>
			</div>
		</td>

		<td>
			<label>Logon Database:</label>
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Default: auth" id="logon_database" required>
			</div>
		</td>

		<td>
			<label>Characters Database:</label>
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Default: characters" id="characters_database" required>
			</div>
		</td>

		<td>
			<label>World Database:</label>
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Default: world" id="world_database" required>
			</div>
		</td>

		<td>
			<label>Default Email:</label>
			<div class="form-group">
				<input type="email" class="form-control" placeholder="Default: noreply@yourserver.com" id="email" required>
			</div>
		</td>
	</tr>

	<tr><td colspan="5"><hr></td></tr>

	<tr>
		<td colspan="5">
			<div class="form-group" id="info"></div>
		</td>
	</tr>

	<tr>
		<td colspan="5">
			<input type="submit" class="btn btn-default" value="Procceed to Step 2" onclick="step1()">
		</td>
	</tr>

</table>
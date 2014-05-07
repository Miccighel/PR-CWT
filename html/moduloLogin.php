<?php
include '../settings/configurazione.inc';
include HOME_ROOT . '/html/testa.php';
?>

<form id="formLogin" method="post" action="../script/scriptControlloLoginAdmin.php">
    <fieldset><legend>Login</legend>
		<div class="label"><label >Username</label></div>
		<input type="text" name="username" class="obbligatorio" /><br />
        <div class="label"><label >Password</label></div>
		<input type="password" name="password" class="obbligatorio" /><br />
		<br /><input type="submit" class="invia" value="Conferma"></input>
	</fieldset>
</form>

<script type="text/javascript">
    gestisciForm('#formLogin', '../script/scriptControlloLoginAdmin.php', '#coldx');
</script>

<?php include HOME_ROOT.'/html/coda.html';?>



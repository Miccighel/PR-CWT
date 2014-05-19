<?php
include '../settings/configurazione.inc';
include HOME_ROOT . '/html/testa.php';
include HOME_ROOT . '/script/funzioni.php';

$connessione = creaConnessione(SERVER, UTENTE, PASSWORD, DATABASE);

for($i = 0; $i < count($_POST['user']); $i++) {
	$query = sprintf("UPDATE tblutenti SET dirittoAmministratore='%s' WHERE user='%s'", $_POST['dirittoAmministratore'][$i], $_POST['user'][$i]);
	$dati = eseguiQuery($connessione, $query);
}

print '<p class="successo">La modifica dei diritti da amministratore &grave; avvenuta correttamente</p>';

chiudiConnessione($connessione);

include HOME_ROOT . '/html/coda.html';
?>
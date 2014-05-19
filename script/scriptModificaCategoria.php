<?php
include '../settings/configurazione.inc';
include HOME_ROOT . '/script/funzioni.php';

$connessione = creaConnessione(SERVER, UTENTE, PASSWORD, DATABASE);
$query = sprintf("UPDATE tblcategorie SET nome='%s' WHERE nome='%s'", $_POST['nome'], $_POST['nomeOld']);
$dati = eseguiQuery($connessione, $query);

chiudiConnessione($connessione);

print '<p class="successo">La modifica della categoria &egrave; avvenuta correttamente</p>';

?>
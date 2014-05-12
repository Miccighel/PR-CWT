<?php
include '../settings/configurazione.inc';
include HOME_ROOT . '/script/funzioni.php';

$connessione = creaConnessione(SERVER, UTENTE, PASSWORD, DATABASE);
$query = sprintf("UPDATE tblUtenti SET codicefiscale='%s', nome='%s', cognome='%s', datanascita='%s', indirizzo='%s', email='%s', telefono='%s', user='%s', psw='%s' WHERE codicefiscale='%s'", strtoupper($_POST['codicefiscale']), $_POST['nome'], $_POST['cognome'], $_POST['datanascita'], $_POST['indirizzo'], $_POST['email'], $_POST['telefono'], $_POST['username'], sha1($_POST['password']),$_POST['oldcodicefiscale']);
$dati = eseguiQuery($connessione, $query);

chiudiConnessione($connessione);

session_destroy();

print '<script type="text/javascript">';
print "$(window.location).attr('href', '../index.php');";
print '</script>';

?>

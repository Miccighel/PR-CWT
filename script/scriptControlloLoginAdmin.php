<?php
include '../settings/configurazione.inc';
include HOME_ROOT . '/script/funzioni.php';

$connessione = creaConnessione(SERVER, UTENTE, PASSWORD, DATABASE);
$query = sprintf("SELECT user, psw, dirittoamministratore FROM tblutenti WHERE user=" . "'" . $_POST['username'] . "'" . " AND " . "psw=" . "'" . sha1($_POST['password']) . "'");
$dati = eseguiQuery($connessione, $query);

if ($dati == null) {
    print '<p class="errore">Alcuni dei tuoi dati sono errati, riprova</p>';
} else {
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['password'] = $_POST['password'];
    if ($dati[0]["dirittoamministratore"] == "si") {
        $_SESSION['amministratore'] = true;
    } else {
        $_SESSION['amministratore'] = false;
    }
    $_SESSION['utenteautorizzato'] = true;
    $_SESSION['collegato'] = true;
    print '<script type="text/javascript">';
    print "$(window.location).attr('href', '../index.php');";
    print '</script>';
}

chiudiConnessione($connessione);

?>

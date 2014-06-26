<?php
include '../settings/configurazione.inc';
include HOME_ROOT . '/script/funzioni.php';

if($_SERVER['REQUEST_METHOD'] != 'GET'){

    $connessione = creaConnessione(SERVER, UTENTE, PASSWORD, DATABASE);
    $query = sprintf("UPDATE tblutenti SET codicefiscale='%s', nome='%s', cognome='%s', datanascita='%s',citta='%s', indirizzo='%s', email='%s', telefono='%s', user='%s', psw='%s' WHERE codicefiscale='%s'", rendiSicuro($connessione,strtoupper($_POST['codicefiscale'])), rendiSicuro($connessione,$_POST['nome']), rendiSicuro($connessione,$_POST['cognome']), $_POST['datanascita'],rendiSicuro($connessione,$_POST['citta']), rendiSicuro($connessione,$_POST['indirizzo']), rendiSicuro($connessione,$_POST['email']), rendiSicuro($connessione,$_POST['telefono']), rendiSicuro($connessione,$_POST['username']), rendiSicuro($connessione,sha1($_POST['password'])),$_POST['oldcodicefiscale']);
    $dati = eseguiQuery($connessione, $query);

    chiudiConnessione($connessione);

// Aggiornata la tabella, la sessione verrà distrutta e l'utente dovrà ricollegarsi al sito
    session_destroy();

    print '<script type="text/javascript">';
    print "$(window.location).attr('href', '../index.php');";
    print '</script>';

} else {
    include HOME_ROOT . '/html/testa.php';
    print '<p class="errore">Attenzione, non puoi accedere direttamente a questa pagina</p>';
    include HOME_ROOT . '/html/coda.html';
}
?>

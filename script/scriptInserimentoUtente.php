<?php
include '../settings/configurazione.inc';
include HOME_ROOT . '/script/funzioni.php';

if($_SERVER['REQUEST_METHOD'] != 'GET'){

    $connessione = creaConnessione(SERVER, UTENTE, PASSWORD, DATABASE);
    $query = sprintf("INSERT INTO tblUtenti(codicefiscale, nome, cognome, datanascita, citta, indirizzo, email, telefono, user, psw, dirittoamministratore) VALUE ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')", rendiSicuro($connessione,strtoupper($_POST['codicefiscale'])), rendiSicuro($connessione,$_POST['nome']), rendiSicuro($connessione,$_POST['cognome']), $_POST['datanascita'],rendiSicuro($connessione,$_POST['citta']), rendiSicuro($connessione,$_POST['indirizzo']), rendiSicuro($connessione,$_POST['email']), rendiSicuro($connessione,$_POST['telefono']), rendiSicuro($connessione,$_POST['username']), rendiSicuro($connessione,sha1($_POST['password'])), "no");
    $dati = eseguiQuery($connessione, $query);
    chiudiConnessione($connessione);

    print '<p class="successo">' . "L'inserimento dell'utente &egrave; avvenuto correttamente</p>";

} else {
    include HOME_ROOT . '/html/testa.php';
    print '<p class="errore">Attenzione, non puoi accedere direttamente a questa pagina</p>';
    include HOME_ROOT . '/html/coda.html';
}
?>
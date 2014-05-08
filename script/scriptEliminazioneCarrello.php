<?php
include '../settings/configurazione.inc';
include HOME_ROOT . '/script/funzioni.php';

$connessione = creaConnessione(SERVER, UTENTE, PASSWORD, DATABASE);

$utente = $_SESSION['username'];
$quantitaEliminazione = $_POST['quantitaEliminazione'];
$codiceEliminazione = $_POST['codiceEliminazione'];

$query = sprintf("SELECT u.codicefiscale, c.codiceprodotto, c.quantita
             FROM tblutenti AS u JOIN tblcarrelli AS c ON u.codicefiscale = c.codiceutente
             WHERE u.user='%s' AND c.codiceprodotto='%s'", $utente, $codiceEliminazione);
$dati = eseguiQuery($connessione, $query);

if ($quantitaEliminazione > $dati[0]['quantita']) {
    print '<p class="errore">Non puoi eliminare dal carrello una quantita maggiore di quella inserita precedentemente</p>';
} else {

    $query = sprintf("SELECT codicefiscale FROM tblutenti WHERE user='%s'", $utente);
    $infoUtente = eseguiQuery($connessione, $query);
    $codiceFiscale = $infoUtente[0]['codicefiscale'];

    $quantitaAggiornata = $dati[0]['quantita'] - $quantitaEliminazione;
    $query = sprintf("UPDATE tblCarrelli SET quantita='%d' WHERE codiceprodotto='%s' AND codiceutente='%s'", $quantitaAggiornata, $codiceEliminazione, $codiceFiscale);
    $dati = eseguiQuery($connessione, $query);

    $query = sprintf("SELECT quantita FROM tblcarrelli WHERE codiceprodotto='%s' AND codiceutente='%s'", $codiceEliminazione, $codiceFiscale);
    $dati = eseguiQuery($connessione, $query);

    if ($dati[0]['quantita'] <= 0) {
        $query = sprintf("DELETE FROM tblcarrelli WHERE codiceutente='%s' AND codiceprodotto='%s'", $codiceFiscale, $codiceEliminazione);
        $dati = eseguiQuery($connessione, $query);
    }
    print '<p class="successo">Aggiornamento del carrello eseguito correttamente</p>';

}
?>

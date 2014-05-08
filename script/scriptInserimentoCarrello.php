<?php
include '../settings/configurazione.inc';
include HOME_ROOT . '/script/funzioni.php';

$connessione = creaConnessione(SERVER, UTENTE, PASSWORD, DATABASE);

$utente = $_SESSION['username'];

$quantitaInserimento = $_POST['quantita'];
$codiceInserimento = $_POST['codiceprodotto'];

$query = sprintf("SELECT numeropezzi FROM tblprodotti WHERE codiceprodotto='%s'", $codiceInserimento);
$dati = eseguiQuery($connessione, $query);

if (($quantitaInserimento > $dati[0]['numeropezzi']) || ($quantitaInserimento <= 0)) {
    print '<p class="errore">Non puoi comprare un numero di prodotti negativo oppure maggiore della quantita disponibile. Riprova.</p>';
} else {
    $query = sprintf("SELECT u.codicefiscale, c.codiceprodotto, c.quantita, p.numeropezzi
             FROM (tblutenti AS u JOIN tblcarrelli AS c ON u.codicefiscale = c.codiceutente)
             JOIN tblprodotti AS p on c.codiceprodotto = p.codiceprodotto
             WHERE u.user='%s' AND c.codiceprodotto='%s'", $_SESSION['username'], $codiceInserimento);

    $dati = eseguiQuery($connessione, $query);


    $query = sprintf("SELECT codicefiscale FROM tblutenti WHERE user='%s'", $utente);
    $infoUtente = eseguiQuery($connessione, $query);
    $codiceFiscale = $infoUtente[0]['codicefiscale'];

    if (!$dati) {
        $query = sprintf("INSERT INTO tblcarrelli(codiceprodotto, codiceutente, quantita) VALUE ('%s','%s','%d')", $codiceInserimento, $codiceFiscale, $quantitaInserimento);
        $dati = eseguiQuery($connessione, $query);
        print '<p class="successo">Inserimento nel carrello avvenuto correttamente</p>';
    } else {
        $quantitaTotale = $dati[0]['quantita'] + $quantitaInserimento;
        if ($quantitaTotale > $dati[0]['numeropezzi']) {
            print '<p class="errore">Attenzione, non puoi inserire una quantit&agrave di prodotto maggiore di quella in magazzino!</p>';
        } else {
            $query = sprintf("UPDATE tblcarrelli SET quantita='%d' WHERE codiceprodotto='%s' AND codiceutente ='%s'", $quantitaTotale, $codiceInserimento, $codiceFiscale);
            $dati = eseguiQuery($connessione, $query);
            print '<p class="successo">Aggiornamento del carrello avvenuto correttamente</p>';
        }
    }
}

chiudiConnessione($connessione);

?>
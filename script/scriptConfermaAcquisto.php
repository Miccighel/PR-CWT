<?php
include '../settings/configurazione.inc';
include HOME_ROOT . '/script/funzioni.php';

$connessione = creaConnessione(SERVER,UTENTE,PASSWORD,DATABASE);

$query = sprintf("SELECT codicefiscale FROM tblUtenti WHERE user='".$_SESSION['username']."'");
$dati = eseguiQuery($connessione,$query);
$codiceFiscale = $dati[0]['codicefiscale'];

$connessione = creaConnessione(SERVER,UTENTE,PASSWORD,DATABASE);
$query = sprintf("SELECT p.codiceprodotto, p.nomeprodotto, c.quantita, p.prezzo FROM tblcarrelli AS c JOIN tblprodotti AS p ON c.codiceprodotto = p.codiceprodotto WHERE c.codiceutente='%s'",$codiceFiscale);
$dati = eseguiQuery($connessione, $query);

foreach ($dati as $prodotto) {
    $query = sprintf("SELECT numeropezzi FROM tblprodotti WHERE codiceprodotto='%s'",$prodotto['codiceprodotto']);
    $infoPezzi = eseguiQuery($connessione,$query);
    $quantitàAggiornata = $infoPezzi[0]['numeropezzi'] - $prodotto['quantita'];
    $query = sprintf("UPDATE tblprodotti SET numeropezzi='%d' WHERE codiceprodotto='%s'",$quantitàAggiornata,$prodotto['codiceprodotto']);
    $dati = eseguiQuery($connessione,$query);
}

$query = sprintf("DELETE FROM tblcarrelli WHERE codiceutente='%s'",$codiceFiscale);
eseguiQuery($connessione, $query);

chiudiConnessione($connessione);

print '<p class="successo">L\'acquisto &egrave stato completato con successo</p>';
?>

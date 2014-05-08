<?php
include '../settings/configurazione.inc';
include HOME_ROOT . '/html/testa.php';
include HOME_ROOT . '/script/funzioni.php';

$connessione = creaConnessione(SERVER, UTENTE, PASSWORD, DATABASE);

$query = sprintf("SELECT u.codicefiscale, c.codiceprodotto, c.quantita, p.nomeprodotto, p.prezzo,
p.immagine, p.categoria, pc.console FROM ((tblutenti AS u JOIN tblcarrelli AS c
ON u.codicefiscale = c.codiceutente) JOIN tblprodotti AS p on c.codiceprodotto = p.codiceprodotto)
JOIN tblprodotticonsole AS pc ON p.codiceprodotto = pc.codiceprodotto WHERE u.user='%s'", $_SESSION['username']);

$dati = eseguiQuery($connessione, $query);

foreach ($dati as $tupla) {
    print '<div id="corpoCatalogo">' .
        '<div id="catcolsx"><img src="' . HOME_WEB . 'img/thumb/' . $tupla['immagine'] . '" height="165px" width="140px"></img>' . '</div>' .
        '<div id="catcoldx"> <p><b>Codice Prodotto: </b>' . $tupla['codiceprodotto'] . '</p>' .
        '<p><b>Nome Prodotto: </b>' . $tupla['nomeprodotto'] . '</p>' .
        '<p><b>Prezzo: </b>' . $tupla['prezzo'] . ' Euro</p>' .
        '<p><b>Categoria: </b>' . $tupla['categoria'] . '</p>' .
        '<p><b>Console: </b>' . $tupla['console'] . '</p>' .
        '<p><b>Quantita Richiesta: </b>' . $tupla['quantita'] . '</p>';
    print '<form id="' . $tupla['codiceprodotto'] . '" method="post" action="../script/scriptEliminazioneCarrello.php">';
    print '<input type="hidden" name="codiceEliminazione" value="' . $tupla['codiceprodotto'] . "'/>";
    print '<p><img src="../img/style/cart_remove.png"></img></p>';
    print '<p>Quantita di prodotto da eliminare:';
    print '<input type="text" name="quantitaEliminazione"></input>';
    print '<input type="submit" value="Elimina"></input></p>';
    print '</form>';
    print '</div>' . '</div>';
    print '<script type="text/javascript">';
    print "gestisciForm('#" . $tupla['codiceprodotto'] . "','" . '../script/scriptEliminazioneCarrello.php' . "','#coldx');";
    print '</script>';
}
print '<form id="conferma' . $tupla['codiceprodotto'] . '" method="post" action="../script/scriptConfermaAcquisto.php">';
foreach ($dati as $tupla) {
    print '<input type="hidden" name="' . $tupla['codiceprodotto'] . '" value="' . $tupla['codiceprodotto'] . '"/>';
}
print '<input type="submit" id="pulsanteAcquisto" value="Conferma l\'acquisto">';
print '</form>';
print '<script type="text/javascript">';
print "gestisciForm('#conferma" . $tupla['codiceprodotto'] . "','" . '../script/scriptConfermaAcquisto.php' . "','#coldx');";
print '</script>';

chiudiConnessione($connessione);

include HOME_ROOT . '/html/coda.html';
?>
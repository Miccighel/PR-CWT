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

$numeroPagine = ceil(count($dati) / PRODOTTIPERPAGINA);

if (!isset($_GET["pagina"])) {
    $pagina = 1;
} else {
    $pagina = $_GET["pagina"];
}

$i = ($pagina * PRODOTTIPERPAGINA) - (PRODOTTIPERPAGINA);

while ($i < PRODOTTIPERPAGINA * $pagina && $i< count($dati)) {
    print '<div id="corpoCatalogo">' .
        '<div id="catcolsx"><img src="' . HOME_WEB . 'img/thumb/' . $dati[$i]['immagine'] . '" height="165px" width="120px"></img>' . '</div>' .
        '<div id="catcoldx"> <p><b>Codice Prodotto: </b>' . $dati[$i]['codiceprodotto'] . '</p>' .
        '<p><b>Nome Prodotto: </b>' . $dati[$i]['nomeprodotto'] . '</p>' .
        '<p><b>Prezzo: </b>' . $dati[$i]['prezzo'] . ' Euro</p>' .
        '<p><b>Categoria: </b>' . $dati[$i]['categoria'] . '</p>' .
        '<p><b>Console: </b>' . $dati[$i]['console'] . '</p>' .
        '<p><b>Quantita Richiesta: </b>' . $dati[$i]['quantita'] . '</p>';
    print '<form id="' . $dati[$i]['codiceprodotto'] . '" method="post" action="../script/scriptEliminazioneCarrello.php">';
    print '<input type="hidden" name="codiceEliminazione" value="' . $dati[$i]['codiceprodotto'] . '"/>';
    print '<p><b>Quantit&agrave:</b>';
    print '<input type="text" size="3" name="quantitaEliminazione" class="intero" value="0"></input>';
    print '<input type="submit" class="invia" value="Elimina"></input></p>';
    print '</form>';
    print '</div>' . '</div>';
    print '<script type="text/javascript">';
    print "gestisciForm('#" . $dati[$i]['codiceprodotto'] . "','" . '../script/scriptEliminazioneCarrello.php' . "','#coldx');";
    print '</script>';
    $i++;
}

print '<form id="confermaAcquisto" method="post" action="moduloVisualizzazioneFattura.php">';
print '<input type="hidden" name="codicefiscale" value="'.$dati[0]['codicefiscale'].'"/>';
print '<input type="submit" id="pulsanteAcquisto" value="Conferma l\'acquisto">';
print '</form>';

visualizzaPaginazione($pagina,$numeroPagine,'Carrello');

print '<script type="text/javascript">';
print "gestisciForm('#confermaAcquisto','" . 'moduloVisualizzazioneFattura.php' . "','#coldx');";
print '</script>';

chiudiConnessione($connessione);

include HOME_ROOT . '/html/coda.html';
?>
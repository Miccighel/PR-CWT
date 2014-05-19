<?php
include '../settings/configurazione.inc';
include HOME_ROOT . '/html/testa.php';
include HOME_ROOT . '/script/funzioni.php';

$connessione = creaConnessione(SERVER, UTENTE, PASSWORD, DATABASE);

//Se l'indice è -1 indica che viene caricata una singola immagine.
$indice = -1;

if(gestioneImmagine($indice,'')){
	generaThumbnail($_FILES['immagine']['tmp_name'],'/img/thumb',200,268,$indice);
}

$query = sprintf("SELECT galleria, immagine FROM tblprodotti WHERE codiceprodotto='%s'", $_POST['codiceprodotto']);
$dati = eseguiQuery($connessione, $query);
$galleriaOld = $dati[0]['galleria'];

if (HOME_ROOT . '/' . 'img' . '/' . $dati[0]['galleria'] != HOME_ROOT . '/' . 'img' . '/' . $_POST['galleria']) {
	if (rename(HOME_ROOT . '/' . 'img' . '/' . $dati[0]['galleria'], HOME_ROOT . '/' . 'img' . '/' . $_POST['galleria'])) {
        if(is_dir(HOME_ROOT . '/' . 'img/thumb' . '/' . $dati[0]['galleria'])) {
            rename(HOME_ROOT . '/' . 'img/thumb' . '/' . $dati[0]['galleria'], HOME_ROOT . '/' . 'img/thumb' . '/' . $_POST['galleria']);
            print '<p class="successo">' . "La cartella della galleria contenente le thumbnail &egrave; stata rinominata con successo</p>";
        }
    	print '<p class="successo">' . "La cartella della galleria &egrave; stata rinominata con successo</p>";
	} else {
    	print '<p class="informazione">' . "La cartella della galleria non &egrave; stata rinominata</p>";
	}
}

var_dump($dati[0]['immagine']);

if (HOME_ROOT . '/' . 'img' . '/' . $dati[0]['immagine'] != HOME_ROOT . '/' . 'img' . '/' . $_FILES['immagine']['name']) {
    unlink(HOME_ROOT . '/' . 'img' . '/' . $dati[0]['immagine']);
    unlink(HOME_ROOT . '/' . 'img' . '/thumb/' . $dati[0]['immagine']);
    print '<p class="successo">' . "L\'immagine principale &egrave; stata aggiornata con successo</p>";
}

$query = sprintf("UPDATE tblprodotti SET nomeprodotto='%s', descrizione='%s', prezzo='%d', numeropezzi='%d', immagine='%s',galleria='%s',categoria='%s' WHERE codiceprodotto='%s'", $_POST['nomeprodotto'], $_POST['descrizione'], $_POST['prezzo'], $_POST['numeropezzi'], $_FILES['immagine']['name'], $_POST['galleria'], $_POST['categoria'], $_POST['codiceprodotto']);
$dati = eseguiQuery($connessione, $query);

$query = sprintf("UPDATE tblprodotti SET galleria='%s' WHERE galleria='%s'", $_POST['galleria'], $galleriaOld);
$dati = eseguiQuery($connessione, $query);

print '<p class="successo">La modifica del prodotto &egrave; avvenuta correttamente</p>';

chiudiConnessione($connessione);

include HOME_ROOT . '/html/coda.html';
?>
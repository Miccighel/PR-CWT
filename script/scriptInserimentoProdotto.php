<?php
include '../settings/configurazione.inc';
include HOME_ROOT . '/script/funzioni.php';
include HOME_ROOT . '/html/testa.php';

if($_SERVER['REQUEST_METHOD'] != 'GET'){

    $connessione = creaConnessione(SERVER, UTENTE, PASSWORD, DATABASE);
    $percorsoCartella = '../img/' . trim($_POST['galleria']);

    //Se l'indice è -1 indica che viene caricata una singola immagine.
    $indice = -1;

    gestioneImmagine($indice,'');
    generaThumbnail($_FILES['immagine']['tmp_name'],'/img/thumb',200,268,$indice);

    $query = sprintf("INSERT INTO tblprodotti(codiceprodotto, nomeprodotto, descrizione, prezzo, numeropezzi, immagine, galleria, categoria) VALUE ('%s','%s','%s','%d','%d','%s','%s','%s')", rendiSicuro($connessione,strtoupper(trim($_POST['codiceprodotto']))), rendiSicuro($connessione,$_POST['nomeprodotto']), rendiSicuro($connessione,$_POST['descrizione']), rendiSicuro($connessione,$_POST['prezzo']), rendiSicuro($connessione,$_POST['numeropezzi']), rendiSicuro($connessione,$_FILES['immagine']['name']), rendiSicuro($connessione,trim($_POST['galleria'])), rendiSicuro($connessione,$_POST['categoria']));
    $dati = eseguiQuery($connessione, $query);

    $query = sprintf("INSERT INTO tblprodotticonsole(codiceprodotto, console) VALUE ('%s','%s')", rendiSicuro($connessione,$_POST['codiceprodotto']), rendiSicuro($connessione,$_POST['console']));
    $dati = eseguiQuery($connessione, $query);

    if(!file_exists($percorsoCartella)){
        mkdir($percorsoCartella);
        print '<p class="successo">'."La creazione della cartella &egrave; avvenuta con successo</p>";
    } else {
        print '<p class="informazione">'."La cartella &egrave; gi&agrave; esistente</p>";
    }

    print '<p class="successo">'."L'inserimento del prodotto &egrave; avvenuto con successo</p>";

    chiudiConnessione($connessione);

} else {
    print '<p class="errore">Attenzione, non puoi accedere direttamente a questa pagina</p>';
}

include HOME_ROOT . '/html/coda.html';
?>
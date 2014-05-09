<?php
include '../settings/configurazione.inc';
include HOME_ROOT . '/script/funzioni.php';

if (isset($_SESSION['collegato'])) {
    if ($_SESSION['amministratore'] == true) {
        $connessione = creaConnessione(SERVER, UTENTE, PASSWORD, DATABASE);

        $query = sprintf("DELETE FROM tblcarrelli WHERE codiceprodotto='%s'", $_POST['codiceprodotto']);
        $dati = eseguiQuery($connessione, $query);

        $query = sprintf("DELETE FROM tblprodotticonsole WHERE codiceprodotto='%s'", $_POST['codiceprodotto']);
        $dati = eseguiQuery($connessione, $query);

        $query = sprintf("SELECT galleria, immagine FROM tblprodotti WHERE codiceprodotto='%s'", $_POST['codiceprodotto']);
        $dati = eseguiQuery($connessione, $query);

        $query = sprintf("SELECT COUNT(galleria) FROM tblprodotti WHERE galleria ='%s'", $dati[0]['galleria']);
        $numeroVersioni = eseguiQuery($connessione, $query);

        if (intval($numeroVersioni[0]['COUNT(galleria)'] > 1)) {
            print '<p class="informazione">Poichè ci sono più versioni dello stesso gioco, la corrispondente galleria non è stata cancellata.</p>';
        } else {
            if (cancellaCartella('../img/' . $dati[0]['galleria'])) {
                print '<p class="successo">La cartella contenente le immagini è stata cancellata con successo</p>';
            } else {
                print '<p class="errore">La cartella contenente le immagini non esiste</p>';
            }

            if (cancellaCartella('../img/thumb/' . $dati[0]['galleria'])) {
                print '<p class="successo">La cartella contenente le thumbnails è stata cancellata con successo</p>';
            } else {
                print '<p class="errore">La cartella contenente le thumbnails non esiste</p>';
            }
        }

        if (cancellaImmagine('../img/' . $dati[0]['immagine'])) {
            print '<p class="successo">L\'immagine principale è stata cancellata con successo</p>';
        } else {
            print '<p class="errore">L\'immagine principale non esiste</p>';
        }

        if (cancellaImmagine('../img/thumb/' . $dati[0]['immagine'])) {
            print '<p class="successo">La thumbnail dell\'immagine principale è stata cancellata con successo</p>';
        } else {
            print '<p class="errore">La thumbnail dell\'immagine principale non esiste</p>';
        }

        $query = sprintf("DELETE FROM tblprodotti WHERE codiceprodotto='%s'", $_POST['codiceprodotto']);
        $dati = eseguiQuery($connessione, $query);

        print '<p class="successo">Il prodotto è stato eliminato con successo</p>';
        chiudiConnessione($connessione);
    } else {
        print 'Non sei autorizzato a visualizzare questa pagina, per favore, esegui il login';
    }
} else {
    print 'Non sei autorizzato a visualizzare questa pagina, per favore, esegui il login';
}

?>
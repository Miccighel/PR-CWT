<?php
include '../settings/configurazione.inc';
include HOME_ROOT . '/script/funzioni.php';

if (isset($_SESSION['collegato'])) {
    if ($_SESSION['amministratore'] == true) {
        $connessione = creaConnessione(SERVER, UTENTE, PASSWORD, DATABASE);
        $query = sprintf("SELECT galleria FROM tblprodotti WHERE codiceprodotto='%s'", $_POST['codiceprodotto']);
        $dati = eseguiQuery($connessione, $query);

        $percorsoThumbnails = '../img/thumb/' . $dati[0]['galleria'] . '/';

        // La funzione glob cerca tutte le immagini presenti nel percorso specificato.

        $thumbnails = glob($percorsoThumbnails . "*");

        print '<p class="informazione">Seleziona le immagini da eliminare</p>';

        print '<form id="formEliminazioneImmagini" method="post" action="../script/scriptEliminazioneImmagine.php">';
        print '<input type="hidden" name="galleria" value="' . $dati[0]['galleria'] . '">';

        // Successivamente le thumbnail relative a ciascuna immagine vengono visualizzate
        // Con la checkbox si indicano quelle da eliminare

        foreach ($thumbnails as $thumb) {
            print '<div id="immagineEliminazione">';
            print '<div><img src="' . $thumb . '"></div>';
            print '<div><input type="checkbox" name="immagine[]" value="' . basename($thumb) . '"/>';
            print '<label>' . basename($thumb) . '</label></div>';
            print '</div>';
        }

        print '<div id="pulsanteEliminazione"><input type="submit" value="Elimina"/></div>';
        print '</form>';

        print '<script type="text/javascript">';
        print "gestisciForm('#formEliminazioneImmagini','../script/scriptEliminazioneImmagine.php','#coldx');";
        print '</script>';

        chiudiConnessione($connessione);

    } else {
        print '<p class="errore">Per poter visualizzare questa pagina devi avere le credenziali da amministratore.</p>';
    }
} else {
    print '<p class="errore">Non sei autorizzato a visualizzare questa pagina, per favore, esegui il login.</p>';
}

?>
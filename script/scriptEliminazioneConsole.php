<?php
include '../settings/configurazione.inc';
include HOME_ROOT . '/script/funzioni.php';

if (isset($_SESSION['collegato'])) {
    if ($_SESSION['amministratore'] == true) {
        $connessione = creaConnessione(SERVER, UTENTE, PASSWORD, DATABASE);

        $query = sprintf("SELECT COUNT(console) FROM tblprodotticonsole WHERE console='%s'", $_POST['nome']);
        $dati = eseguiQuery($connessione, $query);

        if(intval($dati[0]['COUNT(console)'] > 0)){
            print '<p class="informazione">Elimina tutti i prodotti associati a questa console prima di procedere</p>';
        } else {
            $query = sprintf("DELETE FROM tblconsole WHERE nome='%s'", $_POST['nome']);
            $dati = eseguiQuery($connessione, $query);
            print '<p class="successo">La console &egrave; stata eliminata con successo</p>';
        }
        chiudiConnessione($connessione);
    } else {
        print '<p class="errore">Non sei autorizzato a visualizzare questa pagina, per favore, esegui il login</p>';
    }
} else {
    print '<p class="errore">Non sei autorizzato a visualizzare questa pagina, per favore, esegui il login</p>';
}
?>
<?php
include '../settings/configurazione.inc';
include HOME_ROOT . '/script/funzioni.php';
print '<script type="text/javascript" src="'.HOME_WEB.'js/funzioni.js"></script>';

if (isset($_SESSION['collegato'])) {
    if ($_SESSION['amministratore'] == true) {
        $connessione = creaConnessione(SERVER, UTENTE, PASSWORD, DATABASE);

        $query = sprintf("SELECT * FROM tblconsole WHERE nome='" . $_POST['nome'] . "'");
        $dati = eseguiQuery($connessione, $query);

        print '<form id="formModificaConsole" method="post" action="../script/scriptModificaConsole.php">';
        print '<fieldset><legend>Informazioni console</legend>';
        print '<div class="label"><label >Nome</label></div>';
        // Il seguente campo nascosto viene utilizzato per individuare il vecchio valore della chiave primaria nel database e quindi aggiornarlo
        print '<input type="hidden" name="nomeOld" value="' . $dati[0]['nome'] . '"></input>';
        print '<input type="text" name="nome" value="' . $dati[0]['nome'] . '" class="obbligatorio"></input><br />';
        print '<div class="label"><label >Produttore</label></div>';
        print '<input type="text" name="produttore" value="' . $dati[0]['produttore'] . '"></input><br />';
        print '<input type="submit" value="Conferma" class="invia"></input>';
        print '</fieldset>';
        print "</form>";

        print '<script type="text/javascript">';
        print "gestisciForm('#formModificaConsole','../script/scriptModificaConsole.php','#coldx');";
        print '</script>';

    } else {
        print '<p class="errore">Per poter visualizzare questa pagina devi avere le credenziali da amministratore.</p>';
    }
} else {
    print '<p class="errore">Non sei autorizzato a visualizzare questa pagina, per favore, esegui il login.</p>';
}
?>
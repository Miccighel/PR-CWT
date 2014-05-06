<?php
include '../settings/configurazione.inc';
include HOME_ROOT.'/html/testa.php';
include HOME_ROOT . '/script/funzioni.php';

if (isset($_SESSION['collegato'])){
    if ($_SESSION['amministratore'] == true){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            ricercaConsole($_POST['nome'],'moduloModificaConsoleIntermedio.php');
        } else {
            stampaModuloRicerca('moduloModificaConsole.php','console');
        }
    } else {
        print 'Per poter visualizzare questa pagina devi avere le credenziali da amministratore.';
    }
} else {
    print 'Non sei autorizzato a visualizzare questa pagina, per favore, esegui il login.';
}

include HOME_ROOT.'/html/coda.html';
?>
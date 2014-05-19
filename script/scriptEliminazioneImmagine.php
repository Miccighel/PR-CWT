<?php
include '../settings/configurazione.inc';
include HOME_ROOT . '/script/funzioni.php';

var_dump($_POST);

if(count($_POST) > 1){
    foreach ($_POST['immagine'] as $immagine) {
        if (file_exists('../img/thumb/' . $_POST['galleria'] . '/' . $immagine)) {
            unlink('../img/thumb/' . $_POST['galleria'] . '/' . $immagine);
        }
        if (file_exists('../img/' . $_POST['galleria'] . '/' . $immagine)) {
            unlink('../img/' . $_POST['galleria'] . '/' . $immagine);
        }
        print '<p class="successo">Il file ' . $immagine . ' &egrave; stato eliminato con successo</p>';
    }
    print '<p class="successo">Hai eliminato con successo ' . count($_POST['immagine']) . ' immagini</p>';
} else {
    print '<p class="informazione">Non &egrave; stata eliminata nessuna immagine</p>';
}
?>
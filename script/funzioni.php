<?php

function creaConnessione($server,$utente,$password,$database) {
    $connessione = mysqli_connect($server, $utente, $password);
    mysqli_select_db($connessione,$database) or die(mostraErrore($connessione));
    return $connessione;
}

function eseguiQuery($connessione,$query){
    $risultatoQuery = mysqli_query($connessione,$query)or die(mostraErrore($connessione));
    $dati = array();
    if(!is_bool($risultatoQuery)) {
        while($riga = mysqli_fetch_assoc($risultatoQuery)){
            $dati[] = $riga;
        }
    }
    return $dati;
}

function chiudiConnessione($connessione){
    mysqli_close($connessione);
}

function mostraErrore($connessione){
    echo '<p class="errore">'."I dati che hai inserito hanno generato questo errore: ".mysqli_error($connessione)."</p>";
}

function gestioneImmagine($indice, $galleria){
    if($indice == -1){
        $errore = $_FILES['immagine']['error'];
        $nome = $_FILES['immagine']['name'];
        $temp = $_FILES['immagine']['tmp_name'];
    }else{
        $errore = $_FILES['immagini']['error'][$indice];
        $nome = $_FILES['immagini']['name'][$indice];
        $temp = $_FILES['immagini']['tmp_name'][$indice];
    }
    if ($errore == UPLOAD_ERR_OK) {
        copy($temp, HOME_ROOT . '/' . 'img' . '/'.$galleria.'/' . $nome);
        $messaggio = "L'immagine è stata caricata senza problemi";
        print '<p class="successo">' . $nome . ' - Esito : ' . strtoupper($messaggio) . "</p>";
        return true;
    } else {
        switch ($errore) {
            case UPLOAD_ERR_INI_SIZE:
                $messaggio = "L'immagine caricata è troppo grande rispetto alla direttiva specificata in php.ini";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $messaggio = "L'immagine caricata è troppo grande rispetto alla direttiva specificata nel form html";
                break;
            case UPLOAD_ERR_PARTIAL:
                $messaggio = "L'immagine è stata caricata parzialmente";
                break;
            case UPLOAD_ERR_NO_FILE:
                $messaggio = "L'immagine non è stata caricata";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $messaggio = "Immagine temporanea mancante";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $messaggio = "Impossibile scrivere l'immagine su disco";
                break;
            case UPLOAD_ERR_EXTENSION:
                $messaggio = "Caricamento dell'immagine bloccato da un estensione";
                break;
        }
        print '<p class="errore">' . $nome . ' - Esito : ' . strtoupper($messaggio) . "</p>";
        return false;
    }
}

function generaThumbnail($imSorgente, $percorso, $larghezza, $altezza, $indice){
    if(!is_dir(HOME_ROOT .$percorso)){
        mkdir(HOME_ROOT .$percorso);
    }
    list($larghezzaOriginale, $altezzaOriginale) = getimagesize($imSorgente);
    $thumb = imagecreatetruecolor($larghezza, $altezza);
    if($indice == -1){
        $tipo = $_FILES['immagine']['type'];
    }else{
        $tipo = $_FILES['immagini']['type'][$indice];
    }
    switch($tipo) {
        case "image/jpeg":
        $immagine = @imagecreatefromjpeg($imSorgente);
        break;
        case "image/gif":
        $immagine = @imagecreatefromgif($imSorgente);
        break;
        case "image/png":
        $immagine = @imagecreatefrompng($imSorgente);
        break;
    }
    imagecopyresized($thumb, $immagine, 0, 0, 0, 0, $larghezza, $altezza, $larghezzaOriginale, $altezzaOriginale);
    if($indice == -1){
        imagejpeg($thumb,HOME_ROOT.$percorso.'/'. $_FILES['immagine']['name']);
    } else {
        imagejpeg($thumb,HOME_ROOT.$percorso.'/'. $_FILES['immagini']['name'][$indice]);
    }
    imagedestroy($thumb);
    imagedestroy($immagine);
}

function visualizzaGalleria($galleria,$nomeClasse) {
    $percorsoThumbnails = '../img/thumb/'.$galleria.'/';
    $percorsoGalleria = '../img/'.$galleria.'/';
    $thumbnails = glob($percorsoThumbnails . "*.jpg");
    foreach ($thumbnails as $thumb) {
        print '<li><a href="'.$percorsoGalleria.basename($thumb).'" rel="gallery" class="pirobox_gall'.$nomeClasse.'">
                <img width="100" height="58" src="'.$thumb.'"/></a></li>';
    }
}

function ricercaProdotto($nomeCercato, $destinazione){
    $connessione = creaConnessione(SERVER,UTENTE,PASSWORD,DATABASE);
    print '<p class="informazione">Sono stati individuati i seguenti risultati potenziali</p>';
    $query = sprintf("SELECT * FROM tblprodotti AS p LEFT JOIN tblprodotticonsole AS pc ON p.codiceprodotto = pc.codiceprodotto");
    $dati = eseguiQuery($connessione,$query);
    $contantoreRisultati = 0;
    foreach($dati as $riga ){
        $risultatoPotenziale = strtolower(substr(trim($riga['nomeprodotto']),0,strlen($nomeCercato)));
        if($risultatoPotenziale==strtolower($nomeCercato)){
            print '<form id="' . trim($riga['codiceprodotto']) . '" method="post" action="' . trim($destinazione) . '">';
            print '<input type="hidden" name="codiceprodotto" value="'.$riga['codiceprodotto'].'"/>';
            print '<input type="hidden" name="console" value="'.$riga['console'].'"/>';
            print '<div class="label"><label>'.$riga['nomeprodotto'].' - '.$riga['console'].'</label></div>';
            print '<input type="submit" value="Seleziona"/>';
            print '</form>';
            print '<br />';
            $contantoreRisultati++;
            print '<script type="text/javascript">';
            print "gestisciForm('" . "#" . trim($riga['codiceprodotto']) . "','" . trim($destinazione) . "','#coldx');";
            print '</script>';
        }
    }

    chiudiConnessione($connessione);

    if($contantoreRisultati == 0){
        print '<p class="errore">La ricerca non ha prodotto alcun risultato.</p>';
    }
}

function ricercaCategoria($nomeCercato, $destinazione){
    $connessione = creaConnessione(SERVER,UTENTE,PASSWORD,DATABASE);
    $query = sprintf("SELECT * FROM tblcategorie ORDER BY nome ASC");
    $dati = eseguiQuery($connessione,$query);
    $contantoreRisultati = 0;

    print '<p class="informazione">Sono stati individuati i seguenti risultati potenziali</p>';
    foreach($dati as $riga ){
        $risultatoPotenziale = strtolower(substr(trim($riga['nome']),0,strlen($nomeCercato)));
        if($risultatoPotenziale==strtolower($nomeCercato)){
            $idCorretto = preg_replace('/\s+/', 'A', $riga['nome']);
            print '<form id="' . $idCorretto . '" method="post" action="' . trim($destinazione) . '">';
            print '<div class="label"><label>'.$riga['nome'].'</label></div>';
            print '<input type="hidden" name="nome" value="'.$riga['nome'].'">';
            print '<input type="submit" value="Seleziona"/>';
            print '</form>';
            print '<br />';
            $contantoreRisultati++;
            print '<script type="text/javascript">';
            print "gestisciForm('" . "#" . $idCorretto . "','" . trim($destinazione) . "','#coldx');";
            print '</script>';
        }
    }

    chiudiConnessione($connessione);

    if($contantoreRisultati == 0){
        print '<p class="errore">La ricerca non ha prodotto alcun risultato.</p>';
    }
}

function ricercaConsole($nomeCercato, $destinazione){
    $connessione = creaConnessione(SERVER,UTENTE,PASSWORD,DATABASE);
    $query = sprintf("SELECT * FROM tblconsole ORDER BY nome ASC");
    $dati = eseguiQuery($connessione,$query);
    $contantoreRisultati = 0;

    print '<p class="informazione">Sono stati individuati i seguenti risultati potenziali</p>';
    foreach($dati as $riga ){
        $risultatoPotenziale = strtolower(substr(trim($riga['nome']),0,strlen($nomeCercato)));
        if($risultatoPotenziale==strtolower($nomeCercato)){
            print '<form method="post" action="' . trim($destinazione) . '">';
            print '<div class="label"><label>'.$riga['nome'].'</label></div>';
            print '<input type="submit" value="Seleziona"/>';
            print '</form>';
            print '<br />';
            $contantoreRisultati++;
            print '<script type="text/javascript">';
            print "gestisciForm('" . "#" . $idCorretto . "','" . trim($destinazione) . "','#coldx');";
            print '</script>';
        }
    }

    chiudiConnessione($connessione);

    if($contantoreRisultati == 0){
        print '<p class="errore">La ricerca non ha prodotto alcun risultato.</p>';
    }
}

function ricercaUtente($utenteCercato, $destinazione){
    $connessione = creaConnessione(SERVER,UTENTE,PASSWORD,DATABASE);
    $query = sprintf("SELECT user, dirittoAmministratore FROM tblutenti WHERE user != '%s' ORDER BY user ASC",$_SESSION['username']);
    $dati = eseguiQuery($connessione,$query);
    $contantoreRisultati = 0;
    $selezionata = '';

    print '<p class="informazione">Sono stati individuati i seguenti risultati potenziali</p><br />';
    foreach($dati as $riga ){
        $risultatoPotenziale = strtolower(substr(trim($riga['user']),0,strlen($utenteCercato)));
        $contantoreRisultati++;
        if($risultatoPotenziale==strtolower($utenteCercato)){
            if($riga['dirittoAmministratore'] == 'si'){
                $selezionata = 'selected';
            }
            print '<form method="post" action="' . trim($destinazione) . '">';
            print '<div class="label"><label>'.$riga['user'].'</label></div>';
            print '<input type="hidden" name="user[]" value="'.$riga['user'].'">';
            print '<select name="dirittoAmministratore[]">';
            if($riga['dirittoAmministratore'] == 'si'){
                print '<option selected>si</option>';
                print '<option>no</option>';
            }else{
                print '<option>si</option>';
                print '<option selected>no</option>';
            }
            print '</select>';
            print '<label> diritto da amministratore';
            print '<br /><br />';
        }
    }
    print '<input type="submit" value="Conferma"/>';
    print '</form>';
    print '<script type="text/javascript">';
    print "gestisciForm('" . "#" . trim($riga['user']) . "','" . trim($destinazione) . "','#coldx');";
    print '</script>';

    chiudiConnessione($connessione);

    if($contantoreRisultati == 0){
        print '<p class="errore">La ricerca non ha prodotto alcun risultato.</p>';
    }
}

function stampaModuloRicerca($destinazione, $nome){
    print '<form id="formRicerca" method="post" action="' . trim($destinazione) . '">';
    print '<fieldset><legend>Ricerca '.$nome.'</legend>';
    print '<div class="label"><label >Nome</label></div>';
    print '<input type="text" name="nome" class="obbligatorio"></input>';
    print '<input type="submit" value="Cerca" class="inviato"></input>';
    print '</fieldset>';
    print "</form>";

    print '<script type="text/javascript">';
    print "gestisciForm('#formRicerca','" . trim($destinazione) . "','#coldx');";
    print '</script>';
}

function cancellaCartella($cartella) {
    if (is_dir($cartella)) {
        $files = scandir($cartella);
        for ($i = 2; $i < count($files); $i++) {
            unlink($cartella . '/' . $files[$i]);
        }
        rmdir($cartella);
        return true;
    } else {
        return false;
    }
}

function cancellaImmagine($immagine) {
    if (file_exists($immagine)) {
        unlink($immagine);
        return true;
    } else {
        return false;
    }
}

?>
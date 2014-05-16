<?php
/* CONFIGURAZIONE NON NON NECESSARIA */

/* HOME_ROOT indica il percorso assoluto del file in cui viene inclusa; non necessita di ulteriore configurazione. Questa
costante è necessaria perchè in diverse occasioni viene incluso il contenuto di un file a partire da file
che si trovano in posizioni diverse, quindi è necessario usare un riferimento di tipo assoluto */
define('HOME_ROOT',realpath(dirname(__FILE__).'/../'));
// Inizializzazione della sessione
session_start();

/* CONFIGURAZIONE OBBLIGATORIA */

/* HOME_WEB indica il percorso della cartella in cui si trova il file index.php rispetto al filesystem del server.
Esempio: il file index.php si trova nella cartella sito dentro alla cartella public_html
HOME_WEB: /public_html/sito/
La costante viene utilizzata quando può essere utilizzato un percorso di tipo relativo*/
define('HOME_WEB','/Complementi/Progetto/');
// Le costanti SERVER, UTENTE, PASSWORD, DATABASE sono necessarie per eseguire le query alla base di dati desiderata.
define('SERVER','localhost');
define('UTENTE','root');
define('PASSWORD','');
define('DATABASE','ecommerce');

/* CONFIGURAZIONE FACOLTATIVA */

// PRODOTTIPERPAGINA indica il numero di prodotti da mostrare in una singola pagina del carrello o del catalogo.
define('PRODOTTIPERPAGINA',3);
// UTENTIPERPAGINA indica il numero di utenti da mostrare durante le operazioni di amministrazione
define('UTENTIPERPAGINA',1);
?>

<?php
include '../settings/configurazione.inc';
session_destroy();
session_unset(); // Elimina le variabili di sessione residenti sul server
header("location: ../index.php");
?>
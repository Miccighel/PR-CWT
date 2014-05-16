$(document).ready(function(){
    // Visualizza il calendario per la scelta della data di nascita.
    $('input#calendario').datepicker( {
        changeYear: true,
        changeMonth: true,
        yearRange: "-100Y:+0Y"
    });
    $('input.invia').click(function(event) {
        controlloCampi('#codicefiscale',16,'Il codice fiscale deve essere di 16 cifre');
        controlloCampi('.obbligatorio',1,'Il campo &egrave obbligatorio');
        controlloCampi('#codiceprodotto',8,'Il codice prodotto deve essere di 8 cifre');
        controlloDecimali('.decimale','Il campo dev\'essere un numero intero oppure decimale');
        controlloInteri('.intero','Il campo dev\'essere un numero intero');
    });
});

function controlloDecimali(campo, messaggio) {
    $(campo).each(function() {
        var valore = $(this).val();
        // Le virgole sono rimpiazzate da punti, in tal modo il valore viene considerato numerico
        valore = valore.replace(",", ".");
        $(this).val(valore);
        // Se il valore non è un numero
        if(!($.isNumeric($(this).val()))){
            // Visualizzo il messaggio d'errore
            $(this).next('.errore').remove();
            $(this).addClass('evidenzia');
            $(this).after('<span class="errore">'+messaggio+'</span>');
            event.preventDefault();
        } else {
            // Se è un numero rimuovo l'eventuale messaggio già presente
            $(this).removeClass("evidenzia");
            $(this).next('.errore').remove();
        }
    });
}

function controlloInteri(campo, messaggio) {
    $(campo).each(function() {
        var valore = $(this).val();
        // Le virgole sono rimpiazzate da punti, in tal modo il valore viene considerato numerico
        valore = valore.replace(",", ".");
        $(this).val(valore);
        // Se il valore non è un numero
        if(!($.isNumeric($(this).val()))){
            // Visualizzo il messaggio d'errore
            $(this).next('.errore').remove();
            $(this).addClass('evidenzia');
            $(this).after('<span class="errore">'+messaggio+'</span>');
            event.preventDefault();
        } else {
            // Se viene individuato un valore numerico, ma con un punto,è un decimale, quindi il flag sarà vero
            var valore = $(this).val();
            var flag = false;
            for(var i=0;i<valore.length;i++){
                if(valore.charAt(i) == '.'){
                    flag = true;
                }
            }
            // Se il flag è vero, è stato individuato un decimale, quindi viene visualizzato il messaggio d'errore
            if(flag){
                $(this).next('.errore').remove();
                $(this).addClass('evidenzia');
                $(this).after('<span class="errore">'+messaggio+'</span>');
                event.preventDefault();
            } else {
                // In caso contrario rimuovo l'eventuale messaggio d'errore già presente
                $(this).removeClass("evidenzia");
                $(this).next('.errore').remove();
            }
        }
    });
}

function controlloCampi(campo, lunghezza, messaggio){
    // Per ogni campo individuato dal selettore
    $(campo).each(function(){
        // Si verifica che abbia qualcosa al suo interno
        if ($.trim($(this).val()).length < lunghezza){
            // Se il campo è vuoto, viene visualizzato il messaggio d'errore
            $(this).next('.errore').remove();
            $(this).addClass('evidenzia');
            $(this).after('<span class="errore">'+messaggio+'</span>');
            event.preventDefault();
        } else {
            $(this).removeClass("evidenzia");
            $(this).next('.errore').remove();
        }
    });
}

function gestisciForm(selettoreInvio, percorsoServer, selettoreRisposta) {
    $(document).ready(function () {
        // Quando un form individuato dal selettore passato come parametro viene inviato
        // la normale richiesta http viene bloccata, e ne parte una asincrona
        $(selettoreInvio).submit(function () {
            $.ajax({
                type: "POST",
                url: percorsoServer,
                // I dati del form vengono serializzati come stringa
                data: $(selettoreInvio).serialize(),
                /* Se la richiesta asincrona avviene con successo, inserisco il corpo della risposta http nell'elemento del DOM
                individuato dal selettore passato come parametro */
                success: function (data) {
                    $(selettoreRisposta).html(data);
                }
            });
            // Il return false blocca l'invio "normale" del form.
            return false;
        });
    });
}

function gestisciImmaginiGalleria() {
    $(document).ready(function() {
        // Apertura dell'immagine quando la thumbnail nella galleria viene cliccata
        $().piroBox_ext({
            piro_speed : 700,
            bg_alpha : 0.5,
            piro_scroll : true
        });
    });
}

// Creazione dello slider per le thumbnail del catalogo
function gestisciThumbnailsGalleria() {
    $(document).ready(function() {
        $( '.elastislide-list' ).each(function(){
            $(this).elastislide();
        });
    });
}
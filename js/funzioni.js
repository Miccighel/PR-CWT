$(document).ready(function(){
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
       valore = valore.replace(",", ".");
       $(this).val(valore);
       if(!($.isNumeric($(this).val()))){
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

function controlloInteri(campo, messaggio) {
    $(campo).each(function() {
        var valore = $(this).val();
        valore = valore.replace(",", ".");
        $(this).val(valore);
        if(!($.isNumeric($(this).val()))){
            $(this).next('.errore').remove();
            $(this).addClass('evidenzia');
            $(this).after('<span class="errore">'+messaggio+'</span>');
            event.preventDefault();
        } else {
            var valore = $(this).val();
            var flag = false;
            for(var i=0;i<valore.length;i++){
                if(valore.charAt(i) == '.'){
                    flag = true;
                }
            }
            if(flag){
                $(this).next('.errore').remove();
                $(this).addClass('evidenzia');
                $(this).after('<span class="errore">'+messaggio+'</span>');
                event.preventDefault();
            } else {
                $(this).removeClass("evidenzia");
                $(this).next('.errore').remove();
            }
        }
    });
}

function controlloCampi(campo, lunghezza, messaggio){
    $(campo).each(function(){
        if ($.trim($(this).val()).length < lunghezza){
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
        $(selettoreInvio).submit(function () {
            $.ajax({
                type: "POST",
                url: percorsoServer,
                data: $(selettoreInvio).serialize(),
                success: function (data) {
                    $(selettoreRisposta).html(data);
                }
            });
            return false;
        });
    });
}

function gestisciImmaginiGalleria() {
    $(document).ready(function() {
        $().piroBox_ext({
            piro_speed : 700,
            bg_alpha : 0.5,
            piro_scroll : true
        });
    });
}

function gestisciThumbnailsGalleria() {
    $(document).ready(function() {
        $( '.elastislide-list' ).each(function(){
            $(this).elastislide();
        });
    });
}

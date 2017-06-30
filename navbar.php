<script>

var user = "<?php echo $_SESSION["login"]; ?>";
var name = "<?php echo $_SESSION["nome"]; ?>";
var tipo = "<?php echo $_SESSION["tipo"]; ?>";
(function() {
    window.addEventListener("load", function() {
        document.getElementById('saluto').innerHTML = "<a style='color: inherit; padding-left: 20px;' href='profiloUtente.php'>Ciao "+name+"</a>";
        document.getElementById('logout').style.display = "block";
    }, false);
})();
(function() {
    if(tipo=="regolare"){
        window.addEventListener("load", function() {
            document.getElementById('profilo').innerHTML =
                "<a href='profiloUtente.php' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>Profilo<span class='caret'></span></a>"+
                "<ul class='dropdown-menu'>"
                +"<li class='dropdown-submenu'>" +
                "<a href='#' class='dropdown-toggle' data-toggle='dropdown'>Osservazioni</a>"+
                "<ul class='dropdown-menu'>"
                +"<li><a href='inserisciOsservazione.php'>Crea osservazione </a></li>"
                +"<li><a href='modificaEliminaOsservazione.php'>Modifica/Elimina osservazione </a></li>"
                +"<li><a href='vistaOsservazioniNonComplete.php'>Vista osservazioni non complete</a></li>"
                +"<li><a href='vistaOsservazioni.php'>Vista osservazioni</a></li>"
                +"<li><a href='vistaOsservazioniCompleteOggetto.php'>Vista osservazioni oggetto</a></li>"
                +"</ul>"
                +"</li>"
                +"<li class='dropdown-submenu'>" +
                "<a href='#' class='dropdown-toggle' data-toggle='dropdown'>Strumenti</a>"+
                "<ul class='dropdown-menu'>"
                +"<li><a href='vistaMagazzino.php'>Vista strumenti</a></li>"
                +"<li><a href='vistaCombinazioni.php'>Combinazione strumenti</a></li>"
                +"</ul>"
                +"</li>"
                +"<li><a href='vistaSitiOsservativi.php'>Luoghi</a></li>"
                +"<li><a href='vistaSoci.php'>Membri</a></li>"
                +"</ul>";
            document.getElementById('logout').style.display = "block";
        }, false);
    }
})();
(function() {
    if(tipo=="amministratore") {
        window.addEventListener("load", function () {
            document.getElementById('profilo').innerHTML =
                "<a href='profiloUtente.php' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>Profilo<span class='caret'></span></a>"+
                "<ul class='dropdown-menu'>"
                    +"<li class='dropdown-submenu'>" +
                        "<a href='#' class='dropdown-toggle' data-toggle='dropdown'>Osservazioni</a>"+
                        "<ul class='dropdown-menu'>"
                            +"<li><a href='inserisciOsservazione.php'>Crea osservazione </a></li>"
                            +"<li><a href='modificaEliminaOsservazione.php'>Modifica/Elimina osservazione </a></li>"
                            +"<li><a href='vistaOsservazioni.php'>Vista osservazioni</a></li>"
                            +"<li><a href='vistaOsservazioniNonComplete.php'>Vista osservazioni non complete</a></li>"
                            +"<li><a href='vistaOsservazioniCompleteOggetto.php'>Vista osservazioni oggetto</a></li>"
                        +"</ul>"
                    +"</li>"
                    +"<li class='dropdown-submenu'>" +
                        "<a href='#' class='dropdown-toggle' data-toggle='dropdown'>Oggetti celesti</a>"+
                        "<ul class='dropdown-menu'>"
                            +"<li><a href='inserisciOggettoCeleste.php'>Inserisci oggetto celeste</a></li>"
                        +"</ul>"
                    +"</li>"
                    +"<li class='dropdown-submenu'>" +
                        "<a href='#' class='dropdown-toggle' data-toggle='dropdown'>Strumenti</a>"+
                        "<ul class='dropdown-menu'>"
                            +"<li><a href='vistaMagazzino.php'>Vista strumenti</a></li>"
                            +"<li><a href='vistaCombinazioni.php'>Combinazione strumenti</a></li>"
                            +"<li><a href='inserisciStrumento.php'>Inserisci strumento</a></li>"
                            +"<li><a href='modificaEliminaStrumento.php'>Modifica/Elimina strumento</a></li>"
                            +"<li><a href='inserisciOculare.php'>Inserisci oculare</a></li>"
                               +"<li><a href='modificaEliminaOculare.php'>Modifica/Elimina oculare</a></li>"
                            +"<li><a href='inserisciFiltro.php'>Inserisci filtro</a></li>"
                               +"<li><a href='modificaEliminaFiltro.php'>Modifica/Elimina filtro</a></li>"
                        +"</ul>"
                    +"</li>"
                    +"<li class='dropdown-submenu'>" +
                        "<a href='#' class='dropdown-toggle' data-toggle='dropdown'>Luoghi</a>"+
                        "<ul class='dropdown-menu'>"
                            +"<li><a href='vistaSitiOsservativi.php'>Vista luoghi</a></li>"
                            +"<li><a href='inserisciArea.php'>Inserisci luogo</a></li>"
                        +"</ul>"
                    +"</li>"
                    +"<li class='dropdown-submenu'>" +
                        "<a href='#' class='dropdown-toggle' data-toggle='dropdown'>Membri</a>"+
                        "<ul class='dropdown-menu'>"
                            +"<li><a href='vistaSoci.php'>Vista membri</a></li>"
                            +"<li><a href='inserisciUtente.php'>Inserisci nuovo membro</a></li>"
                            +"<li><a href='modificaEliminaUtente.php'>Modifica/Elimina info membri</a></li>"
                        +"</ul>"
                    +"</li>"
                +"</ul>";
            document.getElementById('logout').style.display = "block";
        }, false);
    }
})();

</script>

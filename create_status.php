<?php
// includo le mie funzioni PHP che mi servono per gestire il DB
include 'functions.php';

// apertura tag html, head e body + inclusione navbar
include 'layout/head.php';
?>

<main>
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h1>Creazione stanza</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a id="torna-in-home" class="btn btn-success" href="index.php">
                    Torna in homepage
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <?php

                if (!empty($_GET) && // ricontrollo i dati che mi arrivano in GET
                    check_room_data($_GET['numero_stanza'], $_GET['piano'], ($_GET['letti']))) {
                    // salvo i dati ricevuti in variabili locali
                    $numero_stanza = intval($_GET['numero_stanza']);
                    $piano = intval($_GET['piano']);
                    $letti = intval($_GET['letti']);

                    if ($_GET['success']) {
                        ?>
                        <h2>Stanza creata con successo!</h2>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Dettagli stanza</h3>
                            </div>
                            <div class="panel-body">
                                <ul>
                                    <li>Numero stanza: <?php echo $numero_stanza; ?></li>
                                    <li>Piano: <?php echo
                                    $piano; ?></li>
                                    <li>Numero letti: <?php echo $letti; ?></li>
                                </ul>
                            </div>
                        </div>
                        <?php
                    } else { // $_GET['success']==false
                        ?>
                        <p>Creazione stanza non riuscita</p>
                        <?php
                    }
                } else { ?>
                    <p>Si è verificato un errore</p>
                    <?php
                }
                ?>
            </div>
        </div>

    </div>
</main>

<?php
// footer + chiusura tag body e html
include 'layout/footer.php'
 ?>

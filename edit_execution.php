<?php

// descrizione:
// controlla che i dati ricevuti in POST siano consistenti e nel caso
// esegue la query per aggiornare una stanza nel DB,
// visualizza la pagina con i dettagli della stanza appena aggiornati

// includo le mie funzioni PHP che mi servono per gestire il DB
include 'functions.php';

if (// check consistenza dati inseriti dall'utente
    !empty($_POST) &&
    check_room_data($_POST['numero_stanza'], $_POST['piano'], ($_POST['letti']))) {

    // recupero i dati della stanza da aggiornare
    $numero_stanza = intval($_POST['numero_stanza']);
    $piano = intval($_POST['piano']);
    $letti = intval($_POST['letti']);
    $stanza_id = $_POST['stanza-id'];

    // modifico la stanza nel db
    $sql = "UPDATE stanze SET room_number=$numero_stanza, floor=$piano, beds=$letti, updated_at=NOW() WHERE id=" . $stanza_id;
    $result = run_query($sql);
} else {
    $result = false;
}

// apertura tag html e body, sezione head e navbar
include 'layout/head.php';
?>
<main>
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h1>Modifica dati stanza</h1>
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
                if ($result) { ?>
                    <div class="alert alert-success" role="alert">
                      <a href="#" class="alert-link">Stanza modificata con successo!</a>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Dettagli stanza <?php echo $stanza_id; ?></h3>
                        </div>
                        <div class="panel-body">
                            <ul>
                                <li>Numero stanza: <?php echo $numero_stanza; ?></li>
                                <li>Piano: <?php echo $piano; ?></li>
                                <li>Numero letti: <?php echo $letti; ?></li>
                            </ul>
                        </div>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="alert alert-danger" role="alert">
                      <a href="#" class="alert-link">Si è verificato un errore</a>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>

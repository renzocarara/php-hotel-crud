<?php

// descrizione:
// esegue l'effettiva query di cancellazione di una stanza,
// riceve (in POST) l'id della stanza da cancellare
// visualizza il risultato della query in pagina

// includo le mie funzioni PHP che mi servono per gestire il DB
include 'functions.php';

// recupero l'ID stanza che mi è arrivato in POST
$stanza_id = $_POST['stanza-id'];

// query per cancellare un record
$sql = "DELETE FROM stanze WHERE id=" . $stanza_id;
$result = run_query($sql);

// apertura tag html e body, sezione head e navbar
include 'layout/head.php';
?>
<main>
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h1>Cancellazione stanza</h1>
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
                if ($result) {
                    ?>
                    <div class="alert alert-success" role="alert">
                      <a href="#" class="alert-link">Stanza cancellata!</a>
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

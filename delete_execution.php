<?php
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
                    <h2>Stanza cancellata!</h2>
                    <?php
                } else {
                    ?>
                    <p>Si è verificato un errore</p>
                    <?php
                }
                ?>
            </div>
        </div>

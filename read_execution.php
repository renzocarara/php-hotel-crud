<?php
// includo le mie funzioni PHP che mi servono per gestire il DB
include 'functions.php';

// recupero i dati della singola stanza richiesta dal DB tramite query
// l'id della stanza l'ho ricevuto in $_GET
$sql = "SELECT * FROM stanze WHERE id = " . $_GET['id_stanza'];
$result = run_query($sql);

// solo se ho dei dettagli stanza da visualizzare, allora faccio un'altra query per recuperare
// le prenotazioni associate alla stanza
if ($result && $result->num_rows > 0) {
    $sql = "SELECT * FROM prenotazioni WHERE stanza_id = " . $_GET['id_stanza'];
    $res_list = run_query($sql);
}
// apertura tag html e body, sezione head e navbar
include 'layout/head.php';
?>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <h1>Dettaglio stanza</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a id="torna-in-home" class="btn btn-success" href="index.php">
                        Torna in homepage
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">

                    <!-- visualizzo i dati della singola stanza in pagina -->
                    <?php display_room_data($result); ?>

                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">

                    <!-- visualizzo i dati relativi alle prenotazioni della stanza -->
                    <?php display_res_list($res_list); ?>

                </div>
            </div>
        </div>
    </main>
<?php

// footer + chiusura tag body e html
include 'layout/footer.php'

?>

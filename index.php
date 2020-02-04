<?php

// descrizione:
// è lo script iniziale,
// allo startup esegue una lettura del database e visualizza i dati in pagina
// (elenco delle stanze dell'hotel),
// al click dell'utente sui bottoni corrispondenti,
// passa il controllo a 4 script che implementano le CRUD:
// CREATE: create.php
// READ: read_execution.php
// UPDATE: edit.php
// DELETE: delete.php


// includo le mie funzioni PHP che mi servono per gestire il DB
include 'functions.php';

// leggo dal DB le info di tutte le stanze dell'hotel
$sql = "SELECT id, room_number, floor FROM stanze";
$result = run_query($sql);

// apertura tag html e body, sezione head e navbar
include 'layout/head.php';
?>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <h1>Tutte le stanze dell'hotel</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a id="crea-stanza" class="btn btn-success" href="create.php">
                        Crea nuova stanza
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Room number</th>
                                    <th>Floor</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result && $result->num_rows > 0) {

                                    // leggo i risultati della query, riga per riga con un ciclo while
                                    // ogni fetch_assoc() mi restituisce un array associativo (una singola riga della tabella)
                                    while ($row = $result->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo $row['room_number']; ?></td>
                                            <td><?php echo $row['floor']; ?></td>
                                            <td>
                                                <a class="btn btn-info" href="read_execution.php?id_stanza=<?php echo $row['id']; ?>">
                                                    Visualizza
                                                </a>
                                                <a class="btn btn-warning" href="edit.php?id_stanza=<?php echo $row['id']; ?>">
                                                    Modifica
                                                </a>
                                                <a class="btn btn-danger" href="delete.php?id_stanza=<?php echo $row['id']; ?>">
                                                    Cancella
                                                </a>
                                            </td>
                                        </tr>

                                        <?php
                                    } ?>

                                <?php
                                } elseif ($result) { ?>
                                    <tr>
                                        <td colspan="3"><div class="alert alert-warning" role="alert">
                                          <a href="#" class="alert-link">Non ci sono risultati</a>
                                        </div></td>
                                    </tr>
                                    <?php
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="3"><div class="alert alert-danger" role="alert">
                                          <a href="#" class="alert-link">Si è verificato un errore</a>
                                        </div></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </main>
<?php

// footer + chiusura tag body e html
include 'layout/footer.php'

 ?>

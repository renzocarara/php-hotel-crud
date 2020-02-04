<?php

include 'functions.php';

// Pagina modifica stanza

$sql = "SELECT * FROM stanze WHERE id = " . $_GET['id_stanza'];
$result = run_query($sql);
$row = $result->fetch_assoc();

// apertura tag html, head e body + inclusione navbar
include 'layout/head.php';

?>
<main>
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h1>Modifica dati stanza <?php echo $row['id']; ?></h1>
            </div>
            <div class="col-sm-6 text-right">
                <a id="torna-in-home" class="btn btn-success" href="index.php">
                    Torna in homepage
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <!-- inserisco i dettagli della stanza da modificare nel form di modifica -->
                <?php if ($result && $result->num_rows > 0) { ?>

                    <form method="post" action="edit_execution.php">
                      <div class="form-group">
                        <label for="numero_stanza">Numero stanza</label>
                        <input name="numero_stanza" type="text" class="form-control" placeholder="Numero stanza"
                        id="numero_stanza" value="<?php echo $row['room_number']; ?>" required>
                      </div>
                      <div class="form-group">
                        <label for="piano">Piano</label>
                        <input name="piano" type="text" class="form-control" id="piano" placeholder="Piano"
                         value="<?php echo $row['floor']; ?>" required>
                      </div>
                      <div class="form-group">
                        <label for="letti">Numero letti</label>
                        <input name="letti" type="text" class="form-control" id="letti" placeholder="Letti"
                         value="<?php echo $row['beds']; ?>" required>
                      </div>
                      <div class="form-group">
                        <!-- campo nascosto per passare l'id della stanza in POST tramite questo form -->
                        <input name="stanza-id" type="hidden" class="form-control" id="stanza-id"
                         value="<?php echo $row['id']; ?>">
                      </div>
                      <button type="submit" class="btn btn-success">Aggiorna dati stanza</button>
                    </form>

                    <?php
                } elseif ($result) { ?>
                    <p>Non ci sono risultati</p>
                    <?php
                } else {
                    ?>
                    <p>Si è verificato un errore</p>
                    <?php
                } ?>

            </div>
        </div>
    </div>
</main>

<?php
// footer + chiusura tag body e html
include 'layout/footer.php'

 ?>

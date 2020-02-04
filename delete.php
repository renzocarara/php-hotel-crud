<?php
// includo le mie funzioni PHP che mi servono per gestire il DB
include 'functions.php';

// leggo dati della stanza da cancellare
$sql = "SELECT * FROM stanze WHERE id = " . $_GET['id_stanza'];
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
                    display_room_data($result);

                    $is_room_erasable=check_room_constraints($_GET['id_stanza']);

                    if (($result && $result->num_rows > 0) && ($is_room_erasable)) { ?>
                    <div class="alert alert-danger" role="alert">
                      <a href="#" class="alert-link">ATTENZIONE: i dati verranno cancellati definitivamente</a>
                    </div>

                    <form method="post" action="delete_execution.php">
                      <div class="form-group">
                        <!-- campo nascosto per passare l'id della stanza in POST tramite questo form -->
                        <input name="stanza-id" type="hidden" class="form-control" id="stanza-id"
                         value="<?php echo $_GET['id_stanza']; ?>">
                      </div>
                      <button type="submit" class="btn btn-danger">Clicca per confermare</button>
                    </form>
                    <?php } elseif (!$is_room_erasable) {?>
                        <div class="alert alert-danger" role="alert">
                          <a href="#" class="alert-link">ATTENZIONE: la stanza non può essere cancellata</a>
                        </div>
                                <?php
                    } else {
                        ?>
                                    <p>Si è verificato un errore</p>
                                <?php
                    }?>
                </div>
            </div>
        </div>
    </main>
<?php

// footer + chiusura tag body e html
include 'layout/footer.php'

?>

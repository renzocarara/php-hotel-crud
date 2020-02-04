<?php

// descrizione:
// viene richiamata quando l'utente vuole cancellare una stanza,
// controlla innanzitutto se la stanza è "cancellabile",
// cioè se l'id della stanza non appare nella tabella prenotazioni,
// perchè se così fosse la stanza risulta "non cancellabile" e l'utente non può fare altro,
// Se invece l'utente può procedere con la cancellazione
// chiede all'utente di confermare con un click la cancellazione
// se l'utente conferma passa il controllo ad un altro script che esegue la query
// di cancellazione vera e propria. A questo script passo l'id della stanza da cancellare,
// tramite un campo 'hidden' di un form

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
                    } else {?>
                        <div class="alert alert-danger" role="alert">
                          <a href="#" class="alert-link">Si è verificato un errore</a>
                        </div>
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

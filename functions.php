<?php

function connect_db()
// descrizione:
// esegue una connessione al DB, cioè crea un oggetto mysqli,
// in base ai parametri inclusi da un file esterno (db-config.php)
// ritorna il riferimento all'oggetto (connessione)
{
    include 'db-config.php';

    $conn = new mysqli($servername, $username, $password, $dbname);
    return $conn;
}

function run_query($query)
// descrizione:
// riceve in ingresso una stringa che rappresenta una query MySQL
// si connette al DB, lancia la query chiude la connessione e ritorna il risultato
// se la connessione al DB fallisce, ritorna NULL
{
    // creo connessione al DB
    $conn = connect_db();

    // Check connection
    if ($conn && $conn->connect_error) {
        return null;
    } else {
        // lancio la query
        $result = $conn->query($query);
        // chiudo la connesione
        $conn->close();
        // ritorno il risultato
        return $result;
    }
}

function check_room_data($numero_stanza, $piano, $letti)
// descrizione:
// esegue dei controlli di consistenza sui dati relativi ad una stanza
// (il numero della stanza, il piano e il numero di letti)
// verifica che siano non NULLI, interi e maggiori di zero,
// ritorna TRUE se i dati sono OK, altrimenti FALSE
{
    if (
        !empty($numero_stanza) &&
        !empty($piano) &&
        !empty($letti) &&
        is_numeric($numero_stanza) &&
        is_numeric($piano) &&
        is_numeric($letti) &&
        intval($numero_stanza) > 0 &&
        intval($piano) > 0 &&
        intval($letti) > 0
    ) {
        return true;
    } else {
        return false;
    }
}


function display_room_data($result)
// descrizione:
// visualizza in pagina i dati di una singola stanza,
// riceve in ingresso i dati da visualizzare,
// verifca se i dati in ingresso sono:
// consistenti (ci sono dati da visualizzare, l'array contiene elementi, elabora),
// vuoti (non ci sono risultati da visualizzare, array vuoto, 0 elementi)
// nulli (i dati ricevuti sono NULL)
{
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc(); ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Dettagli stanza <?php echo $row['id']; ?></h3>
            </div>
            <div class="panel-body">
                <ul>
                    <li>Numero stanza: <?php echo $row['room_number']; ?></li>
                    <li>Piano: <?php echo $row['floor']; ?></li>
                    <li>Numero letti: <?php echo $row['beds']; ?></li>
                    <li>Data creazione: <?php echo $row['created_at']; ?></li>
                    <li>Data ultima modifica: <?php echo $row['updated_at']; ?></li>
                </ul>
            </div>
        </div>

        <?php
    } elseif ($result) { ?>
        <div class="alert alert-warning" role="alert">
          <a href="#" class="alert-link">Non ci sono risultati</a>
        </div>
        <?php
        } else {?>
            <div class="alert alert-danger" role="alert">
              <a href="#" class="alert-link">Si è verificato un errore</a>
            </div>
            <?php
        }
}
function display_res_list($res_list)
// descrizione:
// visualizza in pagina i dati relativi alle prenotazioni di una stanza,
// riceve in ingresso i dati da visualizzare,
// verifca se i dati in ingresso sono:
// consistenti (ci sono dati da visualizzare, l'array contiene elementi, elabora),
// vuoti (non ci sono risultati da visualizzare, array vuoto, 0 elementi)
// nulli (i dati ricevuti sono NULL)

{ ?>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>n. prenotazione</th>
                <th>id stanza</th>
                <th>creata il</th>
                <th>ultimo aggiornamento</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($res_list && $res_list->num_rows > 0) {

                // leggo i risultati della query, riga per riga con un ciclo while
                // ogni fetch_assoc() mi restituisce un array associativo (una singola riga della tabella)
                while ($row = $res_list->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['stanza_id']; ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                        <td><?php echo $row['updated_at']; ?></td>
                    </tr>
                    <?php
                } ?>

            <?php
            } elseif ($res_list) { ?>
                <tr>
                    <td colspan="4"><div class="alert alert-warning" role="alert">
                      <a href="#" class="alert-link">Non ci sono prenotazioni per questa stanza</a>
                    </div</td>
                </tr>
                <?php
            } else {
                ?>
                <tr>
                    <td colspan="4"><div class="alert alert-danger" role="alert">
                      <a href="#" class="alert-link">Si è verificato un errore</a>
                    </div></td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</div>
<?php
}

function check_room_constraints($stanza_id)
// descrizione:
// controlla se la stanza, di cui riceve l'id come parametro in ingresso,
// appare nella tabella prenotazioni, nel qual caso la stanza non è cancellabile
// e la funzione ritorna FALSE.
// Se l'id stanza non appare nella tabella prenotazioni, la stanza è cancellabile
// e la funzione ritorna TRUE.
// Se la query fallisce, cioè non riesco a recuperare questa informazione,
// ritorno comunque FALSE e blocco l'eventuale tentativo di cancellazione
{
    $sql = "SELECT * FROM prenotazioni WHERE stanza_id = " . $stanza_id;
    $res_list = run_query($sql);

    if ($res_list && $res_list->num_rows > 0) {
        // ci sono prenotazioni associate a quella stanza,
        // non posso cancellarla
        return false;
    } elseif ($res_list) {
        // non si sono prenotazioni associate alla stanza, posso cancellarla
        return true;
    } else {
        // la query è fallita, non ho riscontro, blocco la cancellazione
        return false;
    }
}
?>

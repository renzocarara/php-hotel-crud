<!-- descrizione:
esegue l'effettiva creazione di un record nella tabella stanze lanciado la query,
viene invocata dalla create.php, la quale invia i dati di creazione in PSOt tramite un FORM,
una volta eseguita la query, il controllo viene passato ad un alra pagina 'create_status.php',
tramite un'istruzione di 'redirect' (header), in modo tale che l'utente non possa
eseguire un ricaricamento dello script stesso (F5) causando un duplice inserimento di dati nel DB.
La pagina verso la quale viene ridiretta l'esecuzione, visualizzerà il risultato dell'operazione,
grazie anche al parametro $status che le viene inviato. -->
<?php
// includo le mie funzioni PHP che mi servono per gestire il DB
include 'functions.php';

// verifico di aver ricevuto dei dati in $_POST[] e che siano consistenti
if (!empty($_POST) &&
    check_room_data($_POST['numero_stanza'], $_POST['piano'], intval($_POST['letti']))) {
    // salvo i dati ricevuti in variabili locali
    $numero_stanza = intval($_POST['numero_stanza']);
    $piano = intval($_POST['piano']);
    $letti = intval($_POST['letti']);

    // eseguo la query sul DB con i dati ricevuti
    $sql = "INSERT INTO stanze (room_number, floor, beds, created_at, updated_at)
            VALUES ($numero_stanza, $piano, $letti, NOW(), NOW())";
    $result = run_query($sql);
} else {
    // non ho dati validi per poter procedere con la creazione della stanza
    $result = false;
}

// verifico il risultato della query di creazione e creo una stringa da passare in GET
// allo script verso il quale faccio una 'redirect'
if ($result) {
    $status='success=true';
} else {
    $status='success=false';
}
// ritorno il controllo allo script chiamante per visualizzare un messaggio sul risultato della creazione
// in questo modo evito che l'utente possa fare un ricaricamento di questa pagina facendo rigirare lo script
// creando così un duplicato della stanza
// alla pagine chiamante ritorno una variabile con il risultato della query (la passo in $_GET)
header('Location: create.php?' . $status);

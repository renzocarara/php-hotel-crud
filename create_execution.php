<?php
// includo le mie funzioni PHP che mi servono per gestire il DB
include 'functions.php';

// verifico di aver ricevuto dei dati in $_POST[] ce che siano consistenti
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
// passo il controllo ad una pagina ad hoc per visualizzare un messaggio sul risultato della creazione
// in questo modo evito che l'utente possa fare un ricaricamento di questa pagina facendo rigirare lo script
// creando così un duplicato della stanza
// al nuovo script passo il risultato della query e i parametri della stanza da creare/creata
header('Location: create_status.php?' . $status . '&numero_stanza=' . $numero_stanza . '&piano=' . $piano . '&letti=' . $letti);

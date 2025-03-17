<?php
header('Content-Type: application/json');

try {
    // Validate input
    if (!isset($_POST['people']) || !filter_var($_POST['people'], FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]])) {
        throw new Exception('Input value does not exist or value is invalid');
    }

    $people = (int) $_POST['people'];

    // Define suits and values
    $suits = ['S', 'H', 'D', 'C'];
    $values = array_combine(range(1, 13), ['A', '2', '3', '4', '5', '6', '7', '8', '9', 'X', 'J', 'Q', 'K']);

    // Generate and shuffle deck
    $deck = [];
    foreach ($suits as $suit) {
        foreach ($values as $num => $display) {
            $deck[] = "$suit-$display";
        }
    }
    shuffle($deck);

    // Distribute cards efficiently
    $result = array_fill(0, $people, []);
    foreach ($deck as $index => $card) {
        $result[$index % $people][] = $card;
    }

    echo json_encode($result);
} catch (Exception $e) {
    echo json_encode(['error' => 'Irregularity occurred']);
    exit;
}

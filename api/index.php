<?php

ini_set("display_errors", 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, OPTIONS, PUT, POST, DELETE");

$tasks = file_get_contents("./tasks.json");
$tasks = json_decode($tasks);    

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    echo json_encode($tasks);
}
if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    $task = file_get_contents("php://input");
    $task =  json_decode($task);

    foreach ($tasks as $i => $t) {
        if ($task->id == $t->id) {
            $tasks[$i] = $task;
            break;
        }
    }
    
    file_put_contents("./tasks.json", json_encode($tasks));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task = file_get_contents('php://input');
    $task = json_decode($task);

    $task->id = uniqid();
    $task->created = date('Y-m-d');

    array_push($tasks, $task);
    
    file_put_contents('./tasks.json', json_encode($tasks));
    echo json_encode($task);
}
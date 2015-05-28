<?php

require_once "db.php";

if (!isset($_GET["action"]) || $_GET["action"] != 'get_mice_info' || !isset($_GET["mice"]))
    return;

$mice = json_decode($_GET["mice"]);

if (!count($mice))
    return;

$mice = array_map('strtoupper', $mice);

$qmarks = str_repeat('?,', count($mice) - 1) . '?';

try {
    $result = $db->prepare("
        SELECT m.name as mouse, a.name as area, c.name as cheese
        FROM mice m
        INNER JOIN mice_areas ma ON ma.mice_id = m.id
        INNER JOIN areas a ON a.id = ma.areas_id
        INNER JOIN mice_cheeses mc ON mc.mice_id = m.id
        INNER JOIN cheeses c ON c.id = mc.cheeses_id
        WHERE m.name IN ($qmarks)");

    $result->execute($mice);
} catch(PDOException $ex) {
    error_log($ex->getMessage());
}
    
$output = array();
while($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $output[$row['area']][$row['mouse']][] = $row['cheese'];
}

header("Content-Type: application/json; charset=UTF-8");
echo json_encode($output);

?>

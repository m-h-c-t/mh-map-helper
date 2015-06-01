<?php

require_once "db/db.php";

if (!isset($_GET["action"])) {
    error_log('Error: action not set when accessing api.php');
    header( 'Location: index.html' );
    return;
}

// TODO: add more cases in the future and convert to restful api structure
switch ($_GET["action"]) {
    case 'get_mice_info':
        $results = get_mice_info();
        break;
}

header("Content-Type: application/json; charset=UTF-8");
echo json_encode($results);

// Functions
function get_mice_info()
{
    global $db;
    if (!isset($_GET["mice"]) || empty($_GET["mice"])) {
        return array();
    }
    
    $mice = json_decode($_GET["mice"]);
    $mice = array_map('trim', $mice);
    $mice = array_map('strtoupper', $mice);
    
    if (!count($mice)) {
        return array();
    }
        
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
    return $output;
}

?>

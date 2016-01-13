<?php

// TODO: add autoloader

if (!isset($_GET["action"])) {
    error_log('Error: action not set when accessing api.php');
    header( 'Location: ./' );
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
    require_once "models/mouse.php";
    $results = array();
    if (!isset($_GET["mice"]) || empty($_GET["mice"])) {
        return $results;
    }

    $mice_names = json_decode($_GET["mice"]);
    $mice_names = array_map('trim', $mice_names);
    $mice_names = array_map('strtoupper', $mice_names);

    if (!count($mice_names)) {
        return $results;
    }

    $mice = array();
    $mouse = new Mouse();
    $unique_mice = array();
    foreach ($mice_names as $mouse_name) {
        $mouse->retrieve($mouse_name);
        if (!$mouse->is_valid)
            $mice[] = clone $mouse;
        else if(!array_key_exists($mouse->id, $unique_mice)) {
            $mice[] = clone $mouse;
            $unique_mice[$mouse->id] = true;
        }
    }

    return $mice;
}

?>

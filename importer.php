<?php


// OFF SWITCH
print "Turned off"; return;

require_once "db/dbw.php";

// This importer takes a csv with 3 columns: 1. Mice 2. Locations 3. Cheeses
$csv = array_map('str_getcsv', file('upload/mh_triple_import_5.25.2015.csv'));

foreach ($csv as $row) {
    
    // $row[0] is mouse name, row[1] are areas, row[2] are cheeses
    
    // Mice
    $mouse = strtoupper(trim($row[0]));

    if (empty($mouse))
        continue;
    //insert mouse into mice table
    try {
        $result = $db->prepare("INSERT IGNORE INTO `mice`(`name`) VALUES (?)");
        $result->execute(array($mouse));
    } catch(PDOException $ex) {
        error_log($ex->getMessage());
    }
    
    // Areas
    $row[1] = strtoupper($row[1]);
    $areas = explode("||", $row[1]);
    $areas = array_map('trim',$areas);
    
    foreach($areas as $area) {
        if (empty($area))
            continue;

        //insert ignore area into areas table
        try {
            $result = $db->prepare("INSERT IGNORE INTO `areas`(`name`) VALUES (?)");
            $result->execute(array($area));
        } catch(PDOException $ex) {
            error_log($ex->getMessage());
        }

        //insert ignore mice.id, areas.id into mice_areas where mice.name = $mouse and areas.name = $area
        try {
            $result = $db->prepare("
                INSERT IGNORE INTO `mice_areas` (`mice_id`, `areas_id`)
                SELECT m.id, a.id
                FROM mice m
                INNER JOIN areas a ON a.name = ?
                WHERE m.name = ?
            ");
            $result->execute(array($area, $mouse));
        } catch(PDOException $ex) {
            error_log($ex->getMessage());
        }
    }
    
    // Cheese
    if (!array_key_exists(2, $row)) {
        $row[2] = 'REGULAR CHEESE';
    }
    
    $row[2] = strtoupper($row[2]);
    $cheeses = explode("||", $row[2]);
    $cheeses = array_map('trim',$cheeses);
    
    $cheese_count = 0;
    foreach($cheeses as $cheese) {
        if (empty($cheese)) {
            if ($cheese_count == 0)
                $cheese = 'REGULAR CHEESE';
            else
                continue;
        }

         //insert ignore cheese into areas table
        try {
            $result = $db->prepare("INSERT IGNORE INTO `cheeses`(`name`) VALUES (?)");
            $result->execute(array($cheese));
        } catch(PDOException $ex) {
            error_log($ex->getMessage());
        }

        //insert ignore mice.id, areas.id into mice_areas where mice.name = $mouse and cheese.name = $cheese
        try {
            $result = $db->prepare("
                INSERT IGNORE INTO `mice_cheeses` (`mice_id`, `cheeses_id`)
                SELECT m.id, c.id
                FROM mice m
                INNER JOIN cheeses c ON c.name = ?
                WHERE m.name = ?
            ");
            $result->execute(array($cheese, $mouse));
        } catch(PDOException $ex) {
            error_log($ex->getMessage());
        }
        $cheese_count++;
    }
}

print "Done!! Wooot! :)";

?>

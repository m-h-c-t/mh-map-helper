<?php


// OFF SWITCH
print "Turned off\n"; return;

require_once "db/dbw.php";
$filename = 'upload/mhimport.csv';
if (!file_exists($filename)) {
    print "File $filename doesn't exist...\n";
    return;
}
$file = fopen($filename, "r");
$num_rows = 0;
// This importer takes a csv with 3 columns: 1. Mice 2. Locations 3. Cheeses
while (! feof($file)) {
    $num_rows++;
    $row = fgetcsv($file);
//    print "Processing file row $num_rows...\n";
    // $row[0] is mouse name, row[1] are locations, row[2] are cheeses
    
    // Mice
    $mouse = strtoupper(trim($row[0]));

    if (empty($mouse))
        continue;

    $mouse = str_replace(' MOUSE', '', $mouse);
    // Check if mouse already exists, then skip it
    try {
        $result = $db->prepare("
            SELECT COUNT(*)
            FROM mice m
            WHERE m.name LIKE ?");
         $result->execute(array($mouse));
    } catch(PDOException $ex) {
        error_log($ex->getMessage());
    }
    $number_of_rows = $result->fetchColumn();

    if ($number_of_rows > 0) {
        print "Skipping existing mouse: $mouse\n";
        continue;
    }
//    print('Adding new mouse: ' . $mouse . "\n");

    //insert mouse into mice table
    try {
        $result = $db->prepare("INSERT IGNORE INTO `mice`(`name`) VALUES (?)");
        $result->execute(array($mouse));
    } catch(PDOException $ex) {
        error_log($ex->getMessage());
    }
    
    // Locations
    $row[1] = strtoupper($row[1]);
    $locations = explode("||", $row[1]);
    $locations = array_map('trim',$locations);

    foreach($locations as $location) {
        if (empty($location))
            continue;
        $stage = array('');

	if (preg_match('/^MANY\sLOCATIONS/', $location))
		$location = 'SEE WIKI';
	else if (preg_match('/^CALAMITY\sCARL/', $location))
		$location = "CALAMITY CARL'S CRUISE";
	else if (preg_match('/^FIERY\sWARPATH/', $location)) {
		list($location, $stage[0]) = explode("--", $location);
		if ($stage[0] == 'WAVES 1-3') {
			$stage[0] = 'WAVE 1';
			$stage[1] = 'WAVE 2';
			$stage[2] = 'WAVE 3';
		}
	}
	

	foreach ($stage as $st) {
	        //insert ignore location into locations table
	        try {
	            $result = $db->prepare("INSERT IGNORE INTO `locations`(`name`, `stage`) VALUES (?, ?)");
	            $result->execute(array($location, $st));
	        } catch(PDOException $ex) {
	            print($ex->getMessage());
	        }

	        //insert ignore mice.id, locations.id into mice_locations where mice.name = $mouse and locations.name = $location
	        try {
                    $query = "
	                INSERT IGNORE INTO `mice_locations` (`mice_id`, `locations_id`)
	                SELECT m.id, l.id
	                FROM mice m
	                INNER JOIN locations l ON l.name = ?
	                WHERE m.name = ?";
                    $query_params = array($location, $mouse);
                    if ($st != '') {
                        $query .= ' AND l.stage = ?';
                        $query_params[] = $st;
                    }
	            $result = $db->prepare($query);
	            $result->execute($query_params);
	        } catch(PDOException $ex) {
	            print($ex->getMessage());
	        }
	 }
    }
    
    // Cheese
    if (!array_key_exists(2, $row) || $row[2] == '') {
        $row[2] = 'REGULAR CHEESE';
    }
//  print "Processing $row[2] cheese\n";
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

         //insert ignore cheese into cheeses table
        try {
            $result = $db->prepare("INSERT IGNORE INTO `cheeses`(`name`) VALUES (?)");
            $result->execute(array($cheese));
        } catch(PDOException $ex) {
            error_log($ex->getMessage());
        }

        //insert ignore mice.id, cheese.id into mice_cheeses where mice.name = $mouse and cheese.name = $cheese
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

fclose($file);
print "Processed $num_rows\n";
print "Done!! Wooot! :)\n";

?>


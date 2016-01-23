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

// TRUNCATE ALL TABLES
$truncate_tables = array(
'cheeses',
'locations',
'mice',
'mice_cheeses',
'mice_locations',
);

foreach ($truncate_tables as $table) {
    $result = $db->prepare("TRUNCATE $table");
    $result->execute();
}

// Burroughs Rift stages
static $burroughs_rift_mice_stages = array(
    'AMPLIFIED BROWN'                   => array('MIST 0'),
    'AMPLIFIED GREY'                    => array('MIST 0'),
    'AMPLIFIED WHITE'                   => array('MIST 0'),
    'ASSASSIN BEAST'                    => array('MIST 19-20'),
    'AUTOMATED SENTRY'                  => array('MIST 0'),
    'BIG BAD BEHEMOTH BURROUGHS'        => array('MIST 19-20'),
    'BOULDER BITER'                     => array('MIST 6-18'),
    'CLUMP'                             => array('MIST 1-5', 'MIST 6-18'),
    'COUNT VAMPIRE'                     => array('MIST 1-5', 'MIST 6-18'),
    'CYBER MINER'                       => array('MIST 1-5', 'MIST 6-18'),
    'CYBERNETIC SPECIALIST'             => array('MIST 0'),
    'DOKTOR'                            => array('MIST 0'),
    'EVIL SCIENTIST'                    => array('MIST 0'),
    'ITTY BITTY RIFTY BURROUGHS'        => array('MIST 1-5', 'MIST 6-18'),
    'LAMBENT'                           => array('MIST 6-18'),
    'LYCANOID'                          => array('MIST 6-18'),
    'MASTER EXPLODER'                   => array('MIST 6-18'),
    'MECHA TAIL'                        => array('MIST 1-5', 'MIST 6-18'),
    'MONSTROUS ABOMINATION'             => array('MIST 19-20'),
    'PHASE ZOMBIE'                      => array('MIST 1-5', 'MIST 6-18'),
    'PLUTONIUM TENTACLE'                => array('MIST 19-20'),
    'PNEUMATIC DIRT DISPLACEMENT'       => array('MIST 1-5', 'MIST 6-18'),
    'PORTABLE GENERATOR'                => array('MIST 0'),
    'PROTOTYPE'                         => array('MIST 1-5', 'MIST 6-18'),
    'RADIOACTIVE OOZE'                  => array('MIST 1-5', 'MIST 6-18'),
    'RANCID BOG BEAST'                  => array('MIST 6-18', 'MIST 19-20'),
    'REVENANT'                          => array('MIST 6-18'),
    'RIFT BIO ENGINEER'                 => array('MIST 0'),
    'RIFTERRANIAN'                      => array('MIST 1-5', 'MIST 6-18'),
    'ROBAT'                             => array('MIST 1-5', 'MIST 6-18'),
    'SUPER MEGA MECHA ULTRA ROBOGOLD'   => array('MIST 6-18', 'MIST 19-20'),
    'SURGEON BOT'                       => array('MIST 0'),
    'TECH RAVENOUS ZOMBIE'              => array('MIST 1-5', 'MIST 6-18'),
    'THE MENACE OF THE RIFT'            => array('MIST 19-20'),
    'TOXIC AVENGER'                     => array('MIST 6-18', 'MIST 19-20'),
    'TOXIKINETIC'                       => array('MIST 1-5', 'MIST 6-18'),
    'ZOMBOT UNIPIRE THE THIRD'          => array('MIST 6-18')
);


// Whisker Woods Rift stages
static $whisker_woods_rift_mice_stages = array(
    'BLOOMED SYLVAN'        => array('CC 0-24',                         'GGT 0-24', 'GGT 25-49',    'GGT 50',   'DL 0-24',  'DL 25-49', 'DL 50' ),
    'CENTAUR RANGER'        => array('CC 0-24', 'CC 25-49', 'CC 50',                                'GGT 50',   'DL 0-24',  'DL 25-49', 'DL 50' ),
    'CHERRY SPRITE'         => array('CC 0-24', 'CC 25-49', 'CC 50',    'GGT 0-24', 'GGT 25-49',    'GGT 50',   'DL 0-24',  'DL 25-49', 'DL 50' ),
    'CRANKY CATERPILLAR'    => array('CC 0-24',                         'GGT 0-24', 'GGT 25-49',    'GGT 50',   'DL 0-24',  'DL 25-49', 'DL 50' ),
    'CRAZED GOBLIN'         => array('CC 0-24', 'CC 25-49', 'CC 50',    'GGT 0-24', 'GGT 25-49',    'GGT 50',   'DL 0-24'                       ),
    'CYCLOPS BARBARIAN'     => array(                       'CC 50',    'GGT 0-24', 'GGT 25-49',    'GGT 50',   'DL 0-24',  'DL 25-49', 'DL 50' ),
    'FUNGAL FROG'           => array('CC 0-24', 'CC 25-49', 'CC 50',    'GGT 0-24',                             'DL 0-24',  'DL 25-49', 'DL 50' ),
    'GILDED LEAF'           => array('CC 0-24', 'CC 25-49', 'CC 50',    'GGT 0-24', 'GGT 25-49',    'GGT 50',   'DL 0-24',  'DL 25-49', 'DL 50' ),
    'GRIZZLED SILTH'        => array('CC 0-24', 'CC 25-49', 'CC 50',    'GGT 0-24', 'GGT 25-49',    'GGT 50',   'DL 0-24',  'DL 25-49', 'DL 50' ),
    'KARMACHAMELEON'        => array('CC 0-24', 'CC 25-49', 'CC 50',    'GGT 0-24',                             'DL 0-24',  'DL 25-49', 'DL 50' ),
    'MEDICINE'              => array('CC 0-24', 'CC 25-49', 'CC 50',    'GGT 0-24', 'GGT 25-49',    'GGT 50',               'DL 25-49'          ),
    'MONSTROUS BLACK WIDOW' => array(           'CC 25-49', 'CC 50',                'GGT 25-49',    'GGT 50',               'DL 25-49', 'DL 50' ),
    'MOSSY MOOSKER'         => array('CC 0-24',                         'GGT 0-24', 'GGT 25-49',    'GGT 50',   'DL 0-24',  'DL 25-49', 'DL 50' ),
    'NATURALIST'            => array('CC 0-24', 'CC 25-49', 'CC 50',    'GGT 0-24', 'GGT 25-49',    'GGT 50',   'DL 0-24',  'DL 25-49', 'DL 50' ),
    'NOMADIC WARRIOR'       => array('CC 0-24', 'CC 25-49', 'CC 50',                'GGT 25-49',                'DL 0-24',  'DL 25-49', 'DL 50' ),
    'RED COAT BEAR'         => array('CC 0-24', 'CC 25-49', 'CC 50',                'GGT 25-49',                'DL 0-24',  'DL 25-49', 'DL 50' ),
    'RED-EYED WATCHER OWL'  => array(           'CC 25-49',             'GGT 0-24', 'GGT 25-49',    'GGT 50',   'DL 0-24',  'DL 25-49', 'DL 50' ),
    'RIFT TIGER'            => array('CC 0-24', 'CC 25-49', 'CC 50',                'GGT 25-49',                'DL 0-24',  'DL 25-49', 'DL 50' ),
    'SPIRIT FOX'            => array(           'CC 25-49',             'GGT 0-24', 'GGT 25-49',    'GGT 50',   'DL 0-24',  'DL 25-49', 'DL 50' ),
    'SPIRIT OF BALANCE'     => array('CC 0-24', 'CC 25-49', 'CC 50',    'GGT 0-24',                             'DL 0-24',  'DL 25-49', 'DL 50' ),
    'TREANT QUEEN'          => array(           'CC 25-49',             'GGT 0-24', 'GGT 25-49',    'GGT 50',   'DL 0-24',  'DL 25-49', 'DL 50' ),
    'TREE TROLL'            => array('CC 0-24', 'CC 25-49', 'CC 50',    'GGT 0-24', 'GGT 25-49',    'GGT 50',               'DL 25-49',         ),
    'TRI-DRA'               => array('CC 0-24', 'CC 25-49', 'CC 50',    'GGT 0-24', 'GGT 25-49',    'GGT 50',                           'DL 50' ),
    'TWISTED TREANT'        => array('CC 0-24', 'CC 25-49', 'CC 50',    'GGT 0-24', 'GGT 25-49',    'GGT 50',   'DL 0-24',                      ),
    'WATER SPRITE'          => array('CC 0-24', 'CC 25-49', 'CC 50',    'GGT 0-24', 'GGT 25-49',    'GGT 50',   'DL 0-24',                      ),
    'WINGED HARPY'          => array('CC 0-24', 'CC 25-49', 'CC 50',    'GGT 0-24', 'GGT 25-49',    'GGT 50',               'DL 25-49',         ),
);

// This importer takes a csv with 3 columns: 1. Mice 2. Locations 3. Cheeses
while (!feof($file)) {
    $num_rows++;
    $row = fgetcsv($file);

    //    print "Processing file row $num_rows...\n";
    // $row[0] is mouse name, row[1] are locations, row[2] are cheeses

    // Mice
    $mouse = strtoupper(trim($row[0]));

    if (empty($mouse)) continue;

    $mouse = str_replace(' MOUSE', '', $mouse);

    // Check if mouse already exists, then skip it
    try {
        $result = $db->prepare("
            SELECT COUNT(*)
            FROM mice m
            WHERE m.name LIKE ?");
        $result->execute(array($mouse));
    }
    catch(PDOException $ex) {
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
    }
    catch(PDOException $ex) {
        error_log($ex->getMessage());
    }

    // Locations
    $row[1] = strtoupper($row[1]);
    $locations = explode("||", $row[1]);
    $locations = array_map('trim', $locations);

    foreach ($locations as $location) {
        if (empty($location)) continue;
        $stage = array('');

        if (preg_match('/^MANY\sLOCATIONS/', $location)) $location = 'SEE WIKI';
        else if (preg_match('/^CALAMITY\sCARL/', $location)) $location = "CALAMITY CARL'S CRUISE";
        else if (preg_match('/^FIERY\sWARPATH/', $location)) {
            list($location, $stage[0]) = explode("--", $location);
            if ($stage[0] == 'WAVES 1-3') {
                $stage[0] = 'WAVE 1';
                $stage[1] = 'WAVE 2';
                $stage[2] = 'WAVE 3';
            }
        }
        else if (preg_match('/^BURROUGHS\sRIFT/', $location)) {
            if (array_key_exists($mouse, $burroughs_rift_mice_stages)) {
                foreach($burroughs_rift_mice_stages[$mouse] as $id => $stg) {
                    $stage[$id] = $stg;
                }
            }
        }
        else if (preg_match('/^WHISKER\sWOODS\sRIFT/', $location)) {
            if (array_key_exists($mouse, $whisker_woods_rift_mice_stages)) {
                foreach($whisker_woods_rift_mice_stages[$mouse] as $id => $stg) {
                    $stage[$id] = $stg;
                }
            }
        }

        foreach ($stage as $st) {

            //insert ignore location into locations table
            try {
                $result = $db->prepare("INSERT IGNORE INTO `locations`(`name`, `stage`) VALUES (?, ?)");
                $result->execute(array($location, $st));
            }
            catch(PDOException $ex) {
                print ($ex->getMessage());
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
                    $query.= ' AND l.stage = ?';
                    $query_params[] = $st;
                }
                $result = $db->prepare($query);
                $result->execute($query_params);
            }
            catch(PDOException $ex) {
                print ($ex->getMessage());
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
    $cheeses = array_map('trim', $cheeses);

    $cheese_count = 0;
    foreach ($cheeses as $cheese) {
        if (empty($cheese)) {
            if ($cheese_count == 0) $cheese = 'REGULAR CHEESE';
            else continue;
        }

        //insert ignore cheese into cheeses table
        try {
            $result = $db->prepare("INSERT IGNORE INTO `cheeses`(`name`) VALUES (?)");
            $result->execute(array($cheese));
        }
        catch(PDOException $ex) {
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
        }
        catch(PDOException $ex) {
            error_log($ex->getMessage());
        }
        $cheese_count++;
    }
}

fclose($file);
print "Processed $num_rows\n";
print "Done!! Wooot! :)\n";
?>


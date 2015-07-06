<?php

require_once "__FILE__/../db/db.php";

class Mouse
{
    public $name = '';
    public $id = '';
    public $mouse_wiki_url = '';
    public $locations = array();
    public $cheeses = array();
    public $is_valid = false;

    public function retrieve($mouse_name)
    {
        global $db;
        $this->name = '';
        $this->id = '';
        $this->locations = array();
        $this->cheeses = array();
        $this->is_valid = false;

        if (empty($mouse_name)) {
            return;
        }

        try {
            $result = $db->prepare("
                SELECT m.id as mouse_id, l.id as location_id, l.name as location, l.stage, c.id as cheese_id, c.name as cheese
                FROM mice m
                INNER JOIN mice_locations ml ON ml.mice_id = m.id
                INNER JOIN locations l ON l.id = ml.locations_id
                INNER JOIN mice_cheeses mc ON mc.mice_id = m.id
                INNER JOIN cheeses c ON c.id = mc.cheeses_id
                WHERE m.name LIKE ?");

            $result->execute(array($mouse_name));
        } catch(PDOException $ex) {
            error_log($ex->getMessage());
        }

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $this->name = $mouse_name;
            $this->id = $row['mouse_id'];
            $mouse_wiki_url = str_replace(' ', '_', ucwords(strtolower($mouse_name)));
            $this->mouse_wiki_url = (substr($mouse_name, -5, 5) === 'MOUSE' ? $mouse_wiki_url : $mouse_wiki_url . '_Mouse');
            $this->mouse_wiki_url = 'http://mhwiki.hitgrab.com/wiki/index.php/' . $this->mouse_wiki_url;
            $this->locations[$row['location_id']] = array('name' => $row['location'], 'stage' => $row['stage']);
            $this->cheeses[$row['cheese_id']] = $row['cheese'];
            $this->is_valid = true;
        }
    }
}

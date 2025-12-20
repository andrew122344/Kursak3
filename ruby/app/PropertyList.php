<?php
require_once('BaseList.php');
require_once('Property.php');
require_once('DBConnect.php');
class PropertyList extends BaseList{
    public function add($params){
        $elem=new Property($params['id'],$params['name'],$params['units']);
        array_push($this->list, $elem);
    }
    public function getAllFromDatabase(){
        global $conn;
        $sql = "SELECT * FROM properties";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $this->add($row);
        }
        }
    }
}
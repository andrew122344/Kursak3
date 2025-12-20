<?php
require_once('BaseList.php');
require_once('ApplTime.php');
require_once('DBConnect.php');
class ApplTimeList extends BaseList{
	public function add($params){
        $elem=new ApplTime($params['id'],$params['name']);
        array_push($this->list, $elem);
    }
    public function getAllFromDatabase(){
        global $conn;
        $sql = "SELECT * FROM applstime";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $this->add($row);
        }
        }
    }
}
?>
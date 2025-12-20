<?php
require_once('BaseList.php');
require_once('SphrofAppl.php');
require_once('DBConnect.php');
class SphrofApplList extends BaseList{
	public function add($params){
        $elem=new SphrofAppl($params['id'],$params['name']);
        array_push($this->list, $elem);
    }    
    public function getAllFromDatabase(){
        global $conn;
        $sql = "SELECT * FROM sphrsofappl";
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
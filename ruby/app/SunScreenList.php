<?php
require_once('BaseList.php');
require_once('SunScreen.php');
require_once('DBConnect.php');
class SunScreenList extends BaseList{
	public function add($params){
        $elem=new SunScreen($params['id'],$params['name'],$params['vendor'],$params['price'],$params['appltimeid'],$params['appltimename'],$params['sphrofapplid'],$params['sphrofapplname']);
        array_push($this->list, $elem);
    }
   
    public function getAllFromDatabase(){
        global $conn;
        $sql = "SELECT sunscreens.*, applstime.name appltimename, sphrsofappl.name sphrofapplname FROM sunscreens
        INNER JOIN applstime ON applstime.id=sunscreens.appltimeid 
        INNER JOIN sphrsofappl ON sphrsofappl.id=sunscreens.sphrofapplid";
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
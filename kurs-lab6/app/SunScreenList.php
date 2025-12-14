<?php
require_once('BaseList.php');
require_once('SunScreen.php');
require_once('DBConnect.php');
class SunScreenList extends BaseList{
	public function add($params){
        $elem=new SunScreen($params['id'],$params['name'],$params['vendor'],$params['price'],$params['appltimeid'],$params['appltimename'],$params['sphrofapplid'],$params['sphrofapplname']);
        array_push($this->list, $elem);
    }
    public function update($params){
        for ($i=0;$i<count($this->list);$i++){
            if($this->list[$i]->getId()==$params['id']){
                $this->list[$i]->update($params['name'],$params['vendor'],$params['price'],$params['applTimeid'],$params['sphrofApplid']);
                break;
            }
        }
    }
    public function getAsJSON(){
        $content='{
    "sunScreens": [';
        for ($i=0;$i<count($this->list);$i++){
            $content.=$this->list[$i]->getAsJSON().",";
        }
        $content = substr($content, 0, -1);
        $content.='    ]
        }';
        return $content;
    }
    public function getAsXML(){
        $content='<sunscreens>
        ';
        for ($i=0;$i<count($this->list);$i++){
            $content.=$this->list[$i]->getAsXML();
        }
        $content.='</sunscreens>';
        return $content;
    }
	public function readFromCSV($filePath){
        $fp = fopen($filePath, 'r');
        if ($fp === false) {
            die('Error: Cannot open the CSV file.');
        }
        while (($row = fgetcsv($fp,10000,",","`","\\")) !== false) {
            $this->add(['name'=>$row[0], 'vendor'=>$row[1],'price'=>$row[2],'applTimeid'=>$row[3],'sphrofApplid'=>$row[4]]);
        }
        fclose($fp);
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
    public function getAllFromDatabaseById($id){
        global $conn;
        $stmt = $conn->prepare("SELECT sunscreens.*, applstime.name appltimename, sphrsofappl.name sphrofapplname FROM sunscreens
        INNER JOIN applstime ON applstime.id=sunscreens.appltimeid 
        INNER JOIN sphrsofappl ON sphrsofappl.id=sunscreens.sphrofapplid WHERE id=?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            return $row;
        }
        } else{
            return null;
        }
    }
    public function addSunScreenProperty($sunscreenid,$propertyid,$value){
        global $conn;
        $stmt = $conn->prepare("INSERT INTO sunscreens_properties VALUES (DEFAULT, ?,?,?)");
        $stmt->bind_param("sss", $sunscreenid,$propertyid, $value);
        $stmt->execute();
        return $conn->insert_id;
    }
    public function updateSunScreenProperty($sunscreenid,$propertyid,$value){
        global $conn;
        $stmt = $conn->prepare("UPDATE `sunscreens_properties` SET `value`=? WHERE `sunscreenid`=? and `propertyid`=?;");
        $stmt->bind_param("sss", $value,$sunscreenid,$propertyid);
        $stmt->execute();
    }
    public function insertIntoDatabase($params){
        global $conn;
        $stmt = $conn->prepare("INSERT INTO sunscreens VALUES (DEFAULT, ?,?,?,?,?)");
        $stmt->bind_param("ssdss", $params['vendor'],$params['name'],$params['price'],$params['appltimeid'],$params['sphrofapplid']);
        $stmt->execute();
        return $conn->insert_id;
    }
    public function updateDatabaseById($params){
        global $conn;
        $stmt = $conn->prepare("UPDATE `sunscreens` SET `vendor`=?, `name`=?,`price`=?, `appltimeid`=?, `sphrofapplid`=? WHERE `id`=?;");
        $stmt->bind_param("ssdsss", $params['vendor'],$params['name'],$params['price'],$params['appltimeid'],$params['sphrofapplid'],$params['id']);
        $stmt->execute();
    }
    public function deleteFromDatabaseById($id){
        global $conn;
        $stmt = $conn->prepare("DELETE FROM sunscreens WHERE id=?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
    }
    public function getSunScreenPropertiesById($id){
        for ($i=0;$i<count($this->list);$i++){
            if($this->list[$i]->getId()==$id){
                return $this->list[$i]->getSunScreensProperties();
            }
        }
    }
}
?>
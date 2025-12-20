<?php
require_once('BaseEntity.php');
require_once('DBConnect.php');
class SunScreen extends BaseEntity{
    private $name;
    private $vendor;
    private $price;
	private $applTimeid;
    private $applTimename;
	private $sphrofApplid;
    private $sphrofApplname;
    public function __construct($id,$name,$vendor,$price,$applTimeid,$applTimename,$sphrofApplid,$sphrofApplname){
        $this->id=$id;
        $this->name=$name;
        $this->vendor=$vendor;
        $this->price=$price;
        $this->applTimeid=$applTimeid;
        $this->applTimename=$applTimename;
        $this->sphrofApplid=$sphrofApplid;
        $this->sphrofApplname=$sphrofApplname;
    }
    public function __destruct(){
        $this->id=null;
        $this->name=null;
        $this->vendor=null;
        $this->price=null;
        $this->applTimeid=null;
		$this->sphrofApplid=null;
    }
    public function getSunScreensProperties(){
        global $conn;
        $stmt = $conn->prepare("SELECT sunscreens_properties.*, properties.name, properties.units FROM sunscreens_properties
        INNER JOIN properties ON properties.id=sunscreens_properties.propertyid WHERE sunscreenid=?");
        $stmt->bind_param("s", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        $array=[];
        if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            array_push($array,$row);
        }
        } 
        return $array;
    }
    public function getAsTableRow(){
        $propArray=$this->getSunScreensProperties();
        $propertiesContent='';
        for($i=0;$i<count($propArray);$i++){
            $propertiesContent.=$propArray[$i]['name'].': '.$propArray[$i]['value'].' '.$propArray[$i]['units'].'</br>';
        }
        return '<tr>
                    <td>'.$this->id.'</td>
                    <td>'.$this->name.'</td>
                    <td>'.$this->vendor.'</td>
                    <td>'.$this->applTimename.'</td>
                    <td>'.$this->sphrofApplname.'</td>
                    <td>'.$this->price.'</td>
                    <td>'.$propertiesContent.'</td>
                </tr>';
    }
}
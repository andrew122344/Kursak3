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
    public function display(){
        echo $this->id.". ".$this->vendor." ".$this->name."</br>";
        echo "Час застосування: <i>".$this->applTimeid."</i></br>";
		echo "Сфера застосування: <i>".$this->sphrofApplid."</i></br>";
        echo "Ціна: <b>".$this->price."</b> грн</br>";
    }
    public function update($name,$vendor,$price,$applTimeid,$sphrofApplid){
        $this->name=$name;
        $this->vendor=$vendor;
        $this->price=$price;
        $this->applTimeid=$applTimeid;
        $this->sphrofApplid=$sphrofApplid;
    }
    public function __destruct(){
        $this->id=null;
        $this->name=null;
        $this->vendor=null;
        $this->price=null;
        $this->applTimeid=null;
		$this->sphrofApplid=null;
    }
    public function getAsJSON(){
        return '{
            "id": "'.$this->id.'",
            "name": "'.$this->name.'",
            "vendor": "'.$this->vendor.'",
            "price": "'.$this->price.'",
            "applTimeid": "'.$this->applTimeid.'",
            "applTimename": "'.$this->applTimename.'",
            "sphrofApplid": "'.$this->sphrofApplid.'",
            "sphrofApplname": "'.$this->sphrofApplname.'",
            "properties":'.json_encode($this->getSunScreensProperties()).'
        }';
    }
    public function getAsXML(){
        return '<sunscreen>
                    <id>'.$this->id.'</id>
                    <name>'.$this->name.'</name>
                    <vendor>'.$this->vendor.'</vendor>
                    <price>'.$this->price.'</price>
                    <workPrinc>'.$this->applTimeid.'</workPrinc>
                    <sphereOfAppl>'.$this->sphrofApplid.'</sphereOfAppl>
                </sunscreen>';
    }
    public function getAsAssociativeArray(){
        return [
                'id'=>$this->id,
                'name'=>$this->name,
                'vendor'=>$this->vendor,
                'price'=>$this->price,
                'applTimeid'=>$this->applTimeid,
                'sphrofApplid'=>$this->sphrofApplid
                ];
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
                    <td>
                        <a class="btn btn-warning" href="./SunScreens.php?action=update&id='.$this->id.'">Редагувати</a>
                        <a class="btn btn-danger" href="./SunScreens.php?action=delete&id='.$this->id.'">Видалити</a>
                    </td>
                </tr>';
    }
    public function getAsIndexedArray(){
        return [$this->name,$this->vendor,$this->price,$this->applTimeid,$this->sphrofApplid];
    }
}
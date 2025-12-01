<?php
require_once('BaseEntity.php');
class SunScreen extends BaseEntity{
    private $name;
    private $vendor;
    private $price;
    private $applTime;
    private $sphrofAppl;
    private $properties;
    public function __construct($id, $name,$vendor,$price,$applTime,$sphrofAppl,$properties){
        $this->id=$id;
        $this->name=$name;
        $this->vendor=$vendor;
        $this->price=$price;
        $this->applTime=$applTime;
        $this->sphrofAppl=$sphrofAppl;
        $this->properties=$properties;
    }
        public function display(){
        echo $this->id.". ".$this->vendor." ".$this->name."</br>";
        echo "Час застосування: <i>".$this->applTime."</i></br>";
		echo "Сфера застосування: <i>".$this->sphrofAppl."</i></br>";
        echo "Ціна: <b>".$this->price."</b> грн</br>";
        echo "<b>Характеристики:</b></br>";
        foreach (json_decode($this->properties) as $propertyName => $propertyValue) {
            echo $propertyName . ": " . $propertyValue . "</br>";
        }
    }
    public function update($name,$vendor,$price,$applTime,$sphrofAppl,$properties){
        $this->name=$name;
        $this->vendor=$vendor;
        $this->price=$price;
        $this->applTime=$applTime;
        $this->sphrofAppl=$sphrofAppl;
        $this->properties=$properties;
    }
    public function __destruct(){
   	    $this->id=null;
        $this->name=null;
		$this->vendor=null;
		$this->price=null;
		$this->applTime=null;
		$this->sphrofAppl=null;
		$this->properties=null;
    }
    public function getAsJSON(){
        return '{
            "id": "'.$this->id.'",
            "name": "'.$this->name.'",
            "vendor": "'.$this->vendor.'",
            "price": "'.$this->price.'",
            "applTime": "'.$this->applTime.'",
            "sphrofAppl": "'.$this->sphrofAppl.'",
            "properties": '.$this->properties.'
        }';
    }
    public function getAsXML(){
        $properties='';
        foreach (json_decode($this->properties) as $propertyName => $propertyValue) {
            $properties.='<property>
                            <name>'.$propertyName.'</name>
                            <value>'.$propertyValue.'</value>
            </property>';
        }
        return '<sunscreen>
                    <id>'.$this->id.'</id>
                    <name>'.$this->name.'</name>
                    <vendor>'.$this->vendor.'</vendor>
                    <price>'.$this->price.'</price>
                    <appltime>'.$this->applTime.'</appltime>
                    <sphrofappl>'.$this->sphrofAppl.'</sphrofappl>
                    <properties>'.$properties.'</properties>
                </sunscreen>';
    }
    public function getAsAssociativeArray(){
        return [
                'id'=>$this->id,
                'name'=>$this->name,
                'vendor'=>$this->vendor,
                'price'=>$this->price,
                'applTime'=>$this->applTime,
                'sphrofAppl'=>$this->sphrofAppl,
                'properties'=>$this->properties
                ];
    }
    public function getAsTableRow(){
        $properties="";
        foreach (json_decode($this->properties) as $propertyName => $propertyValue) {
            $properties.= $propertyName . ": " . $propertyValue . "</br>";
        }
        return '<tr>
                    <td>'.$this->id.'</td>
                    <td>'.$this->name.'</td>
                    <td>'.$this->vendor.'</td>
                    <td>'.$this->applTime.'</td>
                    <td>'.$this->sphrofAppl.'</td>
                    <td>'.$this->price.'</td>
                    <td>'.$properties.'</td>
                    <td>
                        <a class="btn btn-warning" href="./SunScreens.php?action=update&id='.$this->id.'">Редагувати</a>
                        <a class="btn btn-danger" href="./SunScreens.php?action=delete&id='.$this->id.'">Видалити</a>
                    </td>
                </tr>';
    }
    public function getAsIndexedArray(){
        return [$this->name,$this->vendor,$this->price,$this->applTime,$this->sphrofAppl,$this->properties];
    }
}
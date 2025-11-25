<?php
require_once('BaseEntity.php');
class SunScreen extends BaseEntity{
    private $name;
    private $vendor;
    private $price;
	private $applTime;
	private $sphrofAppl;
    private $properties;
    
      public function __construct($params){
        $this->id=$params['id'];
        $this->name=$params['name'];
		$this->vendor=$params['vendor'];
		$this->price=$params['price'];
		$this->applTime=$params['applTime'];
		$this->sphrofAppl=$params['sphrofAppl'];
		$this->properties=$params['properties'];
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
    public function update($params){
		$this->id=$params['id'];
        $this->name=$params['name'];
		$this->vendor=$params['vendor'];
		$this->price=$params['price'];
		$this->applTime=$params['applTime'];
		$this->sphrofAppl=$params['sphrofAppl'];
		$this->properties=$params['properties'];
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
    public function getAsIndexedArray(){
        return [$this->id,$this->name,$this->vendor,$this->price,$this->applTime,$this->sphrofAppl,$this->properties];
    }
}
?>
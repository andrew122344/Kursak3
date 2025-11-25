<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
abstract class BaseEntity{
    protected $id;
    public abstract function display();
	public abstract function update($params);
	public function getId(){
		return $this->id;
	}
}
abstract class BaseList{
	protected $lastId;
	protected $list;
	public function __construct(){
		$this->lastId=1;
		$this->list=array();
	}
	public abstract function add($params);
	public function display(){
		for($i=0;$i<count($this->list);$i++){
			$this->list[$i]->display();
		}
	}
	public function update($params){
		for($i=0;$i<count($this->list);$i++){
			if($this->list[$i]->getId()==$params['id']){
				$this->list[$i]->update($params);
				break;
			}
		}
	}
	public function delete($id){
		for($i=0;$i<count($this->list);$i++){
			if($this->list[$i]->getId()==$id){
				array_splice($this->list,$i,1);
				break;
			}
		}
	}
}
class ApplTime extends BaseEntity {
    private $name;      
    public function __construct($params){
        $this->id = $params['id'];
        $this->name = $params['name'];
    }
    public function display(){
        echo $this->id.". ".$this->name."</br>";
    }
    public function update($params){
        $this->id = $params['id'];
        $this->name = $params['name'];
    }
    public function __destruct(){
        $this->id = null;
        $this->name = null;
    }
}
class SphrOfAppl extends BaseEntity{
    private $name;
    public function __construct($params){
        $this->id=$params['id'];
        $this->name=$params['name'];
    }
    public function display(){
        echo $this->id.". ".$this->name."</br>";
    }
    public function update($params){
        $this->id=$params['id'];
        $this->name=$params['name'];
    }
    public function __destruct(){
        $this->id=null;
        $this->name=null;
    }
}
class Property extends BaseEntity{
    private $name;
    private $units;
    public function __construct($params){
        $this->id=$params['id'];
        $this->name=$params['name'];
		$this->units=$params['units'];
    }
    public function display(){
        echo $this->id.". ".$this->name." <i>(".$this->units.")</i></br>";
    }
    public function update($params){
        $this->id=$params['id'];
        $this->name=$params['name'];
		$this->units=$params['units'];
    }
    public function __destruct(){
        $this->id=null;
        $this->name=null;
        $this->units=null;
    }
}
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
}
class ApplTimeList extends BaseList{
	public function add($params){
		$params['id']=$this->lastId;
		$newObj=new ApplTime($params);
		array_push($this->list,$newObj);
		$this->lastId++;
	}
}
class SphrOfApplList extends BaseList{
	public function add($params){
		$params['id']=$this->lastId;
		$newObj=new SphrOfAppl($params);
		array_push($this->list,$newObj);
		$this->lastId++;
	}
}
class PropertyList extends BaseList{
	public function add($params){
		$params['id']=$this->lastId;
		$newObj=new Property($params);
		array_push($this->list,$newObj);
		$this->lastId++;
	}
}
class SunScreenList extends BaseList{
	public function add($params){
		$params['id']=$this->lastId;
		$newObj=new SunScreen($params);
		array_push($this->list,$newObj);
		$this->lastId++;
	}
}

$c=new SunScreenList();
$c->add(
	[
		'name'=>'Активний загар',
		'vendor'=>'Биокон',
		'price'=>'155',
		'applTime'=>'Універсальні',
		'sphrofAppl'=>'Для тіла',
		'properties'=>'{"SPF": "6", "Вікова категорія": "18+ Роки ", "Консистенція": "Масло", "Країна-виробник: ": "Україна", "Об’єм упаковки": "160 Мл"  }'
	]
);
$c->add(
	[
		'name'=>'Дитячий сонцезахисний спрей',
		'vendor'=>'BABE Laboratorios Pediatric',
		'price'=>'970',
		'applTime'=>'Універсальні',
		'sphrofAppl'=>'Для тіла',
		'properties'=>'{"SPF": "50", "Вікова категорія": "3+ Роки", "Консистенція": "Спрей", "Країна-виробник: ": "Іспанія", "Об’єм упаковки": "200 Мл"  }'
	]
);
$c->display();
$c->update(
	[
		'id'=>'2',
		'name'=>'Дитячий сонцезахисний спрей',
		'vendor'=>'BABE Laboratorios Pediatric',
		'price'=>'1078',
		'applTime'=>'Універсальні',
		'sphrofAppl'=>'Для тіла',
		'properties'=>'{"SPF": "50", "Вікова категорія": "3+ Роки", "Консистенція": "Спрей", "Країна-виробник: ": "Іспанія", "Об’єм упаковки": "200 Мл"  }'
	]
);
$c->display();
$c->delete(1);
$c->display();
?>
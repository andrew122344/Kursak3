<?php
require_once('BaseEntity.php');
class Property extends BaseEntity{
    private $name;
    private $units;
    public function __construct($id, $name, $units){
        $this->id=$id;
        $this->name=$name;
        $this->units=$units;
    }
    public function getAsTableRow(){
        return '<tr>
                    <td>'.$this->id.'</td>
                    <td>'.$this->name.'</td>
                    <td>'.$this->units.'</td>
                </tr>';
    }
    public function __destruct(){
        $this->id=null;
        $this->name=null;
        $this->units=null;
    }
}
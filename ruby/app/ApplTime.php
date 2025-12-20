<?php
require_once('BaseEntity.php');
class ApplTime extends BaseEntity{
    private $name;
    public function __construct($id, $name){
        $this->id=$id;
        $this->name=$name;
    }
    public function getAsTableRow(){
        return '<tr>
                    <td>'.$this->id.'</td>
                    <td>'.$this->name.'</td>
                </tr>';
    }
    public function __destruct(){
        $this->id=null;
        $this->name=null;
    }
}
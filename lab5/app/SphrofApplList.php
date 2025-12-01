<?php
require_once('BaseList.php');
require_once('SphrofAppl.php');
class SphrofApplList extends BaseList{
    public function add($params){
        $this->lastId++;
        $elem=new SphrofAppl($this->lastId,$params['name']);
        array_push($this->list, $elem);
    }
    public function update($params){
        for ($i=0;$i<count($this->list);$i++){
            if($this->list[$i]->getId()==$params['id']){
                $this->list[$i]->update($params['name']);
                break;
            }
        }
    }
    public function getAsJSON(){
        $content='{
    "sphrsofAppl": [';
        for ($i=0;$i<count($this->list);$i++){
            $content.=$this->list[$i]->getAsJSON().",";
        }
        $content = substr($content, 0, -1);
        $content.='    ]
        }';
        return $content;
    }
    public function getAsXML(){
        $content='<sphrsofAppl>
        ';
        for ($i=0;$i<count($this->list);$i++){
            $content.=$this->list[$i]->getAsXML();
        }
        $content.='</sphrsofAppl>';
        return $content;
    }
    public function readFromCSV($filePath){
        $fp = fopen($filePath, 'r');
        if ($fp === false) {
            die('Error: Cannot open the CSV file.');
        }
        while (($row = fgetcsv($fp,10000,",","`","\\")) !== false) {
            $this->add(['name'=>$row[0]]);
        }
        fclose($fp);
    }
    
    
}
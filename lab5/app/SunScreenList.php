<?php
require_once('BaseList.php');
require_once('SunScreen.php');
class SunScreenList extends BaseList{
    public function add($params){
        $this->lastId++;
        $elem=new SunScreen($this->lastId,$params['name'],$params['vendor'],$params['price'],$params['applTime'],$params['sphrofAppl'],$params['properties']);
        array_push($this->list, $elem);
    }
    public function update($params){
        for ($i=0;$i<count($this->list);$i++){
            if($this->list[$i]->getId()==$params['id']){
                $this->list[$i]->update($params['name'],$params['vendor'],$params['price'],$params['applTime'],$params['sphrofAppl'],$params['properties']);
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
            $this->add(['name'=>$row[0], 'vendor'=>$row[1],'price'=>$row[2],'applTime'=>$row[3],'sphrofAppl'=>$row[4],'properties'=>$row[5]]);
        }
        fclose($fp);
    }
    
}
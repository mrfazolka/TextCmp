<?php
namespace App\Components\TextDbParamCmp\Model;

class Texty extends \App\Model\Table{
    /** @var string */
    protected $tableName = 'cmp_text';
    
    public function insert($values)
    {
//        return isset($values->id) ? $this->getTable()
//                    ->insert(array(
//			"id" => $values->id,
//                        "text"=>$values->text,
//        )) 
//	    :
//	$this->getTable()
//                    ->insert(array(
//                        "text"=>$values->text,
//        ));
	
	return $this->getTable()
                    ->insert(array(
//			"id" => $values->id,
                        "text"=>$values->text,
        ));
    }
    
    public function update($id, $text)
    {
        return $this->getTable()
                    ->where("id", $id)
                    ->update(array(
                        'text' => $text
        ));
    }
}
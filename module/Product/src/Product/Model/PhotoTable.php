<?php

namespace Product\Model;

use Zend\Db\TableGateway\TableGateway;
use Product\Model\Photo;

class PhotoTable
{
	protected $tableGateway;

     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
     }

	public function getPhotosByProductId($productId)
	{
	$productId = (int) $productId;
	$rowset = $this->tableGateway->select(
	array('product_id' => $productId));
	return $rowset;
	}
	public function savePhoto(Photo $photo){
		$data = array(
             'photo_url' => $photo->photo_url,
            );

        $id = (int) $photo->id;
         if ($id == 0) {
             $this->tableGateway->insert($data);
         } else {
             if ($this->getPhoto($id)) {
                 $this->tableGateway->update($data, array('id' => $id));
             } else {
                 throw new \Exception('Photo id does not exist');
             }
         }

	}
	public function fetchAll(){
	$resultSet = $this->tableGateway->select();
	return $resultSet;
	}
	public function deletePhoto($id){
	$this->tableGateway->delete(array('id' => $id));
	}
	public function getPhoto($id){
	$id = (int) $id;
	$rowset = $this->tableGateway->select(array('id' => $id));
	$row = $rowset->current();
	if (!$row) {
	throw new \Exception("Could not find row $id");
	}
	return $row;	
}

}
?>
<?php

namespace Product\Model;

use Zend\Db\TableGateway\TableGateway;
use Product\Model\Category;

class CategoryTable 
{
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}

	public function fetchAll()
	{
		$resultSet = $this->tableGateway->select();
		return $resultSet;
	}

	public function getCategoryNames()
	{
		$results = $this->fetchAll();
		$categories = array();

		foreach ($results as $result) {
			$categories[$result->id] = $result->name;
		}

		return $categories;
	}

	public function getCategory($id) {
		$id = (int) $id;
		$rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
	
}



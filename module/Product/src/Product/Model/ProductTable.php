<?php
namespace Product\Model;

 use Zend\Db\TableGateway\TableGateway;

 class ProductTable
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


     public function getProduct($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
         }
         return $row;
     }

     public function getProductByCategory($category_id)
     {
        $category_id = (int) $category_id;
        $rowset->this->tableGateway->select(array('category_id' => $category_id));
        $row = $rowset->current();
        if(!$row) {
            throw new \Exception("Count not find row $category_id");
        }
        return $row;
     }

     public function saveProduct(Product $product)
     {
         $data = array(
             'title'        => $product->title,
             'description'  => $product->description,
             'phone'        => $product->phone,
             'email'        => $product->email,
             'location'     => $product->location,
             'shipping'     => $product->shipping,
             'price'        => $product->price,
             'top'          => $product->top,
             'category_id'  => $product->category_id,
            );

        $id = (int) $product->id;
         if ($id == 0) {
             $this->tableGateway->insert($data);
         } else {
             if ($this->getProduct($id)) {
                 $this->tableGateway->update($data, array('id' => $id));
             } else {
                 throw new \Exception('Product id does not exist');
             }
         }
     }

     public function deleteProduct($id)
     {
         $this->tableGateway->delete(array('id' => (int) $id));
     }
 }
 ?>
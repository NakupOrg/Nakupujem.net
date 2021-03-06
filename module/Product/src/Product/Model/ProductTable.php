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

     public function getProductsByUser($id)
     {
        $id = (int) $id;
        $resultSet = $this->tableGateway->select(array('user_id' => $id));
        return $resultSet;
     }


     public function getProductsByCategory($category_id)
     {
        $category_id = (int) $category_id;
        $resultSet = $this->tableGateway->select(array('category_id' => $category_id));
        return $resultSet;
     }

     public function saveProduct(Product $product)
     {
         $data = array(
             'title'        => $product->title,
             'description'  => $product->description,
             'phone'        => $product->phone,
             'email'        => $product->email,
             'user_id'      => $product->user_id,
             'location'     => $product->location,
             'shipping'     => $product->shipping,
             'price'        => $product->price,
             'top'          => $product->top,
             'category_id'  => $product->category_id,
             'foto1'        => $product->foto1,
             'foto2'        => $product->foto2,
             'foto3'        => $product->foto3,
             'foto4'        => $product->foto4,
             'foto5'        => $product->foto5,

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
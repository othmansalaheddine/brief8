<?php
require 'C:/xampp/htdocs/OOP_electro/database/connexion.php';
require 'C:/xampp/htdocs/OOP_electro/products.php';

class productsDAO{
    private $pdo;
    
    public function __construct(){
        $this->pdo = Database::getInstance()->getConnection(); 
        
    }
    
    public function add_Product($name,$old_price,$new_price,$image,$stock,$country,$city,$nbachat,$category){
        $add_Product = "INSERT INTO product (name,old_price,new_price,image,stock,country,city,nbachat,category)
        VALUES ($name,$old_price,$new_price,$image,$stock,$country,$city,$nbachat,$category);";
        $stmt = $this->pdo->prepare($add_Product);
        $stmt->execute();
    }


    // public function get_products(){
    //     $database = new Database('localhost','root','123','ELECTROTHMAN');
    //     $query = "SELECT * FROM product";
    //     $stmt = $database->executeQuery($query);
       
    //     $stmt->execute();
    //     $productsDATA = $stmt->fetchALL();
    //     $products = array();
    //     foreach($productsDATA as $product){
    //         $products[] = new Products(0,$product['name'],$product['old_price'],$product['new_price'],$product['image'],$product['stock'],$product['country'],$product['city'],$product['nbachat'],$product['category']);
    //     }

    //     return $products;
    // }

            public function get_products()
        {
            $database = new Database('localhost', 'root', '123', 'ELECTROTHMAN');
            $query = "SELECT * FROM product";
            $productsDATA = $database->executeQuery($query);

            $products = array();
            foreach ($productsDATA as $product) {
                $products[] = new Products(0, $product['name'], $product['old_price'], $product['new_price'], $product['image'], $product['stock'], $product['country'], $product['city'], $product['nbachat'], $product['category']);
            }

            return $products;
        }


    public function update_Product($id,$name,$old_price,$new_price,$image,$stock,$country,$city,$nbachat,$category){
        $update_Product = "UPDATE product SET name = '$name',
                                    old_price = '$old_price',
                                    new_price = '$new_price',
                                    image = '$image',
                                    stock = '$stock',
                                    country = '$country',
                                    city ='$city',
                                    nbachat = '$nbachat',
                                    category = '$category',
                                    
                                    WHERE id = '$id'";   
        $stmt = $this->pdo->query($update_Product);
        $stmt->execute();
    }

    public function Delete_product($id){
        $delete = "DELETE FROM product where reference = $id;";
        $stmt = $this->pdo->query($delete);
        $stmt->execute();
    }

    public function get_popular_products (){
        $sql2="SELECT * FROM product p1 WHERE nbachat = (SELECT MAX(nbachat)FROM product p2 WHERE p1.category = p2.category)";
        $result2 = $this->pdo->query($sql2);
        $result2->execute();
        $POPproducts = array();
        foreach($result2 as $product){
            $POPproducts[] = new Products(0,$product['name'],$product['old_price'],$product['new_price'],$product['image'],$product['stock'],$product['country'],$product['city'],$product['nbachat'],$product['category']);
        }

        return $POPproducts;

    }
    
}
?>
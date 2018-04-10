<?php
class Product{

  // database connection and table name
  private $conn;
  private $table_name = "products";

  // object properties
  public $id;
  public $name;
  public $description;
  public $price;
  public $category_id;
  public $category_name;
  public $created;

  // constructor with $db as database connection
  public function __construct($db){
      $this->conn = $db;
  }

  // read products
  function read(){

    // select all query
    $query = "SELECT
                c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
              FROM
                " . $this->table_name . " p
                LEFT JOIN
                  categories c
                    ON p.category_id = c.id
                ORDER BY
                p.created DESC";

    // excute query statement
    $result = $this->conn->query($query);


    return $result;
  }

  // create product
  function create(){

    // query to insert record
    $query = "INSERT INTO $this->table_name (name, description, price,category_id,created) VALUES $this->name,$this->description,$this->price,$this->category_id,$this->create";

    // prepare query
    $result = $this->conn->query($query);
    // execute query
    if($result){
        return true;
    }

    return false;
  }


  // used when filling up the update product form
function show(){
    // query to read single record
    $query = "SELECT
                c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            WHERE
                p.id = ".$this->id."
            LIMIT
                0,1";

    // prepare query statement
    $result = $this->conn->query($query);

    if ($result > 0) {

      // get retrieved row
      while ($row = $result->fetch_assoc()) {
        $this->name = $row['name'];
        $this->price = $row['price'];
        $this->description = $row['description'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];
      }
      // set values to object properties

    }
  }

  // update the product
  function update(){
     "UPDATE MyGuests SET lastname='Doe' WHERE id=2";
    // update query
    $query = "UPDATE  $this->table_name SET name = $this->name,  price = $this->price,  description = $this->description,  category_id = $this->category_id  WHERE id = $this->id";

    // prepare query statement
    $result = $this->conn->query($query);

    // execute the query
    if($result){
        return true;
    }

    return false;
  }

  // delete the product
  function delete(){

    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE id = ".$this->id."";

    // prepare query
    $result = $this->conn->query($query);

    // execute query
    if($result->execute()){
        return true;
    }

    return false;

  }

  // search products
  function search($keywords){

    // select all query
    $query = "SELECT
                c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories c
                          ON p.category_id = c.id
              WHERE
                  p.name LIKE '%{$keywords}%' OR p.description LIKE '%{$keywords}%' OR c.name LIKE '%{$keywords}%'
              ORDER BY
                  p.created DESC";
    // prepare query statement
    $result = $this->conn->query($query);

    return $result;
  }

  // read products with pagination
  public function readPaging($from_record_num, $records_per_page){

    // select query
    $query = "SELECT
                c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            ORDER BY p.created DESC
            LIMIT $from_record_num, $records_per_page";

    // prepare query statement
    $result = $this->conn->query( $query );
    // return values from database
    return  $result;
  }

  // used for paging products
  public function count(){
      $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";

      $result = $this->conn->query( $query );
      $row = $result->fetch_assoc();

      return $row['total_rows'];
  }

}

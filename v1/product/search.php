<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/product.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$product = new Product($db);

// get keywords
$keywords=isset($_GET["s"]) ? $_GET["s"] : "";

// query products
$result = $product->search($keywords);


if ($result >0) {

  // products array
  $products_arr=array();
  $products_arr["records"]=array();

  // retrieve our table contents
  while ($row = $result->fetch_assoc()) {
      // this will make $row['name'] to
      // just $name only
      extract($row);

      $product_item=array(
          "id" => $id,
          "name" => $name,
          "description" => html_entity_decode($description),
          "price" => $price,
          "category_id" => $category_id,
          "category_name" => $category_name
      );

      array_push($products_arr["records"], $product_item);
  }

  echo json_encode($products_arr);
}
else{
    echo json_encode(
        array("message" => "No products found.")
    );
}
?>

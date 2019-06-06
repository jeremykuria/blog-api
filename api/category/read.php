<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Category.php';

  // Instantiate DB & connect
  // $host = 'localhost';
  // $db_name = 'myblog';
  // $username = 'root';
  // $password = ' ';
  // $conn;

  //$dbh = new PDO("mysql:host=127.0.0.1;dbname=myblog", "root", "!QAZ2wsx");
  $database = new Database("mysql:host=127.0.0.1:3306;dbname=myblog", "root", "!QAZ2wsx");
  $db = $database->connect();

  // Instantiate category object
  $category = new Category($db);

  // Category read query
  $result = $category->read();
  
  // Get row count
  $num = $result->rowCount();
  
  // $result = $conn->query($sql);

  // $response = array();
  
  // if ($result->num_rows > 0) {
  // Check if any categories
  if($num > 0) {
        // Cat array
        $cat_arr = array();
        $cat_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
          extract($row);

          $cat_item = array(
            'id' => $id,
            'name' => $name
          );

          // Push to "data"
          array_push($cat_arr['data'], $cat_item);
        }

        // Turn to JSON & output
        echo json_encode($cat_arr);

  } else {
        // No Categories
        echo json_encode(
          array('message' => 'No Categories Found' + $result)
        );
  }

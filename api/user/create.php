<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/User.php';

  // Instantiate DB & connect
  $database = new Database("mysql:host=127.0.0.1;dbname=myblog", "root", "!QAZ2wsx");
  $db = $database->connect();

  // Instantiate blog post object
  $post = new User($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  $post->login = $data->login;
  $post->username = $data->username;
  $post->email = $data->email;
  $post->organisation_id = $data->organisation_id ;

  // Create post
  if($post->create()) {
    echo json_encode(
      array('message' => 'Post Created')
    );
  } else {
    echo json_encode(
      array('message' => 'Post Not Created')
    );
  }


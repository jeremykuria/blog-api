<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Post.php';

  // Instantiate DB & connect
  $database = new Database("mysql:host=127.0.0.1:3306;dbname=myblog", "root", "!QAZ2wsx");
  $db = $database->connect();

  // Instantiate blog post object
  $post = new Post($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  $post->topic = $data->topic;
  $post->body = $data->body;
  $post->author = $data->author;
  $post->category_id = $data->category_id;
  $post->category_name = $data->category_name;
  $post->user_id = $data->user_id;
  $post->organisation_id = $data->organisation_id;
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


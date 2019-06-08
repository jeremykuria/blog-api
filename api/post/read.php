<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Post.php';

  // Instantiate DB & connect
  $database = new Database("mysql:host=127.0.0.1:3306;dbname=myblog", "root", "!QAZ2wsx");
  $db = $database->connect();

  // Instantiate blog post object
  $post = new Post($db);

  if(isset($_GET['orgId'])){
  $post->organisation_id = isset($_GET['orgId']) ? $_GET['orgId'] : die();
    // Blog post query
  $result = $post->readByOrgId();
}else if(isset($_GET['catId'])){
  $post->category_id = isset($_GET['catId']) ? $_GET['catId'] : die();
    // Blog post query
  $result = $post->readByCatId();
}
else{

  // Blog post query
  $result = $post->read();
}
  // Get row count
  $num = $result->rowCount();

  // Check if any posts
  if($num > 0) {
    // Post array
    $posts_arr = array();
    // $posts_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $post_item = array(
        'id' => $id,
        'topic' => $topic,
        'body' => html_entity_decode($body),
        'author' => $author,
        'category_id' => $category_id,
        'category_name' => $category_name,
        'organisation_id' => $organisation_id,
        'user_id' => $user_id
      );

      // Push to "data"
      array_push($posts_arr, $post_item);
      // array_push($posts_arr['data'], $post_item);
    }

    // Turn to JSON & output
    echo json_encode($posts_arr);

  } else {
    // No Posts
    echo json_encode(
      array('message' => 'No Posts Found')
    );
  }

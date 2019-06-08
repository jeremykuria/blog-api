<?php 
  class Post {
    // DB stuff
    private $conn;
    private $table = 'posts';

    // Post Properties
    public $id;
    public $category_id;
    public $category_name;
    public $topic;
    public $body;
    public $author;
    public $created_at;
    public $user_id;
    public $organisation_id;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    
    // Get Posts
    public function read() {
      // Create query
      $query = 'SELECT c.name as category_name, p.id, p.category_id, p.topic, p.body, p.author, p.created_at, p.organisation_id, p.user_id
                                FROM ' . $this->table . ' p
                                LEFT JOIN
                                  categories c ON p.category_id = c.id
                                ORDER BY
                                  p.created_at DESC';
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }
    // Get Posts by org Id
    public function readByOrgId() {
      // Create query
      $query = 'SELECT c.name as category_name, p.id, p.category_id, p.topic, p.body, p.author, p.created_at, p.organisation_id, p.user_id
                                FROM ' . $this->table . ' p
                                LEFT JOIN
                                  categories c ON p.category_id = c.id
                                
                                  WHERE p.organisation_id  = ?';
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(1, $this->organisation_id);
      // Execute query
      $stmt->execute();

      return $stmt;
    }
// Get Posts by org Id
public function readByCatId() {
  // Create query
  $query = 'SELECT c.name as category_name, p.id, p.category_id, p.topic, p.body, p.author, p.created_at, p.organisation_id, p.user_id
                            FROM ' . $this->table . ' p
                            LEFT JOIN
                              categories c ON p.category_id = c.id
                            
                              WHERE p.category_id  = ?';
  // Prepare statement
  $stmt = $this->conn->prepare($query);

  $stmt->bindParam(1, $this->category_id);
  // Execute query
  $stmt->execute();

  return $stmt;
}
    // Get Single Post
    public function read_single() {
          // Create query
          $query = 'SELECT c.name as category_name, p.id, p.category_id, p.topic, p.body, p.author, p.created_at, p.organisation_id, p.user_id
                                    FROM ' . $this->table . ' p
                                    LEFT JOIN
                                      categories c ON p.category_id = c.id
                                     
                                    WHERE
                                      p.id = ?
                                    LIMIT 0,1';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID
          $stmt->bindParam(1, $this->id);

          // Execute query
          $stmt->execute();

          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // Set properties
          $this->topic = $row['topic'];
          $this->body = $row['body'];
          $this->author = $row['author'];
          $this->category_id = $row['category_id'];
          $this->category_name = $row['category_name'];
          $this->organisation_id = $row['organisation_id'];
          $this->user_id = $row['user_id'];
    }

    // Create Post
    public function create() {
          // Create query
          $query = 'INSERT INTO ' . $this->table . 
           'SET topic = :topic,
           body =:body, 
            author = :author,
             category_id = :category_id,
             category_name=:category_name,
              organisation_id =: organisation_id,
              user_id =: user_id';
         // insert into posts set topic ="test", body ="body", author ="ME", user_id="38", organisation_id="722", category_id="1", category_name="Technology";

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->topic = htmlspecialchars(strip_tags($this->topic));
          $this->body = htmlspecialchars(strip_tags($this->body));
          $this->author = htmlspecialchars(strip_tags($this->author));
          $this->category_id = htmlspecialchars(strip_tags($this->category_id));
          $this->category_name = htmlspecialchars(strip_tags($this->category_name));
          $this->organisation_id = htmlspecialchars(strip_tags($this->organisation_id));;
          $this->user_id =htmlspecialchars(strip_tags($this->user_id));;
          //$this->id = 0;    
          // Bind data
          //$stmt->bindParam(':id', $this->id);
          $stmt->bindParam(':topic', $this->topic);
          $stmt->bindParam(':body', $this->body);
          $stmt->bindParam(':author', $this->author);
          $stmt->bindParam(':category_id', $this->category_id);
          $stmt->bindParam(':category_name', $this->category_name);
          $stmt->bindParam(':organisation_id', $this->organisation_id);
          $stmt->bindParam(':user_id', $this->user_id);

          // Execute query
          if($stmt->execute()) {
            return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Update Post
    public function update() {
          // Create query
          $query = 'UPDATE ' . $this->table . '
                                SET topic = :topic, body = :body, author = :author, category_id = :category_id
                                WHERE id = :id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->topic = htmlspecialchars(strip_tags($this->topic));
          $this->body = htmlspecialchars(strip_tags($this->body));
          $this->author = htmlspecialchars(strip_tags($this->author));
          $this->category_id = htmlspecialchars(strip_tags($this->category_id));
          $this->id = htmlspecialchars(strip_tags($this->id));

          // Bind data
          $stmt->bindParam(':topic', $this->topic);
          $stmt->bindParam(':body', $this->body);
          $stmt->bindParam(':author', $this->author);
          $stmt->bindParam(':category_id', $this->category_id);
          $stmt->bindParam(':id', $this->id);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }

    // Delete Post
    public function delete() {
          // Create query
          $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->id = htmlspecialchars(strip_tags($this->id));

          // Bind data
          $stmt->bindParam(':id', $this->id);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }
    
  }
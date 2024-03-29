<?php 
  class Organization {
    // DB stuff
    private $conn;
    private $table = 'organisations';

    // Post Properties
    public $id;
    public $name;
    public $abbreviation;
    public $brief;
    public $industry_id;
    public $description;
    public $profile_status;
    public $logo;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Posts
    public function read() {
      // Create query
      $query = 'SELECT SCOPE_IDENTITY()';
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single Post
    public function read_single() {
          // Create query
          $query = 'SELECT c.name as category_name, p.id, p.industry_id, p.name, p.abbreviation, p.brief, p.created_at
                                    FROM ' . $this->table . ' p
                                    LEFT JOIN
                                      categories c ON p.industry_id = c.id
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
          $this->name = $row['name'];
          $this->abbreviation = $row['abbreviation'];
          $this->brief = $row['brief'];
          $this->industry_id = $row['industry_id'];
          $this->category_name = $row['category_name'];
    }

    // Create Post
    public function create($name) {
          // Create query
          $query = 'INSERT INTO ' . $this->table . ' SET name = :name, abbreviation = :abbreviation, brief = :brief, industry_id = :industry_id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->name = htmlspecialchars(strip_tags($this->name));
          $this->abbreviation = htmlspecialchars(strip_tags($this->abbreviation));
          $this->brief = htmlspecialchars(strip_tags($this->brief));
          //$this->organisation_id = htmlspecialchars(strip_tags($this->organisation_id));

          // Bind data
          $stmt->bindParam(':name', $this->name);
          $stmt->bindParam(':abbreviation', $this->abbreviation);
          $stmt->bindParam(':brief', $this->brief);
          $stmt->bindParam(':industry_id', $this->industry_id);
          // Execute query
          if($stmt->execute()) {
            echo "stmt";
            print_r($stmt);
            echo "stmt";
            return $this->conn->lastInsertId();;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }    // Update Post
    public function update() {
          // Create query
          $query = 'UPDATE ' . $this->table . '
                                SET name = :name, abbreviation = :abbreviation, brief = :brief, industry_id = :industry_id
                                WHERE id = :id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->name = htmlspecialchars(strip_tags($this->name));
          $this->abbreviation = htmlspecialchars(strip_tags($this->abbreviation));
          $this->brief = htmlspecialchars(strip_tags($this->brief));
          $this->industry_id = htmlspecialchars(strip_tags($this->industry_id));
          $this->id = htmlspecialchars(strip_tags($this->id));

          // Bind data
          $stmt->bindParam(':name', $this->name);
          $stmt->bindParam(':abbreviation', $this->abbreviation);
          $stmt->bindParam(':brief', $this->brief);
          $stmt->bindParam(':industry_id', $this->industry_id);
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
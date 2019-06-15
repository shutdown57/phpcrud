<?php

/**
 * Database class to communicate with database
 */
class Database {

    /**
     * Driver, host and databse name formated for PDO
     *
     * @var string
     */
    private $dsn = "mysql:host=db;dbname=simple";

    /**
     * Database username
     *
     * @var string
     */
    private $username = "admin";

    /**
     * Database password
     *
     * @var string
     */
    private $password = "root";

    /**
     * Database connection instance
     *
     * @var PDO
     */
    private $connection;

    /**
     * Class constructor
     */
    function __construct() {
        try {
            $this->connection = new PDO($this->dsn, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->createTable();
        } catch (PDOException $e) {
            throw new PDOException("<br>500<br>Internal Server Error<br>");
        }
    }

    /**
     * Get one post by id
     *
     * @param int $id post id to get
     *
     * @return array|Exception
     */
    public function post(int $id) : ?array {
        $query = sprintf("SELECT * FROM posts WHERE id=%d", $id);
        try {
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            $data = $stmt->fetch();
            $result = [];
            $result["author"] = $data["author"];
            $result["title"] = $data["title"];
            $result["body"] = $data["body"];
            $result["id"] = $data["id"];
        } catch (PDOException $e) {
            throw new PDOException("Fetch post $id failed");
        }

        return $result;
    }

    /**
     * Get all posts ordered by desccending
     *
     * @return array|Exception
     */
    public function posts() : ?array {
        $query = "SELECT * FROM posts ORDER BY id DESC";
        try {
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            $result = [];
            foreach ($stmt->fetchAll() as $k => $v) {
                array_push(
                    $result,
                    [
                        "author" => $v["author"],
                        "title" => $v["title"],
                        "body" => $v["body"],
                        "id" => $v["id"]
                    ]
                );
            }

        } catch (PDOException $e) {
            throw new PDOException("Fetch posts failed: $e->getMessage()");
        }

        return $result;
    }

    /**
     * Insert post data to database
     *
     * @param array $data post data
     *
     * @return null|Exception
     */
    public function insertPost(array $data) {
        if (!$this->validateEntries($data)) {
            die();
        }
        try {
            $query = "INSERT INTO `posts`(author, title, body) VALUES ('%s', '%s', '%s')";
            $query = sprintf($query, $data['author'], $data['title'], $data['body']);
            $this->connection->exec($query);
        } catch(PDOException $e) {
            return "User exists";
        }
    }

    /**
     * Update a post
     *
     * @param array $data post data
     *
     * @return null|Exception
     */
    public function updatePost(array $data) {
        if (!$this->validateEntries($data)) {
            die();
        }
        try {
            $query = "UPDATE `posts` SET author='%s', title='%s', body='%s' WHERE id=%d";
            $query = sprintf(
                $query,
                $data["author"], $data["title"], $data["body"], $data["id"]
            );
            $this->connection->exec($query);
        } catch (PDOException $e) {
            return "<br>500<br>Server Internal Error<br>";
        }
    }

    /**
     * Delete a post by id
     *
     * @param int $id post id to delete
     *
     * @return null|Exception
     */
    public function deletePost(int $id) {
        try {
            $query = "DELETE FROM posts WHERE id=%d";
            $query = sprintf($query, $id);
            $this->connection->exec($query);
        } catch (PDOException $e) {
            return "<br>500<br>Server Internal Error<br>";
        }
    }

    /**
     * Create posts table if not exists
     *
     * @return bool|Exception
     */
    public function createTable() : ?bool {
        $query = "CREATE TABLE IF NOT EXISTS `posts`(
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            author VARCHAR(120) NOT NULL,
            title VARCHAR(120) NOT NULL,
            body TEXT NOT NULL
        )";

        try {
            $this->connection->exec($query);
        } catch(PDOException $e) {
            throw new PDOException("CREATE TABLE ERROR");
        }

        return true;
    }

    /**
     * Make an array from entered data
     *
     * @param string $email author email
     * @param string $title post title
     * @param string $body post body
     * @param string $id post id (default null)
     *
     * @return array entered data as an array
     */
    public function toArray(string $email, string $title, string $body, string $id = null) : array {
        $email = $this->inputCurrection($email);
        $title = $this->inputCurrection($title);
        $body = $this->inputCurrection($body);
        if ($id) {
            $id = $this->inputCurrection($id);
            return [
                'author' => $email,
                'title' => $title,
                'body' => $body,
                'id' => $id
            ];
        }

        return [
            'author' => $email,
            'title' => $title,
            'body' => $body
        ];
    }

    /**
     * Fix entered data and prepared to insert in database
     *
     * @param string $input data entry
     *
     * @return string
     */
    private function inputCurrection(string $input) : string {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }

    /**
     * Check if data entry is not null or empty
     *
     * @param array $data post data
     *
     * @return bool if data entry is null or empty return false else true
     */
    private function validateEntries(array $data) : bool {
        foreach ($data as $k => $v) {
            if ($v == '') {
                return false;
            }
        }
        return true;
    }
}

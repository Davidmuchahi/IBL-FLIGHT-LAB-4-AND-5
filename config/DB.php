<?php
class DB {
    private $host = 'localhost';
    private $dbname = 'IBL_FLIGHTS_LABS';
    private $username = 'root';
    private $password = '';
    private $pdo;
    
    public function __construct() {
        $this->connect();
    }
    
    /**
     * Establish PDO connection
     */
    public function connect() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";
            $this->pdo = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);
            return $this->pdo;
        } catch (PDOException $e) {
            error_log("Database Connection Error: " . $e->getMessage());
            throw new Exception("Database connection failed: " . $e->getMessage());
        }
    }
    
    public function getData($procedure, $params = []) {
        try {
            $placeholders = str_repeat('?,', count($params));
            $placeholders = rtrim($placeholders, ',');
            
            $sql = "CALL {$procedure}({$placeholders})";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Stored Procedure Error: " . $e->getMessage());
            throw new Exception("Database operation failed: " . $e->getMessage());
        }
    }
    
    public function executeProc($procedure, $params = []) {
        try {
            $placeholders = str_repeat('?,', count($params));
            $placeholders = rtrim($placeholders, ',');
            
            $sql = "CALL {$procedure}({$placeholders})";
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute($params);
            
            return [
                'success' => $result,
                'affected_rows' => $stmt->rowCount()
            ];
        } catch (PDOException $e) {
            error_log("Stored Procedure Execution Error: " . $e->getMessage());
            throw new Exception("Database operation failed: " . $e->getMessage());
        }
    }
    
    public function getPDO() {
        return $this->pdo;
    }
}
?>

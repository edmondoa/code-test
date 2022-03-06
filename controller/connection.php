<?php
class SqliteConnect{

    private $pdo;

    /**
     * Initialize the object with a specified PDO object
     * @param \PDO $pdo
     */
    // public function __construct() {

    //     $this->pdo =$this->connect();
    //     return $this->pdo;
    // }

    public function connect(){
  
        try {
            // Create (connect to) SQLite database in file
            $my_conn = new PDO('sqlite:../db/task.sqlite3');
            
            // Set errormode to exceptions
            $my_conn->setAttribute(PDO::ATTR_ERRMODE, 
                                    PDO::ERRMODE_EXCEPTION);
            
            // Create table student
            
            $count=$my_conn->prepare("CREATE TABLE IF NOT EXISTS tasks (
                                task_id INTEGER PRIMARY KEY,
                                task_name  VARCHAR (255) NOT NULL,
                                description  TEXT,
                                status  INTEGER NOT NULL,
                                start_date DATETIME DEFAULT CURRENT_TIMESTAMP,
                                completed_date DATETIME,
                                priority INTEGER
                            )");
                            
            $count->execute();
            return $my_conn;

        }catch(PDOException $e)  {
            // Print PDOException message
            echo $e->getMessage();
        }

    }
}
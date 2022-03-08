<?php

class DBProcess {
    private $db;

    public function __construct($db) {

        $this->db = $db;
    }
    /**
     * Get task from tasks table
     * @param data Array
     * @param id task id
     * @param data['sortBy'] hold the field for sorting 
     * @param data['showBy'] hold the field for viewing 
     * @return Array result 
     */
    public function getTask($id = null,$data){
        $bind = [];
        $addon = "";
        $orderBy = (!empty($data) && isset($data['sortBy']) && $data['sortBy'] != '') ? "ORDER BY ".$data['sortBy']." ASC " : "";
        if($id){
            $addon = "WHERE task_id = :task_id";
            $bind = [':task_id' => $id];
        }else{
            if(!empty($data) && isset($data['showBy']) && $data['showBy'] != ''){
                $addon = "WHERE status = :status";
                $bind = [':status' => $data['showBy']];
            }
        }
        $stmt = $this->db->prepare('SELECT * FROM tasks '.$addon. " ".$orderBy);
        $stmt->execute($bind);
        $tasks = [];
        $completed = 0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if( $row['status'] == 'Complete'){
                $completed++;
            }
            $tasks[] = [
                'task_name' => $row['task_name'],
                'description' => $row['description'],
                'id' => $row['task_id'],
                'status' => $row['status'],
                'priority' => $row['priority'],
                'created' => $row['start_date'],
            ];
        }
        $result = ['tasks'=>$tasks, 'completed'=> $completed ,'total'=> count($tasks)];
        return $result;
    }

    /**
     * Insert a new task into the tasks table
     * @param data Array
     * @return int id of the inserted task
     */
    public function insertTask($data) {
        $sql = 'INSERT INTO tasks(task_name,description,priority,status) '
                . 'VALUES(:task_name,:description,:priority,:status)';

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':task_name' => $data['taskName'],
            ':description' => $data['taskDescription'],
            ':priority' =>  $data['priority'],
            ':status' => 'Pending'
        ]);

        return $this->db->lastInsertId();
    }
    /**
     * Update Task set status to complete in the tasks table
     * @param data Array
     * @param int id of the inserted task
     */
    public function markComplete($id,$data){
        $sql = "UPDATE tasks SET status = :status, completed_date = :completed_date
                WHERE task_id =:task_id ";
       
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':status' => $data['status'],
            'completed_date' => $data['completed_date'],
            ':task_id' => $id
        ]);
    }

    /**
     * Update Task  the tasks table
     * @param data Array
    */
    public function updateTask($data){
        $sql = "UPDATE tasks SET task_name = :task_name, description = :description, priority =:priority
                WHERE task_id =:task_id ";
                echo $sql;
                print_r($data);
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':task_name' => $data['taskName'],
            ':description' => $data['taskDescription'],
            ':priority' =>  $data['priority'],
            ':task_id' => $data['id']
        ]);
    }

    /**
     * Delete Task  the tasks table
     * @param int id
    **/
    public function delete($id){
        $sql = "DELETE FROM tasks WHERE task_id =:task_id ";
       
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':task_id' => $id
        ]);
    }

    public function count(){

    }

    
}
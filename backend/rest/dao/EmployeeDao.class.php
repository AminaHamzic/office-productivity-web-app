<?php

require_once __DIR__ . "/BaseDao.class.php";

class EmployeeDao extends BaseDao
{

    public function __construct()
    {
        parent::__construct("users");
    }

    public function addEmployees($employee)
    {
        return $this->insert('users', $employee);
    }

    public function count_employees_paginated($search) {
        $query = "SELECT COUNT(*) AS count
                  FROM users
                  WHERE LOWER(name_surname) LIKE CONCAT('%', :search, '%'); OR 
                  LOWER(position) LIKE CONCAT('%', :search, '%');";
        return $this->query_unique($query, [
            'search' => strtolower($search)
        ]);
    }
    
    public function get_employees_paginated($offset, $limit, $search, $order_column, $order_direction) {
        $valid_columns = ['name_surname', 'position', 'office', 'working_hours'];
        $valid_directions = ['ASC', 'DESC'];
    
        $order_column = in_array($order_column, $valid_columns) ? $order_column : 'name_surname';
        $order_direction = in_array($order_direction, $valid_directions) ? $order_direction : 'ASC';
    
        $query = "SELECT *
                  FROM users
                  WHERE LOWER(name_surname) LIKE CONCAT('%', :search, '%'); OR 
                  LOWER(position) LIKE CONCAT('%', :search, '%');
                  ORDER BY {$order_column} {$order_direction}
                  LIMIT :offset, :limit";
        return $this->query($query, [
            'search' => strtolower($search),
            'offset' => (int)$offset,
            'limit' => (int)$limit
        ]);
    }

    public function delete_employee($user_id) {
        $query = "DELETE FROM users WHERE user_id = :user_id";
        $this->execute($query, [
            'user_id' => $user_id
        ]);
    }
    

    
}
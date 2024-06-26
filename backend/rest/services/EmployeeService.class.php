<?php

require_once __DIR__ . "/../dao/EmployeeDao.class.php";

class EmployeeService
{
    private $employee_dao;

    public function __construct()
    {
        $this->employee_dao = new EmployeeDao();
    }

    public function addEmployees($employee)
    {
        $employee['password'] = password_hash($employee['password'], PASSWORD_BCRYPT);
        return $this->employee_dao->addEmployees($employee);
    }

    public function get_employees_paginated($offset, $limit, $search, $order_column, $order_direction)
    {
        $count = $this->employee_dao->count_employees_paginated($search)['count'];
        $rows= $this->employee_dao->get_employees_paginated($offset, $limit, $search, $order_column, $order_direction);

        return ['count' => $count, 'data' => $rows];
    }

    public function delete_employee($user_id)
    {
        $this->employee_dao->delete_employee($user_id);
    }

    public function get_employee_by_id($user_id)
    {
        return $this->employee_dao->get_employee_by_id($user_id);
    }

    public function edit_employee($id, $employee) {
        $this->employee_dao->edit_employee($id, $employee);
    }

    
    

    
}
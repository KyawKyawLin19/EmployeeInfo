<?php

require_once('Employee.php');

$employee = new Employee();
$result = $employee->delete_employee($_GET['id']);

if($result){
        echo "<script>alert('Successfully Deleted!');window.location.href='employee_list.php';</script>";
}else{
    echo "ERROR";
}

?>
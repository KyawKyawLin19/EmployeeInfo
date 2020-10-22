<?php

    require_once('admin/Config/common.php');
    require_once('admin/Company.php');
    require_once('admin/Department.php');
    require_once('admin/Employee.php');

    $company = new Company();
    $companies = $company->getall_company();
    $department = new Department();
    $departments = $department->getall_department();
    $employee = new Employee();

    if (empty($_GET['pageno'])) {
        unset($_COOKIE['sort']);
        unset($_COOKIE['order']);
        setcookie('sort', null, -1, '/');
        setcookie('order', null, -1, '/');
    }

    if (isset($_GET['order'])) {
        $order = $_GET['order'];
        setcookie('order', $_GET['order'], time() + (86400 * 30 ), "/");
    } else {
        $order = 'name';
    }

    if (isset($_GET['sort'])) {
        $sort = $_GET['sort'];
        setcookie('sort', $_GET['sort'], time() + (86400 * 30 ), "/");
    } else {
        $sort = 'ASC';
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Info</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="admin/plugins/fontawesome-free/css/all.min.css">
</head>
<body>
    <div class="container">
        <h1 class="text-center">Employee Info</h1>
        <div class="row">
            <div class="col-md-12">
            <?php 
                if(!empty($_GET['pageno'])){
                    $pageno = $_GET['pageno'];
                }else {
                    $pageno = 1;
                }

                $numOfrecs = 10;
                $offset = ($pageno - 1) * $numOfrecs; 

                if (empty($_COOKIE['order']) && empty($_COOKIE['sort'])){
                    $rawResult = $employee->getall_employee();
                    $total_pages = ceil(count($rawResult) / $numOfrecs);
                    $employees = $employee->pagination_employee($order,$sort,$offset,$numOfrecs);
                }else {
                    $order = $_COOKIE['order'];
                    $sort = $_COOKIE['sort'];
                    $rawResult = $employee->getall_employee();
                    $total_pages = ceil(count($rawResult) / $numOfrecs);
                    $employees = $employee->pagination_employee($order,$sort,$offset,$numOfrecs);
                }
                ?>
                <?php
                    $sort == 'ASC'? $sort = 'DESC' :$sort = 'ASC';
                    if ($employees) {
                ?>
                
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name <a href="index.php?order=name&sort=<?php echo $sort ?>"><i class="fas fa-sort"></i></a></th>
                            <th scope="col">Email <a href="index.php?order=email&sort=<?php echo $sort ?>"><i class="fas fa-sort"></i></a></th>
                            <th scope="col">Age <a href="index.php?order=age&sort=<?php echo $sort ?>"><i class="fas fa-sort"></i></a></th>
                            <th scope="col">Company</th>
                            <th scope="col">Department</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if ($pageno == 1) {
                                $id = 1;
                            }else {
                                $id = ($pageno - 1) * $numOfrecs + 1;
                            }
                            foreach ($employees as $e) {
                        ?>
                        <tr>
                            <td scope="row"><?php echo $id; ?></td>
                            <td><?php echo escape ($e->name); ?></td>
                            <td><?php echo escape ($e->email); ?></td>
                            <td><?php echo escape ($e->age); ?></td>
                            <td><?php print_r(escape($company->getcompany_name($e->company_id)->name));?></td>
                            <td><?php print_r(escape($department->getdepartment_name($e->department_id)->name)); ?></td>
                        </tr>

                        <?php
                            $id++;
                                }
                            
                        ?>
                        
                    </tbody>
                </table>
                <nav aria-label="Page navigation example" style="float:right;">
                  <ul class="pagination">
                    <li class="page-item <?php if($pageno == 1){ echo 'disabled'; } ?>"><a class="page-link" href="?pageno=1">First</a></li>
                    <li class="page-item <?php if($pageno <= 1){ echo "disabled";} ?>">
                      <a class="page-link" href="<?php if($pageno <= 1){echo '#'; }else{ echo '?pageno='.($pageno-1);} ?>">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#"><?php echo $pageno; ?></a></li>
                    <li class="page-item <?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                      <a class="page-link" href="<?php if($pageno >= $total_pages){echo '#'; }else{ echo '?pageno='.($pageno+1);} ?>" >Next</a>
                    </li>
                    <li class="page-item <?php if($pageno == $total_pages){ echo 'disabled'; } ?>"><a class="page-link" href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
                  </ul>
                </nav>
                <?php
                    }else {
                ?>
                    <h1 class="text-center">There is no data</h1>
                <?php            
                    }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
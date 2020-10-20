<?php

    require_once('header.php');
    require_once('Company.php');
    require_once('Department.php');
    require_once('Employee.php');

    $company = new Company();
    $companies = $company->getall_company();

    $department = new Department();
    $departments = $department->getall_department();

    $employee = new Employee();

?>


<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
       
      </div>
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Employee Listings</h3>
              </div>
              <?php 

                if(!empty($_GET['pageno'])){

                  $pageno = $_GET['pageno'];

                }else {

                  $pageno = 1;

                }

                $numOfrecs = 10;
                
                $offset = ($pageno - 1) * $numOfrecs; 

                $rawResult = $employee->getall_employee();

                $total_pages = ceil(count($rawResult) / $numOfrecs);

                $employees = $employee->pagination_employee($offset,$numOfrecs);

              ?>
              <div class="card-body">
                <div>
                  <a href="employee_create.php" class="btn btn-primary" type="button">New Employee</a>
                </div>
                <br>
                <table class="table table-bordered">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>DOB</th>
                      <th>Company</th>
                      <th>Department</th>
                      <th style="width: 30px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      if($employees){
                        
                        if($pageno == 1){

                            $id = 1;

                        }else {

                            $id = ($pageno - 1) * $numOfrecs + 1;

                        }
                        foreach($employees as $e){
                    ?>

                    <tr>
                      <td><?php echo $id; ?></td>
                      <td><?php echo $e->name; ?></td>
                      <td><?php echo $e->email; ?></td>
                      <td><?php echo $e->dob; ?></td>
                      <td><?php print_r($company->getcompany_name($e->company_id)->name);?></td>
                      <td><?php print_r($department->getdepartment_name($e->department_id)->name); ?></td>
                      <td>
                        <div class="btn-group">
                          <div class="container">
                            <a href="employee_edit.php?id=<?php echo $e->id;?>" class="btn btn-warning" type="button">Edit</a>
                          </div>
                          <div class="container">
                            <a href="employee_delete.php?id=<?php echo $e->id;?>" 
                            onclick="return confirm('Are you sure you want to delete this category')"
                            class="btn btn-danger" type="button">Delete</a>
                          </div>
                        </div>
                      </td>
                    </tr>


                    <?php
                        $id++;
                        }
                      }

                    ?>
                  </tbody>
                </table>
                <br>
                <a href="index.php" style="float:left;"><button class="btn btn-primary">Back</button></a>
                <nav aria-label="Page navigation example" style="float:right;">
                  <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                    <li class="page-item <?php if($pageno <= 1){ echo "disabled";} ?>">
                      <a class="page-link" href="<?php if($pageno <= 1){echo '#'; }else{ echo '?pageno='.($pageno-1);} ?>">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#"><?php echo $pageno; ?></a></li>
                    <li class="page-item <?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                      <a class="page-link" href="<?php if($pageno >= $total_pages){echo '#'; }else{ echo '?pageno='.($pageno+1);} ?>" >Next</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
                  </ul>
                </nav>
              </div>

            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <?php
    require_once('footer.html');
  ?>
  
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
    $employees = $employee->getall_employee();


    foreach($employees as $e){
    //    print_r("Name".$e->name."<br>");
       $company_name= $company->getcompany_name($e->company_id);
       $department_name= $department->getdepartment_name($e->department_id);
    //    print_r("Company Name".$company_name->name."<br>");
    //    print_r("Department Name".$department_name->name."<br>");
    }
    
  

?>
<div class="content-wrapper" style="margin-top:50px;">
<section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box">
              <a href="index.php" style="cursor:pointer;" class="info-box-icon bg-info elevation-1"><i class="far fa-building"></i></a>

              <div class="info-box-content">
                <span class="info-box-text"><a href="index.php">Companies</a></span>
                <span class="info-box-number">
                <?php echo count($companies) ?>
                  <!-- <small>%</small> -->
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              <a href="department_list.php" style="cursor:pointer;" class="info-box-icon bg-success elevation-1"><i class="fas fa-sitemap"></i></a>

              <div class="info-box-content">
                <span class="info-box-text"><a href="department_list.php">Departments</a></span>
                <span class="info-box-number"><?php echo count($departments) ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              <a href="employee_list.php" style="cursor:pointer;" class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></a>

              <div class="info-box-content">
                <span class="info-box-text"><a href="employee_list.php">Employees</a> </span>
                <span class="info-box-number"><?php echo count($employees) ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Company Listings</h3>
                    </div>
                    <div class="card-body">
                        <br>
                        <table class="table table-bordered">
                        <thead>                  
                            <tr>
                            <th style="width: 10px">#</th>
                            <th>Name</th>
                            <th>Total Employee</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if($companies){
                                    foreach($companies as $c){
                            ?>

                            <tr>
                                <td><?php echo $c->id; ?></td>
                                <td><?php echo $c->name; ?></td>
                                <td>
                                    <?php
                                        $total = $employee->get_com($c->id);
                                        print_r($total);
                                    ?>
                                </td>
                            </tr>


                            <?php
                                    }
                                }
                            ?>
                        </tbody>
                        </table>
                        <br>
                        <nav aria-label="Page navigation example" style="float:right;">
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                            <li class="page-item <?php if($pageno <= 1){ echo "disabled";} ?>">
                            <a class="page-link" href="<?php if($pageno <= 1){echo '#'; }else{ echo '?pageno='.($pageno-1);} ?>">Previous</a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#"><?php echo 1; ?></a></li>
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
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    </div>
<?php
    require_once('footer.html');
?>
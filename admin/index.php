<?php

    require_once('header.php');
    require_once('Config/common.php');
    require_once('Company.php');
    require_once('Department.php');
    require_once('Employee.php');

    $department = new Department();
    $departments = $department->getall_department();

    $employee = new Employee();
    $employees = $employee->getall_employee();

    if(empty($_GET['pageno'])) {

      unset($_COOKIE['sort']);
      unset($_COOKIE['order']);

      setcookie('sort', null, -1, '/');
      setcookie('order', null, -1, '/');

    }

    if(isset($_GET['order'])){
      $order = $_GET['order'];
      setcookie('order', $_GET['order'], time() + (86400 * 30 ), "/");
    }else{
      $order = 'name';
    }

    if(isset($_GET['sort'])){
      $sort = $_GET['sort'];
      setcookie('sort', $_GET['sort'], time() + (86400 * 30 ), "/");
    }else{
      $sort = 'ASC';
    }

    $company = new Company();

    $rawResult = $company->getall_company();

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
                <?php echo count($rawResult) ?>
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
                    <?php 

                      if(!empty($_GET['pageno'])){

                        $pageno = $_GET['pageno'];

                      }else {

                        $pageno = 1;

                      }

                      $numOfrecs = 3;

                      $offset = ($pageno - 1) * $numOfrecs; 

                      if(empty($_COOKIE['order']) && empty($_COOKIE['sort'])){

                        $rawResult = $company->getall_company();

                        $total_pages = ceil(count($rawResult) / $numOfrecs);

                        $companies = $company->pagination_company($order,$sort,$offset,$numOfrecs);
                      }else {

                        $order = $_COOKIE['order'];
                        $sort = $_COOKIE['sort'];
                        $rawResult = $company->getall_company();

                        $total_pages = ceil(count($rawResult) / $numOfrecs);

                        $companies = $company->pagination_company($order,$sort,$offset,$numOfrecs);
                      }

                      ?>
                      <?php
                        $sort == 'ASC'? $sort = 'DESC' :$sort = 'ASC';
                        
                        if($companies){
                          if($pageno == 1){

                            $id = 1;

                          }else {

                              $id = ($pageno - 1) * $numOfrecs + 1;

                          }
                      ?>
                    <div class="card-body">
                        <br>
                        <table class="table table-bordered">
                        <thead>                  
                            <tr>
                            <th style="width: 10px">#</th>
                            <th>Company Name <a href="index.php?order=name&sort=<?php echo $sort ?>"><i class="fas fa-sort"></i></a></th>
                            <th>Total Employee</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if($companies){
                        
                                    if($pageno == 1){
            
                                        $id = 1;
            
                                    }else {
            
                                        $id = ($pageno - 1) * $numOfrecs + 1;
            
                                    }
                                    foreach($companies as $c){
                            ?>

                            <tr>
                                <td><?php echo escape($id); ?></td>
                                <td><?php echo escape($c->name); ?></td>
                                <td>
                                    <?php
                                        $total = $employee->get_com($c->id);
                                        print_r(escape($total));
                                    ?>
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

        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    </div>
<?php
    require_once('footer.html');
?>
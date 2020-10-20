<?php

    require_once('header.php');
    require_once('Company.php');
    require_once('Department.php');
    require_once('Employee.php');

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
                <h3 class="card-title">Department Listings</h3>
              </div>
              
              <div class="card-body">
                <br>
                <table class="table table-bordered">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th>Total Employees</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      if($departments){
                        foreach($departments as $d){
                    ?>

                    <tr>
                      <td><?php echo $d->id; ?></td>
                      <td><?php echo $d->name; ?></td>
                      <td>
                            <?php
                                $total = $employee->get_depart($d->id);
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
                <a href="index.php" style="float:left;"><button class="btn btn-primary">Back</button></a>
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
      </div>
    </div>
  </div>

  <?php
    require_once('footer.html');
  ?>
  
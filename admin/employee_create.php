<?php
    require_once('header.php');
    require_once('Company.php');
    require_once('Department.php');
    require_once('Employee.php');

    $company = new Company();
    $company_list=$company->getall_company();

    $department = new Department();
    $department_list=$department->getall_department();

    if(!empty($_POST)){
        if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['dob']) 
        || empty($_POST['company']) || empty($_POST['department'])) {
            
            if(empty($_POST['name'])) {

                $nameError = '* Name cannot be null';

            }

            if(empty($_POST['email'])) {

                $emailError = '* Email cannot be null';

            }

            if(empty($_POST['dob'])) {

                $dobError = '* Date of Birth cannot be null';

            } 

            if(empty($_POST['company'])) {

                $companyError = '* Company cannot be null';

            }

            if(empty($_POST['department'])) {

                $departmentError = '* Department cannot be null';

            }
        
        } 
        else {
            $employee = new Employee();

            $result = $employee->add_employee($_POST);

            if($result){
                echo "<script>alert('Successfully Created!');window.location.href='employee_list.php';</script>";
            }
        }
    }
 
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          
          <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                <h4>Create New Employee</h4>
                    <form action="employee_create.php" method="post">
                        
                        <!-- <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'] ?>"> -->
                        
                        <div class="form-group">
                            <label for="">Name</label><p style="color:red"><?php echo empty($nameError)? '' : $nameError; ?></p>
                            <input type="text" name="name" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="">Email</label><p style="color:red"><?php echo empty($emailError)? '' : $emailError; ?></p>
                            <input type="email" name="email" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="">Date Of Birth</label><p style="color:red"><?php echo empty($dobError)? '' : $dobError; ?></p>
                            <input type="date" name="dob" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label for="">Company</label><p style="color:red"><?php echo empty($companyError)? '' : $companyError; ?></p>
                            <select class="form-control" name="company">
                                <option value="">Select Company</option>
                                <?php foreach($company_list as $company){ ?>
                                    <option value="<?php echo $company->id ?>"><?php echo $company->name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Department</label><p style="color:red"><?php echo empty($departmentError)? '' : $departmentError; ?></p>
                            <select class="form-control" name="department">
                                <option value="">Select Department</option>
                                <?php foreach($department_list as $department){ ?>
                                    <option value="<?php echo $department->id ?>"><?php echo $department->name ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="from-group">
                          <input type="submit" class="btn btn-success" value="Submit">
                          <a href="product_list.php" class="btn btn-warning">Back</a>
                        </div>
                
                    </form>
                </div>
            </div>
            <!-- /.card -->
          </div>

        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php
    require_once('footer.html');
  ?>
  
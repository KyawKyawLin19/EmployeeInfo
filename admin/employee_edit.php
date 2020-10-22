<?php
    session_start();
    require_once('Config/common.php');
    require_once('Company.php');
    require_once('Department.php');
    require_once('Employee.php');

    if(empty($_SESSION['user_id'] && $_SESSION['logged_in'])){
        header('Location: login.php');
    }

    $company = new Company();
    $company_list=$company->getall_company();
    $department = new Department();
    $department_list=$department->getall_department();
    
    if(!empty($_POST)){
        if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['age']) 
        || empty($_POST['company']) || empty($_POST['department']) || is_numeric($_POST['age']) != 1) {
            
            if (empty($_POST['name'])) {
                $nameError = '* Name cannot be null';
            }

            if (empty($_POST['email'])) {
                $emailError = '* Email cannot be null';
            }

            if (empty($_POST['age'])) {
                $ageError = '* Age cannot be null';
            }else if (is_numeric ($_POST['age']) != 1) {
                $ageError = 'Age should be integer value';
            } 

            if (empty($_POST['company'])) {
                $companyError = '* Company cannot be null';
            }

            if (empty($_POST['department'])) {
                $departmentError = '* Department cannot be null';
            }
        
        } 
        else {
            $employee = new Employee();
            $result = $employee->update_employee($_POST);

            if ($result) {
                echo "<script>alert('Successfully Updated!');window.location.href='employee_list.php';</script>";
            }
        }
    }

    if (!empty($_GET['id'])) {
        $employee = new Employee();
        $emp = $employee->get_employee($_GET['id']);
    }
    
    require_once('header.php');
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
                <div class="card-body">
                <h4>Edit Employee Info</h4>
                    <form action="" method="post">
                        <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'] ?>">
                        <input type="hidden" name="id" value="<?php echo $emp->id ?>">
                        <div class="form-group">
                            <label for="">Name</label><p style="color:red"><?php echo empty($nameError)? '' : $nameError; ?></p>
                            <input type="text" name="name" class="form-control" value="<?php echo $emp->name; ?>">
                        </div>
                        <div class="form-group">
                            <label for="">Email</label><p style="color:red"><?php echo empty($emailError)? '' : $emailError; ?></p>
                            <input type="email" name="email" class="form-control" value="<?php echo $emp->email; ?>">
                        </div>
                        <div class="form-group">
                            <label for="">Age</label><p style="color:red"><?php echo empty($ageError)? '' : $ageError; ?></p>
                            <input type="text" name="age" class="form-control" value="<?php echo $emp->age;?>">
                        </div>
                        <div class="form-group">
                            <label for="">Company</label><p style="color:red"><?php echo empty($companyError)? '' : $companyError; ?></p>
                            <select class="form-control" name="company">
                                <option value="">Select Company</option>
                                <?php foreach($company_list as $company){ ?>
                                    <?php if($emp->company_id == $company->id): ?>
                                        <option value="<?php echo $company->id ?>" selected><?php echo $company->name ?></option>
                                    <?php else: ?>
                                        <option value="<?php echo $company->id ?>"><?php echo $company->name ?></option>
                                    <?php endif ?>      
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
                                <?php foreach($department_list as $department){ ?>
                                    <?php if($emp->department_id == $department->id): ?>
                                        <option value="<?php echo $department->id ?>" selected><?php echo $department->name ?></option>
                                    <?php else: ?>
                                        <option value="<?php echo $department->id ?>"><?php echo $department->name ?></option>
                                    <?php endif ?>
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
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php
    require_once('footer.php');
  ?>
  
<?php session_start() ;
require('inc/header.php') ;?>

    <div class="container py-5">
        <div class="row">

            <div class="col-md-6 offset-md-3">
                <h3 class="mb-3">Add user</h3>
                <div class="card">
                    <div class="card-body p-5">
                        <?php
                    if(isset($_SESSION['success']) ){
      ?>
      <div class="alert alert-success"><?= $_SESSION['success']?></div>
              <?php  }
              unset($_SESSION['success']);
              ?>
 <!--رتبت شكل الارورو الي بطلع عندي وحطيته جوا ليست -->

                <ul>

<?php
if(isset($_SESSION['errors'])){
    foreach($_SESSION['errors'] as $error){?>
    <li class="alert alert-danger"><?= $error?></li>
      
  <?php  }

}
unset($_SESSION['errors']);
?>
</ul>
                        <form action="handle/add_user.php" method="post"enctype="multipart/form-data" >
                            <div class="form-group">
                              <label>FirstName</label>
                              <input type="text" name="fname"class="form-control" value=<?php 
                              if(isset($_SESSION['fname'])){
                                echo $_SESSION['fname'];
                              } ?> ><!-- ملاحظة لما احط فاليو هون معناها انو هذا الحقل يوخد قيمة بدائية -->
                            </div>
                            <div class="form-group">
                              <label>LastName</label>
                              <input type="text" name="lname"class="form-control" value=<?php 
                              if(isset($_SESSION['lname'])){
                                echo $_SESSION['lname'];
                              } ?> ><!-- ملاحظة لما احط فاليو هون معناها انو هذا الحقل يوخد قيمة بدائية -->
                            </div>
                            <div class="form-group">
                              <label>Gender:</label>
                              <br>
                              <input type="radio" name="gender"
<?php if (isset($gender) && $gender=="female") echo "checked";?>
value="female">Female
<input type="radio" name="gender"
<?php if (isset($gender) && $gender=="male") echo "checked";?>
value="male">Male
                            </div>
                            
 

                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email"class="form-control" value=<?php if(isset($_SESSION['email'])){
                                echo $_SESSION['email'];
                              } ?>>
                            </div>

                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="pass" class="form-control">
                            </div>
                           
                            
                            
                            <div class="custom-file">
                                <input type="file" name="img" class="custom-file-input" id="customFile">
                                <label class="custom-file-label" for="customFile">Choose Your Image</label>
                            </div>
                              
                          
                            <div class="text-center mt-5">
                              
                            <button type="submit" name="signup" class="btn btn-primary">Sign Up</button>
                            <div class="d-flex justify-content-start align-items-center  mt-2 ">
                                <h6 class=" text-success small  ">Have account?</h6>
                                <br>
                            <a class="btn btn-dark ml-3" href="login.php">Log In</a>
                            </div>
                                
                            </div>
                           
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <?php require_once('inc/footer.php') ;?>
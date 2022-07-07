<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome-free-5.0.1/css/fontawesome-all.css">
</head>

    <body>
  
    


<?php session_start() ;
require('handle/connection.php') ;
if(isset($_GET['id'])){
    $id=(int)$_GET['id'];
    $sql="select * from users where id=$id ";
    $query=mysqli_query($conn,$sql);
    $user=mysqli_fetch_assoc($query);
    
//print_r($user);
}
?>

    <div class="container py-5">
        <div class="row">

            <div class="col-md-6 offset-md-3">
                <h3 class="mb-3">Edit information</h3>
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
                        <form action="handle/update.php" method="post"enctype="multipart/form-data" >
                            <div class="form-group">
                                <input type="hidden" value="<?=$id?> " name="id"><!-- هسا رح اشتغل داخل صفحة update.php
                            ولكن بلزم يكون معي الايدي اما ببعته بالطريقة العادية داخل اكشن بالفورم وببعته او هون عملت انبوت خاص بالايدي ونوعه هدين انو ما يظهر قدام اليوزر-->
                              <label>FirstName</label>
                              <input type="text" name="fname"class="form-control" value=<?= 
                              $user['firstName'];
                             ?> ><!-- ملاحظة لما احط فاليو هون معناها انو هذا الحقل يوخد قيمة بدائية -->
                            </div>
                            <div class="form-group">
                              <label>LastName</label>
                              <input type="text" name="lname"class="form-control" value=<?=
                               
                               $user['lastName'];
                              ?> ><!-- ملاحظة لما احط فاليو هون معناها انو هذا الحقل يوخد قيمة بدائية -->
                            </div>
                            <div class="form-group">
                              <label>Gender:</label>
                              <br>
                              <input type="radio" name="gender"
<?php if (isset($gender) && $gender=="female") echo "checked";?>
value="female" <?= ($user['gender']=="female")?'checked':''?> >Female
<input type="radio" name="gender"
<?php if (isset($gender) && $gender=="male") echo "checked";?>
value="male"<?= ($user['gender']=="male")?'checked':''?> >Male
                            </div>
                            
 

                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value=<?= 
                              $user['email'];
                             ?> >
                            </div>

                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="pass" class="form-control">
                            </div>
                           
                            
                            
                            <div class="custom-file">
                                <input type="file" name="img" class="custom-file-input" id="customFile" 
                              >
                                <label class="custom-file-label" for="customFile">Choose Your Image</label>
                           </div>
<div class="form-group">
    <img class="w-50  mx-auto d-block rounded" style="height:200px" src="uploads/<?=$user['user_img']?>" alt="">
    
</div>

                              
                          
                            <div class="text-center mt-5">
                              
                            <button type="submit" name="edit" class="btn btn-primary">Update</button>
                            <div class="d-flex justify-content-start align-items-center  mt-2 ">
                                <h6 class=" text-success small  ">Have account?</h6>
                                <br>
                            <a class="btn btn-dark ml-3" href="login.php">Log In</a>
                            </div>
</div>
</div> 
                            </div>
</form>
                           
</div>
                    </div>
                
            

        

    <?php require_once('inc/footer.php') ;?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome-free-5.0.1/css/fontawesome-all.css">
</head>
<body>


<?php session_start();
 require('handle/connection.php') ;?>
<?php
 
 
// echo $_SESSION['correctemail'];
 $eemail=$_SESSION['correctemail'];
 //echo $eemail;
$sql="SELECT id,firstName,lastName,email,user_img FROM users where email='$eemail'";
$query=mysqli_query($conn,$sql);
if(mysqli_num_rows($query)>0){
  $user=mysqli_fetch_assoc($query);
  
  //ملاحظة دايما السيليكت بستخدم هاي انو يعمل فيتش سواء لصف واحد او كلهن
 // print_r($user);
 
 
}
  
?>

    <div class="container-fluid py-5">
        <div class="row">

            <div class="col-md-10 offset-md-1">

                <div class="d-flex justify-content-between align-items-center mb-3 ">
                    <h3>My Profile!</h3>
                   
                </div>
 

                <div class="form-group my-4 ">
                    <img src="uploads/<?=$user['user_img']?>" alt="" class="rounded-circle w-25"    >
</div>
<br>
 

                  
                   <ul class="list-group" style="list-style-type:none" >
                      
                
                        <li class=" "><h3 class="text-success" >FirstName:</h3>
                        <?=$user['firstName']?>
                    </li>
                    <br>
                    <li class="  " ><h3 class="text-success">LastName:</h3>
                        <?=$user['lastName']?>
                    </li>
                    <br>
                    <li class="  "><h3 class="text-success">Email:</h3>
                        <?=$user['email']?>
                    </li>
                    <br>

                    
                         
                       
                       

                         

                       
                        
                      
                       
                      
                      </ul>

                      <a  class="btn btn-primary" href="edit_user.php?id=<?=$user['id']?>">Edit profile</a>
                      
                    <?php
                   
                    mysqli_close($conn);
                      ?>
                      
                
            </div>

        </div>
    </div>
    <?php require_once('inc/footer.php') ;?>
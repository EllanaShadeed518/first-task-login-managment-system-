<?php
require('connection.php') ;

session_start();



if(isset($_POST['login'])){
 
  $email= htmlspecialchars(trim($_POST['email']));
  $password= htmlspecialchars(trim($_POST['password']));
  
  
  
  $errors=[];

//validation email
if(empty($email)){
    $errors[]= "email must be requiered";
      }
      else if((!filter_var($email,FILTER_VALIDATE_EMAIL))){
        $errors[]= " is not validate email";
      }
      else if(strlen($email)>100){
        $errors[]= "email must be less than 100";
      
    }
     
    //validate password
  
   if(empty($password)){
  $errors[]= "password must be requiered";
    }
    else if(strlen($password)>30){
      $errors[]= "name must be less than 30";
    
  }
  elseif(!preg_match("#[0-9]+#",$password)) {//معناها انو الباسوورد يكون فيه رقم واحد عالاقل
    $errors[] = "Your Password Must Contain At Least 1 Number!";
  }
  elseif(!preg_match("#[A-Z]+#",$password)) {//معناها انو الباسوورد يكون في حرف كبير واحد عالاقل 
    $errors[] = "Your Password Must Contain At Least 1 Capital Letter!";
  }
  elseif(!preg_match("#[a-z]+#",$password)) {//معناها انو الباسوورد يكون في حرف صغير واحد عالاقل
    $errors[] = "Your Password Must Contain At Least 1 Lowercase Letter!";
  }



  if(empty($errors)){
   $sql=" SELECT * FROM users WHERE email='$email'";//اول خطوة افحص الايميل اذا موجود بالداتابيس عندي
    
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result) > 0){
        //اذا موجود بدي افحص الباسوورد صح او لا
        $user=mysqli_fetch_assoc($result);
        print_r($user);
        $userpassword=$user['password'];
        if(password_verify($password,$userpassword)){
           
            $_SESSION['correctemail']=$email;
            header('location: ../user.php');
     }
        else{
            $_SESSION['errors']=['please enter correct password'];
            header('location: ../login.php');
       }

    }

    else{
        $_SESSION['errors']=['please enter correct email'];
        header('location: ../login.php');
    }}


    
  else{

  
  $_SESSION['errors']=$errors;
  header('location: ../login.php');






}
}
else{
    header('location: ../login.php');
}

?>
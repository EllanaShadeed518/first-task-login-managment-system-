<?php session_start();
 require('connection.php') ;?>

<?php

$id=$_POST['id'];
$query="select * from users where id=$id";
$result=mysqli_query($conn,$query);
$user=mysqli_fetch_assoc($result);
//print_r($user);


if(isset($_POST['edit'])){
    $fname= htmlspecialchars( trim($_POST['fname']));
    $lname= htmlspecialchars( trim($_POST['lname']));
    $email= htmlspecialchars( trim( $_POST['email']));
    $gender= htmlspecialchars( trim( $_POST['gender']));
    $user_image=htmlspecialchars(  trim($_POST['img']));
    $oldimage=$user['user_img'];
    
    
    $errors=[];
    //validation firstname
    if(empty($fname)){
  $errors[]= "name must be requiered";
    }
    else if(is_numeric($fname)){
      $errors[]= "name must be string";
    }
    else if(strlen($fname)>100){
      $errors[]= "name must be less than 100";
    
  }
    //validation lastname
    if(empty($lname)){
      $errors[]= "name must be requiered";
        }
        else if(is_numeric($lname)){
          $errors[]= "name must be string";
        }
        else if(strlen($lname)>100){
          $errors[]= "name must be less than 100";
        
      }
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
    
   
  
  
  
   
      //validate image
      
  //الصورة احنا لما عملنا جدول اليوزر اخترنا انو الصورة تكون اختيارية يعني مش اجباري احط صورة 
  //هسا اول اشي بدي اكتب كود بالتفصيل كيف اجيب الصورة 
  if($_FILES==true && $_FILES['img']['name']){//دائما الصورة بترجع ب مصفوفة الفايلز
    //يعني هون اذا في صورة 
    $image=$_FILES['img'];//هون بترجع مصفوفة شفناها قبل فيها معلومات كثير عن الصورة ومن ضمنها الاسم والسايز والباث وغيرها 
  print_r($image);
    $imagename=$image['name'];
    $imagetempname=$image['tmp_name'];
    $imagesize=$image['size'];
    $sizemb=$imagesize/(1024*1024);//ملاحظة هاي المعادلة بعملها لما بدي احول سايز الصورة لميجا بايت عشان اقدر اطبق شروط الفاليديشن عليها
  
   
    $ext=pathinfo($imagename,PATHINFO_EXTENSION);//هون جبت الاكستنشن للصورة الي عندي 
    $newname=uniqid().".".$ext;//هون جبت انو يكون اسم وهمي وهذا الاسم هوي الي رح ينضاف فيه عالداتابيس واضفلو الاكستنشن تاع الصورف
    //بعد ما انا جبت معلومات الصورة كلها صار بامكاني هسا احط شروط الفاليديشن الي بدي اياها لهاي الصورة 
  
  
    //validate img
    
    if($sizemb > 1){//بدي السايز للصورة يكون اقل من واحد ميجا بايت 
      $errors[]= "size must be less than 1mb";
    }
    else if(!in_array(strtolower($ext),['png','jpg','jpge','gif'])){//هون بدي الصورة تكون فقط ضمن امتداد معين وبرضو عشان ممكن المستخد يحط اسم الصورة ويكون الامتداد احرف كابيتل هون بحزل الاكستنشن لاحرف صغيرة 
  
      $errors[]= "image not correct";
    }
  
  }
  else{
    //اذا ما دخلت اشي 
    $newname=$oldimage;//في حال اليوزر ما بدو يغير الصورة بضل الصورة القديمة 

  
  }}
  if(empty($errors)){
$sql="update users set firstName='$fname',lastName='$lname',email='$email',gender='$gender',user_img ='$newname'where id=$id";
$result=mysqli_query($conn,$sql);

    if($result){//هسا هون عشان الصورة تنضاف على ملف الابلود عندي مش بس بالداتا بيس
        if($_FILES['img']['name']){
          move_uploaded_file($imagetempname,"../uploads/$newname");
          unlink("../uploads/$oldimage");//حتى في حال عدلت عالصورة احذف الصورة القديمة من ملف الابلود
        }
        $_SESSION['success']="user updated successfully";
       header("location: ../user.php");
          }

  }
  else{
    $_SESSION['errors']=$errors;
    header("location: ../edit_user.php?id=$id");
  }




?>
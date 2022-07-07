<?php
require('connection.php') ;

session_start();



if(isset($_POST['signup'])){
  $fname= htmlspecialchars( trim($_POST['fname']));
  $lname= htmlspecialchars( trim($_POST['lname']));
  $email= htmlspecialchars( trim( $_POST['email']));
  $password= htmlspecialchars( trim($_POST['pass']));
  $gender= htmlspecialchars(  trim($_POST['gender']));
  $user_image=htmlspecialchars(  trim($_POST['img']));
  
  
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
  
/*
ملاحظة مهمة مهمة 
اي باسوورد بدخل على الداتا بيس مستحيل وغلط يدخل نفسه لازم يدخل مشفر وحتى اشفره اول شي فحصت الفليديشن وبعدها طلبت يتشفر 
*/
$password=password_hash($password,PASSWORD_DEFAULT);



 
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

  //حكينا احنا برضو لما شرحنا عن ابلود فايل انو الصورة لازم تدخل مشفرة عندي 
  $ext=pathinfo($imagename,PATHINFO_EXTENSION);//هون جبت الاكستنشن للصورة الي عندي 
  $newname=uniqid().".".$ext;//هون جبت انو يكون اسم وهمي وهذا الاسم هوي الي رح ينضاف فيه عالداتابيس واضفلو الاكستنشن تاع الصورة وبرضو ممكن اخليه مشفلادر بزيادة واخدنا كيف لما شرحنا رفع ملف
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
  $newname="default.png";//هون اذا اليوزر ما دخل صورة لانو حكينا الصورة وادخالها بكون اختياري فهون انو الاسم الي يدخل على الداتا بيس يكون هاد 

}

if(empty($errors)){//تمام هسا بعد ما عملت فاليديشن وكلشي تمام وما في ارورو هون صرت جاهز اعمل انسيرت عالداتا بيس 
  $query="INSERT INTO users(`firstName`,`lastName`,`email`,`password`,`gender`,`user_img`)
  VALUES('$fname','$lname','$email','$password','$gender','$newname')";
  $result=mysqli_query($conn,$query);//هون ضفت الصورة على الداتا بيس سواء اخترت صورة او ما دخلت وكانت ديفولت
  if($result){//هسا هون عشان الصورة تنضاف على ملف الابلود عندي مش بس بالداتا بيس
if($_FILES['img']['name']){
  move_uploaded_file($imagetempname,"../uploads/$newname");
}
$_SESSION['success']="user added";
header('location: ../register.php');
  }

}

else{
  $_SESSION['errors']=$errors;
  //ملاحظة لو مثلا دخلت بحقل الاسم وحقل الايميل وعملت سمبيت ونسيت ادخل باسوورد رح يمحكي لبيانات الي كانت مكتوبة بحقول الاسم والايميل حتى احل المشكلة وانو الي كتبته يضل بحقل الاسم والايميل حتى لو ما دخلت البسوورد
  $_SESSION['fname']=$fname;
  $_SESSION['lname']=$lname;
  $_SESSION['email']=$email;
   header('location: add_user.php');
}

}




else{
    header('location: ../register.php');
}


?>
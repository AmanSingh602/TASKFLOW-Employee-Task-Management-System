<?php
session_start();
if (isset($_SESSION["role"]) && isset($_SESSION["id"])) {
   if(isset($_POST["confirm_password"]) && isset($_POST["new_password"]) && isset($_POST["password"]) && isset($_POST["full_name"]) && $_SESSION["role"]=="employee" )
   {
    include "../DB_connection.php";
        function valid_input($data)
        {
            $data=trim($data);  
            $data=stripcslashes($data);
            $data=htmlspecialchars($data);
            return $data;
        }
        $password=valid_input($_POST["password"]);
        $full_name=valid_input($_POST["full_name"]);
        $new_password=valid_input($_POST["new_password"]);
        $confirm_password=valid_input($_POST["confirm_password"]);
        $id=$_SESSION["id"];
        if(empty($password) || empty($new_password) || empty($confirm_password))
        {
            $em="Password is required";
            header("Location: ../edit_profile.php?error=$em");
            exit();
        }
        else if(empty($full_name))
        {
            $em="Full Name is required";
            header("Location: ../edit_profile.php?error=$em");
            exit();
        }
        else if($confirm_password != $new_password)
        {
            $em="New Password & Confirm Password do not match";
            header("Location: ../edit_profile.php?error=$em");
            exit();
        }
        else
        {
           include "mode1/user.php";
           $user=get_user_by_id($conn,$id);
           if($user)
           {
            if(password_verify($password,$user["password"]))
            {
           $new_password=password_hash($new_password,PASSWORD_DEFAULT);
           $data=array($full_name,$new_password,$id);
           update_profile($conn,$data);
           $em="User Created Successfully";
           header("Location: ../edit_profile.php?success=$em");
           exit();
        }        
    else{
        $em="Incorrect Password";
        header("Location: ../edit_profile.php?error=$em");
        exit();
        }
    }
        else
        {
            $em="Unknown error occured";
            header("Location: ../edit_profile.php?error=$em");
            exit();  
        }

}
  }
   else
   {
    $em="Unknown error occured";
    header("Location: ../edit_profile.php?error=$em");
    exit();
   }
   
?>
<?php }else{ 
	  $em="First login";
	  header("Location: ../login.php?error=$em");
	  exit();
}
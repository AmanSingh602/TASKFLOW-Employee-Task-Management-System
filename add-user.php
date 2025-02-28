<?php
session_start();
if (isset($_SESSION["role"]) && isset($_SESSION["id"])) {
   if(isset($_POST["user_name"]) && isset($_POST["password"]) && isset($_POST["full_name"]) && $_SESSION["role"]=="admin" )
   {
    include "../DB_connection.php";
        function valid_input($data)
        {
            $data=trim($data);  
            $data=stripcslashes($data);
            $data=htmlspecialchars($data);
            return $data;
        }
        $user_name=valid_input($_POST["user_name"]);
        $password=valid_input($_POST["password"]);
        $full_name=valid_input($_POST["full_name"]);
        if(empty($user_name))
        {
            $em="Username is required";
            header("Location: ../add-user.php?error=$em");
            exit();
        }
        else if(empty($password))
        {
            $em="Password is required";
            header("Location: ../add-user.php?error=$em");
            exit();
        }
        else if(empty($full_name))
        {
            $em="Full Name is required";
            header("Location: ../add-user.php?error=$em");
            exit();
        }
        else
        {
           include "mode1/user.php";
           $password=password_hash($password,PASSWORD_DEFAULT);
           $data=array($full_name,$user_name,$password,"employee");
           insert_user($conn,$data);
           $em="User Created Successfully";
           header("Location: ../add-user.php?success=$em");
           exit();
        }        
   }
   else
   {
    $em="unknown error occured";
    header("Location: ../add-user.php?error=$em");
    exit();
   }
   
?>
<?php }else{ 
	  $em="First login";
	  header("Location: ../add-user.php?error=$em");
	  exit();
}
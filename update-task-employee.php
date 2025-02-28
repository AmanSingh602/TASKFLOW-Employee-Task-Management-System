<?php
session_start();
if (isset($_SESSION["role"]) && isset($_SESSION["id"])) {
   if(isset($_POST["id"]) && isset($_POST["status"]) && $_SESSION["role"]=="employee" )
   {
    include "../DB_connection.php";
        function valid_input($data)
        {
            $data=trim($data);  
            $data=stripcslashes($data);
            $data=htmlspecialchars($data);
            return $data;
        }
        $status=valid_input($_POST["status"]);
        $id=valid_input($_POST["id"]);
        if(empty($status))
        {
            $em="Status is required";
            header("Location: ../edit-task-employee.php?error=$em&id=$id");
            exit();
        }
        else
        {
           include "mode1/Task.php";
           $data=array($status,$id);
           update_task_status($conn,$data);
           $em="Task Updated Successfully";
           header("Location: ../edit-task-employee.php?success=$em&id=$id");
           exit();
        }       
   }
   else
   {
    $em="Unknown error occured";
    header("Location: ../edit-task-employee.php?error=$em");
    exit();
   }
   
?>
<?php }else{ 
	  $em="First login";
	  header("Location: ../login.php?error=$em");
	  exit();
}
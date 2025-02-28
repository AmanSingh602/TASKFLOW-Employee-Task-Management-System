<?php
session_start();
if (isset($_SESSION["role"]) && isset($_SESSION["id"])) {
   if(isset($_POST["title"]) && isset($_POST["description"]) && isset($_POST["assigned_to"]) && $_SESSION["role"]=="admin" && isset($_POST["due_date"]))
   {
    include "../DB_connection.php";
        function valid_input($data)
        {
            $data=trim($data);  
            $data=stripcslashes($data);
            $data=htmlspecialchars($data);
            return $data;
        }
        $title=valid_input($_POST["title"]);
        $description=valid_input($_POST["description"]);
        $assigned_to=valid_input($_POST["assigned_to"]);
        $due_date=valid_input($_POST["due_date"]);
        if(empty($title))
        {
            $em="Title is required";
            header("Location: ../create_task.php?error=$em");
            exit();
        }
        else if(empty($description))
        {
            $em="Description is required";
            header("Location: ../create_task.php?error=$em");
            exit();
        }
        else if($assigned_to == 0)
        {
            $em="Select User";
            header("Location: ../create_task.php?error=$em");
            exit();
        }
        else
        {
           include "mode1/Task.php";
           include "mode1/Notification.php";
           $data=array($title,$description,$assigned_to,$due_date);
           insert_task($conn,$data);
           $notif_data=array("'$title' has been assigned to you. Please review and start working on it",$assigned_to,'New Task Assigned');
           insert_notification($conn,$notif_data);
           $em="Task Created Successfully";
           header("Location: ../create_task.php?success=$em");
           exit();
        }       
   }
   else
   {
    $em="Unknown error occured";
    header("Location: ../create_task.php?error=$em");
    exit();
   }
   
?>
<?php }else{ 
	  $em="First login";
	  header("Location: ../create_task.php?error=$em");
	  exit();
}
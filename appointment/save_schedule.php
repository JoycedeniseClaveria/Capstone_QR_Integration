<?php 
require_once('connection.php');
if($_SERVER['REQUEST_METHOD'] !='POST'){
    echo "<script> alert('Error: No data to save.'); location.replace('appointment.php') </script>";
    $conn->close();
    exit;
}
extract($_POST);
$allday = isset($allday);

if(empty($id)){
    $sql = "INSERT INTO `schedule_list` (`userId`,`title`,`description`,`start_datetime`,`end_datetime`) VALUES ('$userId','$title','$description','$start_datetime','$end_datetime')";
}else{
    $sql = "UPDATE `schedule_list` set `userId` = '{$userId}', `title` = '{$title}', `description` = '{$description}', `start_datetime` = '{$start_datetime}', `end_datetime` = '{$end_datetime}' where `id` = '{$id}'";
}
$save = $conn->query($sql);
if($save){
    echo "<script> alert('Schedule Successfully Saved.'); location.replace('appointment.php') </script>";
}else{
    echo "<pre>";
    echo "An Error occured.<br>";
    echo "Error: ".$conn->error."<br>";
    echo "SQL: ".$sql."<br>";
    echo "</pre>";
}
$conn->close();
?>
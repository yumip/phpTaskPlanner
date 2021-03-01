<?php
include_once("configdetails.php");

if($_POST){

    //retrieve post
    $taskTitle = $_POST['taskTitle'];
    $taskDescription = $_POST['taskDescription'];
    $taskAssignedTo = $_POST['taskAssignedTo'];
    $taskDueDate = $_POST['taskDueDate'];
    $taskDueTime = $_POST['taskDueTime'];
    $priority = $_POST['priority'];
    $status = $_POST['status'];
    if($_POST['taskid']!==""){
        $taskId=$_POST['taskid'];
        $sql = editTask($taskId,$taskTitle,$taskDueDate,$taskDueTime,$taskAssignedTo,$taskDescription,$priority,$status,$conn); 
    } else {
        $sql = addTask($taskTitle,$taskDueDate,$taskDueTime,$taskAssignedTo,$taskDescription,$priority,$status,$conn); 
    }
    dbcalling($conn,$sql);
    header("Location: http://localhost:81/taskplanner/index.php");
}

function addTask($taskTitle,$taskDueDate,$taskDueTime,$taskAssignedTo,$taskDescription,$priority,$status,$conn){    //create query string
   return "INSERT INTO `task_details`(`task_title`, `task_description`, `task_assignee`, `task_date`, `task_time`, `task_priority`, `task_status`) 
VALUES ('".$taskTitle."','".$taskDescription."','".$taskAssignedTo."','".$taskDueDate."','".$taskDueTime."', '".$priority."','".$status."' )";
}

if($_GET['edit_task_id']){
    $taskEditId = $_GET['edit_task_id'];
    $sql = retrieveTask($taskEditId);
    $editTask = mysqli_query($conn, $sql);
    if(count($result)==1){
        $row = mysqli_fetch_array($result);
        $taskTitle = $row['task_title'];
    }
    //$editTask->num_rows
}
function editTask($taskId,$taskTitle,$taskDueDate,$taskDueTime,$taskAssignedTo,$taskDescription,$priority,$status,$conn){
    return "UPDATE `task_details` 
SET `task_title`='".$taskTitle."',`task_description`='".$taskDescription."',`task_assignee`='".$taskAssignedTo."',`task_date`='".$taskDueDate."',`task_time`='".$taskDueTime."',`task_priority`='".$priority."',`task_status`='".$status."' 
WHERE `task_id`='".$taskId."'";
}

function pre_r($array){
    echo'<pre>';
    print_r($array);
    echo'</pre>';
}

if($_GET['del_task_id']){
    $taskId = $_GET['del_task_id'];
    $sql = deleteTask($taskId);
    dbcalling($conn,$sql);
    header("Location: http://localhost:81/taskplanner/index.php");
}

function deleteTask($taskId){
    return "DELETE FROM `task_details` where `task_id`='".$taskId."'"; 
}

if($_GET['del_All']){
    $sql = deleteAll();
    dbcalling($conn,$sql);
    header("Location: http://localhost:81/taskplanner/index.php");
}

function deleteAll(){
    return "DELETE FROM `task_details`";
}

function displayTaskbyStatus($conn, $getStatus="all"){
    if($_GET['getStatus']){
        $getStatus = $_GET['getStatus'];
        return displayTask($conn,$getStatus);
    }
    return displayTask($conn,"all");
}

function displayTask($conn,$getStatus){
   if($getStatus==="all"){ 
        $sql = "SELECT * FROM `task_details`";
   } else {
        $sql = "SELECT * FROM `task_details` WHERE `task_status` = '".$getStatus."'";   
   }

   $result = mysqli_query($conn, $sql);
   if($result->num_rows > 0){
       $displayDiv="";

       while ($row = mysqli_fetch_array($result)){
           $displayDiv .= '
          <div data-task class="task">
            <div  class="row">
              <div class = "col-lg-6 order-2 order-lg-1">
                <a href="#newTaskInput" data-editbutton role="button" class="d-inline text-decoration-none btn btn-link col-2 ml-0 pl-0 text-dark" data-toggle="modal" data-target="#newTaskInput" data-id='.$row[task_id].'>
                    <i class="fas fa-edit text-secondary"></i>
                </a>
                  <p class = "text-left d-inline"> <span class="h5" data-name="tasktitle">'.$row[task_title].'</span> 
                  <a href="#task'.$row[task_id].'Description" class="text-secondary icon ml-0 pl-0 small" data-toggle="collapse" data-target="#task'.$row[task_id].'Description"> See More
                </a></p>
              </div>
              <div class="col-lg-6 order-1 order-lg-2">
                <ul class = "row justify-content-between taskSummary" >
                  <li class="col-4 col-sm-1 order-1 order-sm-1">
                  <i class = "fas fa-exclamation-triangle '.$row[task_priority].'" data-toggle = "tooltip" data-placement = "top" title = "Priority"></i>
                  </li>
                  <li class="col-4 col-sm-1 order-2 order-sm-2 text-center">
                    <i class="icon fas fa-star '.$row[task_status].'" data-toggle="tooltip" data-placement="top" title="Status"></i>
                  </li>
                  <li class="col-6 col-sm-4 order-4 order-sm-3 text-sm-right">
                    '.$row[task_date].' '.$row[task_time].'
                  </li>
                  <li class="col-6 col-sm-4 order-5 order-sm-4 text-sm-center text-right" data-name="taskassignee">
                  '.$row[task_assignee].'
                  </li>
                  <li class="col-4 col-sm-1 order-3 order-sm-5 text-right">
                      <a href="index.php?del_task_id='.$row[task_id].'" type="button" class="bin ml-0 pl-0 btn btn-link text-secondary"><i class="icon fas fa-trash"></i></a>
                  </li>
                </ul>
              </div>
            </div>
            <div id="task'.$row[task_id].'Description" class="collapse" data-name="taskdescription">'.$row[task_description].'</div>
            <hr>
             <input type = "hidden" 
             data-taskDate = '.$row[task_date].'
             data-taskTime = '.$row[task_time].'
             data-taskPriority ='.$row[task_priority].'
             data-taskStatus ='.$row[task_status].'>
          </div>';
       }
   }
   return $displayDiv;
}
function counutByStatus($conn,$getStatus){
   if($getStatus==="all"){ 
        $sql = "SELECT `task_status` FROM `task_details`";
   } else {
        $sql = "SELECT `task_status` 
    FROM `task_details` WHERE `task_status` = '".$getStatus."'";   
   }
  $result = mysqli_query($conn,$sql);
  return $result->num_rows ;
}

function dbcalling($conn,$sql){
    if(mysqli_query($conn,$sql)){ //insering the query into the database using the connection
        echo "success";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    mysqli_close($conn);
}
?>
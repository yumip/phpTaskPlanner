<?php
include("configdetails.php");
include("crudoperations.php");
?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css"
    integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">
  <link rel="stylesheet" href="styles.css">
  <title>Task Planner</title>
</head>

<body class="bg-info container-fluid">
  <div class="bg-light mt-5 pt-5 mx-auto px-auto shadow rounded">
    <header class="container m-auto p-auto">
      <h1 class="mt-3 mb-5 text-secondary text-center font-weight-light display-4">Task Planner</h1>
      <nav>
        <ul class="nav justify-content-around">
          <li class="nav-item">
            <a href="index.php?getStatus=all" type="button" class="btn text-info btn-med total">
              TOTAL: <span class="font-weight-bold">
                <?php
                    echo counutByStatus($conn,'all');   
                ?> 
                </span>
            </a>
          </li>
          <li class="nav-item">
            <a href="index.php?getStatus=text-success" type="button" class="btn text-success done btn-med">
              <i class="icon fas fa-star"></i> DONE: <span class="font-weight-bold">
                <?php
                    echo counutByStatus($conn,'text-success');   
                ?> 
            </span>
            </a>
          </li>
          <li class="nav-item">
            <a href="index.php?getStatus=text-primary" type="button" class="btn text-primary review btn-med">
              <i class="icon fas fa-star"></i> REVIEW: <span class="font-weight-bold">
                <?php
                    echo counutByStatus($conn,'text-primary');   
                ?> 
              </span>
            </a>
          </li>
          <li class="nav-item">
            <a href="index.php?getStatus=text-warning" type="button" class="btn text-warning inProgress btn-med">
              <i class="icon fas fa-star"></i> IN PROGRESS: <span class="font-weight-bold">
                <?php
                    echo counutByStatus($conn,'text-warning');   
                ?> 
               </span>
            </a>
          </li>
          <li class="nav-item">
            <a href="index.php?getStatus=text-danger" type="button" class="btn text-danger toDo btn-med">
              <i class="icon fas fa-star"></i> TO DO: <span class="font-weight-bold">
                <?php
                    echo counutByStatus($conn,'text-danger');   
                ?>  </span>
            </a>
          </li>
        </ul>
      </nav>

    </header>
    <main>
      <div class="container" id="newTask">
        <div class="form-group row align-items-center justify-content-center border-bottom border-info">
          <input id="newToDo" type="text" class="ml-4 form-control form-control-lg col-8 border-0 bg-light"
            placeholder="Enter a New Task Here!">
          <a href="#newTaskInput" id="openForm" role="button" class="btn btn-link col-2 ml-0 pl-0 mb-0 pb-0 text-dark"
            data-toggle="modal" data-target="#newTaskInput">
            <h2><i class="fas fa-plus text-secondary"></i></i></h2>
          </a>
        </div>
      </div>
      <div class="container" id="tasks">
      <?php
        echo displayTaskbyStatus($conn, $getStatus);
      ?>
      </div>
    </main>
    <footer class="container mt-5 pt-5">
      <form class="clearAll">
        <a href="index.php?del_All=yes" type="button" class="ml-0 pl-0 btn btn-link text-secondary" id="clearAll">
          Clear All
          <i class="icon fas fa-trash text-secondary"></i>
        </a>
      </form>
    </footer>
  </div>
  <!--modals-->
 <!--new input modal-->
  <div class="modal fade" id="newTaskInput">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form id="taskForm" name="taskForm" method="POST" action="crudoperations.php">
          <div class="modal-header">
            <h5 class="modal-title">Task Detail</h5>
            <button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
           <input type='hidden' id="hiddenId" name='taskid'>
            <div class="form-group">
              <label for="taskTitle">Title <span class="text-secondary font-weight-light"> (min 8 letters)</span>
              </label>
              <input class="form-control" type="text" id="taskTitle" name="taskTitle" required minlength="8"></i>
              <div class="valid-feedback"> looks good </div>
              <div class="invalid-feedback"> It needs to be longer than 8 letters </div>
            </div>
            <div class="row form-group ">
              <div class="col-lg-6 form-row">
                <label class="col-4 col-form-label" for="taskDueDate">Due Date:<span
                    class="text-secondary font-weight-light"> (required)</span></label>
                <input class="col-8 form-control" class="color" type="date" id="taskDueDate" name="taskDueDate"
                  required>
              </div>
              <div class="col-lg-6 form-row">
                <label class="col-4 col-form-label" for="taskDueTime">Due Time:</label>
                <input class="col-8 form-control" class="color" type="time" id="taskDueTime" name="taskDueTime">
              </div>
            </div>
            <div class="form-group form-row">
              <label class="col-3 col-form-label" for="taskAssignedTo">Assigned to <span
                  class="text-secondary font-weight-light"> (min 8 letters)</span>:</label>
              <input class="col-9 form-control" type="text" id="taskAssignedTo" name="taskAssignedTo" required
                minlength="8">
              <div class="valid-feedback"> looks good </div>
              <div class="invalid-feedback"> It needs to be longer than 8 letters </div>
            </div>
            <div class="form-group">
              <label for="taskDescription">Task Detail <span class="text-secondary font-weight-light"> (min 15
                  letters)</span>:</label>
              <textarea class="form-control" id="taskDescription" name="taskDescription" required minlength="15"></textarea>
              <div class="valid-feedback"> looks good </div>
              <div class="invalid-feedback"> It needs to be longer than 15 letters </div>
            </div>
            <p class="text-center"><button class="btn btn-outline-info btn-lg border-0 font-weight-bold shadow"
                data-toggle="collapse" href="#selectPriority" type="button"><i class="fas fa-exclamation-triangle"></i>
                Priority</button>
              <button class="btn btn-outline-info btn-lg border-0 font-weight-bold shadow" data-toggle="collapse"
                href="#selectStatus" type="button"><i class="icon fas fa-star"></i>Status</button></p>
                <p class="text-center text-secondary font-weight-light">(required)</p>
            <div class="collapse" id="selectPriority">
              <div class="card card-body form-group">
                <p>
                  Set priority of your task <span class="text-secondary font-weight-light"> (required)</span>
                </p>
                <div class="custom-control custom-radio">
                  <input type="radio" id="highPriority" name="priority" class="custom-control-input" value="text-danger"
                    required>
                  <label class="custom-control-label font-weight-bold text-danger" for="highPriority"><i
                      class="fas fa-exclamation-triangle"></i> High
                    Priority</label>
                </div>
                <div class="custom-control custom-radio">
                  <input type="radio" id="mediumPriority" name="priority" class="custom-control-input"
                    value="text-warning">
                  <label class="custom-control-label font-weight-bold text-warning" for="mediumPriority"><i
                      class="fas fa-exclamation-triangle"></i> Medium
                    Priority</label>
                </div>
                <div class="custom-control custom-radio">
                  <input type="radio" id="lowPriority" name="priority" class="custom-control-input"
                    value="text-primary">
                  <label class="custom-control-label font-weight-bold text-primary" for="lowPriority"><i
                      class="fas fa-exclamation-triangle"></i> Low
                    Priority</label>
                </div>
                <div class="custom-control custom-radio">
                  <input type="radio" id="noPriority" name="priority" class="custom-control-input"
                    value="text-secondary">
                  <label class="custom-control-label font-weight-bold text-secondary" for="noPriority"><i
                      class="fas fa-exclamation-triangle"></i> No
                    Priority</label>
                </div>
              </div>
            </div>
            <div class="collapse" id="selectStatus">
              <div class="card card-body form-group">
                <p>
                  Record your progress <span class="text-secondary font-weight-light"> (required)</span>
                </p>
                <div class="custom-control custom-radio">
                  <input type="radio" id="statusDone" name="status" class="custom-control-input" value="text-success"
                    required>
                  <label class="custom-control-label font-weight-bold text-success" for="statusDone"><i
                      class="icon fas fa-star"></i> Done</label>
                </div>
                <div class="custom-control custom-radio">
                  <input type="radio" id="statusReview" name="status" class="custom-control-input" value="text-primary">
                  <label class="custom-control-label font-weight-bold text-primary" for="statusReview"><i
                      class="icon fas fa-star"></i> Review</label>
                </div>
                <div class="custom-control custom-radio">
                  <input type="radio" id="statusInProgress" name="status" class="custom-control-input"
                    value="text-warning">
                  <label class="custom-control-label font-weight-bold text-warning" for="statusInProgress"><i
                      class="icon fas fa-star"></i> In Progress</label>
                </div>
                <div class="custom-control custom-radio">
                  <input type="radio" id="statusToDo" name="status" class="custom-control-input" value="text-danger">
                  <label class="custom-control-label font-weight-bold text-danger" for="statusToDo"> <i
                      class="icon fas fa-star"></i> To Do</label>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary shadow" id="cancelButton"
                data-dismiss="modal">Close</button>
              <button type="submit" name="submitForm" class="btn btn-info shadow" id="task-modal-save">Save</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>


  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
  </script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
  </script>
  <script src="app.js"></script>
</body>

</html>
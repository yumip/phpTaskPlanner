$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});
const taskForm = document.forms.taskForm;
const taskTitle = taskForm.taskTitle;
const taskDescription = taskForm.taskDescription;
const taskAssignedTo = taskForm.taskAssignedTo;
const taskDueDate = taskForm.taskDueDate;
const taskSummary = [taskTitle, taskDescription, taskAssignedTo, taskDueDate]

// //Priority && Status
const selectPriority = [...taskForm.querySelectorAll("input[name=priority]")];
const selectStatus = [...taskForm.querySelectorAll("input[name=status]")];
// //TaskContainer
const taskContainer = document.querySelector("#tasks");

//main page entry
const newTaskInputForm = document.querySelector("#newTask");

class TaskFormManager {
    constructor(taskForm, taskSummary, newTaskInputForm, taskContainer, selectPriority, selectStatus ) {
        this.taskForm = taskForm,
        this.taskSummary = taskSummary,
        this.newTaskInputForm = newTaskInputForm,
        this.taskContainer = taskContainer,
        this.selectPriority = selectPriority,
        this.selectStatus = selectStatus
    }

    addEditDisplay() {
        this.clearValues();
        this.clearValidations();
    }

    clearValues() {
        return this.taskForm.reset();
    }
    clearValidations() {
        return this.taskSummary.map(formItem => {
            return formItem.classList.remove("is-invalid", "is-valid");
        });
    }
    openNewTaskClickHandler() {
        const newToDo = this.newTaskInputForm.querySelector("#newToDo");
        this.taskForm.querySelector("#task-modal-save").innerHTML = "Save";
        this.clearValues();
        this.clearValidations();
        this.taskForm.taskid.value = "";
        this.taskForm.removeAttribute('data-id');
        this.taskForm.taskTitle.value = newToDo.value;
        if (this.taskForm.taskTitle.value.length > 7) {
            this.taskForm.taskTitle.classList.add("is-valid");
        } else {
            this.taskForm.taskTitle.classList.add("is-invalid");
        }
        newToDo.value = null;
    }

    displayCurrentInput(task) {
        this.taskForm.querySelector("#task-modal-save").innerHTML = "Edit";
        this.clearValues();
        this.clearValidations();
        this.taskForm.setAttribute("data-id", task.id);
        this.taskForm.taskid.value = task.id;
        this.taskForm.taskTitle.value = task.title;
        this.taskForm.taskDescription.value = task.description;
        this.taskForm.taskAssignedTo.value = task.assignee;
        this.taskForm.taskDueDate.value = task.date;
        this.taskForm.taskDueTime.value = task.time;
        this.selectPriority.find(priority => priority.value === task.priority).checked = true;
        this.selectStatus.find(status => status.value === task.status).checked = true;
    }
    saveButtonClicked() {
        console.log(this.taskForm.taskTitle.value);
        this.taskForm.submit();
        this.addEditDisplay();
        this.taskForm.taskid.value="";
        this.taskForm.removeAttribute('data-id');

        $("#newTaskInput").modal("hide");
        this.taskForm.querySelector("#task-modal-save").innerHTML = "Save";
    }

    clearTaskForm() {
        this.clearValues();
        this.clearValidations();
        this.taskForm.taskid.value = "";
        this.taskForm.removeAttribute('data-id');
        this.taskForm.querySelector("#task-modal-save").innerHTML = "Save";
    }

    prefill(event){
        //console.log(event.target);

        let taskId;
        if (event.target.parentNode.hasAttribute('data-editbutton')) {
            taskId = event.target.parentNode.getAttribute('data-id');
        }
        if (event.target.hasAttribute('data-editbutton')) {
            taskId = event.target.getAttribute('data-id');
        }
        console.log(taskId);
        const dataDOM = event.target.closest("div.task").querySelector('input[type=hidden]');
        const titleDom = event.target.closest("div.task").querySelector('span[data-name=tasktitle]');
        const descDOM = event.target.closest("div.task").querySelector('div[data-name=taskdescription]');
        const asigneeDOM = event.target.closest("div.task").querySelector('li[data-name=taskassignee]');
        console.log(dataDOM);
        let task = {
            id: taskId,
            title: titleDom.innerText,
            description: descDOM.innerText,
            assignee: asigneeDOM.innerText,
            date: dataDOM.dataset.taskdate,
            time: dataDOM.dataset.tasktime,
            priority: dataDOM.dataset.taskpriority,
            status: dataDOM.dataset.taskstatus
        }
        console.log(task);
        this.displayCurrentInput(task);
    }

    addEventListeners() {
        this.newTaskInputForm.querySelector("#openForm").addEventListener("click", () => this.openNewTaskClickHandler());
        this.taskForm.addEventListener("submit", (event) => {
            event.preventDefault();
            this.saveButtonClicked();

        });
        this.taskSummary.map(formItem => {
            formItem.addEventListener("input", function (event) {
                if (!event.target.checkValidity()) {
                    event.target.classList.remove("is-valid");
                    event.target.classList.add("is-invalid");
                } else {
                    event.target.classList.remove("is-invalid");
                    event.target.classList.add("is-valid");
                }
            })
        });
        this.taskContainer.addEventListener("click", (event)=> this.prefill(event));
        this.taskForm.cancelButton.addEventListener("click", () => this.clearTaskForm());
        this.taskForm.close.addEventListener("click", () => this.clearTaskForm());
    }

    start() {
        this.addEventListeners();
    }
}
const taskFormManager = new TaskFormManager(
    taskForm,
    taskSummary,
    newTaskInputForm,
    taskContainer,
    selectPriority, 
    selectStatus
);
taskFormManager.start();
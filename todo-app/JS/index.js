// Select the "add task" button, mode icon, input field, task list, task counter,
// task filter buttons, and clear completed tasks button
const adding_task_btn = document.querySelector(".add-task .check");
const modeIcon = document.querySelector(".theme-icon img");
const input_task = document.querySelector(".add-task input");
const taskList = document.querySelector(".body-task .tasks");
const taskCounter = document.querySelector(".items-counter");
const task_fil_but = document.querySelectorAll(".task-footer .container p");
const clearCompletedTasksBtn = document.querySelector(".clear-completed");

// Add event listener to the task list to handle clicks on task items
taskList.addEventListener("click", handleTaskListClick);

// Add event listener to the "add task" button to create a new task
input_task.addEventListener("keypress", (e) => {
  if (e.keyCode === 13) {
    createTask();
  }
});

// Add event listener to the input field to remove the error class when the user types something
input_task.addEventListener("input", () =>
  input_task.parentElement.classList.remove("error")
);

// Add event listener to the mode icon to toggle the theme
modeIcon.addEventListener("click", () => {
  document.body.classList.toggle("theme");
});

// Define the function to handle clicks on task items
function handleTaskListClick(e) {
  const taskItem = e.target.closest(".task-container");
  const checkBtn = e.target.closest(".check");
  const crossBtn = e.target.closest(".cross");

  if (!taskItem || (!checkBtn && !crossBtn)) return;

  if (checkBtn) {
    // Toggle the "completed" class on the task item when the check button is clicked
    taskItem.classList.toggle("completed");
  } else if (crossBtn) {
    // Remove the task item when the cross button is clicked
    taskItem.remove();
  }

  // Update the task counter
  counter();
}

// Define the function to create a new task
function createTask() {
  if (input_task.value.trim() === "") {
    // Add the error class to the input field's parent element if the input field is empty
    input_task.parentElement.classList.add("error");
    return;
  }

  const taskContainer = document.createElement("div");
  taskContainer.className = "task-container";
  taskContainer.setAttribute("draggable", "true");

  const checkBtn = document.createElement("div");
  checkBtn.className = "check";
  const iconCheck = document.createElement("img");
  iconCheck.src = "assests/icon-check.svg";
  checkBtn.appendChild(iconCheck);

  const taskContent = document.createElement("p");
  taskContent.appendChild(document.createTextNode(input_task.value));

  const cross = document.createElement("div");
  cross.className = "cross";
  const iconCross = document.createElement("img");
  iconCross.src = "assests/icon-cross.svg";
  cross.appendChild(iconCross);

  taskContainer.appendChild(checkBtn);
  taskContainer.appendChild(taskContent);
  taskContainer.appendChild(cross);
  taskList.appendChild(taskContainer);

  input_task.value = "";
  input_task.focus();
  input_task.parentElement.classList.remove("error");

  // Update the task counter
  counter();
}

// Define the function to update the task counter
function counter() {
  const taskArray = Array.from(document.querySelectorAll(".task-container"));
  taskCounter.innerHTML = `${taskArray.length} items left`;

  taskArray.forEach((draggable) => {
    draggable.addEventListener("dragstart", () => {
      draggable.classList.add("dragging");
    });

    draggable.addEventListener("dragend", () =>
      draggable.classList.remove("dragging")
    );
  });

  taskList.addEventListener("dragover", (e) => {
    e.preventDefault();
    const draggingItem = taskList.querySelector(".dragging");

    const sibling = Array.from(
      document.querySelectorAll(".task-container:not(.dragging)")
    ).find((sibling) => {
      return e.clientY <= sibling.offsetTop + sibling.offsetHeight / 2;
    });

    taskList.insertBefore(draggingItem, sibling);
  });
}

// Define the function to handle clicks on task filter buttons
function menu(e) {
  const filterName = e.target.innerHTML;

  task_fil_but.forEach((link) => (link.style.color = "#9394a5"));
  e.target.style.color = "#6a6ae4";

  const tasks = Array.from(taskList.querySelectorAll(".task-container"));

  switch (filterName) {
    case "All":
      tasks.forEach((task) => (task.style.display = "flex"));
      break;
    case "Active":
      tasks.forEach(
        (task) =>
          (task.style.display = task.classList.contains("completed")
            ? "none"
            : "flex")
      );
      break;
    case "Completed":
      tasks.forEach(
        (task) =>
          (task.style.display = task.classList.contains("completed")
            ? "flex"
            : "none")
      );
      break;
    case "Clear Completed":
      tasks.forEach((task) => {
        if (task.classList.contains("completed")) {
          task.remove();
        }
      });
      counter();
      break;
  }
}

// Add event listeners to task filter buttons and clear completed tasks button
task_fil_but.forEach((button) => button.addEventListener("click", menu));
clearCompletedTasksBtn.addEventListener("click", menu);

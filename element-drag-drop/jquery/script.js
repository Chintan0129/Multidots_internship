// Initialize the correct card positions counter
let correctCardPositions = 0;

// Define the total number of items
const totalItems = 10;

// Define the numbers array
const numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

// Define the nos array
const nos = [
  "one",
  "two",
  "three",
  "four",
  "five",
  "six",
  "seven",
  "eight",
  "nine",
  "ten",
];

// Run the begin function when the document is ready
$(document).ready(begin());

// Define the begin function
function begin() {
  // Hide the win message
  hideMessage();

  // Reset the correct card positions counter
  correctCardPositions = 0;

  // Reset the HTML elements
  resetElements();

  // Shuffle the numbers array
  shuffleArray(numbers);

  // Insert the drag cards
  insertDragCard(numbers);

  // Insert the drop slots
  dropSlots(nos);

  // Initialize the time elapsed variable
  let timeElapsed = 0;

  // Start the timer
  let timer = setInterval(function () {
    // Increment the time elapsed by 1 second
    timeElapsed++;

    // Update the timer display
    $("#time").text("Timer: " + timeElapsed + " seconds");

    // If all the cards are in the correct positions
    if (correctCardPositions == totalItems) {
      // Clear the timer
      clearInterval(timer);

      // Show the win message
      showMessage();
    } else if (timeElapsed >= 40) {
      // If 40 seconds have passed without completing the game
      clearInterval(timer);
      // Show the loss message
      showLossMessage();
    }
  }, 1000); // Update the timer every 1 second
}

// Define the hideMessage function
function hideMessage() {
  // Hide the win message and score msg by setting its display property to none
  $("#winMsg").css({ display: "none" });
  $("#score").css({ display: "none" });
  $("#lossMsg").css({ display: "none" });
}

// Define the shuffleArray function
function shuffleArray(array) {
  // Loop through the array from the last index to the second index
  for (let i = array.length - 1; i > 0; i--) {
    // Generate a random index between 0 and i
    const j = Math.floor(Math.random() * (i + 1));

    // Swap the elements at index i and j
    [array[i], array[j]] = [array[j], array[i]];
  }
}

// Define the resetElements function
function resetElements() {
  // Empty the drag and drop elements
  $("#drag__number-slots").empty();
  $("#drop__number-slots").empty();
}

// Define the insertDragCard function
function insertDragCard(numbers) {
  // Loop through the numbers array
  numbers.forEach((number) => {
    // Create a new div element with the number as its text
    $("<div>" + number + "</div>")
      // Set the data-number attribute to the number
      .data("number", number)
      // Set the id attribute to card + number
      .attr("id", "card" + number)
      // Append the div element to the drag number slots element
      .appendTo("#drag__number-slots")
      // Make the div element draggable
      .draggable({
        // Set the containment to the container element
        containment: "#container",
        // Set the stack to the drag number slots div elements
        stack: "#drag__number-slots div",
        // Set the cursor to move
        cursor: "move",
        // Set the revert option to true
        revert: true,
      });
  });
}

// Define the dropSlots function
function dropSlots(nos) {
  // Loop through the nos array
  nos.forEach((nos, index) => {
    // Create a new div element with the nos as its text
    $("<div>" + nos + "</div>")
      // Set the data-number attribute to the index + 1
      .data("number", index + 1)
      // Append the div element to the drop number slots element
      .appendTo("#drop__number-slots")
      // Make the div element droppable
      .droppable({
        // Set the accept option to the drag number slots div elements
        accept: "#drag__number-slots div",
        // Set the hoverClass option to hovered
        hoverClass: "hovered",
        // Define the drop function
        drop: controlDrop,
      });
  });
}

// Define the controlDrop function
function controlDrop(event, ui) {
  // Get the selected slot number
  var selectedSlot = $(this).data("number");
  // Get the card index
  var indexOfCard = ui.draggable.data("number");

  // If the selected slot number is equal to the card number
  if (selectedSlot == indexOfCard) {
    // Disable the draggable element
    ui.draggable.draggable("disable");
    // Disable the droppable element
    $(this).droppable("disable");
    // Position the draggable element above the droppable element
    ui.draggable.position({ of: $(this), my: "left top", at: "left top" });
    // Set the revert option to false
    ui.draggable.draggable("option", "revert", false);
    // Increment the correct card positions counter
    correctCardPositions++;
    // Set the background color, color, and font size of the draggable element
    ui.draggable.css({
      "background-color": "yellow",
      color: "black",
      "font-size": "65px",
    });
    score();
  }
}

function score() {
  // Show the score message
  $("#score")
    .show()
    .html("Your Score is: " + correctCardPositions + "/10");
}

// Define the showMessage function
function showMessage() {
  // Show the win message by setting its display property to block and setting its position
  $("#winMsg").show().css({
    left: "580px",
    top: "150px",
    width: "500px",
    height: "300px",
  });
}
//Define the loss message
function showLossMessage() {
  $("#lossMsg").show().css({
    left: "580px",
    top: "150px",
    width: "500px",
    height: "300px",
  });
}

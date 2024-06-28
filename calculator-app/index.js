let display = document.getElementById("display");
let operators = ["+", "-", "*", "/"];

function changeColor() {
  let selectedColor = document.querySelector(
    'input[name="color"]:checked'
  ).value;
  document.body.style.backgroundColor = selectedColor;
}

function appendNumber(number) {
  display.value += number;
}

function appendOperator(operator) {
  if (display.value === "") {
    return; //empty input check
  }
  let lastChar = display.value.charAt(display.value.length - 1); //get last character
  if (operators.indexOf(lastChar) !== -1) {
    return; //duplicate operator check
  }
  display.value += operator;
}

function clearDisplay() {
  display.value = "";
}
function backspace() {
  let currentValue = display.value;
  if (currentValue.length > 0) {
    display.value = currentValue.slice(0, -1);
  }
}
function calculate() {
  let expression = display.value;
  let result = eval(expression);
  display.value = result;
}

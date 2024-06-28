// Get the form element
const form = document.getElementById("myForm");

// Define an array of field objects, each with properties for the form element, error element, validation function, and error message
const fields = [
  {
    element: document.getElementById("username"),
    errorElement: document.getElementById("usernameError"),
    validate: (value) => value.length >= 5,
    errorMessage: "Username must be at least 5 characters long",
  },
  {
    element: document.getElementById("email"),
    errorElement: document.getElementById("emailError"),
    validate: (value) =>
      /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/.test(value),
    errorMessage: "Please enter a valid email address",
  },
  {
    element: document.getElementById("password"),
    errorElement: document.getElementById("passwordError"),
    validate: (value) =>
      /^(?=.*[A-Z])(?=.*[!@#$%^&*(),.?":{}|<>])[a-zA-Z0-9!@#$%^&*(),.?":{}|<>]{8,}$/.test(
        value
      ),
    errorMessage:
      "Password must be at least 8 characters long, contain at least one uppercase letter and one special character.",
  },
  {
    element: document.getElementById("phonenum"),
    errorElement: document.getElementById("phoneNumError"),
    validate: (value) =>
      /^(\+\d{1,2}\s?)?1?\-?\.?\s?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/.test(
        value
      ),
    errorMessage: "Please enter a valid Phone Number",
  },
  {
    element: document.getElementById("zipcode"),
    errorElement: document.getElementById("zipCodeError"),
    validate: (value) =>
      /^(\d{5}(-\d{4})?|[a-zA-Z]\d[a-zA-Z] \d[a-zA-Z]\d)$/.test(value),
    errorMessage:
      "Please enter a valid zipcode like 12345,12345-6789,AB1-2CD-3 etc",
  },
  {
    element: document.getElementById("about"),
    errorElement: document.getElementById("aboutUsError"),
    validate: (value) => value.length >= 25,
    errorMessage: "About us must have atleast 25  characters.",
  },
];

// Define a function that takes a field object and returns a function that validates the field value using the validate function and returns the error message if the validation fails
const validateField = (field) => (value) =>
  field.validate(value)
    ? ""
    : `${field.errorMessage}\n${field.errorElement.previousElementSibling.innerText}`;

// Define a function that clears all error messages for each field
const clearErrorMessages = () =>
  fields.forEach((field) => (field.errorElement.innerText = ""));

// Add an event listener to the form that listens for the submit event
form.addEventListener("submit", (event) => {
  // Clear all error messages
  clearErrorMessages();

  // Check if all fields are valid
  const isValid = fields.every(
    (field) =>
      field.element.value.length > 0 && field.validate(field.element.value)
  );

  // If not all fields are valid, prevent the form from submitting and display the error messages
  if (!isValid) {
    event.preventDefault();
    fields.forEach((field) => {
      field.errorElement.innerText = validateField(field)(field.element.value);
    });
  }
});

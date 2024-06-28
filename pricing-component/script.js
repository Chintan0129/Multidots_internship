const range = document.getElementById("second__range");
const toggleBtn = document.getElementById("toggle");
const totalPriceDisplay = document.getElementById("total-price");
const sliderValue = document.querySelector(".value2");
const viewers = document.querySelector(".main__pageviews");

// Function to update the total price based on quantity and discount toggle state
function updateTotalPrice() {
  // Get the current quantity value from the range input
  const quantity = parseInt(range.value);
  // Check if the discount toggle is checked
  const discountApplied = toggleBtn.checked;

  // Set the price per pageview and total pageviews based on the quantity
  let pricePerPageview = 0.08;
  let totalPageviews = 0;
  let totalPrice = 0;

  if (quantity === 0) {
    pricePerPageview = 0.08;
    totalPageviews = 10;
  } else if (quantity === 25) {
    pricePerPageview = 0.12;
    totalPageviews = 50;
  } else if (quantity === 50) {
    pricePerPageview = 0.16;
    totalPageviews = 100;
  } else if (quantity === 75) {
    pricePerPageview = 0.24;
    totalPageviews = 500;
  } else if (quantity === 100) {
    pricePerPageview = 0.36;
    totalPageviews = 1000;
  }

  // Calculate the total price
  totalPrice = pricePerPageview * totalPageviews;

  // If the discount toggle is checked, apply a 25% discount
  if (discountApplied) {
    totalPrice *= 0.75;
  }

  // Update the total price and pageviews display
  totalPriceDisplay.textContent = `$${totalPrice.toFixed(2)}`;
  viewers.textContent = `${totalPageviews}k pageviews`;
}

// Event listeners to update the quantity and total price when range or toggle changes
range.addEventListener("input", function (e) {
  // Update the slider value display
  const tempSliderValue = e.target.value;
  sliderValue.textContent = tempSliderValue;

  // Update the range input background gradient based on the current value
  const rangebar = (tempSliderValue / range.max) * 100;
  range.style.background = `linear-gradient(to right, #a5f3eb ${rangebar}%, #eaeefb ${rangebar}%)`;

  // calling function
  updateTotalPrice();
});

toggleBtn.addEventListener("change", updateTotalPrice);

updateTotalPrice();

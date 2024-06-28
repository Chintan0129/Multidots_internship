// Utility functions
const selectElement = (selector) => document.querySelector(selector);
const $ = (selector) => selectElement(selector);

// Element references
const bodyElement = $("body");
const mainContainerElement = $("#mainContainer");
const quoteContainerElement = $("#quoteBlock");
const timeContainerElement = $("#timeBlock");
const quoteElement = $("#quoteContent");
const authorElement = $("#quoteAuthor");
const newQuoteButtonElement = $("#newQuoteBtn");
const greetingElement = $("#greetingText");
const timeIconElement = $("#timeIcon");
const userTimeElement = $("#currentTime");
const abbreviationElement = $("#timeAbbreviation");
const userLocationElement = $("#userLoc");
const currentTimezoneElement = $("#currentTimezone");
const dayOfTheYearElement = $("#dayOfTheYear");
const dayOfTheWeekElement = $("#dayOfTheWeek");
const weekNumberElement = $("#weekNumber");
const expandButtonElement = $("#expandButton");
const expandTextElement = $("#expandButtonText");
const expandIconElement = $("#expandButtonIcon");
const moreInfoElement = $("#moreDetails");

// Fetch data
const fetchData = async (url) => {
  try {
    const response = await fetch(url);
    if (!response.ok) {
      throw new Error(`HTTP error: ${response.status}`);
    }
    return await response.json();
  } catch (err) {
    console.log(err);
  }
};

// Fetch a new quote
const fetchQuote = async () => {
  const quoteData = await fetchData("https://api.quotable.io/random");
  quoteElement.innerHTML = quoteData.content;
  authorElement.innerHTML = quoteData.author;
};

// Fetch current time and location
const fetchLocationTime = async () => {
  const locationTimeData = await fetchData("./php/get_location_timezone.php");
  updateUI(locationTimeData);
};

// Update various UI elements
const updateUI = (data) => {
  userLocationElement.innerHTML = `${data.city}, ${data.countryCode}`;
  abbreviationElement.innerHTML = data.abbreviation;
  currentTimezoneElement.innerHTML = data.timezone;
  dayOfTheYearElement.innerHTML = data.day_of_year;
  dayOfTheWeekElement.innerHTML = data.day_of_week;
  weekNumberElement.innerHTML = data.week_number;
};

// Update time
const updateTime = async () => {
  const timeData = await fetchData("./php/display_time.php");
  updateTimeUI(timeData);
};

// Update time UI
const updateTimeUI = (timeData) => {
  greetingElement.innerHTML = timeData.greeting;

  const { hour, minute } = timeData;

  // Change theme and icon based on time ofday
  if (hour < 5 || hour >= 18) {
    bodyElement.classList.replace("sun", "moon");
    timeIconElement.src = "assets/desktop/icon-moon.svg";
  } else {
    bodyElement.classList = "sun";
    timeIconElement.src = "assets/desktop/icon-sun.svg";
  }

  // Update displayed time
  userTimeElement.innerHTML = `${hour}:${minute}`;
};

// Add event listeners
document.addEventListener("DOMContentLoaded", async () => {
  // Fetch initial data
  await Promise.all([fetchQuote(), fetchLocationTime()]);
  updateTime();

  // Event listener for clicking the "New Quote" button
  newQuoteButtonElement.addEventListener("click", fetchQuote);

  // Event listener for clicking the "Expand" button
  expandButtonElement.addEventListener("click", () => {
    // Check if more information is currently shown
    const isShowingMoreInfo =
      moreInfoElement.classList.contains("show-less-info");

    // Toggle visibility of more information
    moreInfoElement.classList.toggle("show-less-info");
    quoteContainerElement.classList.toggle("hidden");
    mainContainerElement.classList.toggle("less-info");
    timeContainerElement.classList.toggle("less-time-info");

    // Change expand button text and icon based on visibility state
    expandIconElement.src = isShowingMoreInfo
      ? "assets/desktop/icon-arrow-up.svg"
      : "assets/desktop/icon-arrow-down.svg";

    expandTextElement.textContent = isShowingMoreInfo ? "Less" : "More";
  });
});

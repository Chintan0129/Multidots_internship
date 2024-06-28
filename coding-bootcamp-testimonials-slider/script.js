const tanya = document.querySelector(".hero-banner-tanya");
const john = document.querySelector(".hero-banner-john");
// Taking the next and previous button of both the slide
const prevBtn = document.querySelectorAll(".hero-profile__prev-btn");
const nextBtn = document.querySelectorAll(".hero-profile__next-btn");

// Adding Condition for Slide changes by adding and removing class hidden
const changeSlide = () => {
  if (tanya.classList.contains("hidden")) {
    john.classList.add("hidden");
    tanya.classList.remove("hidden");
  } else if (john.classList.contains("hidden")) {
    john.classList.remove("hidden");
    tanya.classList.add("hidden");
  } else {
    john.classList.add("hidden");
  }
};

// Adding eventlistener for each button when the user click
prevBtn.forEach((slide) => {
  slide.addEventListener("click", changeSlide);
});

nextBtn.forEach((slide) => {
  slide.addEventListener("click", changeSlide);
});

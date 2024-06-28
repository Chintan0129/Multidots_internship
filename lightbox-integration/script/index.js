let slideIndex = 1;
showSlide(slideIndex);
// opening lightbox
function openLightbox() {
  document.getElementById("Lightbox").style.display = "block";
}
// for closing the ligthbox
function closeLightbox() {
  document.getElementById("Lightbox").style.display = "none";
}
// for silde change
function changeSlide(n) {
  showSlide((slideIndex += n));
}

function toSlide(n) {
  showSlide((slideIndex = n));
}
// This is the logic for the light box. It will decide which slide to show

function showSlide(n) {
  const slides = document.getElementsByClassName("slide");

  if (n > slides.length) {
    slideIndex = 1;
  }

  if (n < 1) {
    slideIndex = slides.length;
  }

  for (let i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }

  slides[slideIndex - 1].style.display = "block";
}

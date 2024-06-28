const component = document.getElementById("links");
const btn = document.getElementsByTagName("button");
const img = document.getElementsByTagName("img");

validate();
function validate() {
  if (component.style.display == "none") {
    component.style.display = "flex";
    btn[0].style.backgroundColor = "#6E8098";
    img[2].style.filter = "brightness(100)";
  } else {
    component.style.display = "none";
    btn[0].style.backgroundColor = "#ECF2F8";
    img[2].style.filter = "unset";
  }
}

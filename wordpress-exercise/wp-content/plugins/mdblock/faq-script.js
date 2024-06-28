document.addEventListener("DOMContentLoaded", function () {
	document.querySelectorAll(".toggle-answer").forEach(function (button) {
		button.addEventListener("click", function () {
			var answer = this.parentElement.nextElementSibling;
			if (answer.style.display === "none" || answer.style.display === "") {
				answer.style.display = "block";
				this.textContent = "▲";
			} else {
				answer.style.display = "none";
				this.textContent = "▼";
			}
		});
	});
});

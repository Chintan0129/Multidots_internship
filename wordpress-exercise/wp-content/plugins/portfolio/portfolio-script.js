jQuery(document).ready(function ($) {
	$(".read-more").click(function (e) {
		e.preventDefault();
		var contentWrapper = $(this).closest(".portfolio-content-wrapper");
		var limitedContent = contentWrapper.find(".portfolio-limited-content");
		var fullContent = contentWrapper.find(".portfolio-full-content");
		limitedContent.toggle();
		fullContent.toggle();
		$(this).text(function (i, text) {
			return text === "Read More" ? "Read Less" : "Read More";
		});
	});
});

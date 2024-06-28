$(document).ready(function () {
  const $li = $("header nav a"); //stores all <a> tag element in li
  const $sec = $("section"); //stores all sections in sec

  $(window).on("scroll", function () {
    //attach event listner to window on scrolling the page
    $li.removeClass("active").css("text-decoration", "none"); //remove active class from nav and also remove underline
    //filtering for visible section
    const visibleSection = $sec.filter((i, el) => {
      //filter method on sec is use to find current  view port section based on the scroll position
      const top = $(el).offset().top;
      const bottom = top + $(el).outerHeight();
      return (
        top <= $(window).scrollTop() + 100 &&
        bottom >= $(window).scrollTop() + 100
      );
    });
    // getting indexed and highlighting the link
    const index = $sec.index(visibleSection); //This finds the index of the visible section in the $sec jQuery object.
    $li.eq(index).addClass("active").css("text-decoration", "underline"); //adds the "active" class to the corresponding navigation link
  });
});

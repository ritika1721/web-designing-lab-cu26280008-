// Customer Rating Stars

document.querySelectorAll(".stars").forEach(function(star) {

    let rating = Number(star.getAttribute("data-rating"));

    if (rating >= 1 && rating <= 5) {
        star.setAttribute("aria-label", rating + " out of 5 stars");
    }

});
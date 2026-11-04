// Image Carousel

let currentSlide = 0;

const slides = document.querySelectorAll(".slide");

function showSlide(index) {

    slides.forEach(slide => {
        slide.classList.remove("active");
        slide.setAttribute("aria-hidden", "true");
    });

    currentSlide = (index + slides.length) % slides.length;

    slides[currentSlide].classList.add("active");
    slides[currentSlide].setAttribute("aria-hidden", "false");

    document.getElementById("slideStatus").textContent =
        (currentSlide + 1) + " / " + slides.length;
}

document.getElementById("nextSlide").onclick = function () {
    showSlide(currentSlide + 1);
};

document.getElementById("prevSlide").onclick = function () {
    showSlide(currentSlide - 1);
};
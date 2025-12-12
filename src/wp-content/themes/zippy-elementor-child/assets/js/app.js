import "./components/post_search_list";

$(document).ready(function ($) {});

document.addEventListener("DOMContentLoaded", function () {
  const slides = document.querySelectorAll(".homepage-slider .slider");
  let current = 0;

  function showSlide(index) {
    slides.forEach((slide, i) => {
      slide.classList.toggle("active", i === index);
    });
  }

  showSlide(current);

  const interval = setInterval(() => {
    current = (current + 1) % slides.length;
    showSlide(current);
  }, 8000);

  const prevBtn = document.createElement("button");
  prevBtn.className = "slider-nav prev";
  prevBtn.innerHTML = "&#10094;";
  const nextBtn = document.createElement("button");
  nextBtn.className = "slider-nav next";
  nextBtn.innerHTML = "&#10095;";

  const sliderWrapper = document.querySelector(".homepage-slider");
  sliderWrapper.appendChild(prevBtn);
  sliderWrapper.appendChild(nextBtn);

  prevBtn.addEventListener("click", () => {
    current = (current - 1 + slides.length) % slides.length;
    showSlide(current);
  });

  nextBtn.addEventListener("click", () => {
    current = (current + 1) % slides.length;
    showSlide(current);
  });
});

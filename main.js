// Navbar toggle
const menuBtn = document.getElementById("menu-btn");
const navLinks = document.getElementById("nav-links");
const menuBtnIcon = menuBtn.querySelector("i"); // Assuming <i> tag inside menu button

menuBtn.addEventListener("click", () => {
  navLinks.classList.toggle("active");
  const isActive = navLinks.classList.contains("active");
  menuBtnIcon.setAttribute("class", isActive ? "ri-close-line" : "ri-menu-line");
});

navLinks.addEventListener("click", (e) => {
  if (e.target.tagName === "A") {
    navLinks.classList.remove("active");
    menuBtnIcon.setAttribute("class", "ri-menu-line");
  }
});

const navSearch = document.getElementById("nav-search");
const searchIcon = document.getElementById("search-icon");
const dropdown = document.getElementById("myDropdown");

// Toggle search animation (if used)
navSearch.addEventListener("click", () => {
  navSearch.classList.toggle("open");
});

// Toggle dropdown on clicking search icon
searchIcon.addEventListener("click", (e) => {
  e.stopPropagation();
  const dropdown = document.getElementById("myDropdown");
  dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
});
// Hide dropdown when clicking outside
document.addEventListener("click", (e) => {
  const dropdown = document.getElementById("myDropdown");
  if (!e.target.closest("#nav-search") && dropdown.style.display === "block") {
    dropdown.style.display = "none";
  }
});




// ScrollReveal settings
const scrollRevealOption = {
  distance: "50px",
  origin: "bottom",
  duration: 1000,
  reset: true,
};


// Header animation
ScrollReveal().reveal(".header__image img", {
  ...scrollRevealOption,
  origin: "right",
});
ScrollReveal().reveal(".header__content div", {
  duration: 1000,
  delay: 500,
});
ScrollReveal().reveal(".header__content h1", {
  ...scrollRevealOption,
  delay: 1000,
});
ScrollReveal().reveal(".header__content p", {
  ...scrollRevealOption,
  delay: 1500,
});

// Deals section
ScrollReveal().reveal(".deals__card", {
  ...scrollRevealOption,
  interval: 300,
});

// About section
ScrollReveal().reveal(".about__image img", {
  ...scrollRevealOption,
  origin: "right",
});
ScrollReveal().reveal(".about__card", {
  duration: 1000,
  interval: 400,
  delay: 500,
});

// Testimonial Swiper slider
const swiper = new Swiper(".testimonial-slider", {
  loop: true,
  autoplay: {
    delay: 4000,
    disableOnInteraction: false,
  },
  spaceBetween: 30,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
});

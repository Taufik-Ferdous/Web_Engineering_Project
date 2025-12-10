"use strict";

const navToggleBtn = document.querySelector("[data-nav-toggle-btn]");
const header = document.querySelector("[data-header]");
const goTopBtn = document.querySelector("[data-go-top]");

if (navToggleBtn && header) {
  navToggleBtn.addEventListener("click", () => {
    header.classList.toggle("active");
  });
}

window.addEventListener("scroll", () => {
  if (!goTopBtn) return;
  if (window.scrollY >= 300) {
    goTopBtn.classList.add("active");
  } else {
    goTopBtn.classList.remove("active");
  }
});

if (goTopBtn) {
  goTopBtn.addEventListener("click", () => {
    window.scrollTo({ top: 0, behavior: "smooth" });
  });
}

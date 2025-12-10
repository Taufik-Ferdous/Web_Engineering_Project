"use strict";

const navToggleBtn = document.querySelector("[data-nav-toggle-btn]");
const header = document.querySelector("[data-header]");

if (navToggleBtn && header) {
  navToggleBtn.addEventListener("click", () => {
    header.classList.toggle("active");
  });
}

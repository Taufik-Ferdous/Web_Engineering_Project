"use strict";

const navToggleBtn = document.querySelector("[data-nav-toggle-btn]");
const header = document.querySelector("[data-header]");

if (navToggleBtn && header) {
  navToggleBtn.addEventListener("click", () => {
    header.classList.toggle("active");
  });
}

// Dummy form handler
const form = document.getElementById("contact-form");
const statusEl = document.getElementById("form-status");

if (form && statusEl) {
  form.addEventListener("submit", (e) => {
    e.preventDefault();
    statusEl.textContent = "Thank you! Your message has been received.";
    form.reset();
  });
}

"use strict";

const navToggleBtn = document.querySelector("[data-nav-toggle-btn]");
const header = document.querySelector("[data-header]");

if (navToggleBtn && header) {
  navToggleBtn.addEventListener("click", () => {
    header.classList.toggle("active");
  });
}

// Simple destination data
const destinations = {
  coxbazar: {
    title: "Cox's Bazar, Chattogram",
    subtitle: "World’s longest natural sea beach and a favorite holiday spot.",
    image:
      "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQLgfcqUkBbnjtQ21T8FY_vkuzCarfckf-nVQ&s",
    overview:
      "Cox's Bazar is Bangladesh's most popular beach destination, famous for its long sandy shoreline, colorful sunsets, and lively seaside town. It is ideal for families, couples, and friends looking to relax by the Bay of Bengal.",
    highlights: [
      "Enjoying sunrise and sunset walks on the 120 km long beach",
      "Visiting Kolatoli, Laboni, and Inani beaches",
      "Tasting fresh seafood at local restaurants",
      "Exploring nearby Himchari and marine drive",
    ],
    bestTime: "November to March for cooler, pleasant weather and calmer seas.",
    duration: "Ideal stay: 2–4 days.",
    budget:
      "Approx. ৳3,000–৳7,000 per person per day, depending on hotel and transport.",
    tour: "Try our ‘Cox’s Bazar Beach Escape’ package for a relaxed sea holiday.",
  },

  sylhet: {
    title: "Sylhet & Srimangal",
    subtitle: "Tea gardens, haor wetlands, and peaceful green landscapes.",
    image:
      "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ9TjQjsU5jch6qu6atTSi1DxiTq-KBDG8n_g&s",
    overview:
      "Sylhet and Srimangal are known for lush tea estates, rolling hills, and scenic wetlands. It’s a calm getaway where you can enjoy nature, local culture, and unique food.",
    highlights: [
      "Walking through endless tea gardens in Srimangal",
      "Exploring Ratargul Swamp Forest and Lalakhal",
      "Trying ‘7-layer tea’ and local snacks",
      "Visiting shrines and cultural sites in Sylhet city",
    ],
    bestTime: "October to March for comfortable weather; monsoon for lush greenery.",
    duration: "Ideal stay: 2–3 days.",
    budget:
      "Approx. ৳2,500–৳6,000 per person per day, depending on hotel and activities.",
    tour: "Book our ‘Sylhet Tea Garden Retreat’ for a nature-focused short trip.",
  },

  bandarban: {
    title: "Bandarban, Chattogram Hill Tracts",
    subtitle: "Misty hills, waterfalls, and indigenous culture.",
    image:
      "https://thumbs.dreamstime.com/b/landscape-debotakhum-waterfall-road-bandarban-251564263.jpg",
    overview:
      "Bandarban is one of the most scenic hill districts of Bangladesh, offering trekking routes, waterfalls, viewpoints, and rich indigenous culture.",
    highlights: [
      "Visiting Nilgiri, Nilachal, and Shoilo Propat",
      "Trekking through hills and forests",
      "Learning about local tribal communities",
      "Enjoying cool weather and cloud-covered hilltops",
    ],
    bestTime: "November to March for clear views and comfortable temperatures.",
    duration: "Ideal stay: 2–4 days.",
    budget:
      "Approx. ৳3,000–৳7,500 per person per day, depending on transport and stay.",
    tour: "Join our ‘Bandarban Adventure Trail’ for trekking and hilltop views.",
  },

  sundarbans: {
    title: "Sundarbans, Khulna",
    subtitle: "The world’s largest mangrove forest and wildlife haven.",
    image:
      "https://upload.wikimedia.org/wikipedia/commons/thumb/2/23/Sundarban_Tiger.jpg/1200px-Sundarban_Tiger.jpg",
    overview:
      "The Sundarbans is a UNESCO World Heritage Site and the largest mangrove forest on Earth. Boat safaris through narrow canals let you experience unique wildlife and untouched nature.",
    highlights: [
      "Boat cruising through rivers and canals",
      "Spotting deer, crocodiles, and rare birds",
      "Learning about mangrove ecosystems",
      "Visiting watchtowers and forest stations",
    ],
    bestTime: "November to February for cooler weather and safer boat trips.",
    duration: "Ideal stay: 2–3 days (usually by boat tour).",
    budget:
      "Approx. ৳4,000–৳9,000 per person per day, depending on boat type and group size.",
    tour: "Choose our ‘Sundarbans Wildlife Cruise’ for a full mangrove experience.",
  },
};

// Populate page from query
const params = new URLSearchParams(window.location.search);
const id = params.get("id");

const data = destinations[id] || destinations["coxbazar"];

document.getElementById("dest-title").textContent = data.title;
document.getElementById("dest-subtitle").textContent = data.subtitle;

const img = document.getElementById("dest-image");
img.src = data.image;
img.alt = data.title;

document.getElementById("dest-overview").textContent = data.overview;

const list = document.getElementById("dest-highlights");
list.innerHTML = "";
data.highlights.forEach((item) => {
  const li = document.createElement("li");
  li.textContent = item;
  list.appendChild(li);
});

document.getElementById("dest-best-time").textContent = data.bestTime;
document.getElementById("dest-duration").textContent = data.duration;
document.getElementById("dest-budget").textContent = data.budget;
document.getElementById("dest-tour").textContent = data.tour;

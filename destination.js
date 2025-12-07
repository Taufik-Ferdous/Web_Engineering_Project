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
  maldives: {
    title: "Malé, Maldives",
    subtitle: "A tropical paradise of turquoise lagoons and overwater villas.",
    image:
      "https://images.unsplash.com/photo-1500375592092-40eb2168fd21?auto=format&fit=crop&w=1200&q=80",
    overview:
      "The Maldives is a dream for beach lovers and honeymooners alike. Enjoy calm lagoons, vibrant coral reefs, and luxurious villas perched over the water. Whether you want to relax on white sands or explore underwater worlds, Malé is the perfect starting point.",
    highlights: [
      "Snorkeling and diving with colorful marine life",
      "Romantic sunset cruises",
      "Relaxing in private overwater villas",
      "World-class spa and wellness retreats",
    ],
    bestTime: "November to April for sunny, dry weather.",
    duration: "Ideal stay: 5–7 days.",
    budget: "Approx. $150–$350 per person per day, depending on resort.",
    tour: "Try our 'Maldives Lagoon Retreat' tour for the full overwater experience.",
  },
  bangkok: {
    title: "Bangkok, Thailand",
    subtitle: "A vibrant city of temples, markets, and sparkling nightlife.",
    image:
      "https://images.unsplash.com/photo-1506976785307-8732e854ad89?auto=format&fit=crop&w=1200&q=80",
    overview:
      "Bangkok blends ancient temples with modern skyscrapers and buzzing markets. Explore ornate palaces, savor street food, and cruise along the Chao Phraya River while discovering the city's rich culture.",
    highlights: [
      "Visiting the Grand Palace and Wat Pho",
      "Exploring floating and weekend markets",
      "Tasting world-famous Thai street food",
      "Enjoying rooftop bars with skyline views",
    ],
    bestTime:
      "November to February offers comfortable temperatures and less humidity.",
    duration: "Ideal stay: 3–5 days.",
    budget:
      "Approx. $60–$150 per person per day, depending on hotel and activities.",
    tour: "Our 'Bangkok City Highlights' tour covers the must-see landmarks.",
  },
  kathmandu: {
    title: "Kathmandu, Nepal",
    subtitle: "Gateway to the Himalayas and center of rich spiritual heritage.",
    image:
      "https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1200&q=80",
    overview:
      "Kathmandu is a city of temples, narrow alleys, and historic squares. It’s the starting point for many Himalayan treks and a destination in itself for culture and spirituality.",
    highlights: [
      "Exploring Durbar Square and ancient courtyards",
      "Visiting Swayambhunath (Monkey Temple)",
      "Day trips to nearby villages and viewpoints",
      "Sampling Nepali momos and local cuisine",
    ],
    bestTime: "September to November or March to May for clear skies.",
    duration: "Ideal stay: 4–7 days, longer if trekking.",
    budget:
      "Approx. $50–$120 per person per day, excluding multi-day treks.",
    tour: "Join our 'Himalayan Trekker' experience from Kathmandu.",
  },
  jakarta: {
    title: "Jakarta, Indonesia",
    subtitle:
      "A lively capital city with a mix of modern skylines and coastal escapes.",
    image:
      "https://images.unsplash.com/photo-1517821099605-271d7857790f?auto=format&fit=crop&w=1200&q=80",
    overview:
      "Jakarta is Indonesia's energetic capital, offering shopping, nightlife, and easy access to nearby islands. Discover local culture, museums, and beaches just outside the city.",
    highlights: [
      "Exploring the historic Kota Tua district",
      "Island-hopping in the Thousand Islands",
      "Discovering Indonesian cuisine and coffee",
      "Shopping in vibrant malls and markets",
    ],
    bestTime:
      "June to September for generally drier conditions and pleasant evenings.",
    duration: "Ideal stay: 3–5 days.",
    budget:
      "Approx. $70–$160 per person per day, depending on activities and hotels.",
    tour: "Choose our 'Jakarta & Beyond Explorer' for city and island experiences.",
  },
};

// Populate page from query
const params = new URLSearchParams(window.location.search);
const id = params.get("id");

const data = destinations[id] || destinations["maldives"];

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

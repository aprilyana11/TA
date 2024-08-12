"use strict";
document.addEventListener("DOMContentLoaded", function () {
    const qrContainer = document.getElementById("qr-container");
    const qrToggle = document.getElementById("qr-toggle");

    qrToggle.addEventListener("click", function () {
        if (
            qrContainer.style.display === "none" ||
            qrContainer.style.display === ""
        ) {
            qrContainer.style.display = "flex";
            qrToggle.innerHTML = '<ion-icon name="close-outline"></ion-icon>';
        } else {
            qrContainer.style.display = "none";
            qrToggle.innerHTML = '<ion-icon name="add-outline"></ion-icon>';
        }
    });
});

/**
 * navbar toggle
 */

const navOpenBtn = document.querySelector("[data-nav-open-btn]");
const navbar = document.querySelector("[data-navbar]");
const navCloseBtn = document.querySelector("[data-nav-close-btn]");

const navElemArr = [navOpenBtn, navCloseBtn];

for (let i = 0; i < navElemArr.length; i++) {
    navElemArr[i].addEventListener("click", function () {
        navbar.classList.toggle("active");
    });
}

/**
 * toggle navbar when click any navbar link
 */

const navbarLinks = document.querySelectorAll("[data-nav-link]");

for (let i = 0; i < navbarLinks.length; i++) {
    navbarLinks[i].addEventListener("click", function () {
        navbar.classList.remove("active");
    });
}

/**
 * header active when window scrolled down
 */

const header = document.querySelector("[data-header]");

window.addEventListener("scroll", function () {
    window.scrollY >= 50
        ? header.classList.add("active")
        : header.classList.remove("active");
});

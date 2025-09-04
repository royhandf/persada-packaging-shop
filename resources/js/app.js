import "./bootstrap";
import { Notyf } from "notyf";
import Alpine from "alpinejs";
import Swal from "sweetalert2";

window.Alpine = Alpine;
Alpine.start();

window.Swal = Swal;

window.notyf = new Notyf({
    duration: 2500,
    position: { x: "right", y: "top" },
});

document.addEventListener("DOMContentLoaded", () => {
    const darkModeToggle = document.getElementById("darkModeToggle");
    const htmlElement = document.documentElement;

    if (darkModeToggle) {
        const sunIcon = darkModeToggle.querySelector(".sun-icon");
        const moonIcon = darkModeToggle.querySelector(".moon-icon");

        const updateTheme = () => {
            if (htmlElement.classList.contains("dark")) {
                sunIcon.classList.add("hidden");
                moonIcon.classList.remove("hidden");
                localStorage.setItem("theme", "dark");
            } else {
                sunIcon.classList.remove("hidden");
                moonIcon.classList.add("hidden");
                localStorage.setItem("theme", "light");
            }
        };

        darkModeToggle.addEventListener("click", () => {
            htmlElement.classList.toggle("dark");
            updateTheme();
        });

        updateTheme();
    }
});

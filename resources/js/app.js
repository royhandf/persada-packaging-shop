import "./bootstrap";
import { Notyf } from "notyf";
import Alpine from "alpinejs";

window.Alpine = Alpine;
Alpine.start();

window.notyf = new Notyf({
    duration: 3000,
    position: { x: "right", y: "top" },
});

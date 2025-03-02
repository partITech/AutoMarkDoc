import { Controller } from "@hotwired/stimulus";
import { Offcanvas } from "bootstrap";

export default class extends Controller {
    static targets = ["menu", "toggler"];

    connect() {

        if (!this.hasMenuTarget) {
            console.error("Offcanvas not found");
            return;
        }

        this.offcanvasInstance = new Offcanvas(this.menuTarget);

        this.menuTarget.addEventListener("show.bs.offcanvas", () => {
            console.log("Offcanvas is being shown");
            this.menuTarget.classList.add("left-menu-is-visible");
        });

        this.menuTarget.addEventListener("shown.bs.offcanvas", () => {
            console.log("Offcanvas is now fully visible");
        });

        this.menuTarget.addEventListener("hide.bs.offcanvas", () => {
            console.log("Offcanvas is being hidden");
            this.menuTarget.classList.remove("left-menu-is-visible");
        });

        this.menuTarget.addEventListener("hidden.bs.offcanvas", () => {
            console.log("Offcanvas is now fully hidden");
        });
    }

    toggle(event) {
        event.preventDefault();
        this.offcanvasInstance.toggle();
    }
}

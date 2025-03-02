import { Controller } from "@hotwired/stimulus";
import { ScrollSpy } from "bootstrap";

export default class extends Controller {
    connect() {

        new ScrollSpy(document.body, {
            target: this.element.dataset.target || "#right-sidebar",
            offset: parseInt(this.element.dataset.offset, 10) || 10
        });
    }
}
// controllers/menu_controller.js
import { Controller } from "@hotwired/stimulus"

export default class extends Controller {
    connect() {
        const params = new URLSearchParams(window.location.search);
        const title = params.get('title');

        if (title) {
            const menuHeader = Array.from(this.element.querySelectorAll('h2'))
                .find(h2 => h2.textContent.trim() === title);

            if (menuHeader) {
                menuHeader.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }
    }
}

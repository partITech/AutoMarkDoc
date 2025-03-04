// image_modal_controller.js
import { Controller } from "@hotwired/stimulus";
import { Modal } from 'bootstrap';

export default class extends Controller {
    connect() {
        this.modal = new Modal(document.getElementById('imageModal'));

        // Ajouter un écouteur d'événement à toutes les images dans #main-content
        document.querySelectorAll('#main-content img').forEach(img => {
            img.addEventListener('click', this.openModal.bind(this, img.src));
        });
    }

    openModal(src) {
        // Mettre à jour la source de l'image dans la modal
        document.getElementById('modalImage').src = src;
        // Ouvrir la modal
        this.modal.show();
    }
}

import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

    connect() {
        const socket = new WebSocket('ws://localhost:8080/game');
        const form = document.querySelector('form');

        socket.onmessage = (event) => {
            form.requestSubmit();
        };
    }

    validate() {
        const socket = new WebSocket('ws://localhost:8080/game');

        setTimeout(() => {
            socket.send('validate');
        }, 500);
    }

}

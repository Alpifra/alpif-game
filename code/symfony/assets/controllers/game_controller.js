import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

    connect() {
        const socket = new WebSocket('ws://localhost:8080/game');
        const form = document.querySelector('form');

        socket.onmessage = (event) => {

            if (event.data === 'validate') {
                form.requestSubmit();
            } else if (event.data === 'refresh') {
                location.reload();
            }
        };
    }

    validate() {
        const socket = new WebSocket('ws://localhost:8080/game');

        setTimeout(() => {
            socket.send('validate');
        }, 500);
    }

    increase(event) {
        const player = event.target.dataset.player;
        const socket = new WebSocket('ws://localhost:8080/game');

        fetch(`/player/${player}/increase`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({}),
        })
        .then(response => response.json())
        .then(() => {
            setTimeout(() => {
                socket.send('refresh');
            }, 500);
        })
    }

    decrease(event) {
        const player = event.target.dataset.player;
        const socket = new WebSocket('ws://localhost:8080/game');

        fetch(`/player/${player}/decrease`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({}),
        })
        .then(response => response.json())
        .then(() => {
            setTimeout(() => {
                socket.send('refresh');
            }, 500);
        })
    }

}

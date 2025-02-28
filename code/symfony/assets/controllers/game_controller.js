import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

    static values = {
        wsEndpoint: String,
    }

    connect() {
        const socket = new WebSocket(this.wsEndpointValue + '/game');
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
        const socket = new WebSocket(this.wsEndpointValue + '/game');

        setTimeout(() => {
            socket.send('validate');
        }, 500);
    }

    increase(event) {
        const player = event.target.dataset.player;
        const socket = new WebSocket(this.wsEndpointValue + '/game');

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
        const socket = new WebSocket(this.wsEndpointValue + '/game');

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

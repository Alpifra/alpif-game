import { Controller } from '@hotwired/stimulus';
import { io } from "socket.io-client";

export default class extends Controller {

    static values = {
        wsEndpoint: String,
    }

    connect() {
        const socket = io(this.wsEndpointValue);
        const form = document.querySelector('form');

        socket.emit('joinRoom', 'game');

        socket.on('messageGame', (data) => {
            console.log(data);
            if (data === 'validate') {
                form.requestSubmit();
            } else if (data === 'refresh') {
                location.reload();
            }
        });
    }

    validate() {
        const socket = io(this.wsEndpointValue );

        socket.emit('messageGame', 'validate');
    }

    increase(event) {
        const player = event.target.dataset.player;
        const socket = io(this.wsEndpointValue );

        fetch(`/player/${player}/increase`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({}),
        })
        .then(response => response.json())
        .then(() => {
            socket.emit('messageGame', 'refresh');
        })
    }

    decrease(event) {
        const player = event.target.dataset.player;
        const socket = io(this.wsEndpointValue );

        fetch(`/player/${player}/decrease`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({}),
        })
        .then(response => response.json())
        .then(() => {
            socket.emit('messageGame', 'refresh');
        })
    }

}

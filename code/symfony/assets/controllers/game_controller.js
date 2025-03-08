import { Controller } from '@hotwired/stimulus';
import { io } from "socket.io-client";

export default class extends Controller {

    static values = {
        wsEndpoint: String,
        lobbyHash: String,
    }

    connect() {
        const socket = io(this.wsEndpointValue);
        const form = document.querySelector('form');
        const buzzed = [];

        socket.emit('joinRoom', 'game');

        socket.on('messageGame', (data) => {

            if (data === 'validate') {
                form.requestSubmit();
            } else if (data === 'refresh') {
                location.reload();
            } else if (data === 'blind_test') {
                location.href = `/lobby/${this.lobbyHashValue}/speed-test`;
            } else if (data === 'leaderboard') {
                location.href = `/lobby/${this.lobbyHashValue}/leaderboard`;
            } else {
                // speed buzz game
                const buzzedContainer = document.querySelector('.speed-player-container')

                if (buzzedContainer && !buzzed.includes(data)) {
                    buzzedContainer.innerHTML += ', ' + data;
                    buzzed.push(data);
                }
            }
        });
    }

    validate() {
        const socket = io(this.wsEndpointValue);

        socket.emit('messageGame', 'validate');
    }

    increase(event) {
        const player = event.target.dataset.player;
        const socket = io(this.wsEndpointValue);

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
        const socket = io(this.wsEndpointValue);

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

    switch(event) {
        const socket = io(this.wsEndpointValue);
        const target = event.target.dataset.target;

        if (target === 'blind_test') {
            socket.emit('messageGame', 'blind_test');
        } else {
            socket.emit('messageGame', 'leaderboard');
        }
    }

    buzz(event) {
        const button = event.target;
        const socket = io(this.wsEndpointValue);
        const player = event.target.dataset.player;

        button.classList.add('active');
        socket.emit('messageGame', player);
    }
}

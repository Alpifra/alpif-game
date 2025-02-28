import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

    static values = {
        wsEndpoint: String,
        avatar: String,
        username: String,
        url: String,
    }

    connect() {
        const socket = new WebSocket(this.wsEndpointValue + '/lobby');

        socket.onmessage = (event) => {
            if (event.data === 'start') {
                this.startGame();
            } else {
                this.updateLobby(event.data);
            }
        };

        setTimeout(() => {
            socket.send(JSON.stringify({
                avatar: this.avatarValue,
                username: this.usernameValue 
            }));
        }, 500);
    }

    start() {
        const socket = new WebSocket(this.wsEndpointValue + '/lobby');

        setTimeout(() => {
            socket.send('start');
        }, 500);
    }

    updateLobby(data) {

        const newUser = JSON.parse(data);
        const slots = document.querySelectorAll('.slot');
        const currentUsernames = [];

        slots.forEach(slot => {
            const currentUsername = slot.querySelector('.slot-username').innerHTML.trim();
            currentUsernames.push(currentUsername);
        });

        if (currentUsernames.includes(newUser.username)) return;

        const slot = document.querySelector('.slot.empty');
        const slotImage = slot.querySelector('.slot-image');
        let counter = document.querySelector('#lobbyCount');
        let newImage = document.createElement('img');

        // update counter
        counter.textContent = parseInt(counter.textContent) + 1;

        // update new user image
        newImage.src = `/img${newUser.avatar}`;
        slotImage.appendChild(newImage);
        slot.classList.remove('empty');

        // update new user username
        slot.querySelector('.slot-username').textContent = newUser.username;
    }

    startGame() {
        location.assign(location.href + '/question');
    }

}

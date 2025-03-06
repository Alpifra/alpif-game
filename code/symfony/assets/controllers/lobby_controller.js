import { Controller } from '@hotwired/stimulus';
import { io } from "socket.io-client";

export default class extends Controller {

    static values = {
        wsEndpoint: String,
        avatar: String,
        username: String,
        url: String,
    }

    connect() {
        const socket = io(this.wsEndpointValue);

        socket.emit('joinRoom', 'lobby');

        socket.emit('messageLobby', JSON.stringify({
            avatar: this.avatarValue,
            username: this.usernameValue 
        }));

        socket.on('messageLobby', (data) => {
            if (data === 'start') {
                this.startGame();
            } else {
                this.updateLobby(data);
            }
        });
    }

    start() {
        const socket = io(this.wsEndpointValue);

        socket.emit('messageLobby', 'start');
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

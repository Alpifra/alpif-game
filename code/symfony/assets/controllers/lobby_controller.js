import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

    static values = {
        avatar: String,
        username: String,
    }

    connect() {
        const avatar = this.element.dataset.avatar;
        const username = this.element.dataset.username;

        const socket = new WebSocket('ws://localhost:8080/lobby');
        this.avatar = avatar;
        this.username = username

        socket.onmessage = (event) => {
            this.updateLobby(event.data);
        };

        setTimeout(() => {
            socket.send(JSON.stringify({ avatar: avatar, username: username }));
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

}

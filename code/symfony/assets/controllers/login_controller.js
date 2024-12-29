import { Controller } from '@hotwired/stimulus';

/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * hello_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {

    static values = {
        avatars: Array,
        current: String,
    }

    connect() {
        this.avatars = JSON.parse(this.element.dataset?.avatars);
        this.current = this.element.dataset?.current

        const usernameInput = document.getElementById('player_join_username');
        const altUsernameInput = document.getElementById('player_create_username');

        usernameInput.addEventListener('input', () => { 
            altUsernameInput.value = usernameInput.value
        });
    }

    prevAvatar() {
        const img = this.element.querySelector('img');
        const index = this.avatars.indexOf(this.current) - 1;

        if (index >= 0) {
            this.current = this.avatars[index];
        } else {
            this.current = this.avatars[this.avatars.length - 1];
        }

        img.src = `/img/${this.current}`;
        this.updateInputs()
    }

    nextAvatar() {
        const img = this.element.querySelector('img');
        const index = this.avatars.indexOf(this.current) + 1;

        if (index < this.avatars.length) {
            this.current = this.avatars[index];
        } else {
            this.current = this.avatars[0];
        }

        img.src = `/img/${this.current}`;
        this.updateInputs()
    }

    updateInputs() {
        const inputs = document.querySelectorAll('.avatar-input');

        inputs.forEach(input => {
            input.value = this.current
        });
    }
}

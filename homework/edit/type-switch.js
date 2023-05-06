const homework_type_buttons = document.querySelectorAll('.button_divider-button');

for (const button of homework_type_buttons) {
    button.addEventListener('click', e => {
        for (const button of homework_type_buttons) {
            button.classList.remove('button_divider-button_active');
        }
        button.classList.add('button_divider-button_active');
        type = button.getAttribute('type-letter');
    });
}
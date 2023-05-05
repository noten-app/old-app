const class_selector = document.getElementById('class-selector');
const task_input = document.getElementById('task-input');
const date_input_input = document.getElementById('date_input-input');
const class_add_button = document.querySelector('.class_add');

class_add_button.addEventListener('click', () => {
    $.ajax({
        url: './add.php',
        type: 'POST',
        data: {
            class: class_selector.value,
            type: type,
            date_due: date_input_input.value,
            task: task_input.value
        },
        success: (data) => {
            console.log(data);
            if (data == "success") {
                location.assign("/homework");
            } else {
                console.log(data);
            }
        }
    });
});
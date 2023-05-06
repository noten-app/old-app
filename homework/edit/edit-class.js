const class_selector = document.getElementById('class-selector');
const task_input = document.getElementById('task-input');
const date_input_input = document.getElementById('date_input-input');
const class_edit_button = document.querySelector('.class_edit');

class_edit_button.addEventListener('click', () => {
    $.ajax({
        url: './edit.php',
        type: 'POST',
        data: {
            class: class_selector.value,
            type: type,
            task_id: task_id,
            date_due: date_input_input.value,
            task: task_input.value
        },
        success: (data) => {
            if (data == "success") {
                location.assign("/homework");
            } else {
                console.log(data);
            }
        }
    });
});
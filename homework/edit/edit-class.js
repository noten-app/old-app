const class_selector = document.getElementById('class-selector');
const task_input = document.getElementById('task-input');
const date_input_input = document.getElementById('date_input-input');
const class_edit_button = document.getElementById('task_save');
const task_mark_undone_button = document.getElementById('task_mark_undone');

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

task_mark_undone_button.addEventListener('click', () => {
    $.ajax({
        url: './state.php',
        type: 'POST',
        data: {
            status: 2,
            task_id: task_id
        },
        success: (data) => {
            console.log(data);
            if (data != "success") console.log(data);
            else $.ajax({
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
        }
    });
});
const grade_add_button = document.querySelector('.grade_add');
const date_input_input = document.getElementById('date_input-input');
const note_input = document.getElementById('note-input');

grade_add_button.addEventListener('click', () => {
    $.ajax({
        url: './add.php',
        type: 'POST',
        data: {
            grade: gradeFull,
            gradeModifier: gradeModifier,
            date: date_input_input.value,
            note: note_input.value,
            type: typeGrade,
            class: document.getElementById('class_id').innerText
        },
        success: (data) => {
            if (data === 'success') location.assign("/grades/class?class=" + document.getElementById('class_id').innerText);
            else {
                console.log(data);
            }
        }
    });
});
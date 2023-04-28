const grade_save_button = document.querySelector('#grade_save');
const date_input_input = document.getElementById('date_input-input');
const note_input = document.getElementById('note-input');

grade_save_button.addEventListener('click', () => {
    $.ajax({
        url: './edit.php',
        type: 'POST',
        data: {
            grade: gradeFull,
            gradeModifier: gradeModifier,
            date: date_input_input.value,
            note: note_input.value,
            type: typeGrade,
            grade_id: document.getElementById('grade_id').innerText
        },
        success: (data) => {
            if (data === 'success') history.back();
            else {
                document.body.innerHTML = data;
            }
        }
    });
});
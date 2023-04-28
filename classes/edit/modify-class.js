const classname_input = document.getElementById('name-input');
const grading_option_type_k = document.getElementById('grading_option-type_k');
const grading_option_type_m = document.getElementById('grading_option-type_m');
const grading_option_type_t = document.getElementById('grading_option-type_t');
const grading_option_type_s = document.getElementById('grading_option-type_s');
const classcolor_input = document.getElementById('color_input-input');
const class_save_button = document.getElementById('save_class')
const classID = document.getElementById('classID').innerText;

class_save_button.addEventListener('click', () => {
    $.ajax({
        url: './modify.php',
        type: 'POST',
        data: {
            classID: classID,
            className: classname_input.value,
            testCustom: test_custom,
            gradingTypeK: grading_option_type_k.value,
            gradingTypeM: grading_option_type_m.value,
            gradingTypeT: grading_option_type_t.value,
            gradingTypeS: grading_option_type_s.value,
            classColor: classcolor_input.value
        },
        success: (data) => {
            console.log(data);
            if (data == "success") {
                location.assign("/classes/class?class=" + classID);
            } else {
                console.log(data);
            }
        }
    });
});
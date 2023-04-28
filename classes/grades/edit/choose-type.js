var typeGrade = "";

const button_type_k = document.getElementById('type_k');
const button_type_m = document.getElementById('type_m');
const button_type_s = document.getElementById('type_s');
const button_type_t = document.getElementById('type_t');

function chooseType(type) {
    button_type_k.classList.remove('type_active');
    button_type_m.classList.remove('type_active');
    button_type_s.classList.remove('type_active');
    button_type_t.classList.remove('type_active');
    document.getElementById('type_' + type).classList.add('type_active');
    typeGrade = type;
}

button_type_k.addEventListener('click', () => chooseType("k"));
button_type_m.addEventListener('click', () => chooseType("m"));
button_type_s.addEventListener('click', () => chooseType("s"));
button_type_t.addEventListener('click', () => chooseType("t"));
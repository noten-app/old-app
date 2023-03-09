var typeGrade = "";

const button_type_k = document.getElementById('type_k');
const button_type_m = document.getElementById('type_m');
const button_type_o = document.getElementById('type_o');

function chooseType(type) {
    button_type_k.classList.remove('type_active');
    button_type_m.classList.remove('type_active');
    button_type_o.classList.remove('type_active');
    document.getElementById('type_' + type).classList.add('type_active');
    typeGrade = type;
}

button_type_k.addEventListener('click', () => chooseType("k"));
button_type_m.addEventListener('click', () => chooseType("m"));
button_type_o.addEventListener('click', () => chooseType("o"));
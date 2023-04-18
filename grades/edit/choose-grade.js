var gradeFull = 0;
var gradeModifier = 0;

const grade_container_1_6 = document.querySelector('.grade-container_1-6');
const grade_button_1 = document.querySelector('.gr1');
const grade_button_2 = document.querySelector('.gr2');
const grade_button_3 = document.querySelector('.gr3');
const grade_button_4 = document.querySelector('.gr4');
const grade_button_5 = document.querySelector('.gr5');
const grade_button_6 = document.querySelector('.gr6');

const grade_modifier_container = document.querySelector('.grade-modifier_container');
const grade_button_full = document.querySelector('.gr-full');
const grade_button_025 = document.querySelector('.gr-025');
const grade_button_050 = document.querySelector('.gr-050');
const grade_button_075 = document.querySelector('.gr-075');
const gr_full_grade = document.querySelector('#gr-full_grade');
const gr_025_grade = document.querySelector('#gr-025_grade');
const gr_050_grade = document.querySelector('#gr-050_grade');
const gr_075_grade = document.querySelector('#gr-075_grade');
const gr_full_container = document.querySelector('.gr-full');
const gr_025_container = document.querySelector('.gr-025');
const gr_050_container = document.querySelector('.gr-050');
const gr_075_container = document.querySelector('.gr-075');

function chooseGrade(grade) {
    grade_container_1_6.style.display = 'none';
    grade_modifier_container.style.display = 'grid';
    gr_full_grade.innerText = grade;
    gr_025_grade.innerText = grade + 0.25;
    gr_050_grade.innerText = grade + 0.5;
    gr_075_grade.innerText = grade + 0.75;
    if (grade === 6) {
        gr_full_container.classList.add('grade-modify_active');
        gr_025_container.style.display = 'none';
        gr_050_container.style.display = 'none';
        gr_075_container.style.display = 'none';
    }
    gradeFull = grade;
}

grade_button_1.addEventListener('click', () => chooseGrade(1));
grade_button_2.addEventListener('click', () => chooseGrade(2));
grade_button_3.addEventListener('click', () => chooseGrade(3));
grade_button_4.addEventListener('click', () => chooseGrade(4));
grade_button_5.addEventListener('click', () => chooseGrade(5));
grade_button_6.addEventListener('click', () => chooseGrade(6));

gr_full_container.addEventListener('click', () => chooseGradeModifier('full'));
gr_025_container.addEventListener('click', () => chooseGradeModifier('025'));
gr_050_container.addEventListener('click', () => chooseGradeModifier('050'));
gr_075_container.addEventListener('click', () => chooseGradeModifier('075'));

function chooseGradeModifier(grade) {
    gr_full_container.classList.remove('grade-modify_active');
    gr_025_container.classList.remove('grade-modify_active');
    gr_050_container.classList.remove('grade-modify_active');
    gr_075_container.classList.remove('grade-modify_active');
    document.querySelector('.gr-' + grade).classList.add('grade-modify_active');
    gradeModifier = grade;
}

function resetGradeModifier() {
    gr_full_container.classList.remove('grade-modify_active');
    gr_025_container.classList.remove('grade-modify_active');
    gr_050_container.classList.remove('grade-modify_active');
    gr_075_container.classList.remove('grade-modify_active');
    grade_modifier_container.style.display = 'none';
    grade_container_1_6.style.display = 'grid';
    gr_025_container.style.display = 'grid';
    gr_050_container.style.display = 'grid';
    gr_075_container.style.display = 'grid';
    gradeFull = 0;
    gradeModifier = 0;
}
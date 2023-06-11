var gradeFull = 0;
var gradeModifier = 0;
var highNumChosen = 0;
var modifierChosen = 0;

const grade_title = document.querySelector('.grade-title');
const grade_container_1_6 = document.querySelector('.grade-container_1-6');
const grade_modifier_container = document.querySelector('.grade-modifier_container');
const grade_button_full = document.querySelector('.gr-full');
const grade_button_minusone = document.querySelector('.gr-minusone');
const grade_button_minustwo = document.querySelector('.gr-minustwo');
const gr_full_text = document.querySelector('#gr-full_points');
const gr_minusone_text = document.querySelector('#gr-minusone_points');
const gr_minustwo_text = document.querySelector('#gr-minustwo_points');

function openModifiers(highNum) {
    grade_container_1_6.style.display = 'none';
    grade_modifier_container.style.display = 'grid';
    gr_full_text.innerText = highNum;
    if (highNum == 0) {
        grade_button_full.classList.add('grade-modify_active');
        grade_button_full.style.aspectRatio = '3/1';
        grade_button_full.style.width = grade_title.offsetWidth + "px";
        grade_button_full.style.backgroundColor = '#d14838';
        grade_button_minusone.style.display = 'none';
        grade_button_minustwo.style.display = 'none';
    } else {
        gr_minusone_text.innerText = highNum - 1;
        gr_minustwo_text.innerText = highNum - 2;
    }
    highNumChosen = highNum;
}

function modify(modifier) {
    grade_button_full.classList.remove('grade-modify_active');
    grade_button_minusone.classList.remove('grade-modify_active');
    grade_button_minustwo.classList.remove('grade-modify_active');
    if (modifier == 0) grade_button_full.classList.add('grade-modify_active');
    if (modifier == 1) grade_button_minusone.classList.add('grade-modify_active');
    if (modifier == 2) grade_button_minustwo.classList.add('grade-modify_active');
    modifierChosen = modifier;
    calcToGrade();
}

function resetGradeModifier() {
    grade_button_full.classList.remove('grade-modify_active');
    grade_button_minusone.classList.remove('grade-modify_active');
    grade_button_minustwo.classList.remove('grade-modify_active');
    grade_modifier_container.style.display = 'none';
    grade_container_1_6.style.display = 'grid';
    gradeFull = 0;
    gradeModifier = 0;
    grade_button_full.style.aspectRatio = '1/1';
    grade_button_full.style.width = "";
    grade_button_full.style.backgroundColor = '';
    grade_button_minusone.style.display = 'grid';
    grade_button_minustwo.style.display = 'grid';
}

function calcToGrade(){
    const points = highNumChosen - modifierChosen;
    switch(points){
        case 15:
            gradeFull = 0;
            gradeModifier = "075";
            break;
        case 14:
            gradeFull = 1;
            gradeModifier = "0";
            break;
        case 13:
            gradeFull = 1;
            gradeModifier = "025";
            break;
        case 12:
            gradeFull = 1;
            gradeModifier = "075";
            break;
        case 11:
            gradeFull = 2;
            gradeModifier = "0";
            break;
        case 10:
            gradeFull = 2;
            gradeModifier = "025";
            break;
        case 9:
            gradeFull = 2;
            gradeModifier = "075";
            break;
        case 8:
            gradeFull = 3;
            gradeModifier = "0";
            break;
        case 7:
            gradeFull = 3;
            gradeModifier = "025";
            break;
        case 6:
            gradeFull = 3;
            gradeModifier = "075";
            break;
        case 5:
            gradeFull = 4;
            gradeModifier = "0";
            break;
        case 4:
            gradeFull = 4;
            gradeModifier = "025";
            break;
        case 3:
            gradeFull = 4;
            gradeModifier = "075";
            break;
        case 2:
            gradeFull = 5;
            gradeModifier = "0";
            break;
        case 1:
            gradeFull = 5;
            gradeModifier = "025";
            break;
        case 0:
            gradeFull = 6;
            gradeModifier = "0";
            break;
    }
}
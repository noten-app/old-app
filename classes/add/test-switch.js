const test_behaviour_switch = document.querySelector('.test-behaviour-switch');
const test_behaviour_switch_all1 = document.getElementById('test-behaviour-switch_all1');
const test_behaviour_switch_custom = document.getElementById('test-behaviour-switch_custom');
const grading_option_tests = document.getElementById('grading-option_tests');
var test_custom = false;

test_behaviour_switch.addEventListener('click', function() {
    test_behaviour_switch_all1.classList.toggle('button_divider-button_active');
    test_behaviour_switch_custom.classList.toggle('button_divider-button_active');
    test_custom = !test_custom;
    if (test_custom) grading_option_tests.style.display = 'flex';
    else grading_option_tests.style.display = 'none';
});
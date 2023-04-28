const grade_delete_button = document.querySelector('#grade_delete');

grade_delete_button.addEventListener('click', () => {
    $.ajax({
        url: './delete.php',
        type: 'POST',
        data: {
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
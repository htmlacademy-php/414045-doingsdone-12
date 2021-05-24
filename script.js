'use strict';

var $checkbox = document.getElementsByClassName('show_completed');

if ($checkbox.length) {
    $checkbox[0].addEventListener('change', function (event) {
        var is_checked = +event.target.checked;

        var searchParams = new URLSearchParams(window.location.search);
        searchParams.set('show_completed', is_checked);

        window.location = '/index.php?' + searchParams.toString();
    });
}

var $taskCheckboxes = document.getElementsByClassName('tasks');

if ($taskCheckboxes.length) {
    $taskCheckboxes[0].addEventListener('change', function (event) {
        if (event.target.classList.contains('task__checkbox')) {
            var el = event.target;
            var task_id = el.getAttribute('value');

            var form = document.createElement('form');
            form.action = '/scripts/change_task_state.php';
            form.method = 'POST';

            form.innerHTML = '<input name="id_task_for_state_changing" value="' + task_id + '">';
            document.body.append(form);

            form.submit();
        }
    })
}

flatpickr('#date', {
    enableTime: false,
    dateFormat: "Y-m-d",
    locale: "ru"
});

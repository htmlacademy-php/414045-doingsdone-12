<?php
/**
 * @var int $user_id id пользователя
 */
require_once ('../bootstrap.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_task_for_state_changing'])) {
    change_task_done_state($user_id, $_POST['id_task_for_state_changing']);
    redirect_to_home();
}
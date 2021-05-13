<?php
/**
 * @var array $layout_data данные для шаблона layout.php
 */

require_once('../bootstrap.php');

$layout_data['content'] = include_template(
    'auth.php',
    get_form_auth_data()
);

print (include_template('layout.php', $layout_data));
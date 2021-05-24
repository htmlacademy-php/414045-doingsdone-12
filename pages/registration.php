<?php
/**
 * @var array $layout_data данные для шаблона layout.php
 */

require_once('../bootstrap.php');

$layout_data['content'] = include_template(
    'form_registration.php',
    get_form_registration_data()
);

print (include_template('layout.php', $layout_data));

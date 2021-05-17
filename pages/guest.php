<?php

require_once('../bootstrap.php');

$layout_data['content'] = include_template(
    'guest.php'
);

print (include_template('layout.php', $layout_data));
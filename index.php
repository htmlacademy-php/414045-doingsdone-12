<?php

require_once('bootstrap.php');

$layout_data = get_layout_data();

print(include_template('layout.php', $layout_data));

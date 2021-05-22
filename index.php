<?php
/**
 * @var array $layout_data данные для шаблона layout.php
 */

require_once(__DIR__.'/bootstrap.php');

redirect_guest();

print(include_template('layout.php', $layout_data));

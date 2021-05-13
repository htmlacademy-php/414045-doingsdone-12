<?php
/**
 * @var array       $layout_data         данные для шаблона layout.php
 */

require_once('bootstrap.php');

print(include_template('layout.php', $layout_data));

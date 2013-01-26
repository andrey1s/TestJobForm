<?php
$config = array(
    'dsn' => "mysql:dbname=test_form;host=localhost",
    'user' => "test_form",
    'pass' => "#8fGmAHV#8fGmAHV",
);
function __autoload($name) {
    include str_replace('\\', '/', $name).'.php';
}
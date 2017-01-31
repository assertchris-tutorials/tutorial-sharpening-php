<?php

require __DIR__ . "/vendor/autoload.php";

$sprocket = new App\Sprocket();
$sprocket->bar = "hello world";

print $sprocket->bar;

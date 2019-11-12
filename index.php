<?php

require 'vendor/autoload.php';

use Blue\Saber\View;

$dir = 'test';

$view = new View($dir);

$view->make('home');
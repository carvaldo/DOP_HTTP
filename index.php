<?php

use Doap\Sample\IndexController;

require __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

(new IndexController())->index();
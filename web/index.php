<?php

declare(strict_type = 1);

echo "Hello world!<br>";

if ($_SERVER['REMOTE_ADDR'] === '127.0.0.1') {
    echo "(Admin stuff)";
}

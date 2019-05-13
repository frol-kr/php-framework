<?php // web/index.php

declare(strict_type = 1);

if (isset($_GET['page']) && $_GET['page'] === 'foo') {
    echo "Foo page<br>";
} else {
    echo "Index page<br>";
}

if ($_SERVER['REMOTE_ADDR'] === '127.0.0.1') {
    echo "(Admin stuff)";
}

<?php

if ($_SERVER['SERVER_NAME'] == 'localhost') {
    define('DB_HOST', '127.0.0.1');
    define('DB_NAME', 'historical_weapons_catalog'); 
    define('DB_USER', 'root'); 
    define('DB_PASS', '');     
} else {
    define('DB_HOST', '127.0.0.1');
    define('DB_NAME', '*'); 
    define('DB_USER', '*');
    define('DB_PASS', 'EIVv91gM4isr');
}

define('DB_CHARSET', 'utf8mb4');

?>
<?php
define('ADMIN_USERNAME', 'admin');
// Generate a real hash with: php -r "echo password_hash('your-real-password', PASSWORD_DEFAULT);"
define('ADMIN_PASSWORD_HASH', password_hash('changeme', PASSWORD_DEFAULT));
?>

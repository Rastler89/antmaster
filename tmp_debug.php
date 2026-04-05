<?php
require_once 'config.php';
echo "BASE_URL is: [" . BASE_URL . "]\n";
echo "SCRIPT_NAME is: [" . ($_SERVER['SCRIPT_NAME'] ?? 'N/A') . "]\n";
echo "PHP_SELF is: [" . ($_SERVER['PHP_SELF'] ?? 'N/A') . "]\n";
?>

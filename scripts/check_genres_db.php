<?php
// CLI helper to list genres from the database configured in app/core/Db.php
if (php_sapi_name() !== 'cli') {
    echo "Run this script from the command line.\n";
    exit(1);
}

require_once __DIR__ . '/../app/core/Db.php';
use app\core\Db;

$db = new Db();
$res = $db->execQuery('SELECT id, genre FROM genres ORDER BY id ASC');

if ($res === false) {
    echo "Database query failed or table 'genres' not found.\n";
    exit(1);
}

if (empty($res)) {
    echo "No genres found in the database.\n";
    exit(0);
}

foreach ($res as $row) {
    echo sprintf("%s: %s\n", $row['id'], $row['genre']);
}

exit(0);

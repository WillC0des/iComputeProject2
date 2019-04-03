<?php
// If the unix socket is unavailable, try to connect using TCP. This will work
// if you're running a local MySQL server or using the Cloud SQL proxy, for example:
//
//     $ cloud_sql_proxy -instances=your-connection-name=tcp:3306
//
// This will mean your DSN for connecting locally to Cloud SQL would look like this:
//
//     // for MySQL
//     $dsn = "mysql:dbname=DATABASE;host=127.0.0.1";
//     // for PostgreSQL
//     $dsn = "pgsql:dbname=DATABASE;host=127.0.0.1";
//
$dsn = getenv('CLOUDSQL_DSN');
$user = getenv('CLOUDSQL_USER');
$password = getenv('CLOUDSQL_PASSWORD');

// create the PDO client
$db = new PDO($dsn, $user, $password);

// create the tables if they don't exist
$sql = 'CREATE TABLE IF NOT EXISTS entries (guestName VARCHAR(255), content VARCHAR(255))';
$stmt = $db->prepare($sql);
$stmt->execute();

// Insert a new row into the guestbook on POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $db->prepare('INSERT INTO entries (guestName, content) VALUES (:name, :content)');
    $stmt->execute([
        ':name' => $_POST['name'],
        ':content' => $_POST['content'],
    ]);
}

// Query existing guestbook entries.
$results = $db->query('SELECT * from entries');

// Now you can use the PDOStatement object to print or iterate over the results:
//
//     var_dump($results->fetchAll(PDO::FETCH_ASSOC));
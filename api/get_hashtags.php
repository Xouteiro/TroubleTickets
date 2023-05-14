<?php

// Assuming you have a database connection in $pdo
$stmt = $pdo->prepare('SELECT * FROM hashtags');
$stmt->execute();
$hashtags = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($hashtags);


?>
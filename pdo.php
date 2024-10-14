<?php
$pdo = new PDO('mysql:host=localhost;dbname=pendu_php', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


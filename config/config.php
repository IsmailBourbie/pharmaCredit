<?php
define("URL_ROOT", 'http://' . $_SERVER['HTTP_HOST'] . str_replace(
      $_SERVER["DOCUMENT_ROOT"], "", str_replace('\\', '/', dirname(__DIR__) . "/")));

define('SITE_NAME', 'Bourbie Pharm');
// if ($_SERVER['REQUEST_METHOD'] === "GET" || $_SERVER['REQUEST_METHOD'] === "POST") {
// 	header('Location: ' . URL_ROOT);
// }

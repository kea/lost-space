<?php

namespace LostSpace;

require_once(__DIR__."/../src/Directory.php");
require_once(__DIR__."/../src/FlashBag.php");

if (!isset($_GET['file'])) {
  exit('File parameter not set');
}

$fileToTrash = new Directory($_GET['file']);

$flashBag = new FlashBag();

if ($fileToTrash->moveToTrash()) {
  $flashBag->add("success", "File moved to trash");
} else {
  $flashBag->add("error", "Something went wrong");
}

header('Location: index.php');
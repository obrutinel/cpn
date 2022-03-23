<?php

use Wagaia\Lib;

$type = !empty($_POST['type']) ? $_POST['type'] : (!empty($_GET['type']) ? $_GET['type'] : null);
$parent = Lib::digital(!empty($_POST['parent']) ? $_POST['parent'] : (!empty($_GET['parent']) ? $_GET['parent'] : null));
$identifiant = !empty($_POST['id']) ? $_POST['id'] : ($_GET && isset($_GET['id']) ? Lib::digital($_GET['id']) : null);

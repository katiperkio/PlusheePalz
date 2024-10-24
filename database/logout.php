<?php

session_start();

session_destroy();

header("Location: /plusheepalz/index.php");
exit;

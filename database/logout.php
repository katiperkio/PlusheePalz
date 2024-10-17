<?php

session_start();

session_destroy();

header("Location: /plusheepalz/landing.php");
exit;

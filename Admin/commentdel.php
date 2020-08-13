<?php
require_once '../functions/functions.php';
if (!empty ($_GET['comdel'])) {
	comment_del($_GET['comdel']);
}
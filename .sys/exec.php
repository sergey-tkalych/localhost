<?php
	$exec = $_POST['exec'];
	$config = json_decode(file_get_contents('config.json'), true);
	$config['exec'] = $exec == 1 ? false : true;
	file_put_contents('config.json', json_encode($config));
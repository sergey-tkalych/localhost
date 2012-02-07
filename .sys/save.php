<?php
	$name = $_POST['name'];
	$href = $_POST['href'];

	$config = json_decode(file_get_contents('config.json'), true);
	if (isset($config['history'][$name])){
		unset($config['history'][$name]);
	}
	$config['history'][$name] = $href;
	file_put_contents('config.json', json_encode($config));
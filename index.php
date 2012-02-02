<?php
	include_once('lib.php');
	$directory = new Dir($system->documentRoot);
?>

<html>
	<head>
		<link rel="stylesheet" href="main.css" />
		<script src="jquery.js"></script>
		<script src="main.js"></script>
	</head>
	<body>
		<div id="page">
			<div id="header"><?php echo $system->serverAddr; ?></div>
			<div id="list">
				<ul class="directory">
					<li class="crumbs"></li>
					<?php foreach ($directory->list as $item): ?>
						<li href="<?php echo $item['type'] === 'dir' ? $item['documentPath'] : $item['webPath']; ?>" type="<?php echo $item['type']; ?>">
							<?php echo $item['name']; ?>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div id="footer"></div>
		</div>
	</body>
</html>
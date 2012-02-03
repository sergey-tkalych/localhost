<?php
	include_once('.sys/lib.php');
	$directory = new Dir($system->documentRoot, array('.git', '.svn', '.idea', '.sys'));
	$isiPad = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPad');
?>

<html>
	<head>
		<title><?php echo $system->serverAddr; ?></title>
		<link rel="stylesheet" href=".sys/main.css" />
		<script src=".sys/ext.js"></script>
		<?php if ($isiPad): ?>
			<script src=".sys/iscroll.js"></script>
		<?php else: ?>
			<link rel="stylesheet" href=".sys/browser.css" />
		<?php endif; ?>
		<script src=".sys/main.js"></script>
	</head>
	<body>
		<div id="page">
			<div id="header"><?php echo $system->serverAddr; ?></div>
			<div id="list">
				<div class="crumbs"></div>
				<div class="wrapper">
					<ul class="directory" documentRoot="<?php echo $system->documentRoot; ?>" relPath="<?php echo $directory->relPath; ?>">
						<?php foreach ($directory->list as $item): ?>
							<li href="<?php echo $item['type'] === 'dir' ? $item['documentPath'] : $item['webPath']; ?>" type="<?php echo $item['type']; ?>">
								<?php echo $item['name']; ?>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
			<div id="footer">
				<div class="content"></div>
			</div>
		</div>
	</body>
</html>
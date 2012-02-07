<?php
	include_once('.sys/lib.php');
	$directory = new Dir($system->documentRoot, array('.git', '.svn', '.idea', '.sys'));
	$isiPad = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPad');
?>

<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
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
			<div id="header">
				<?php echo $system->serverAddr; ?>
				<div class="exec-switcher">
					Execute index
					<span <?php echo $directory->config['exec'] ? '' : 'class="off"'; ?>>
						<?php echo $directory->config['exec'] ? ':)' : ':('; ?>
					</span>
				</div>
			</div>
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
				<div class="content">
					<a href=".sys/index.php">Old index</a>
				</div>
			</div>
		</div>
	</body>
</html>
<?php
	include_once('lib.php');
	$path = isset($_POST['href']) ? $_POST['href'] : $system->documentRoot;
	$directory = new Dir($path, array('.git', '.svn', '.idea', '.sys'));
?>

<div class="crumbs">
	<?php if ($directory->backPath): $splitRelPath = explode('/', $directory->relPath); ?>
		<span href="<?php echo $path = $system->documentRoot; ?>" type="dir">home</span>
		<?php for ($i = 0; $i < count($splitRelPath) - 2; $i++): ?>
			<span href="<?php echo $path .= $splitRelPath[$i].'/'; ?>" type="dir"><?php echo $splitRelPath[$i]; ?></span>
		<?php endfor; ?>
		<span class="cur"><?php echo $splitRelPath[count($splitRelPath) - 2]; ?></span>
	<?php endif; ?>
</div>
<div class="wrapper">
	<ul class="directory" documentRoot="<?php echo $system->documentRoot; ?>" relPath="<?php echo $directory->relPath; ?>">
		<?php if ($directory->backPath): ?>
			<li href="<?php echo $directory->backPath; ?>" type="dir">...</li>
		<?php endif; ?>
		<?php foreach ($directory->list as $item): ?>
			<li href="<?php echo $item['type'] === 'dir' ? $item['documentPath'] : $item['webPath']; ?>" type="<?php echo $item['type']; ?>">
				<?php echo $item['name']; ?>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
<?php
	$path = isset($_POST['href']) ? $_POST['href'] : $system->documentRoot;
	include_once('lib.php');
	$directory = new Dir($path);
?>

<li class="crumbs">
	<?php if ($directory->backPath): $splitRelPath = explode('/', $directory->relPath); ?>
		<span href="<?php echo $path = $system->documentRoot; ?>" type="dir">home</span>
		<?php for ($i = 0; $i < count($splitRelPath) - 2; $i++): ?>
			<span href="<?php echo $path .= $splitRelPath[$i].'/'; ?>" type="dir"><?php echo $splitRelPath[$i]; ?></span>
		<?php endfor; ?>
		<span class="cur"><?php echo $splitRelPath[count($splitRelPath) - 2]; ?></span>
	<?php endif; ?>
</li>
<?php if ($directory->backPath): ?>
	<li href="<?php echo $directory->backPath; ?>" type="dir">...</li>
<?php endif; ?>
<?php foreach ($directory->list as $item): ?>
	<li href="<?php echo $item['type'] === 'dir' ? $item['documentPath'] : $item['webPath']; ?>" type="<?php echo $item['type']; ?>">
		<?php echo $item['name']; ?>
	</li>
<?php endforeach; ?>
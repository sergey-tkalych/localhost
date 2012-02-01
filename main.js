(function(){
	$(window).bind('load', function(){
		var onResizeWindow = function(){
				var height = window.innerHeight - $('#header').innerHeight() - $('#footer').innerHeight();
				$('#list').css({height: height});
			},
			content = $('#list .directory'),
			onClick = function(){
				var href = $(this).attr('href'),
					type = $(this).attr('type');

				if (type === 'file' || type === 'exec'){
					window.location = href;
				}
				if (type === 'dir'){
					content.load('nav.php', {href: href}, function(){

					});
				}
			};

		onResizeWindow();
		$(window).bind('resize', onResizeWindow);

		$('li:not(.crumbs), li.crumbs span', content).live('click', onClick);
	});
})();
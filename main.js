window.addEventListener('load', function(){
	var list = document.getElementById('list'),
		header = document.getElementById('header'),
		footer = document.getElementById('footer'),
		content = list.querySelector('.directory'),
		onResizeWindow = function(){
			list.style.height = window.innerHeight - header.offsetHeight - footer.offsetHeight;
		},
		onClick = function(){
			var href = this.getAttribute('href'),
				type = this.getAttribute('type');

			if (type === 'file' || type === 'exec'){
				window.location = href;
			}
			if (type === 'dir'){
				var request = new XmlHttpRequest();
				request.onreadystatechange = function(){
					if (request.readyState == 4){
						content.innerHTML = request.responseText;
						content.querySelectorAll('li:nth-child(n+2), li.crumbs span:not(.cur)').forEach(function(el){
							el.addEventListener(events.start, onClick);
						});
					}
				};
				request.open('POST', 'nav.php');
				request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				request.send('href='+href);
			}
		};

	onResizeWindow();
	window.addEventListener('resize', onResizeWindow);

	content.querySelectorAll('li:nth-child(n+2)').forEach(function(el){
		el.addEventListener(events.start, onClick);
	});
});
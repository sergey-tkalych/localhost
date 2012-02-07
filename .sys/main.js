window.addEventListener('load', function(){
	var list = document.getElementById('list'),
		header = document.getElementById('header'),
		footer = document.getElementById('footer'),
		execSwitcher = header.querySelector('.exec-switcher'),
		createScroller = function(selector){
			if (!isiPad) return;
			return new iScroll(selector, {desktopCompatibility:true, vScrollbar: true});
		},
		scroller = createScroller(list.querySelector('.directory')),
		onResizeWindow = function(){
			var listHeight = window.innerHeight - header.offsetHeight - footer.offsetHeight;
			list.style.height = listHeight;
			list.querySelector('.wrapper').style.height = listHeight - list.querySelector('.crumbs').offsetHeight;
		},
		loadDirectory = function(href){
			new Post('.sys/nav.php', {href: href}, function(request){
				if (request.readyState == 4){
					list.innerHTML = request.responseText;
					var directory = list.querySelector('.directory');
					window.location.hash = directory.getAttribute('relPath');
					scroller = createScroller(directory);
					list.querySelectorAll('li, .crumbs span:not(.cur)').forEach(function(el){
						el.addEventListener(events.click, onClick);
					});
					onResizeWindow();
				}
			});
		},
		onClick = function(){
			var href = this.getAttribute('href'),
				type = this.getAttribute('type');

			if (type === 'file' || type === 'exec'){
				window.location = href;
			}
			if (type === 'dir'){
				loadDirectory(href);
			}
		},
		switcher = function(){
			execSwitcher.removeEventListener(events.start, switcher);
			var indicator = this.querySelector('span'),
				exec = indicator.hasClass('off') ? 0 : 1;
			indicator.addClass('waite');
			indicator.innerText = '?';
			new Post('.sys/exec.php', {exec: exec}, function(request){
				if (request.readyState == 4){
					window.location.reload();
				}
			});
		};

	onResizeWindow();
	window.addEventListener(events.resize, onResizeWindow);

	if (window.location.hash.length > 0){
		var directory = list.querySelector('.directory');
		loadDirectory(directory.getAttribute('documentRoot') + window.location.hash.replace('#', ''));
	}

	list.querySelectorAll('li').forEach(function(el){
		el.addEventListener(events.click, onClick);
	});

	execSwitcher.addEventListener(events.start, switcher);
});
document.addEventListener(events.move, function(){event.preventDefault();});
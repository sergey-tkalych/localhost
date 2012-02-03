window.addEventListener('load', function(){
	var list = document.getElementById('list'),
		header = document.getElementById('header'),
		footer = document.getElementById('footer'),
		wrapper = list.querySelector('.wrapper'),
		crumbs = list.querySelector('.crumbs'),
		createScroller = function(selector){
			if (!isiPad) return;
			return new iScroll(selector, {desktopCompatibility:true, vScrollbar: true});
		},
		scroller = createScroller(list.querySelector('.directory')),
		onResizeWindow = function(){
			list.style.height = window.innerHeight - header.offsetHeight - footer.offsetHeight;
			//wrapper.style.height = wrapper.offsetHeight - crumbs.offsetHeight;
		},
		onClick = function(){
			var href = this.getAttribute('href'),
				type = this.getAttribute('type');

			if (type === 'file' || type === 'exec'){
				window.location = href;
			}
			if (type === 'dir'){
				new Post('.sys/nav.php', {href: href}, function(request){
					if (request.readyState == 4){
						list.innerHTML = request.responseText;
						scroller = createScroller(list.querySelector('.directory'));
						list.querySelectorAll('li, .crumbs span:not(.cur)').forEach(function(el){
							el.addEventListener(events.click, onClick);
						});
					}
				});
			}
		};

	onResizeWindow();
	window.addEventListener(events.resize, onResizeWindow);

	list.querySelectorAll('li').forEach(function(el){
		el.addEventListener(events.click, onClick);
	});
});
document.addEventListener(events.move, function(){event.preventDefault();});
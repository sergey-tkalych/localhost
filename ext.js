(function (global) {
	var events = {
			isTouch:'ontouchstart' in window,
			start:this.isTouch ? 'touchstart' : 'mousedown',
			end:this.isTouch ? 'touchend' : 'mouseup'
		},
		augment = function (receivingClass, givingClass) {
			if (arguments[2]) {
				for (var i = 2, len = arguments.length; i < len; i++) {
					receivingClass.prototype[arguments[i]] = givingClass.prototype[arguments[i]];
				}
			}
			else {
				for (methodName in givingClass.prototype) {
					if (!receivingClass.prototype[methodName]) {
						receivingClass.prototype[methodName] = givingClass.prototype[methodName];
					}
				}
			}
		},
		XmlHttpRequest = function () {
			if(window.XMLHttpRequest){
				xmlhttp = new XMLHttpRequest();
			}else if (window.ActiveXObject){
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			if (xmlhttp == null) {
				alert("Your browser does not support XMLHTTP.");
			}
			return xmlhttp;
		};

	augment(NodeList, Array, 'forEach');

	global.events = events;
	global.XmlHttpRequest = XmlHttpRequest;
})(window);
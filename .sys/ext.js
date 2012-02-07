(function (global) {
	var isTouch = 'ontouchstart' in window,
		ua = navigator.userAgent,
		isiPad = /iPad/i.test(ua) || /iPhone OS 3_1_2/i.test(ua) || /iPhone OS 3_2_2/i.test(ua),
		events = {
			start:isTouch ? 'touchstart' : 'mousedown',
			move:isTouch ? 'touchmove' : 'mousemove',
			end:isTouch ? 'touchend' : 'mouseup',
			resize:'onorientationchange' in window ? 'orientationchange' : 'resize',
			click:'click'
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
		};

	function XmlHttpRequest() {
		var xmlhttp;
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		} else if (window.ActiveXObject) {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		if (xmlhttp == null) {
			alert("Your browser does not support XMLHTTP.");
		}
		return xmlhttp;
	}

	function Post(url, data, callback) {
		var request = new XmlHttpRequest(),
			params = '';
		request.onreadystatechange = function () {
			callback(request);
		};
		request.open('POST', url);
		request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		for (var property in data) {
			params += property + '=' + data[property]+'&';
		}
		if (params.length > 0){
			params = params.substr(0, params.length-1);
		}
		request.send(params);
	}

	augment(NodeList, Array, 'forEach');

	global.isTouch = isTouch;
	global.isiPad = isiPad;
	global.events = events;
	global.XmlHttpRequest = XmlHttpRequest;
	global.Post = Post;
})(window);

HTMLElement.prototype.hasClass = function (c) {
	var re = new RegExp("(^|\\s)" + c + "(\\s|$)", "g");
	return re.test(this.className);
};
HTMLElement.prototype.addClass = function (c) {
	if (this.hasClass(c)) {
		return this;
	}
	this.className = (this.className + " " + c).replace(/\s+/g, " ").replace(/(^ | $)/g, "");
	return this;
};
HTMLElement.prototype.removeClass = function (c) {
	var re = new RegExp("(^|\\s)" + c + "(\\s|$)", "g");
	this.className = this.className.replace(re, "$1").replace(/\s+/g, " ").replace(/(^ | $)/g, "");
	return this;
};
HTMLElement.prototype.toggleClass = function (c) {
	this.hasClass(c) ? this.removeClass(c) : this.addClass(c);
	return this;
};
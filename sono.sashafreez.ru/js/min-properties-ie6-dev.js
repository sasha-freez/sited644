/*
Min-properties IE6
 
	Список  элементов

	#body 	элемент с id="body" 
	body		все элементы с тегом <body>
	.body		все элементы с class="body"

	Возможно использование, как одиночного элемента:
		minProperties = document.getElementById ("body");
	так и массива элементов:
		minProperties = [document.getElementById ("body"), document.getElementById ("content")];
		или, к примеру:
		minProperties = document.getElementsByTagName ("body");

*/
minProperties = "body";
(function () {
	if (/msie 6/i.test (navigator.userAgent)) {		
		timer = setInterval(function(){
        if (/loaded|complete/.test(document.readyState)) {
	            clearInterval(timer);
	            preparams();
	        }
	    }, 10);
		window.attachEvent('onresize', preparamsResize);
	}
	oldval = 0;
	function minparams(){
		var element = minProperties;
		element.len = element.length;
	    for (i = 0; i < element.len; i++) {
	        if (element[i] != null) {
				if (element[i].currentStyle.minHeight != null) {
					var minheight = parseInt(element[i].currentStyle.minHeight);
					if (minheight != null && parseInt(element[i].clientHeight) < minheight) {
						element[i].style.height = minheight + "px";
					}
				}
	            if (document.documentElement.clientWidth != oldval && element[i].currentStyle['min-width'] != null) {
	                var minwidth = parseInt(element[i].currentStyle['min-width']);
	                if (minwidth != null && parseInt(element[i].clientWidth) < minwidth) {
	                    element[i].style.width = minwidth + "px";
						
	                }else {
	                    if (minwidth != null && parseInt(element[i].clientWidth) > minwidth || parseInt(element[i].clientWidth) == minwidth && document.documentElement.clientWidth > minwidth) {
	                        element[i].style.width = element[i].currentStyle['width'];
	                    }
	                }
					oldval = document.documentElement.clientWidth;
	            }
	        }
	    }
	    
	}
	function preparams(){
		minProperties = getIE6Element(minProperties);
	    minparams();
	}
	resizeInterval = 0;
	function preparamsResize(){
	    clearTimeout(resizeInterval);
	    resizeInterval = setTimeout(minparams, 100);
	}
	document.getElementsByClassName = function (className){
		var regExp = new RegExp("(^|\\s)" + className + "(\\s|$)");
		var elementsArray = new Array ();
		var elements = this.all;
		var length = elements.length;
		for (var i=0; i < length; i++) {
			temp = elements[i];
			if (regExp.test(temp.className))
				elementsArray[elementsArray.length] = temp;
		}
		return elementsArray;
	}
	function getIE6Element (elem) {
			if (typeof elem == "string") {
				elem.replace (/\s/, "");
				elem = elem.split (",");
				var releaseElem = new Array();
	 
				elem.len = elem.length;
	 
				for (var i=0; i<elem.len; i++) {		
					if (/#/.test (elem[i])) {
						elem.repl = document.getElementById (elem[i].replace (/#/, ""));
						if (elem.repl) {
							releaseElem[releaseElem.length] = elem.repl;
						}
					}else if (/\./i.test (elem[i])) {
						elem.repl = document.getElementsByClassName (elem[i].replace (/\./, ""));
						elem.repl.len = elem.repl.length;
						for (var r = 0; r < elem.repl.len; r++) {
							if (elem.repl[r]) {
								releaseElem[releaseElem.length] = elem.repl[r];
							}
						}
					}else {
						elem.repl = document.getElementsByTagName (elem[i]);
						elem.repl.len = elem.repl.length;
						for (var r = 0; r < elem.repl.len; r++) {
							if (elem.repl[r]) {
								releaseElem[releaseElem.length] = elem.repl[r];
							}
						}
					}
				}
				return releaseElem;
			}
			if (elem instanceof Array) {
				return elem;
			}
			return [elem];
	}
		
}).call (this);

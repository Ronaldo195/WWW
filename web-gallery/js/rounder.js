/*
CBB function by Roger Johansson, http://www.456bereastreet.com/

Modified Nifty Corners by:
Ilkka Huotari at http://www.editsite.net
Mathieu 'p01' HENRI at http://www.p01.org/
http://seky.nahory.net/2005/04/rounded-corners/
Steven Wittens at http://www.acko.net/anti-aliased-nifty-corners
Original Nifty Corners by Alessandro Fulciniti at http://pro.html.it/esempio/nifty/
*/
var Rounder = function() {
	
	var _insertTop = function(obj) {
		var oOuter, oInner;
		// Create the two div elements needed for the top of the box
		oOuter = document.createElement("div");
		oOuter.className = "bt"; // The outer div needs a class name
	    oInner = document.createElement("div");
	    oOuter.appendChild(oInner);
		obj.insertBefore(oOuter,obj.firstChild);
    };
	
	var _insertBottom = function(obj) {
		var oOuter, oInner;
		// Create the two div elements needed for the bottom of the box
		oOuter = document.createElement("div");
		oOuter.className = "bb"; // The outer div needs a class name
	    oInner = document.createElement("div");
	    oOuter.appendChild(oInner);
		obj.appendChild(oOuter);
	}; 
	
	var _add = function(el, bk, color, sizex, sizey, top) {
		var i, j;
		var d = document.createElement("div");
		d.style.backgroundColor = bk;
		var lastarc = 0;
		for (i = 1; i <= sizey; i++) {
			var coverage, arc, arc2, arc3;
			// Find intersection of arc with bottom of pixel row
			arc = Math.sqrt(1.0 - _sqr(1.0 - i / sizey)) * sizex;
			// Calculate how many pixels are bg, fg and blended.
			var n_bg = sizex - Math.ceil(arc);
			var n_fg = Math.floor(lastarc);
			var n_aa = sizex - n_bg - n_fg;
			// Create pixel row wrapper
			var x = document.createElement("div");
			var y = d;
			x.style.margin = "0px " + n_bg + "px";
			x.style.height = '1px';
			x.style.overflow = 'hidden';
			// Make a wrapper per anti-aliased pixel (at least one)
			for (j = 1; j <= n_aa; j++) {
				// Calculate coverage per pixel
				// (approximates circle by a line within the pixel)
				if (j == 1) {
					if (j == n_aa) {
						// Single pixel
						coverage = ((arc + lastarc) * 0.5) - n_fg;
					} else {
						// First in a run
						coverage = 0;
					}
				} else if (j == n_aa) {
					// Last in a run
					arc2 = Math.sqrt(1.0 - _sqr((sizex - n_bg - j + 1) / sizex)) * sizey;
					coverage = 1.0 - (1.0 - (arc2 - (sizey - i))) * (1.0 - (lastarc - n_fg)) * 0.5;
				} else {
					// Middle of a run
					arc3 = Math.sqrt(1.0 - _sqr((sizex - n_bg - j) / sizex)) * sizey;
					arc2 = Math.sqrt(1.0 - _sqr((sizex - n_bg - j + 1) / sizex)) * sizey;
					coverage = ((arc2 + arc3) * 0.5) - (sizey - i);
				}
				
				x.style.backgroundColor = _blend(bk, color, coverage);
				if (top) {
					y.appendChild(x);
				} else {
					y.insertBefore(x, y.firstChild);
				}
				y = x;
				x = document.createElement("div");
				x.style.height = '1px';
				x.style.overflow = 'hidden';
				x.style.margin = "0px 1px";
			}
			x.style.backgroundColor = color;
			if (top) {
				y.appendChild(x);
			} else {
				y.insertBefore(x, y.firstChild);
			}
			lastarc = arc;
		}
		if (top) {
			el.insertBefore(d, el.firstChild);
		} else {
			el.appendChild(d);
		}
	}; 
	
	var _blend = function(a, b, alpha) {
		var ca = [
			parseInt('0x' + a.substring(1, 3)), 
			parseInt('0x' + a.substring(3, 5)), 
			parseInt('0x' + a.substring(5, 7))
	  	];
		var cb = [
			parseInt('0x' + b.substring(1, 3)), 
			parseInt('0x' + b.substring(3, 5)), 
			parseInt('0x' + b.substring(5, 7))
	 	];
		return '#' + ('0'+Math.round(ca[0] + (cb[0] - ca[0])*alpha).toString(16)).slice(-2).toString(16) +
               ('0'+Math.round(ca[1] + (cb[1] - ca[1])*alpha).toString(16)).slice(-2).toString(16) +
               ('0'+Math.round(ca[2] + (cb[2] - ca[2])*alpha).toString(16)).slice(-2).toString(16);
	}; 
	
	var _getBgColor = function(element) {
		var val;
		try {
			var cs = document.defaultView.getComputedStyle(element, null);
			val = cs.getPropertyValue("background-color");
		} catch(ee) {
			if (element.currentStyle) {
				val = element.currentStyle.getAttribute("backgroundColor");
			}
		}
		if ((val.indexOf("rgba") > -1 || val == "transparent") && element.parentNode) {
			if (element.parentNode != document) {
				val = _getBgColor(element.parentNode);
			} else {
				val = '#FFFFFF';
			}
		}
		if (val.indexOf("rgb") > -1 && val.indexOf("rgba") == -1) {
			val = _rgb2hex(val);
		}
		if (val.length == 4) {
			val = '#'+val.substring(1,1)+val.substring(1,1)+val.substring(2,1)+val.substring(2,1)+val.substring(3,1)+val.substring(3,1);
		}
		return val;
	}; 
	
	var _rgb2hex = function(value) {
		var hex = '';
		var regexp = /([0-9]+)[, ]+([0-9]+)[, ]+([0-9]+)/;
		var array = regexp.exec(value);
		for (var i = 1; i < 4; i++) {
			hex += ('0'+parseInt(array[i]).toString(16)).slice(-2);
		}
		return '#'+hex;
	}; 

	var _sqr = function(x) {
	      return x*x;
	};

      var getElementsByClassName = function(requiredClass) {
          var requiredElements = [];
          var children = document.getElementsByTagName("*");
          var pattern = new RegExp("\\b"+requiredClass+"\\b");
          for (var i = 0, x = 0; i < children.length; i++) {
              if (pattern.test(children[i].className) ) {
                  requiredElements[x] = children[i];
                  x++;
              }
          }
          return requiredElements;
      }
	
	return {
		init: function(className) {
                  var roundedElements = getElementsByClassName("rounded");
                  for (var i = 0; i < roundedElements.length; i++) {
                      Rounder.addCorners(roundedElements[i], 8, 8);
                  }
			
			// Check that the browser supports the DOM methods used
			if (!className) className = "cbb";
			if (!document.getElementById || !document.createElement || !document.appendChild) return false;
			// Find all elements with a class name of cbb
			var oRegExp = new RegExp("(^|\\s)"+className+"(\\s|$)");

                  var elements = getElementsByClassName(className);
                  for (var i = 0; i < elements.length; i++) {
                      var oElement = elements[i];
				// 	Create a new element and give it the original element's class name(s) while replacing 'cbb' with 'cb'
				var oOuter = document.createElement('div');
				oOuter.className = oElement.className.replace(oRegExp, '$1cb$2');
				// Give the new div the original element's id if it has one
				if (oElement.getAttribute("id")) {
					var tempId = oElement.id;
					oElement.removeAttribute('id');
					oOuter.setAttribute('id', '');
					oOuter.id = tempId;
				}
				// Change the original element's class name and replace it with the new div
				oElement.className = 'i3';
				oElement.parentNode.replaceChild(oOuter, oElement);
				// Create two new div elements and insert them into the outermost div
				var oI1 = document.createElement('div');
				oI1.className = 'i1';
				oOuter.appendChild(oI1);
				var oI2 = document.createElement('div');
				oI2.className = 'i2';
				oI1.appendChild(oI2);
				// Insert the original element
				oI2.appendChild(oElement);
				// Insert the top and bottom divs
				_insertTop(oOuter);
				_insertBottom(oOuter);

                        var titleElements = getElementsByClassName("title");
                       for (var j = 0; j < titleElements.length; j++) {
                              var titleEl = titleElements[i];
					if (!titleEl.parentNode.className || titleEl.parentNode.className != "rounded-container") {
						Rounder.addCorners(titleEl, 4, 4, "rounded-container");
					}
				}
                  }
		},

		addCorners: function(el, sizex, sizey, outerClassName) {
			var color = _getBgColor(el);
			var bk = _getBgColor(el.parentNode);
			
			var outerEl = document.createElement('div');
			if (outerClassName) outerEl.className = "rounded-container";
			var tempEl = el.cloneNode(true);
			outerEl.appendChild(tempEl);
			el.parentNode.replaceChild(outerEl, el);
			_add(outerEl, bk, color, sizex, sizey, true);
			_add(outerEl, bk, color, sizex, sizey, false);
		}
	};
}();


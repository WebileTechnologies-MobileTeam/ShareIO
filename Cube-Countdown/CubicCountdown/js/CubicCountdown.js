;(function(){
	
	this.Cubic = function(userOptions){

		var self = this;

		this.change = function(userOptions) {

			oldOptions = options;

			oldElement = element;

			parseOptions(userOptions);

			modifyTimer();

			mountTimer();

		}

		this.start = function() {

			if (!running) {tick1000 = setInterval(tick1000Handler, 1000); running = true;}

		}

		this.stop = function() {

			if (running) {clearInterval(tick1000); running = false;}

		}

		this.remove = function() {

			if (!removed) {element.removeChild(timer); removed = true;}

		}

		this.restore = function() {

			if (removed) {element.appendChild(timer); removed = false;}

		}

		this.hide = function() {

			timer.style.display = "none";

		}

		this.show = function() {

			timer.style.display = "flex";

		}

		this.getTime = function(){

			var result = {};

			for (var key in times) {

				result[key] = times[key];

			}

			return result;

		}



		var SETTINGS = {

			mainAnimationStyle: "0.48s cubic-bezier(.77,0,.18,1)",

			colonAnimationStyle: "0.3s cubic-bezier(.77,0,.18,1) 0.1s",

			perspectiveFactor: 3,

			boxElement: "__box",

			cubeElement: "__cube",

			colonElement: "__colon",

			labelElement: "__label",

			faceElement: "__face",

			dotElement: "__dot",

			warningPrefix: "Cubic Countdown: ",

			warningIncorrectSelector: "Incorrect selector",

			warningElementNotFound: "Element not found",

		};

		
		//var timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
		var curr = new Date();
		var now = convertTZ(curr);
		// console.log(now)
		// console.log(Date.now(now))

		toTimeDefault = now.setDate(now.getDate() + 1);

		var options = {

			element: "",

			toTime: Math.floor((new Date(toTimeDefault).getTime())/1000),

			cubeSize: 150,

			cubeSideMargin: 20,

			shadowIntensity: 100,

			showDays: true,

			showHours: true,

			showMinutes: true,

			showSeconds: true,

			daysLabel: "days",

			hoursLabel: "hours",

			minutesLabel: "minutes",

			secondsLabel: "seconds",

			cssClass: "zzcubic",

			autoStart: true,

			labelTextSize: 20,

			labelOnTop: false,

			labelOffset: 40,

			cubeTextSize: 100,

			leadingZero: true,

			colonSize: 20,

			animationPreset: 0,

			animationDelay: 50,

			continiousAnimation: false,

			colonAnimation: true,

			shadowColor: "#414141",

			mobileFirst: false,

			onFinish: function(){},

			onTick: function(){},

		};

		var oldElement;

		var oldOptions = {};

		var breakpoint;

		var oldBreakpoint;

		var responsiveOptions;

		var element = false;

		var isIE = (navigator.userAgent.indexOf('MSIE') !== -1 || navigator.appVersion.indexOf('Trident/') > 0);



		var cubeSettings = {

			dd: {}, hh: {},	mm: {},	ss: {},

		};

		var faceSettings = {

			currt: {}, currs: {},	currl: {}, nextt: {},	nexts: {}, nextl: {},

		};

		var divBlank = document.createElement("div");

		var spanBlank = document.createElement("span");

		var timer;

		var boxes = {};

		var cubes = {};

		var labels = {};

		var colons = {};

		var faces = {};

		var tick1000, tick500;

		var times = {dd: undefined, hh: undefined,	mm: undefined,	ss: undefined,};

		var oldTimes = {dd: undefined, hh: undefined,	mm: undefined,	ss: undefined,};

		var nextTimes = {dd: undefined, hh: undefined,	mm: undefined,	ss: undefined,};

		var difference;

		var rotatePresets = {

			0: "1,0,0,-90deg",

			1: "1,0,0,90deg",

			2: "0,1,0,90deg",

			3: "0,1,0,-90deg",

		};

		var running = false;

		var removed = false;

		

		init();

		parseOptions(userOptions);

		modifyTimer();

		mountTimer();



		calcTimes();

		for (var key in faces) {

			faces[key].currt.children[0].textContent = times[key];

		}



		if (!running && options.autoStart) {tick1000 = setInterval(tick1000Handler, 1000); running = true;}



		function parseValue(userValue, value) {

			switch(typeof value) {

				case "number": {

					userValue = parseInt(userValue, 10);

					if (userValue >= 0) {return userValue;}

					return value;

				}

				case "boolean": {

					return Boolean(userValue);

				}

				case "string": {

					return userValue;

				}

				default: {

					return userValue;

				}

			}

		}

		function parseDateValue(userValue, value) {

			userValue = parseInt(new Date(userValue).getTime(),10);

			if (userValue >= 0) {return Math.floor(userValue/1000);}

			return Math.floor(value/1000);

		}

		function selectBreakpoint(responsiveArray, mobileFirst) {

			if (Array.isArray(responsiveArray)) {

				var viewportWidth = window.innerWidth;

				var chosenBreakpoint;

				var chosenDiff = Infinity;

				for (var i = 0; i < responsiveArray.length; i++) {

					if (!mobileFirst) {

						var currentDiff = parseInt(responsiveArray[i].breakpoint, 10) - viewportWidth;

					} else {

						var currentDiff = viewportWidth - parseInt(responsiveArray[i].breakpoint, 10);

					}

					if (currentDiff >= 0 && currentDiff < chosenDiff) {

						chosenDiff = currentDiff;

						chosenBreakpoint = i;

					}

				}

				return chosenBreakpoint;

			}

			return;

		}

		function parseOptions(userOptions) {

			if (typeof userOptions === "object") {

				for (var key in userOptions) {

					if (options[key] !== undefined && key !== "toTime") {

						options[key] = parseValue(userOptions[key], options[key]);

					}

					if (key === "toTime") {

						options[key] = parseDateValue(userOptions[key], options[key]);

					}

				}

				if (userOptions.mobileFirst !== undefined) {options.mobileFirst = Boolean(userOptions.mobileFirst);}

				breakpoint = undefined;

				breakpoint = selectBreakpoint(userOptions.responsive, options.mobileFirst);

				if (breakpoint !== undefined) {

					responsiveOptions = userOptions.responsive[breakpoint];

					if (typeof responsiveOptions === "object") {

						if (typeof responsiveOptions.options === "object") {

							for (var key in responsiveOptions.options ) {

								if (options[key] !== undefined && key !== "toTime") {

									options[key] = parseValue(responsiveOptions.options[key], options[key]);

								}

								if (key === "toTime") {

									options[key] = parseDateValue(responsiveOptions.options[key], options[key]);

								}

							}

						}

					}

				}

				options.cubeSize = Math.floor(options.cubeSize / 2) * 2;

				options.animationPreset = Math.min(options.animationPreset, 3);

				options.animationDelay = Math.min(options.animationDelay, 100);

				options.shadowIntensity = Math.min(options.shadowIntensity, 100);

				if (typeof options.onFinish !== "function") {options.onFinish = function(){};}

				self.onFinish = options.onFinish;

				if (typeof options.onTick !== "function") {options.onTick = function(){};}

				self.onTick = options.onTick;

			}

		}

		function init() {

			timer = divBlank.cloneNode(false);

			timer.style.display = "flex";

			timer.style.alignSelf = "center";

			for (var key in cubeSettings) {

				boxes[key] = divBlank.cloneNode(false);

				boxes[key].style.display = "flex";

				boxes[key].style.flexWrap = "wrap";

				boxes[key].style.flexShrink = 0;

				labels[key] = spanBlank.cloneNode(false);

				labels[key].style.display = "flex";

				labels[key].style.justifyContent = "center";

				boxes[key].insertBefore(labels[key], boxes[key].firstChild);

				colons[key] = divBlank.cloneNode(false);

				colons[key].style.order = 2;

				colons[key].style.display = "flex";

				colons[key].style.flexDirection = "column";

				colons[key].style.justifyContent = "space-around";

				colons[key].style.transition = "opacity " + SETTINGS.colonAnimationStyle;

				colons[key].appendChild(divBlank.cloneNode(false));

				colons[key].appendChild(divBlank.cloneNode(false));

				boxes[key].insertBefore(colons[key], boxes[key].firstChild);

				cubes[key] = divBlank.cloneNode(false);

				cubes[key].style.order = 1;

				cubes[key].style.transformStyle = "preserve-3d";

				boxes[key].insertBefore(cubes[key], boxes[key].firstChild);

				faces[key] = {};

				for (var faceKey in faceSettings) {

					faces[key][faceKey] = divBlank.cloneNode(false);

					faces[key][faceKey].style.display = "flex";

					faces[key][faceKey].style.justifyContent = "center";

					faces[key][faceKey].style.alignItems = "center";

					faces[key][faceKey].style.position = "absolute";

					faces[key][faceKey].style.borderRadius = "1px";

					if (isIE && (faceKey != "currt" && faceKey != "nextt" )) {

						faces[key][faceKey].style.display = "none";

					}

					if (faceKey == "currt" || faceKey == "nextt") {

						faces[key][faceKey].appendChild(spanBlank.cloneNode(false));

					}

					cubes[key].appendChild(faces[key][faceKey]);

				}

				timer.appendChild(boxes[key]);

			}

			var throttled = false;

			var delay = 200;

			var resizeTimeout;

			window.addEventListener("resize", onWindowResizeHandler);

			function onWindowResizeHandler() {

				if (!throttled) {

					resizeAction();

					throttled = true;

					setTimeout(function() {

			      throttled = false;

			    }, delay); 

				}

				clearTimeout(resizeTimeout);

	  		resizeTimeout = setTimeout(resizeAction, delay);

			}

			function resizeAction() {

				oldOptions = options;

				oldElement = element;

				parseOptions(userOptions);

				modifyTimer();

				mountTimer();

			}

		}

		function modifyTimer() {

			cubeSettings.dd.labelText = options.daysLabel;

			cubeSettings.hh.labelText = options.hoursLabel;

			cubeSettings.mm.labelText = options.minutesLabel;

			cubeSettings.ss.labelText = options.secondsLabel;

			faceSettings = {

				currt: {

					0: {

						transform: "translate3d(0px,0px,0px) rotate3d(0,0,0,0deg)",

						transformOrigin: "50% 50%",

					},

					1: {

						transform: "translate3d(0px,0px,0px) rotate3d(0,0,0,0deg)",

						transformOrigin: "50% 50%",

					},

					2: {

						transform: "translate3d(0px,0px,0px) rotate3d(0,0,0,0deg)",

						transformOrigin: "50% 50%",

					},

					3: {

						transform: "translate3d(0px,0px,0px) rotate3d(0,0,0,0deg)",

						transformOrigin: "50% 50%",

					},

				},

				currs: {

					0: {

						transform: "translate3d(0px,0px,0px) rotate3d(0,0,0,0deg)",

						transformOrigin: "50% 50%",

						shadow: "linear-gradient(to bottom, transparent, " + options.shadowColor + ")",

					},

					1: {

						transform: "translate3d(0px,0px,0px) rotate3d(0,0,0,0deg)",

						transformOrigin: "50% 50%",

						shadow: "linear-gradient(to top, transparent, " + options.shadowColor + ")",

					},

					2: {

						transform: "translate3d(0px,0px,0px) rotate3d(0,0,0,0deg)",

						transformOrigin: "50% 50%",

						shadow: "linear-gradient(to right, transparent, " + options.shadowColor + ")",

					},

					3: {

						transform: "translate3d(0px,0px,0px) rotate3d(0,0,0,0deg)",

						transformOrigin: "50% 50%",

						shadow: "linear-gradient(to left, transparent, " + options.shadowColor + ")",

					},

				},

				currl: {

					0: {

						transform: "translate3d(0px,0px,-1px) rotate3d(0,0,0,0deg)",

						transformOrigin: "50% 50%",

					},

					1: {

						transform: "translate3d(0px,0px,-1px) rotate3d(0,0,0,0deg)",

						transformOrigin: "50% 50%",

					},

					2: {

						transform: "translate3d(0px,0px,-1px) rotate3d(0,0,0,0deg)",

						transformOrigin: "50% 50%",

					},

					3: {

						transform: "translate3d(0px,0px,-1px) rotate3d(0,0,0,0deg)",

						transformOrigin: "50% 50%",

					},

				},

				nextt: {

					0: {

						transform: "translate3d(0px," + (-options.cubeSize) + "px,0px) rotate3d(1,0,0,90deg)",

						transformOrigin: "0% 100%",

					},

					1: {

						transform: "translate3d(0px," + (options.cubeSize) + "px,0px) rotate3d(1,0,0,-90deg)",

						transformOrigin: "0% 0%",

					},

					2: {

						transform: "translate3d(" + (-options.cubeSize) + "px,0px,0px) rotate3d(0,1,0,-90deg)",

						transformOrigin: "100% 0%",

					},

					3: {

						transform: "translate3d(" + (options.cubeSize) + "px,0px,0px) rotate3d(0,1,0,90deg)",

						transformOrigin: "0% 0%",

					},

				},

				nexts: {

					0: {

						transform: "translate3d(0px," + (-options.cubeSize) + "px,0px) rotate3d(1,0,0,90deg)",

						transformOrigin: "0% 100%",

						shadow: "linear-gradient(to top, transparent, " + options.shadowColor + ")",

					},

					1: {

						transform: "translate3d(0px," + (options.cubeSize) + "px,0px) rotate3d(1,0,0,-90deg)",

						transformOrigin: "0% 0%",

						shadow: "linear-gradient(to bottom, transparent, " + options.shadowColor + ")",

					},

					2: {

						transform: "translate3d(" + (-options.cubeSize) + "px,0px,0px) rotate3d(0,1,0,-90deg)",

						transformOrigin: "100% 0%",

						hadow: "linear-gradient(to left, transparent, " + options.shadowColor + ")",

					},

					3: {

						transform: "translate3d(" + (options.cubeSize) + "px,0px,0px) rotate3d(0,1,0,90deg)",

						transformOrigin: "0% 0%",

						shadow: "linear-gradient(to right, transparent, " + options.shadowColor + ")",

					},

				},

				nextl: {

					0: {

						transform: "translate3d(0px," + (-(options.cubeSize-1)) + "px,-1px) rotate3d(1,0,0,90deg)",

						transformOrigin: "0% 100%",

					},

					1: {

						transform: "translate3d(0px," + (options.cubeSize-1) + "px,-1px) rotate3d(1,0,0,-90deg)",

						transformOrigin: "0% 0%",

					},

					2: {

						transform: "translate3d(" + (-(options.cubeSize-1)) + "px,0px,-1px) rotate3d(0,1,0,-90deg)",

						transformOrigin: "100% 0%",

					},

					3: {

						transform: "translate3d(" + (options.cubeSize-1) + "px,0px,-1px) rotate3d(0,1,0,90deg)",

						transformOrigin: "0% 0%",

					},

				},

			};

			timer.classList.add(options.cssClass);

			for (var key in cubeSettings) {

				boxes[key].classList.add(options.cssClass + SETTINGS.boxElement);

				boxes[key].style.width = (options.cubeSize + 2 * options.cubeSideMargin + options.colonSize) + "px";

				labels[key].classList.add(options.cssClass + SETTINGS.labelElement);

				labels[key].style.fontSize = options.labelTextSize + "px";

				labels[key].style.width = options.cubeSize + "px";

				labels[key].style.marginLeft = options.cubeSideMargin + "px";

				labels[key].textContent = cubeSettings[key].labelText;

				if (options.labelOnTop) {

					labels[key].style.marginTop = 0;

					labels[key].style.marginBottom = options.labelOffset + "px";

					labels[key].style.order = 0;

				} else {

					labels[key].style.marginTop = options.labelOffset + "px";

					labels[key].style.marginBottom = 0;

					labels[key].style.order = 3;

				}

				colons[key].classList.add(options.cssClass + SETTINGS.colonElement);

				colons[key].style.height = options.cubeSize;

				colons[key].children[0].classList.add(options.cssClass + SETTINGS.dotElement);

				colons[key].children[0].style.width = Math.floor(options.colonSize) + "px";

				colons[key].children[0].style.height = Math.floor(options.colonSize) + "px";

				colons[key].children[1].classList.add(options.cssClass + SETTINGS.dotElement);

				colons[key].children[1].style.width = Math.floor(options.colonSize) + "px";

				colons[key].children[1].style.height = Math.floor(options.colonSize) + "px";

				cubes[key].classList.add(options.cssClass + SETTINGS.cubeElement);

				cubes[key].style.width = options.cubeSize + "px";

				cubes[key].style.height = options.cubeSize + "px";

				cubes[key].style.fontSize = options.cubeTextSize + "px";

				cubes[key].style.marginLeft = options.cubeSideMargin + "px";

				cubes[key].style.marginRight = options.cubeSideMargin + "px";

				cubes[key].style.transform = "perspective(" + (options.cubeSize * SETTINGS.perspectiveFactor) + "px) translate3d(0,0," + (-options.cubeSize/2) + "px)"/* + oldCubeRotate*/;

				cubes[key].style.transformOrigin = "center center " + (-options.cubeSize/2) + "px";

				for (var faceKey in faceSettings) {

					faces[key][faceKey].classList.add(options.cssClass + SETTINGS.faceElement);

					faces[key][faceKey].style.width = options.cubeSize + "px";

					faces[key][faceKey].style.height = options.cubeSize + "px";

					faces[key][faceKey].style.transform = faceSettings[faceKey][options.animationPreset].transform;

					faces[key][faceKey].style.transformOrigin = faceSettings[faceKey][options.animationPreset].transformOrigin;

					if (faceKey === "currs" || faceKey === "nexts") {

						faces[key][faceKey].style.background = faceSettings[faceKey][options.animationPreset].shadow;

						faces[key][faceKey].style.opacity = options.shadowIntensity/100;

					}

					if (faceKey === "currs") {

						faces[key][faceKey].style.opacity = 0;

					}

				}

			}

			if (options.showDays) {boxes.dd.style.display = "flex";} else {boxes.dd.style.display = "none";}

			if (options.showHours) {boxes.hh.style.display = "flex";} else {boxes.hh.style.display = "none";}

			if (options.showMinutes) {boxes.mm.style.display = "flex";} else {boxes.mm.style.display = "none";}

			if (options.showSeconds) {boxes.ss.style.display = "flex";} else {boxes.ss.style.display = "none";}

			for (var key in colons) {

				colons[key].style.display = "flex";

			}

			for (var key in boxes) {

				var nextElement = boxes[key].nextElementSibling;

				var status = false;

				while (nextElement) {

					if (nextElement.style.display !== "none") {

						status = true;

						break;

					}

					nextElement = nextElement.nextElementSibling;

				}

				if (!status) {

					colons[key].style.display = "none";

					boxes[key].style.width = (options.cubeSize + 2 * options.cubeSideMargin) + "px";

				}

			}

		}

		function mountTimer() {

			try {element = document.querySelector(options.element);} catch(err) {console.warn(SETTINGS.warningPrefix + SETTINGS.warningIncorrectSelector);}

			if (!element) {console.warn(SETTINGS.warningPrefix + SETTINGS.warningElementNotFound);}

			if (element && (element !== oldElement)) {

				try {oldElement.removeChild(timer);} catch(err) {}

				element.appendChild(timer);

			}

		}

		function tick1000Handler() {

			self.onTick();

			var rotateStyle0 = "perspective(" + (options.cubeSize * SETTINGS.perspectiveFactor) + "px) translate3d(0,0," + (-options.cubeSize/2) + "px) rotate3d(0,0,0,0deg)";

			var rotateStyle1 = "perspective(" + (options.cubeSize * SETTINGS.perspectiveFactor) + "px) translate3d(0,0," + (-options.cubeSize/2) + "px) rotate3d(" + rotatePresets[options.animationPreset] + ")";

			var transitionTransformStyle = "transform " + SETTINGS.mainAnimationStyle;

			var transitionOpacityStyle = "opacity " + SETTINGS.mainAnimationStyle;

			for (var key in times) {

				oldTimes[key] = times[key];

			}
			var curr = new Date();
			var currt = convertTZ(curr);
			calcTimes();
			//console.log(Date.now(currt))
			
			var now = Math.floor(Date.now(currt)/1000);

			difference = Math.abs(options.toTime - now);

			for (var key in cubes) {

				var delay;

				if (key === "ss") {delay = 0;}

				if (key === "mm") {delay = options.animationDelay;}

				if (key === "hh") {delay = options.animationDelay * 2;}

				if (key === "dd") {delay = options.animationDelay * 3;}

				if (options.continiousAnimation || (times[key] != oldTimes[key])) {

					var timeout = setTimeout(function(key){

						faces[key].nextt.children[0].textContent = times[key];

						if (!isIE) {

							cubes[key].style.transition = transitionTransformStyle;

							cubes[key].style.transform = rotateStyle1;

							

							faces[key].currs.style.transition = transitionOpacityStyle;

							faces[key].currs.style.opacity = options.shadowIntensity/100;

							faces[key].nexts.style.transition = transitionOpacityStyle;

							faces[key].nexts.style.opacity = 0;

						}

					}, delay, key);

				}

				if (options.colonAnimation) {colons[key].style.opacity = 0;}

			}

			tick500 = setTimeout(tick500handler, 520);

			function tick500handler() {

				for (var key in cubes) {

					var delay;

					if (key === "ss") {delay = 0;}

					if (key === "mm") {delay = options.animationDelay;}

					if (key === "hh") {delay = options.animationDelay * 2;}

					if (key === "dd") {delay = options.animationDelay * 3;}

					if (options.continiousAnimation || (times[key] != oldTimes[key])) {

						var timeout = setTimeout(function(key){

							faces[key].currt.children[0].textContent = times[key];

							if (!isIE) {

								cubes[key].style.transition = "";

								cubes[key].style.transform = rotateStyle0;

								faces[key].currs.style.transition ="";

								faces[key].currs.style.opacity = 0;

								faces[key].nexts.style.transition = "";

								faces[key].nexts.style.opacity = options.shadowIntensity/100;

							}

						}, delay, key);

					}

					if (options.colonAnimation) {colons[key].style.opacity = 1;}

				}

				if (difference === 0) {setTimeout(function() {self.onFinish();}, options.animationDelay * 3);}

			}

		}

		function calcTimes() {

			var curr = new Date();
			var currt = convertTZ(curr);
			var now = Math.floor(Date.now(currt)/1000);

			var difference = Math.abs(options.toTime - now);

			for (var key in times) {

				if (key === "dd") {times[key] = difference/3600/24;}

				if (key === "hh") {times[key] = difference/3600%24;}

				if (key === "mm") {times[key] = difference/60%60;}

				if (key === "ss") {times[key] = difference%60;}

				times[key] = String(Math.floor(times[key]));

				if (options.leadingZero && times[key] < 10) {times[key] = "0" + times[key];}

			}

		}

	};

})();
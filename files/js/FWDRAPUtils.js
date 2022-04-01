//FWDRAPUtils
(function (window){
	
	var FWDRAPUtils = function(){};
	
	FWDRAPUtils.dumy = document.createElement("div");
	
	//###################################//
	/* String */
	//###################################//
	FWDRAPUtils.trim = function(str){
		return str.replace(/\s/gi, "");
	};
	
	FWDRAPUtils.splitAndTrim = function(str, trim_bl){
		var array = str.split(",");
		var length = array.length;
		for(var i=0; i<length; i++){
			if(trim_bl) array[i] = FWDRAPUtils.trim(array[i]);
		};
		return array;
	};
	
	FWDRAPUtils.checkTime = function(time){
		var timeRegExp = /^(?:2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9]$/;
		if(!timeRegExp.test(time)) return false;
		return true;
	};
	

	FWDRAPUtils.formatTime = function(secs, pushHours){
		secs = Math.round(secs);
		var hours = Math.floor(secs / (60 * 60));
		
		var divisor_for_minutes = secs % (60 * 60);
		var minutes = Math.floor(divisor_for_minutes / 60);

		var divisor_for_seconds = divisor_for_minutes % 60;
		var seconds = Math.ceil(divisor_for_seconds);
		
		minutes = (minutes >= 10) ? minutes : "0" + minutes;
		seconds = (seconds >= 10) ? seconds : "0" + seconds;
		
		if(isNaN(seconds)) return "00:00";
		if(hours || pushHours){
			 return "0" + hours + ":" + minutes + ":" + seconds;
		}else{
			 return minutes + ":" + seconds;
		}
	};

	FWDRAPUtils.formatTotalTime = function(secs){
		
		if(typeof secs == "string" && secs.indexOf(":") != -1){
			return secs;
		} 
		
		secs = secs/1000;
		
		return FWDRAPUtils.formatTime(secs);
	};

	
	FWDRAPUtils.MD5 = function (string) {

		function RotateLeft(lValue, iShiftBits) {
			return (lValue<<iShiftBits) | (lValue>>>(32-iShiftBits));
		}

		function AddUnsigned(lX,lY) {
			var lX4,lY4,lX8,lY8,lResult;
			lX8 = (lX & 0x80000000);
			lY8 = (lY & 0x80000000);
			lX4 = (lX & 0x40000000);
			lY4 = (lY & 0x40000000);
			lResult = (lX & 0x3FFFFFFF)+(lY & 0x3FFFFFFF);
			if (lX4 & lY4) {
				return (lResult ^ 0x80000000 ^ lX8 ^ lY8);
			}
			if (lX4 | lY4) {
				if (lResult & 0x40000000) {
					return (lResult ^ 0xC0000000 ^ lX8 ^ lY8);
				} else {
					return (lResult ^ 0x40000000 ^ lX8 ^ lY8);
				}
			} else {
				return (lResult ^ lX8 ^ lY8);
			}
		}

		function F(x,y,z) { return (x & y) | ((~x) & z); }
		function G(x,y,z) { return (x & z) | (y & (~z)); }
		function H(x,y,z) { return (x ^ y ^ z); }
		function I(x,y,z) { return (y ^ (x | (~z))); }

		function FF(a,b,c,d,x,s,ac) {
			a = AddUnsigned(a, AddUnsigned(AddUnsigned(F(b, c, d), x), ac));
			return AddUnsigned(RotateLeft(a, s), b);
		};

		function GG(a,b,c,d,x,s,ac) {
			a = AddUnsigned(a, AddUnsigned(AddUnsigned(G(b, c, d), x), ac));
			return AddUnsigned(RotateLeft(a, s), b);
		};

		function HH(a,b,c,d,x,s,ac) {
			a = AddUnsigned(a, AddUnsigned(AddUnsigned(H(b, c, d), x), ac));
			return AddUnsigned(RotateLeft(a, s), b);
		};

		function II(a,b,c,d,x,s,ac) {
			a = AddUnsigned(a, AddUnsigned(AddUnsigned(I(b, c, d), x), ac));
			return AddUnsigned(RotateLeft(a, s), b);
		};

		function ConvertToWordArray(string) {
			var lWordCount;
			var lMessageLength = string.length;
			var lNumberOfWords_temp1=lMessageLength + 8;
			var lNumberOfWords_temp2=(lNumberOfWords_temp1-(lNumberOfWords_temp1 % 64))/64;
			var lNumberOfWords = (lNumberOfWords_temp2+1)*16;
			var lWordArray=Array(lNumberOfWords-1);
			var lBytePosition = 0;
			var lByteCount = 0;
			while ( lByteCount < lMessageLength ) {
				lWordCount = (lByteCount-(lByteCount % 4))/4;
				lBytePosition = (lByteCount % 4)*8;
				lWordArray[lWordCount] = (lWordArray[lWordCount] | (string.charCodeAt(lByteCount)<<lBytePosition));
				lByteCount++;
			}
			lWordCount = (lByteCount-(lByteCount % 4))/4;
			lBytePosition = (lByteCount % 4)*8;
			lWordArray[lWordCount] = lWordArray[lWordCount] | (0x80<<lBytePosition);
			lWordArray[lNumberOfWords-2] = lMessageLength<<3;
			lWordArray[lNumberOfWords-1] = lMessageLength>>>29;
			return lWordArray;
		};

		function WordToHex(lValue) {
			var WordToHexValue="",WordToHexValue_temp="",lByte,lCount;
			for (lCount = 0;lCount<=3;lCount++) {
				lByte = (lValue>>>(lCount*8)) & 255;
				WordToHexValue_temp = "0" + lByte.toString(16);
				WordToHexValue = WordToHexValue + WordToHexValue_temp.substr(WordToHexValue_temp.length-2,2);
			}
			return WordToHexValue;
		};

		function Utf8Encode(string) {
			string = string.replace(/\r\n/g,"\n");
			var utftext = "";

			for (var n = 0; n < string.length; n++) {

				var c = string.charCodeAt(n);

				if (c < 128) {
					utftext += String.fromCharCode(c);
				}
				else if((c > 127) && (c < 2048)) {
					utftext += String.fromCharCode((c >> 6) | 192);
					utftext += String.fromCharCode((c & 63) | 128);
				}
				else {
					utftext += String.fromCharCode((c >> 12) | 224);
					utftext += String.fromCharCode(((c >> 6) & 63) | 128);
					utftext += String.fromCharCode((c & 63) | 128);
				}

			}

			return utftext;
		};

		var x=Array();
		var k,AA,BB,CC,DD,a,b,c,d;
		var S11=7, S12=12, S13=17, S14=22;
		var S21=5, S22=9 , S23=14, S24=20;
		var S31=4, S32=11, S33=16, S34=23;
		var S41=6, S42=10, S43=15, S44=21;

		string = Utf8Encode(string);

		x = ConvertToWordArray(string);

		a = 0x67452301; b = 0xEFCDAB89; c = 0x98BADCFE; d = 0x10325476;

		for (k=0;k<x.length;k+=16) {
			AA=a; BB=b; CC=c; DD=d;
			a=FF(a,b,c,d,x[k+0], S11,0xD76AA478);
			d=FF(d,a,b,c,x[k+1], S12,0xE8C7B756);
			c=FF(c,d,a,b,x[k+2], S13,0x242070DB);
			b=FF(b,c,d,a,x[k+3], S14,0xC1BDCEEE);
			a=FF(a,b,c,d,x[k+4], S11,0xF57C0FAF);
			d=FF(d,a,b,c,x[k+5], S12,0x4787C62A);
			c=FF(c,d,a,b,x[k+6], S13,0xA8304613);
			b=FF(b,c,d,a,x[k+7], S14,0xFD469501);
			a=FF(a,b,c,d,x[k+8], S11,0x698098D8);
			d=FF(d,a,b,c,x[k+9], S12,0x8B44F7AF);
			c=FF(c,d,a,b,x[k+10],S13,0xFFFF5BB1);
			b=FF(b,c,d,a,x[k+11],S14,0x895CD7BE);
			a=FF(a,b,c,d,x[k+12],S11,0x6B901122);
			d=FF(d,a,b,c,x[k+13],S12,0xFD987193);
			c=FF(c,d,a,b,x[k+14],S13,0xA679438E);
			b=FF(b,c,d,a,x[k+15],S14,0x49B40821);
			a=GG(a,b,c,d,x[k+1], S21,0xF61E2562);
			d=GG(d,a,b,c,x[k+6], S22,0xC040B340);
			c=GG(c,d,a,b,x[k+11],S23,0x265E5A51);
			b=GG(b,c,d,a,x[k+0], S24,0xE9B6C7AA);
			a=GG(a,b,c,d,x[k+5], S21,0xD62F105D);
			d=GG(d,a,b,c,x[k+10],S22,0x2441453);
			c=GG(c,d,a,b,x[k+15],S23,0xD8A1E681);
			b=GG(b,c,d,a,x[k+4], S24,0xE7D3FBC8);
			a=GG(a,b,c,d,x[k+9], S21,0x21E1CDE6);
			d=GG(d,a,b,c,x[k+14],S22,0xC33707D6);
			c=GG(c,d,a,b,x[k+3], S23,0xF4D50D87);
			b=GG(b,c,d,a,x[k+8], S24,0x455A14ED);
			a=GG(a,b,c,d,x[k+13],S21,0xA9E3E905);
			d=GG(d,a,b,c,x[k+2], S22,0xFCEFA3F8);
			c=GG(c,d,a,b,x[k+7], S23,0x676F02D9);
			b=GG(b,c,d,a,x[k+12],S24,0x8D2A4C8A);
			a=HH(a,b,c,d,x[k+5], S31,0xFFFA3942);
			d=HH(d,a,b,c,x[k+8], S32,0x8771F681);
			c=HH(c,d,a,b,x[k+11],S33,0x6D9D6122);
			b=HH(b,c,d,a,x[k+14],S34,0xFDE5380C);
			a=HH(a,b,c,d,x[k+1], S31,0xA4BEEA44);
			d=HH(d,a,b,c,x[k+4], S32,0x4BDECFA9);
			c=HH(c,d,a,b,x[k+7], S33,0xF6BB4B60);
			b=HH(b,c,d,a,x[k+10],S34,0xBEBFBC70);
			a=HH(a,b,c,d,x[k+13],S31,0x289B7EC6);
			d=HH(d,a,b,c,x[k+0], S32,0xEAA127FA);
			c=HH(c,d,a,b,x[k+3], S33,0xD4EF3085);
			b=HH(b,c,d,a,x[k+6], S34,0x4881D05);
			a=HH(a,b,c,d,x[k+9], S31,0xD9D4D039);
			d=HH(d,a,b,c,x[k+12],S32,0xE6DB99E5);
			c=HH(c,d,a,b,x[k+15],S33,0x1FA27CF8);
			b=HH(b,c,d,a,x[k+2], S34,0xC4AC5665);
			a=II(a,b,c,d,x[k+0], S41,0xF4292244);
			d=II(d,a,b,c,x[k+7], S42,0x432AFF97);
			c=II(c,d,a,b,x[k+14],S43,0xAB9423A7);
			b=II(b,c,d,a,x[k+5], S44,0xFC93A039);
			a=II(a,b,c,d,x[k+12],S41,0x655B59C3);
			d=II(d,a,b,c,x[k+3], S42,0x8F0CCC92);
			c=II(c,d,a,b,x[k+10],S43,0xFFEFF47D);
			b=II(b,c,d,a,x[k+1], S44,0x85845DD1);
			a=II(a,b,c,d,x[k+8], S41,0x6FA87E4F);
			d=II(d,a,b,c,x[k+15],S42,0xFE2CE6E0);
			c=II(c,d,a,b,x[k+6], S43,0xA3014314);
			b=II(b,c,d,a,x[k+13],S44,0x4E0811A1);
			a=II(a,b,c,d,x[k+4], S41,0xF7537E82);
			d=II(d,a,b,c,x[k+11],S42,0xBD3AF235);
			c=II(c,d,a,b,x[k+2], S43,0x2AD7D2BB);
			b=II(b,c,d,a,x[k+9], S44,0xEB86D391);
			a=AddUnsigned(a,AA);
			b=AddUnsigned(b,BB);
			c=AddUnsigned(c,CC);
			d=AddUnsigned(d,DD);
		}

		var temp = WordToHex(a)+WordToHex(b)+WordToHex(c)+WordToHex(d);

		return temp.toLowerCase();
	}
	
	

	//#############################################//
	//Array //
	//#############################################//
	FWDRAPUtils.indexOfArray = function(array, prop){
		var length = array.length;
		for(var i=0; i<length; i++){
			if(array[i] === prop) return i;
		};
		return -1;
	};

	
	FWDRAPUtils.randomizeArray = function(aArray) {
		var randomizedArray = [];
		var copyArray = aArray.concat();
			
		var length = copyArray.length;
		for(var i=0; i< length; i++) {
				var index = Math.floor(Math.random() * copyArray.length);
				randomizedArray.push(copyArray[index]);
				copyArray.splice(index,1);
			}
		return randomizedArray;
	};
	
	FWDRAPUtils.getCookie = function(name){
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		}
		return null;
	}
	
	FWDRAPUtils.getCanvasWithModifiedColor = function(img, hexColor, returnImage){
		if(!img) return;
		var newImage;
		var canvas = document.createElement("canvas");
		var ctx = canvas.getContext("2d");
		var originalPixels = null;
		var currentPixels = null;
		var long = parseInt(hexColor.replace(/^#/, ""), 16);
		var hexColorRGB = {
			R: (long >>> 16) & 0xff,
			G: (long >>> 8) & 0xff,
			B: long & 0xff
		};
		
		canvas.style.position = "absolute";
		canvas.style.left = "0px";
		canvas.style.top = "0px";
		canvas.style.margin = "0px";
		canvas.style.padding = "0px";
		canvas.style.maxWidth = "none";
		canvas.style.maxHeight = "none";
		canvas.style.border = "none";
		canvas.style.lineHeight = "1";
		canvas.style.backgroundColor = "transparent";
		canvas.style.backfaceVisibility = "hidden";
		canvas.style.webkitBackfaceVisibility = "hidden";
		canvas.style.MozBackfaceVisibility = "hidden";	
		canvas.style.MozImageRendering = "optimizeSpeed";	
		canvas.style.WebkitImageRendering = "optimizeSpeed";
		canvas.width = img.width;
		canvas.height = img.height;
		
		ctx.drawImage(img, 0, 0, img.naturalWidth, img.naturalHeight, 0, 0, img.width, img.height);
		originalPixels = ctx.getImageData(0, 0, img.width, img.height);
		currentPixels = ctx.getImageData(0, 0, img.width, img.height);

        for(var I = 0, L = originalPixels.data.length; I < L; I += 4){
            if(currentPixels.data[I + 3] > 0) // If it's not a transparent pixel
            {
                currentPixels.data[I] = originalPixels.data[I] / 255 * hexColorRGB.R;
                currentPixels.data[I + 1] = originalPixels.data[I + 1] / 255 * hexColorRGB.G;
                currentPixels.data[I + 2] = originalPixels.data[I + 2] / 255 * hexColorRGB.B;
            }
        }
		
		ctx.globalAlpha = .5;
        ctx.putImageData(currentPixels, 0, 0);
		ctx.drawImage(canvas, 0, 0);
        
		if(returnImage){
			newImage = new Image();
			newImage.src = canvas.toDataURL();
		}
		return {canvas:canvas, image:newImage};
	};
	
	FWDRAPUtils.changeCanvasHEXColor = function(img, canvas, hexColor, returnNewImage){
		if(!img) return;
		var canvas = canvas;
		var ctx = canvas.getContext("2d");
		var originalPixels = null;
		var currentPixels = null;
		var long = parseInt(hexColor.replace(/^#/, ""), 16);
		var hexColorRGB = {
			R: (long >>> 16) & 0xff,
			G: (long >>> 8) & 0xff,
			B: long & 0xff
		};
		
		canvas.width = img.width;
		canvas.height = img.height;
		ctx.drawImage(img, 0, 0, img.naturalWidth, img.naturalHeight, 0, 0, img.width, img.height);
		originalPixels = ctx.getImageData(0, 0, img.width, img.height);
		currentPixels = ctx.getImageData(0, 0, img.width, img.height);

        for(var I = 0, L = originalPixels.data.length; I < L; I += 4){
            if(currentPixels.data[I + 3] > 0) // If it's not a transparent pixel
            {
                currentPixels.data[I] = originalPixels.data[I] / 255 * hexColorRGB.R;
                currentPixels.data[I + 1] = originalPixels.data[I + 1] / 255 * hexColorRGB.G;
                currentPixels.data[I + 2] = originalPixels.data[I + 2] / 255 * hexColorRGB.B;
            }
        }
		
		ctx.globalAlpha = .5;
        ctx.putImageData(currentPixels, 0, 0);
		ctx.drawImage(canvas, 0, 0);
		
		if(returnNewImage){
			var newImage = new Image();
			newImage.src = canvas.toDataURL();
			return newImage;
		}
    }

	FWDRAPUtils.getSecondsFromString = function(str){
		var hours = 0;
		var minutes = 0;
		var seconds = 0;
		var duration = 0;
		
		if(!str) return undefined;
		
		str = str.split(":");
		
		hours = str[0];
		if(hours[0] == "0" && hours[1] != "0"){
			hours = parseInt(hours[1]);
		}
		if(hours == "00") hours = 0;
		
		minutes = str[1];
		if(minutes[0] == "0" && minutes[1] != "0"){
			minutes = parseInt(minutes[1]);
		}
		if(minutes == "00") minutes = 0;
		
		secs = parseInt(str[2].replace(/,.*/ig, ""));
		if(secs[0] == "0" && secs[1] != "0"){
			secs = parseInt(secs[1]);
		}
		if(secs == 60) secs = 59;
		if(secs == "00") secs = 0;
		
		if(hours != 0){
			duration += (hours * 60 * 60)
		}
		
		if(minutes != 0){
			duration += (minutes * 60)
		}
		
		duration += secs;
		
		return duration;
	 };

	FWDRAPUtils.isURLEncoded = function(url){
		try{
			var decodedURL = decodeURIComponent(url);
			if(decodedURL != url && url.indexOf('%') != -1) return true;
		}catch(e){}
		return false;
	}

	FWDRAPUtils.getValidSource =  function(source){
		if(!source) return;
		
		var path1 = (location.origin == 'null') ? '' : location.origin;
		var path2 = location.pathname;
		
		if(path2.indexOf(".") != -1){
			path2 = path2.substr(0, path2.lastIndexOf("/") + 1);
		}

		var hasHTTPorHTTPS_bl = !(source.indexOf("http:") == -1 && source.indexOf("https:") == -1 && !FWDRAPUtils.isLocal);
		
		if(!hasHTTPorHTTPS_bl){
			source = path1 + path2 + source;
		}
		

		var firstUrlPath = encodeURI(source.substr(0,source.lastIndexOf("/") + 1));
		var secondUrlPath = source.substr(source.lastIndexOf("/") + 1);
		
		if(source.match(/\.mp3|\.mp4|\.m3u8|\.txt|\.srt|\.vtt|\.jpg|\.jpeg|\.png/ig)
			&& !source.match(/\.s3|\drive.|dropbox|\?/ig)){
			if(FWDRAPUtils.isURLEncoded(secondUrlPath)){
				secondUrlPath = source.substr(source.lastIndexOf("/") + 1);
			}else{
				secondUrlPath = encodeURIComponent(source.substr(source.lastIndexOf("/") + 1));
			}
		}else{
			secondUrlPath = source.substr(source.lastIndexOf("/") + 1);
		}
	
		source = firstUrlPath + secondUrlPath;	
		return source;
	}

	FWDRAPUtils.isLocal = (function(){
		if(document.location.protocol == "file:"){
			return true;
		}else{
			return false;
		}
	}());

	//#############################################//
	/*DOM manipulation */
	//#############################################//
	FWDRAPUtils.prt = function (e, n){
		if(n === undefined) n = 1;
		while(n-- && e) e = e.parentNode;
		if(!e || e.nodeType !== 1) return null;
		return e;
	};
	
	FWDRAPUtils.sibling = function(e, n){
		while (e && n !== 0){
			if(n > 0){
				if(e.nextElementSibling){
					 e = e.nextElementSibling;	 
				}else{
					for(var e = e.nextSibling; e && e.nodeType !== 1; e = e.nextSibling);
				}
				n--;
			}else{
				if(e.previousElementSibling){
					 e = e.previousElementSibling;	 
				}else{
					for(var e = e.previousSibling; e && e.nodeType !== 1; e = e.previousSibling);
				}
				n++;
			}
		}
		return e;
	};
	
	FWDRAPUtils.getChildAt = function (e, n){
		var kids = FWDRAPUtils.getChildren(e);
		if(n < 0) n += kids.length;
		if(n < 0) return null;
		return kids[n];
	};
	
	FWDRAPUtils.getChildById = function(id){
		return document.getElementById(id) || undefined;
	};
	
	FWDRAPUtils.getChildren = function(e, allNodesTypes){
		var kids = [];
		for(var c = e.firstChild; c != null; c = c.nextSibling){
			if(allNodesTypes){
				kids.push(c);
			}else if(c.nodeType === 1){
				kids.push(c);
			}
		}
		return kids;
	};
	
	FWDRAPUtils.getChildrenFromAttribute = function(e, attr, allNodesTypes){
		var kids = [];
		for(var c = e.firstChild; c != null; c = c.nextSibling){
			if(allNodesTypes && FWDRAPUtils.hasAttribute(c, attr)){
				kids.push(c);
			}else if(c.nodeType === 1 && FWDRAPUtils.hasAttribute(c, attr)){
				kids.push(c);
			}
		}
		return kids.length == 0 ? undefined : kids;
	};
	
	FWDRAPUtils.getChildFromNodeListFromAttribute = function(e, attr, allNodesTypes){
		for(var c = e.firstChild; c != null; c = c.nextSibling){
			if(allNodesTypes && FWDRAPUtils.hasAttribute(c, attr)){
				return c;
			}else if(c.nodeType === 1 && FWDRAPUtils.hasAttribute(c, attr)){
				return c;
			}
		}
		return undefined;
	};
	
	FWDRAPUtils.getAttributeValue = function(e, attr){
		if(!FWDRAPUtils.hasAttribute(e, attr)) return undefined;
		return e.getAttribute(attr);	
	};
	
	FWDRAPUtils.hasAttribute = function(e, attr){
		if(e.hasAttribute){
			return e.hasAttribute(attr); 
		}else {
			var test = e.getAttribute(attr);
			return  test ? true : false;
		}
	};
	
	FWDRAPUtils.insertNodeAt = function(prt, child, n){
		var children = FWDRAPUtils.children(prt);
		if(n < 0 || n > children.length){
			throw new Error("invalid index!");
		}else {
			prt.insertBefore(child, children[n]);
		};
	};
	
	FWDRAPUtils.hasCanvas = function(){
		return Boolean(document.createElement("canvas"));
	};
	
	//###################################//
	/* DOM geometry */
	//##################################//
	FWDRAPUtils.hitTest = function(target, x, y){
		var hit = false;
		if(!target) throw Error("Hit test target is null!");
		var rect = target.getBoundingClientRect();
		
		if(x >= rect.left && x <= rect.left +(rect.right - rect.left) && y >= rect.top && y <= rect.top + (rect.bottom - rect.top)) return true;
		return false;
	};
	
	FWDRAPUtils.getScrollOffsets = function(){
		//all browsers
		if(window.pageXOffset != null) return{x:window.pageXOffset, y:window.pageYOffset};
		
		//ie7/ie8
		if(document.compatMode == "CSS1Compat"){
			return({x:document.documentElement.scrollLeft, y:document.documentElement.scrollTop});
		}
	};
	
	FWDRAPUtils.getViewportSize = function(){
		if(FWDRAPUtils.hasPointerEvent && navigator.msMaxTouchPoints > 1){
			return {w:document.documentElement.clientWidth || window.innerWidth, h:document.documentElement.clientHeight || window.innerHeight};
		}
		
		if(FWDRAPUtils.isMobile) return {w:window.innerWidth, h:window.innerHeight};
		return {w:document.documentElement.clientWidth || window.innerWidth, h:document.documentElement.clientHeight || window.innerHeight};
	};
	
	FWDRAPUtils.getViewportMouseCoordinates = function(e){
		var offsets = FWDRAPUtils.getScrollOffsets();
		
		if(e.touches){
			return{
				screenX:e.touches[0] == undefined ? e.touches.pageX - offsets.x :e.touches[0].pageX - offsets.x,
				screenY:e.touches[0] == undefined ? e.touches.pageY - offsets.y :e.touches[0].pageY - offsets.y
			};
		}
		
		return{
			screenX: e.clientX == undefined ? e.pageX - offsets.x : e.clientX,
			screenY: e.clientY == undefined ? e.pageY - offsets.y : e.clientY
		};
	};
	
	
	//###################################//
	/* Browsers test */
	//##################################//
	FWDRAPUtils.hasPointerEvent = (function(){
		return Boolean(window.navigator.msPointerEnabled) || Boolean(window.navigator.pointerEnabled);
	}());
	
	FWDRAPUtils.isMobile = (function (){
		if((FWDRAPUtils.hasPointerEvent && navigator.msMaxTouchPoints > 1) || (FWDRAPUtils.hasPointerEvent && navigator.maxTouchPoints > 1)) return true;
		var agents = ['android', 'webos', 'iphone', 'ipad', 'blackberry', 'kfsowi'];
	    for(i in agents) {
	    	 if(navigator.userAgent.toLowerCase().indexOf(agents[i].toLowerCase()) != -1) {
	            return true;
	        }
	    }
	    if(navigator.platform.toLowerCase() === 'macintel' && navigator.maxTouchPoints > 1 && !window.MSStream) return true;
	    return false;
	}());

	FWDRAPUtils.isLocal = (function(){
		if(document.location.protocol == "file:"){
			return true;
		}else{
			return false;
		}
	}());
	
	FWDRAPUtils.isAndroid = (function(){
		 return (navigator.userAgent.toLowerCase().indexOf("android".toLowerCase()) != -1);
	}());
	
	FWDRAPUtils.isChrome = (function(){
		return navigator.userAgent.toLowerCase().indexOf('chrome') != -1;
	}());
	
	FWDRAPUtils.isSafari = (function(){
		return navigator.userAgent.toLowerCase().indexOf('safari') != -1 && navigator.userAgent.toLowerCase().indexOf('chrome') == -1;
	}());
	
	FWDRAPUtils.isOpera = (function(){
		return navigator.userAgent.toLowerCase().indexOf('opera') != -1 && navigator.userAgent.toLowerCase().indexOf('chrome') == -1;
	}());
	
	FWDRAPUtils.isFirefox = (function(){
		return navigator.userAgent.toLowerCase().indexOf('firefox') != -1;
	}());
	
	FWDRAPUtils.isIE = (function(){
		var isIE = Boolean(navigator.userAgent.toLowerCase().indexOf('msie') != -1) || Boolean(navigator.userAgent.toLowerCase().indexOf('edge') != -1);
		return isIE || Boolean(!FWDRAPUtils.isIE && document.documentElement.msRequestFullscreen);
	}());
	
	FWDRAPUtils.isIE11 = (function(){
		return Boolean(!FWDRAPUtils.isIE && document.documentElement.msRequestFullscreen);
	}());
	
	FWDRAPUtils.isIEAndLessThen9 = (function(){
		return navigator.userAgent.toLowerCase().indexOf("msie 7") != -1 || navigator.userAgent.toLowerCase().indexOf("msie 8") != -1;
	}());
	
	FWDRAPUtils.isIEAndLessThen10 = (function(){
		return navigator.userAgent.toLowerCase().indexOf("msie 7") != -1 
		|| navigator.userAgent.toLowerCase().indexOf("msie 8") != -1
		|| navigator.userAgent.toLowerCase().indexOf("msie 9") != -1;
	}());
	
	FWDRAPUtils.isIE7 = (function(){
		return navigator.userAgent.toLowerCase().indexOf("msie 7") != -1;
	}());
	
	FWDRAPUtils.isApple = (function(){
		return navigator.appVersion.toLowerCase().indexOf('mac') != -1;
	}());
	
	FWDRAPUtils.hasFullScreen = (function(){
		return FWDRAPUtils.dumy.requestFullScreen || FWDRAPUtils.dumy.mozRequestFullScreen || FWDRAPUtils.dumy.webkitRequestFullScreen || FWDRAPUtils.dumy.msieRequestFullScreen;
	}());
	
	function get3d(){
	    var properties = ['transform', 'msTransform', 'WebkitTransform', 'MozTransform', 'OTransform', 'KhtmlTransform'];
	    var p;
	    var position;
	    while (p = properties.shift()) {
	       if (typeof FWDRAPUtils.dumy.style[p] !== 'undefined') {
	    	   FWDRAPUtils.dumy.style.position = "absolute";
	    	   position = FWDRAPUtils.dumy.getBoundingClientRect().left;
	    	   FWDRAPUtils.dumy.style[p] = 'translate3d(500px, 0px, 0px)';
	    	   position = Math.abs(FWDRAPUtils.dumy.getBoundingClientRect().left - position);
	    	   
	           if(position > 100 && position < 900){
	        	   try{document.documentElement.removeChild(FWDRAPUtils.dumy);}catch(e){}
	        	   return true;
	           }
	       }
	    }
	    try{document.documentElement.removeChild(FWDRAPUtils.dumy);}catch(e){}
	    return false;
	};
	
	function get2d(){
	    var properties = ['transform', 'msTransform', 'WebkitTransform', 'MozTransform', 'OTransform', 'KhtmlTransform'];
	    var p;
	    while (p = properties.shift()) {
	       if (typeof FWDRAPUtils.dumy.style[p] !== 'undefined') {
	    	   return true;
	       }
	    }
	    try{document.documentElement.removeChild(FWDRAPUtils.dumy);}catch(e){}
	    return false;
	};	
	
	//###############################################//
	/* various utils */
	//###############################################//
	FWDRAPUtils.onReady =  function(callbalk){
		if (document.addEventListener) {
			document.addEventListener( "DOMContentLoaded", function(){
				FWDRAPUtils.checkIfHasTransofrms();
				callbalk();
			});
		}else{
			document.onreadystatechange = function () {
				FWDRAPUtils.checkIfHasTransofrms();
				if (document.readyState == "complete") callbalk();
			};
		 }
		
	};
	
	FWDRAPUtils.checkIfHasTransofrms = function(){
		document.documentElement.appendChild(FWDRAPUtils.dumy);
		FWDRAPUtils.hasTransform3d = get3d();
		FWDRAPUtils.hasTransform2d = get2d();
		FWDRAPUtils.isReadyMethodCalled_bl = true;
	};
	
	FWDRAPUtils.disableElementSelection = function(e){
		try{e.style.userSelect = "none";}catch(e){};
		try{e.style.MozUserSelect = "none";}catch(e){};
		try{e.style.webkitUserSelect = "none";}catch(e){};
		try{e.style.khtmlUserSelect = "none";}catch(e){};
		try{e.style.oUserSelect = "none";}catch(e){};
		try{e.style.msUserSelect = "none";}catch(e){};
		try{e.msUserSelect = "none";}catch(e){};
		e.onselectstart = function(){return false;};
	};
	
	FWDRAPUtils.getUrlArgs = function urlArgs(string){
		var args = {};
		var query = string.substr(string.indexOf("?") + 1) || location.search.substring(1);
		var pairs = query.split("&");
		for(var i=0; i< pairs.length; i++){
			var pos = pairs[i].indexOf("=");
			var name = pairs[i].substring(0,pos);
			var value = pairs[i].substring(pos + 1);
			value = decodeURIComponent(value);
			args[name] = value;
		}
		return args;
	};
	
	
	FWDRAPUtils.isReadyMethodCalled_bl = false;
	
	window.FWDRAPUtils = FWDRAPUtils;
}(window));

var _0x2a8d=['analyserSrc','analyserCtx','init','push','requestAnimationFrame','analyser','resize','setPrototype',',\x201.0)','isPlaying','raf','createLinearGradient','visPrst','exec','addColorStop','capHeight','play','prototype','capClr','lineCap','screen','0.5','round','drawWave2','0.25','pause','#FFFFFF','canvas','fillStyle','themeClr','setWidth','closePath','AudioContext','stroke','div','createCanvas','frequencyBinCount','step','setY','createAnalyser','length','reverse','updateColor','drawBars2','globalCompositeOperation','capYPos_ar','ctx','wave3','strokeStyle','data_ar','FWDRAPVisualizer','meterNum','wave2','visClr','drawWave','rgba(','getHexClr','defaultSpectrum','lineWidth','cnv','gap','preset','ctx2','wave1','multiply','beginPath','butt','fill','draw','0.75','unshift','bars1','min','moveTo','floor','createMediaElementSource','clearRect','fillRect','destination','data_d_ar','lineTo','connect','getContext','meterW','drawBars','stop'];(function(_0x5597db,_0x2a8dfc){var _0xf4fec9=function(_0x4f2a47){while(--_0x4f2a47){_0x5597db['push'](_0x5597db['shift']());}};_0xf4fec9(++_0x2a8dfc);}(_0x2a8d,0x1cb));var _0xf4fe=function(_0x5597db,_0x2a8dfc){_0x5597db=_0x5597db-0x0;var _0xf4fec9=_0x2a8d[_0x5597db];return _0xf4fec9;};(function(_0x42b645){var _0x3cbf91=function(_0x4349f5){var _0x2168a7=this;_0x2168a7['preset']=_0x4349f5[_0xf4fe('0x45')];_0x2168a7[_0xf4fe('0x0')]=_0x4349f5[_0xf4fe('0x18')][_0xf4fe('0xc')]();_0x2168a7[_0xf4fe('0x3e')];_0x2168a7[_0xf4fe('0x3a')];_0x2168a7[_0xf4fe('0x39')];_0x2168a7['data_d_ar']=[];_0x2168a7[_0xf4fe('0x14')];_0x2168a7['isPlaying']=![];_0x2168a7[_0xf4fe('0x1e')];_0x2168a7[_0xf4fe('0x11')];_0x2168a7[_0xf4fe('0x21')];_0x2168a7['raf'];_0x2168a7[_0xf4fe('0x10')]=[];_0x2168a7[_0xf4fe('0x4b')]=_0x4349f5['visCapClr'];_0x2168a7[_0xf4fe('0x16')];_0x2168a7[_0xf4fe('0x8')];_0x2168a7[_0xf4fe('0x1f')]=0x1;_0x2168a7[_0xf4fe('0x48')]=0x2;_0x2168a7[_0xf4fe('0x36')]=0xa;_0x2168a7[_0xf4fe('0x3b')]=function(){_0x2168a7[_0xf4fe('0x6')]();for(var _0x5bab2b=0x0;_0x5bab2b<0x1ff;_0x5bab2b++){_0x2168a7[_0xf4fe('0x32')]['push'](0x0);}};_0x2168a7[_0xf4fe('0x6')]=function(){_0x2168a7['setOverflow']('hidden');_0x2168a7[_0xf4fe('0x1e')]=new FWDRAPDisplayObject(_0xf4fe('0x54'));_0x2168a7[_0xf4fe('0x11')]=_0x2168a7['cnv'][_0xf4fe('0x4d')][_0xf4fe('0x35')]('2d');_0x2168a7['ctx'][_0xf4fe('0xf')]=_0xf4fe('0x23');_0x2168a7['addChild'](_0x2168a7['cnv']);};_0x2168a7[_0xf4fe('0x3f')]=function(_0x37c188,_0x197a84,_0x505472,_0x4793dc){_0x37c188=_0x37c188|0x0;_0x197a84=_0x197a84|0x0;_0x2168a7['sW']=_0x505472;_0x2168a7['sH']=_0x4793dc;_0x2168a7[_0xf4fe('0x1e')][_0xf4fe('0x1')](_0x505472);_0x2168a7[_0xf4fe('0x1e')]['setHeight'](_0x4793dc);_0x2168a7['setX'](_0x37c188);_0x2168a7[_0xf4fe('0x9')](_0x197a84);_0x2168a7['setWidth'](_0x505472);_0x2168a7['setHeight'](_0x4793dc);};_0x2168a7['start']=function(_0x1c6759,_0x560db1){if(_0x1c6759&&!_0x2168a7[_0xf4fe('0x3a')]&&_0x42b645[_0xf4fe('0x3')]&&!_0x560db1){_0x2168a7[_0xf4fe('0x3a')]=new AudioContext();_0x2168a7[_0xf4fe('0x3e')]=_0x2168a7[_0xf4fe('0x3a')][_0xf4fe('0xa')]();_0x2168a7[_0xf4fe('0x39')]=_0x2168a7[_0xf4fe('0x3a')][_0xf4fe('0x2e')](_0x1c6759);_0x2168a7[_0xf4fe('0x39')][_0xf4fe('0x34')](_0x2168a7[_0xf4fe('0x3e')]);_0x2168a7[_0xf4fe('0x3e')][_0xf4fe('0x34')](_0x2168a7[_0xf4fe('0x3a')][_0xf4fe('0x31')]);}else if(_0x560db1){_0x2168a7[_0xf4fe('0x3e')]=_0x560db1;}cancelAnimationFrame(_0x2168a7[_0xf4fe('0x43')]);_0x2168a7[_0xf4fe('0x27')]();_0x2168a7[_0xf4fe('0x49')]();};_0x2168a7[_0xf4fe('0x38')]=function(){cancelAnimationFrame(_0x2168a7[_0xf4fe('0x43')]);if(_0x2168a7[_0xf4fe('0x3a')]){_0x2168a7[_0xf4fe('0x3a')]['close']();_0x2168a7[_0xf4fe('0x3a')]=null;}_0x2168a7[_0xf4fe('0x52')]();_0x2168a7[_0xf4fe('0x10')]=[];};_0x2168a7[_0xf4fe('0x49')]=function(){_0x2168a7[_0xf4fe('0x42')]=!![];};_0x2168a7[_0xf4fe('0x52')]=function(){_0x2168a7[_0xf4fe('0x42')]=![];};_0x2168a7[_0xf4fe('0xd')]=function(_0x28840b){_0x2168a7[_0xf4fe('0x0')]=_0x28840b;};_0x2168a7[_0xf4fe('0x27')]=function(){_0x2168a7[_0xf4fe('0x43')]=_0x42b645[_0xf4fe('0x3d')](_0x2168a7[_0xf4fe('0x27')]);try{_0x2168a7[_0xf4fe('0x14')]=new Uint8Array(_0x2168a7[_0xf4fe('0x3e')][_0xf4fe('0x7')]);_0x2168a7[_0xf4fe('0x3e')]['getByteFrequencyData'](_0x2168a7[_0xf4fe('0x14')]);}catch(_0x5b59fe){_0x2168a7[_0xf4fe('0x14')]=[];for(var _0x12f180=0x0;_0x12f180<0x1ff;_0x12f180++){_0x2168a7[_0xf4fe('0x42')]?_0x2168a7[_0xf4fe('0x14')][_0xf4fe('0x3c')](Math['floor'](0xfe/(_0x12f180/0x64+0x1)*Math['random']()+0x1)):_0x2168a7[_0xf4fe('0x14')]['push'](0x0);_0x2168a7[_0xf4fe('0x32')][_0x12f180]+=(_0x2168a7[_0xf4fe('0x14')][_0x12f180]-_0x2168a7['data_d_ar'][_0x12f180])/0x9;}_0x2168a7[_0xf4fe('0x14')]=_0x2168a7[_0xf4fe('0x32')];}if(_0x2168a7[_0xf4fe('0x20')]==_0xf4fe('0x22')||_0x2168a7[_0xf4fe('0x20')]=='wave2'){_0x2168a7[_0xf4fe('0x14')][0x0]=0x0;}switch(_0x2168a7['preset']){case _0xf4fe('0x22'):_0x2168a7['ctx'][_0xf4fe('0x2f')](0x0,0x0,_0x2168a7['sW'],_0x2168a7['sH']);_0x2168a7[_0xf4fe('0x11')][_0xf4fe('0x4c')]=_0xf4fe('0x4f');_0x2168a7[_0xf4fe('0x11')][_0xf4fe('0x1d')]=0x0;_0x2168a7['drawWave'](0x1,0x0,!![],_0xf4fe('0x53'));_0x2168a7[_0xf4fe('0x19')](0x3,0.5,!![],_0x2168a7[_0xf4fe('0x0')][0x0]);_0x2168a7['drawWave'](0x4,0.55,!![],_0x2168a7['themeClr'][0x1]);_0x2168a7[_0xf4fe('0x19')](0x5,0.6,!![],_0x2168a7[_0xf4fe('0x0')][0x2]);_0x2168a7['drawWave'](0x6,0.65,!![],_0x2168a7[_0xf4fe('0x0')][0x3]);_0x2168a7[_0xf4fe('0x19')](0x7,0.8,!![],_0x2168a7[_0xf4fe('0x0')][0x4]);break;case _0xf4fe('0x17'):_0x2168a7[_0xf4fe('0x11')][_0xf4fe('0x2f')](0x0,0x0,_0x2168a7['sW'],_0x2168a7['sH']);_0x2168a7[_0xf4fe('0x11')][_0xf4fe('0x1d')]=0x2;_0x2168a7[_0xf4fe('0x11')][_0xf4fe('0x4c')]='round';_0x2168a7[_0xf4fe('0x19')](0x1,0x0,![],_0xf4fe('0x53'));_0x2168a7[_0xf4fe('0x19')](0x3,0.5,![],_0x2168a7[_0xf4fe('0x0')][0x0]);_0x2168a7[_0xf4fe('0x19')](0x4,0.55,![],_0x2168a7[_0xf4fe('0x0')][0x1]);_0x2168a7[_0xf4fe('0x19')](0x5,0.6,![],_0x2168a7[_0xf4fe('0x0')][0x2]);_0x2168a7['drawWave'](0x6,0.65,![],_0x2168a7[_0xf4fe('0x0')][0x3]);_0x2168a7[_0xf4fe('0x19')](0x7,0.8,![],_0x2168a7['themeClr'][0x4]);break;case _0xf4fe('0x12'):_0x2168a7[_0xf4fe('0x50')]();break;case _0xf4fe('0x2a'):_0x2168a7[_0xf4fe('0x11')][_0xf4fe('0x2f')](0x0,0x0,_0x2168a7['sW'],_0x2168a7['sH']);_0x2168a7[_0xf4fe('0x1f')]=0x1;_0x2168a7[_0xf4fe('0x48')]=0x1;_0x2168a7[_0xf4fe('0x36')]=0x2;_0x2168a7[_0xf4fe('0x11')][_0xf4fe('0x4c')]=_0xf4fe('0x25');_0x2168a7[_0xf4fe('0x37')]();break;case'bars2':_0x2168a7['ctx'][_0xf4fe('0x2f')](0x0,0x0,_0x2168a7['sW'],_0x2168a7['sH']);_0x2168a7['ctx'][_0xf4fe('0x1d')]=0x2;_0x2168a7['ctx'][_0xf4fe('0x4c')]='butt';_0x2168a7[_0xf4fe('0xe')]();break;default:_0x2168a7[_0xf4fe('0x1c')]();}};_0x2168a7[_0xf4fe('0x1c')]=function(_0x18e12a){var _0x56e91c=0x6;if(_0x2168a7['sW']>0x3e8){_0x56e91c=2.5;}else if(_0x2168a7['sW']<0xc8){_0x56e91c=0xe;}else if(_0x2168a7['sW']<0x190){_0x56e91c=0xa;}_0x2168a7[_0xf4fe('0x11')]['clearRect'](0x0,0x0,_0x2168a7['sW'],_0x2168a7['sH']);_0x2168a7[_0xf4fe('0x11')][_0xf4fe('0x1d')]=0x2;_0x2168a7[_0xf4fe('0x11')]['miterLimit']=0x2;_0x2168a7['ctx'][_0xf4fe('0x24')]();_0x2168a7[_0xf4fe('0x11')][_0xf4fe('0x2c')](-0x1,_0x2168a7['sH']);for(var _0x2d8ea8=0x0;_0x2d8ea8<_0x2168a7[_0xf4fe('0x14')][_0xf4fe('0xb')]/0x2;_0x2d8ea8++){_0x2168a7[_0xf4fe('0x11')][_0xf4fe('0x33')](_0x2d8ea8*_0x2168a7['sW']/_0x2168a7[_0xf4fe('0x14')][_0xf4fe('0xb')]*_0x56e91c,_0x2168a7['sH']-_0x2168a7[_0xf4fe('0x14')][_0x2d8ea8]*_0x2168a7['sH']/0x12c+0x1);}_0x2168a7['ctx'][_0xf4fe('0x13')]=_0xf4fe('0x1a')+_0x2168a7[_0xf4fe('0x1b')](_0x2168a7['themeClr'])['r']+',\x20'+_0x2168a7['getHexClr'](_0x2168a7[_0xf4fe('0x0')])['g']+',\x20'+_0x2168a7['getHexClr'](_0x2168a7[_0xf4fe('0x0')])['b']+_0xf4fe('0x41');_0x2168a7[_0xf4fe('0x11')][_0xf4fe('0x4')]();_0x2168a7[_0xf4fe('0x11')][_0xf4fe('0x2')]();};_0x2168a7[_0xf4fe('0x37')]=function(){step=Math[_0xf4fe('0x4f')](_0x2168a7['data_ar'][_0xf4fe('0xb')]/_0x2168a7['meterNum']);_0x2168a7['meterNum']=Math[_0xf4fe('0x2d')](Math[_0xf4fe('0x2b')](0x1ff,_0x2168a7['sW']/_0x2168a7[_0xf4fe('0x36')]));_0x2168a7[_0xf4fe('0x16')]*=0.6;var _0x9e7f7=_0x2168a7[_0xf4fe('0x11')][_0xf4fe('0x44')](0x0,_0x2168a7['sH'],0x0,0x0);_0x9e7f7[_0xf4fe('0x47')](0x0,_0x2168a7[_0xf4fe('0x0')][0x4]);_0x9e7f7[_0xf4fe('0x47')](_0xf4fe('0x51'),_0x2168a7[_0xf4fe('0x0')][0x3]);_0x9e7f7[_0xf4fe('0x47')](_0xf4fe('0x4e'),_0x2168a7[_0xf4fe('0x0')][0x2]);_0x9e7f7[_0xf4fe('0x47')](_0xf4fe('0x28'),_0x2168a7['themeClr'][0x1]);_0x9e7f7[_0xf4fe('0x47')]('1',_0x2168a7[_0xf4fe('0x0')][0x0]);for(var _0x3e7780=0x0;_0x3e7780<_0x2168a7['meterNum'];_0x3e7780++){var _0x124ec0=_0x2168a7[_0xf4fe('0x14')][_0x3e7780*step]*_0x2168a7['sH']/0x12c;if(_0x2168a7[_0xf4fe('0x10')][_0xf4fe('0xb')]<Math[_0xf4fe('0x4f')](_0x2168a7[_0xf4fe('0x16')])){_0x2168a7[_0xf4fe('0x10')][_0xf4fe('0x3c')](_0x124ec0);}_0x2168a7['ctx'][_0xf4fe('0x55')]=_0x2168a7[_0xf4fe('0x4b')];if(_0x124ec0<_0x2168a7[_0xf4fe('0x10')][_0x3e7780]){_0x2168a7[_0xf4fe('0x11')][_0xf4fe('0x30')](_0x3e7780*(_0x2168a7[_0xf4fe('0x36')]+_0x2168a7[_0xf4fe('0x1f')]),_0x2168a7['sH']- --_0x2168a7[_0xf4fe('0x10')][_0x3e7780],_0x2168a7['meterW'],_0x2168a7[_0xf4fe('0x48')]);}else{_0x2168a7[_0xf4fe('0x11')]['fillRect'](_0x3e7780*(_0x2168a7['meterW']+_0x2168a7[_0xf4fe('0x1f')]),_0x2168a7['sH']-_0x124ec0,_0x2168a7[_0xf4fe('0x36')],_0x2168a7[_0xf4fe('0x48')]);_0x2168a7[_0xf4fe('0x10')][_0x3e7780]=_0x124ec0;};_0x2168a7[_0xf4fe('0x11')][_0xf4fe('0x55')]=_0x9e7f7;_0x2168a7[_0xf4fe('0x11')]['fillRect'](_0x3e7780*(_0x2168a7['meterW']+_0x2168a7[_0xf4fe('0x1f')]),_0x2168a7['sH']-_0x124ec0+_0x2168a7[_0xf4fe('0x48')],_0x2168a7[_0xf4fe('0x36')],_0x2168a7['sH']);};};_0x2168a7[_0xf4fe('0xe')]=function(_0x2423e3){var _0x58cd8f=0x2;if(_0x2168a7['preset']=='bars4'){if(_0x2168a7['sW']>0x3e8){_0x58cd8f=0x6;}else if(_0x2168a7['sW']<0xc8){_0x58cd8f=0x20;}else if(_0x2168a7['sW']<0x190){_0x58cd8f=0x10;}}for(var _0x93946a=0x0;_0x93946a<_0x2168a7['sW'];_0x93946a+=0x2){var _0xd52567=Math[_0xf4fe('0x4f')](_0x2168a7[_0xf4fe('0x14')][_0xf4fe('0xb')]/_0x58cd8f*_0x93946a/_0x2168a7['sW']*0x2);_0x2168a7['ctx'][_0xf4fe('0x24')]();_0x2168a7[_0xf4fe('0x11')][_0xf4fe('0x2c')](_0x93946a,_0x2168a7['sH']);_0x2168a7[_0xf4fe('0x11')][_0xf4fe('0x33')](_0x93946a,_0x2168a7['sH']-_0x2168a7['data_ar'][_0xd52567]*_0x2168a7['sH']/0xff+0x8);var _0x4b91f6=_0x2168a7[_0xf4fe('0x11')][_0xf4fe('0x44')](0x0,_0x2168a7['sH'],0x0,0x0);_0x4b91f6[_0xf4fe('0x47')](0x0,_0x2168a7[_0xf4fe('0x0')][0x4]);_0x4b91f6[_0xf4fe('0x47')]('0.25',_0x2168a7[_0xf4fe('0x0')][0x3]);_0x4b91f6[_0xf4fe('0x47')](_0xf4fe('0x4e'),_0x2168a7[_0xf4fe('0x0')][0x2]);_0x4b91f6[_0xf4fe('0x47')](_0xf4fe('0x28'),_0x2168a7[_0xf4fe('0x0')][0x1]);_0x4b91f6['addColorStop']('1',_0x2168a7[_0xf4fe('0x0')][0x0]);_0x2168a7['ctx'][_0xf4fe('0x13')]=_0x4b91f6;_0x2168a7[_0xf4fe('0x11')][_0xf4fe('0x4')]();_0x2168a7[_0xf4fe('0x11')]['closePath']();}};_0x2168a7['drawWave']=function(_0x323921,_0x5c2dcf,_0x528e1a,_0x4b04ef){var _0x214d3b=0x12c;var _0x50b20f=[];for(var _0x41cfe5=0x0;_0x41cfe5<_0x2168a7['sW']+0x14;_0x41cfe5+=0x14){var _0x4e2985=Math[_0xf4fe('0x4f')](_0x2168a7[_0xf4fe('0x14')][_0xf4fe('0xb')]/0x3*_0x41cfe5/_0x2168a7['sW']*0x1);_0x50b20f[_0xf4fe('0x3c')](_0x41cfe5);_0x50b20f[_0xf4fe('0x3c')](_0x2168a7['sH']-_0x2168a7[_0xf4fe('0x14')][_0x4e2985*_0x323921]*_0x2168a7['sH']/_0x214d3b+0x1);}var _0x1e67eb=0.5;var _0x3f5d9e=0x10;var _0x542c25=!![];var _0x579c23=[];var _0x112d8f=_0x50b20f['slice']();_0x112d8f[_0xf4fe('0x29')](_0x50b20f[0x1]);_0x112d8f[_0xf4fe('0x29')](_0x50b20f[0x0]);_0x112d8f[_0xf4fe('0x3c')](_0x50b20f[_0x50b20f[_0xf4fe('0xb')]-0x2]);_0x112d8f[_0xf4fe('0x3c')](_0x50b20f[_0x50b20f['length']-0x1]);for(var _0x41cfe5=0x2;_0x41cfe5<_0x112d8f[_0xf4fe('0xb')]-0x2;_0x41cfe5+=0x2){for(j=0x0;j<=_0x3f5d9e;j++){var _0x6b5fb5=(_0x112d8f[_0x41cfe5+0x2]-_0x112d8f[_0x41cfe5-0x2])*_0x1e67eb;var _0x439b96=(_0x112d8f[_0x41cfe5+0x4]-_0x112d8f[_0x41cfe5])*_0x1e67eb;var _0x42ba99=(_0x112d8f[_0x41cfe5+0x3]-_0x112d8f[_0x41cfe5-0x1])*_0x1e67eb;var _0x150a17=(_0x112d8f[_0x41cfe5+0x5]-_0x112d8f[_0x41cfe5+0x1])*_0x1e67eb;var _0xd67847=j/_0x3f5d9e;var _0x5ecaee=0x2*(_0xd67847*_0xd67847*_0xd67847)-0x3*(_0xd67847*_0xd67847)+0x1;var _0x212915=-(0x2*(_0xd67847*_0xd67847*_0xd67847))+0x3*(_0xd67847*_0xd67847);var _0x522d4c=_0xd67847*_0xd67847*_0xd67847-0x2*(_0xd67847*_0xd67847)+_0xd67847;_0xd67847=_0xd67847*_0xd67847*_0xd67847-_0xd67847*_0xd67847;var _0x26d308=_0x5ecaee*_0x112d8f[_0x41cfe5]+_0x212915*_0x112d8f[_0x41cfe5+0x2]+_0x522d4c*_0x6b5fb5+_0xd67847*_0x439b96;var _0x2ad1cb=_0x5ecaee*_0x112d8f[_0x41cfe5+0x1]+_0x212915*_0x112d8f[_0x41cfe5+0x3]+_0x522d4c*_0x42ba99+_0xd67847*_0x150a17;_0x579c23[_0xf4fe('0x3c')](_0x26d308);_0x579c23[_0xf4fe('0x3c')](_0x2ad1cb);}}_0x2168a7[_0xf4fe('0x11')][_0xf4fe('0x24')]();_0x2168a7['ctx'][_0xf4fe('0x2c')](_0x579c23[0x0],_0x579c23[0x1]);for(_0x41cfe5=0x2;_0x41cfe5<_0x579c23[_0xf4fe('0xb')]-0x1;_0x41cfe5+=0x2){_0x2168a7[_0xf4fe('0x11')][_0xf4fe('0x33')](_0x579c23[_0x41cfe5],_0x579c23[_0x41cfe5+0x1]);}if(_0x528e1a){_0x2168a7[_0xf4fe('0x11')][_0xf4fe('0x33')](_0x2168a7['sW'],_0x2168a7['sH']);_0x2168a7[_0xf4fe('0x11')][_0xf4fe('0x33')](0x0,_0x2168a7['sH']);_0x2168a7[_0xf4fe('0x11')][_0xf4fe('0x55')]=_0xf4fe('0x1a')+_0x2168a7[_0xf4fe('0x1b')](_0x4b04ef)['r']+',\x20'+_0x2168a7['getHexClr'](_0x4b04ef)['g']+',\x20'+_0x2168a7['getHexClr'](_0x4b04ef)['b']+',\x20'+_0x5c2dcf+')';_0x2168a7[_0xf4fe('0x11')][_0xf4fe('0x26')]();_0x2168a7[_0xf4fe('0x11')][_0xf4fe('0x2')]();}else{_0x2168a7[_0xf4fe('0x11')]['strokeStyle']=_0xf4fe('0x1a')+_0x2168a7[_0xf4fe('0x1b')](_0x4b04ef)['r']+',\x20'+_0x2168a7[_0xf4fe('0x1b')](_0x4b04ef)['g']+',\x20'+_0x2168a7[_0xf4fe('0x1b')](_0x4b04ef)['b']+',\x20'+_0x5c2dcf+')';_0x2168a7[_0xf4fe('0x11')]['stroke']();_0x2168a7[_0xf4fe('0x11')][_0xf4fe('0x2')]();}};_0x2168a7[_0xf4fe('0x50')]=function(){var _0x113234=0x4;if(_0x2168a7['sW']>0x3e8){_0x113234=0x4;}else if(_0x2168a7['sW']<0xc8){_0x113234=0xf;}else if(_0x2168a7['sW']<0x190){_0x113234=0x8;}_0x2168a7[_0xf4fe('0x11')][_0xf4fe('0x2f')](0x0,0x0,_0x2168a7['sW'],_0x2168a7['sH']);_0x2168a7[_0xf4fe('0x11')][_0xf4fe('0x1d')]=0x1;_0x2168a7[_0xf4fe('0x11')]['miterLimit']=0x1;_0x2168a7[_0xf4fe('0x11')]['beginPath']();_0x2168a7[_0xf4fe('0x11')]['moveTo'](0x0,_0x2168a7['sH']);for(var _0x3c1825=0x0;_0x3c1825<_0x2168a7[_0xf4fe('0x14')][_0xf4fe('0xb')];_0x3c1825++){_0x2168a7[_0xf4fe('0x11')][_0xf4fe('0x33')](_0x3c1825*_0x2168a7['sW']/_0x2168a7[_0xf4fe('0x14')][_0xf4fe('0xb')]*_0x113234,_0x2168a7['sH']-_0x2168a7[_0xf4fe('0x14')][_0x3c1825]*_0x2168a7['sH']/0xff+0x1);}_0x2168a7[_0xf4fe('0x11')]['lineTo'](_0x2168a7['sW'],_0x2168a7['sH']);_0x2168a7[_0xf4fe('0x11')][_0xf4fe('0x33')](0x0,_0x2168a7['sH']);_0x2168a7['ctx'][_0xf4fe('0x55')]=_0xf4fe('0x1a')+_0x2168a7[_0xf4fe('0x1b')](_0x2168a7[_0xf4fe('0x0')])['r']+',\x20'+_0x2168a7[_0xf4fe('0x1b')](_0x2168a7[_0xf4fe('0x0')])['g']+',\x20'+_0x2168a7[_0xf4fe('0x1b')](_0x2168a7[_0xf4fe('0x0')])['b']+',\x201.0)';_0x2168a7[_0xf4fe('0x11')][_0xf4fe('0x26')]();_0x2168a7[_0xf4fe('0x11')]['closePath']();};_0x2168a7[_0xf4fe('0x1b')]=function(_0x4f12ac){return(_0x4f12ac=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i[_0xf4fe('0x46')](_0x4f12ac))?{'r':parseInt(_0x4f12ac[0x1],0x10),'g':parseInt(_0x4f12ac[0x2],0x10),'b':parseInt(_0x4f12ac[0x3],0x10)}:null;};_0x2168a7[_0xf4fe('0x3b')]();};_0x3cbf91[_0xf4fe('0x40')]=function(){_0x3cbf91[_0xf4fe('0x4a')]=new FWDRAPDisplayObject(_0xf4fe('0x5'));};_0x42b645[_0xf4fe('0x15')]=_0x3cbf91;}(window));
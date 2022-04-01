if (typeof asual == "undefined") {
    var asual = {}
}
if (typeof asual.util == "undefined") {
    asual.util = {}
}
asual.util.Browser = new function () {
    var b = navigator.userAgent.toLowerCase(),
        a = /webkit/.test(b),
        e = /opera/.test(b),
        c = /msie/.test(b) && !/opera/.test(b),
        d = /mozilla/.test(b) && !/(compatible|webkit)/.test(b),
        f = parseFloat(c ? b.substr(b.indexOf("msie") + 4) : (b.match(/.+(?:rv|it|ra|ie)[\/: ]([\d.]+)/) || [0, "0"])[1]);
    this.toString = function () {
        return "[class Browser]"
    };
    this.getVersion = function () {
        return f
    };
    this.isMSIE = function () {
        return c
    };
    this.isSafari = function () {
        return a
    };
    this.isOpera = function () {
        return e
    };
    this.isMozilla = function () {
        return d
    }
};
asual.util.Events = new function () {
    var c = "DOMContentLoaded",
        j = "onstop",
        k = window,
        h = document,
        b = [],
        a = asual.util,
        e = a.Browser,
        d = e.isMSIE(),
        g = e.isSafari();
    this.toString = function () {
        return "[class Events]"
    };
    this.addListener = function (n, l, m) {
        b.push({
            o: n,
            t: l,
            l: m
        });
        if (!(l == c && (d || g))) {
            if (n.addEventListener) {
                n.addEventListener(l, m, false)
            } else {
                if (n.attachEvent) {
                    n.attachEvent("on" + l, m)
                }
            }
        }
    };
    this.removeListener = function (p, m, n) {
        for (var l = 0, o; o = b[l]; l++) {
            if (o.o == p && o.t == m && o.l == n) {
                b.splice(l, 1);
                break
            }
        }
        if (!(m == c && (d || g))) {
            if (p.removeEventListener) {
                p.removeEventListener(m, n, false)
            } else {
                if (p.detachEvent) {
                    p.detachEvent("on" + m, n)
                }
            }
        }
    };
    var i = function () {
        for (var m = 0, l; l = b[m]; m++) {
            if (l.t != c) {
                a.Events.removeListener(l.o, l.t, l.l)
            }
        }
    };
    var f = function () {
        if (h.readyState == "interactive") {
            function l() {
                h.detachEvent(j, l);
                i()
            }
            h.attachEvent(j, l);
            k.setTimeout(function () {
                h.detachEvent(j, l)
            }, 0)
        }
    };
    if (d || g) {
        (function () {
            try {
                if ((d && h.body) || !/loaded|complete/.test(h.readyState)) {
                    h.documentElement.doScroll("left")
                }
            } catch (m) {
                return setTimeout(arguments.callee, 0)
            }
            for (var l = 0, m; m = b[l]; l++) {
                if (m.t == c) {
                    m.l.call(null)
                }
            }
        })()
    }
    if (d) {
        if(k.attachEvent) k.attachEvent("onbeforeunload", f)
    }
    this.addListener(k, "unload", i)
};
asual.util.Functions = new function () {
    this.toString = function () {
        return "[class Functions]"
    };
    this.bind = function (f, b, e) {
        for (var c = 2, d, a = []; d = arguments[c]; c++) {
            a.push(d)
        }
        return function () {
            return f.apply(b, a)
        }
    }
};
var FWDAddressEvent = function (d) {
    this.toString = function () {
        return "[object FWDAddressEvent]"
    };
    this.type = d;
    this.target = [FWDAddress][0];
    this.value = FWDAddress.getValue();
    this.path = FWDAddress.getPath();
    this.pathNames = FWDAddress.getPathNames();
    this.parameters = {};
    var c = FWDAddress.getParameterNames();
    for (var b = 0, a = c.length; b < a; b++) {
        this.parameters[c[b]] = FWDAddress.getParameter(c[b])
    }
    this.parameterNames = c
};
FWDAddressEvent.INIT = "init";
FWDAddressEvent.CHANGE = "change";
FWDAddressEvent.INTERNAL_CHANGE = "internalChange";
FWDAddressEvent.EXTERNAL_CHANGE = "externalChange";
var FWDAddress = new function () {
        var _getHash = function () {
            var index = _l.href.indexOf("#");
            return index != -1 ? _ec(_dc(_l.href.substr(index + 1))) : ""
        };
        var _getWindow = function () {
            try {
                top.document;
                return top
            } catch (e) {
                return window
            }
        };
        var _strictCheck = function (value, force) {
            if (_opts.strict) {
                value = force ? (value.substr(0, 1) != "/" ? "/" + value : value) : (value == "" ? "/" : value)
            }
            return value
        };
        var _ieLocal = function (value, direction) {
            return (_msie && _l.protocol == "file:") ? (direction ? _value.replace(/\?/, "%3F") : _value.replace(/%253F/, "?")) : value
        };
        var _searchScript = function (el) {
            if (el.childNodes) {
                for (var i = 0, l = el.childNodes.length, s; i < l; i++) {
                    if (el.childNodes[i].src) {
                        _url = String(el.childNodes[i].src)
                    }
                    if (s = _searchScript(el.childNodes[i])) {
                        return s
                    }
                }
            }
        };
        var _titleCheck = function () {
            if (_d.title != _title && _d.title.indexOf("#") != -1) {
                _d.title = _title
            }
        };
        var _listen = function () {
            if (!_silent) {
                var hash = _getHash();
                var diff = !(_value == hash);
                if (_safari && _version < 523) {
                    if (_length != _h.length) {
                        _length = _h.length;
                        if (typeof _stack[_length - 1] != UNDEFINED) {
                            _value = _stack[_length - 1]
                        }
                        _update.call(this, false)
                    }
                } else {
                    if (_msie && diff) {
                        if (_version < 7) {
                            _l.reload()
                        } else {
                            this.setValue(hash)
                        }
                    } else {
                        if (diff) {
                            _value = hash;
                            _update.call(this, false)
                        }
                    }
                } if (_msie) {
                    _titleCheck.call(this)
                }
            }
        };
        var _bodyClick = function (e) {
            if (_popup.length > 0) {
                var popup = window.open(_popup[0], _popup[1], eval(_popup[2]));
                if (typeof _popup[3] != UNDEFINED) {
                    eval(_popup[3])
                }
            }
            _popup = []
        };
        var _swfChange = function () {
            for (var i = 0, id, obj, value = FWDAddress.getValue(), setter = "setFWDAddressValue"; id = _ids[i]; i++) {
                obj = document.getElementById(id);
                if (obj) {
                    if (obj.parentNode && typeof obj.parentNode.so != UNDEFINED) {
                        obj.parentNode.so.call(setter, value)
                    } else {
                        if (!(obj && typeof obj[setter] != UNDEFINED)) {
                            var objects = obj.getElementsByTagName("object");
                            var embeds = obj.getElementsByTagName("embed");
                            obj = ((objects[0] && typeof objects[0][setter] != UNDEFINED) ? objects[0] : ((embeds[0] && typeof embeds[0][setter] != UNDEFINED) ? embeds[0] : null))
                        }
                        if (obj) {
                            obj[setter](value)
                        }
                    }
                } else {
                    if (obj = document[id]) {
                        if (typeof obj[setter] != UNDEFINED) {
                            obj[setter](value)
                        }
                    }
                }
            }
        };
        var _jsDispatch = function (type) {
            this.dispatchEvent(new FWDAddressEvent(type));
            type = type.substr(0, 1).toUpperCase() + type.substr(1);
            if (typeof this["on" + type] == FUNCTION) {
                this["on" + type]()
            }
        };
        var _jsInit = function () {
            if (_util.Browser.isSafari()) {
                _d.body.addEventListener("click", _bodyClick)
            }
            _jsDispatch.call(this, "init")
        };
        var _jsChange = function () {
            _swfChange();
            _jsDispatch.call(this, "change")
        };
        var _update = function (internal) {
            _jsChange.call(this);
            if (internal) {
                _jsDispatch.call(this, "internalChange")
            } else {
                _jsDispatch.call(this, "externalChange")
            }
            _st(_functions.bind(_track, this), 10)
        };
        var _track = function () {
            var value = (_l.pathname + (/\/$/.test(_l.pathname) ? "" : "/") + this.getValue()).replace(/\/\//, "/").replace(/^\/$/, "");
            var fn = _t[_opts.tracker];
            if (typeof fn == FUNCTION) {
                fn(value)
            } else {
                if (typeof _t.pageTracker != UNDEFINED && typeof _t.pageTracker._trackPageview == FUNCTION) {
                    _t.pageTracker._trackPageview(value)
                } else {
                    if (typeof _t.urchinTracker == FUNCTION) {
                        _t.urchinTracker(value)
                    }
                }
            }
        };
        var _htmlWrite = function () {
            var doc = _frame.contentWindow.document;
            doc.open();
            doc.write("<html><head><title>" + _d.title + "</title><script>var " + ID + ' = "' + _getHash() + '";<\/script></head></html>');
            doc.close()
        };
        var _htmlLoad = function () {
            var win = _frame.contentWindow;
            var src = win.location.href;
            _value = (typeof win[ID] != UNDEFINED ? win[ID] : "");
            if (_value != _getHash()) {
                _update.call(FWDAddress, false);
                _l.hash = _ieLocal(_value, TRUE)
            }
        };
        var _load = function () {
            if (!_loaded) {
                _loaded = TRUE;
                if (_msie && _version < 8) {
                    var frameset = _d.getElementsByTagName("frameset")[0];
                    _frame = _d.createElement((frameset ? "" : "i") + "frame");
                    if (frameset) {
                        frameset.insertAdjacentElement("beforeEnd", _frame);
                        frameset[frameset.cols ? "cols" : "rows"] += ",0";
                        _frame.src = "javascript:false";
                        _frame.noResize = true;
                        _frame.frameBorder = _frame.frameSpacing = 0
                    } else {
                        _frame.src = "javascript:false";
                        _frame.style.display = "none";
                        _d.body.insertAdjacentElement("afterBegin", _frame)
                    }
                    _st(function () {
                        _events.addListener(_frame, "load", _htmlLoad);
                        if (typeof _frame.contentWindow[ID] == UNDEFINED) {
                            _htmlWrite()
                        }
                    }, 50)
                } else {
                    if (_safari) {
                        if (_version < 418) {
                            _d.body.innerHTML += '<form id="' + ID + '" style="position:absolute;top:-9999px;" method="get"></form>';
                            _form = _d.getElementById(ID)
                        }
                        if (typeof _l[ID] == UNDEFINED) {
                            _l[ID] = {}
                        }
                        if (typeof _l[ID][_l.pathname] != UNDEFINED) {
                            _stack = _l[ID][_l.pathname].split(",")
                        }
                    }
                }
                _st(_functions.bind(function () {
                    _jsInit.call(this);
                    _jsChange.call(this);
                    _track.call(this)
                }, this), 1);
                if (_msie && _version >= 8) {
                    _d.body.onhashchange = _functions.bind(_listen, this);
                    _si(_functions.bind(_titleCheck, this), 50)
                } else {
                    _si(_functions.bind(_listen, this), 50)
                }
            }
        };
        var ID = "swfaddress",
            FUNCTION = "function",
            UNDEFINED = "undefined",
            TRUE = true,
            FALSE = false,
            _util = asual.util,
            _browser = _util.Browser,
            _events = _util.Events,
            _functions = _util.Functions,
            _version = _browser.getVersion(),
            _msie = _browser.isMSIE(),
            _mozilla = _browser.isMozilla(),
            _opera = _browser.isOpera(),
            _safari = _browser.isSafari(),
            _supported = FALSE,
            _t = _getWindow(),
            _d = _t.document,
            _h = _t.history,
            _l = _t.location,
            _si = setInterval,
            _st = setTimeout,
            _dc = decodeURI,
            _ec = encodeURI,
            _frame, _form, _url, _title = _d.title,
            _length = _h.length,
            _silent = FALSE,
            _loaded = FALSE,
            _justset = TRUE,
            _juststart = TRUE,
            _ref = this,
            _stack = [],
            _ids = [],
            _popup = [],
            _listeners = {}, _value = _getHash(),
            _opts = {
                history: TRUE,
                strict: TRUE
            };
        if (_msie && _d.documentMode && _d.documentMode != _version) {
            _version = _d.documentMode != 8 ? 7 : 8
        }
        _supported = (_mozilla && _version >= 1) || (_msie && _version >= 6) || (_opera && _version >= 9.5) || (_safari && _version >= 312);
        if (_supported) {
            if (_opera) {
                history.navigationMode = "compatible"
            }
            for (var i = 1; i < _length; i++) {
                _stack.push("")
            }
            _stack.push(_getHash());
            if (_msie && _l.hash != _getHash()) {
                _l.hash = "#" + _ieLocal(_getHash(), TRUE)
            }
            _searchScript(document);
            var _qi = _url ? _url.indexOf("?") : -1;
            if (_qi != -1) {
                var param, params = _url.substr(_qi + 1).split("&");
                for (var i = 0, p; p = params[i]; i++) {
                    param = p.split("=");
                    if (/^(history|strict)$/.test(param[0])) {
                        _opts[param[0]] = (isNaN(param[1]) ? /^(true|yes)$/i.test(param[1]) : (parseInt(param[1]) != 0))
                    }
                    if (/^tracker$/.test(param[0])) {
                        _opts[param[0]] = param[1]
                    }
                }
            }
            if (_msie) {
                _titleCheck.call(this)
            }
            if (window == _t) {
                _events.addListener(document, "DOMContentLoaded", _functions.bind(_load, this))
            }
            _events.addListener(_t, "load", _functions.bind(_load, this))
        } else {
            if ((!_supported && _l.href.indexOf("#") != -1) || (_safari && _version < 418 && _l.href.indexOf("#") != -1 && _l.search != "")) {
                _d.open();
                _d.write('<html><head><meta http-equiv="refresh" content="0;url=' + _l.href.substr(0, _l.href.indexOf("#")) + '" /></head></html>');
                _d.close()
            } else {
                _track()
            }
        }
        this.toString = function () {
            return "[class FWDAddress]"
        };
        this.back = function () {
            _h.back()
        };
        this.forward = function () {
            _h.forward()
        };
        this.up = function () {
            var path = this.getPath();
            this.setValue(path.substr(0, path.lastIndexOf("/", path.length - 2) + (path.substr(path.length - 1) == "/" ? 1 : 0)))
        };
        this.go = function (delta) {
            _h.go(delta)
        };
        this.href = function (url, target) {
            target = typeof target != UNDEFINED ? target : "_self";
            if (target == "_self") {
                _s.location.href = url
            } else {
                if (target == "_top") {
                    _l.href = url
                } else {
                    if (target == "_blank") {
                        window.open(url)
                    } else {
                        _t.frames[target].location.href = url
                    }
                }
            }
        };
        this.popup = function (url, name, options, handler) {
            try {
                var popup = window.open(url, name, eval(options));
                if (typeof handler != UNDEFINED) {
                    eval(handler)
                }
            } catch (ex) {}
            _popup = arguments
        };
        this.getIds = function () {
            return _ids
        };
        this.getId = function (index) {
            return _ids[0]
        };
        this.setId = function (id) {
            _ids[0] = id
        };
        this.addId = function (id) {
            this.removeId(id);
            _ids.push(id)
        };
        this.removeId = function (id) {
            for (var i = 0; i < _ids.length; i++) {
                if (id == _ids[i]) {
                    _ids.splice(i, 1);
                    break
                }
            }
        };
        this.addEventListener = function (type, listener) {
            if (typeof _listeners[type] == UNDEFINED) {
                _listeners[type] = []
            }
            _listeners[type].push(listener)
        };
        this.removeEventListener = function (type, listener) {
            if (typeof _listeners[type] != UNDEFINED) {
                for (var i = 0, l; l = _listeners[type][i]; i++) {
                    if (l == listener) {
                        break
                    }
                }
                _listeners[type].splice(i, 1)
            }
        };
        this.dispatchEvent = function (event) {
            if (this.hasEventListener(event.type)) {
                event.target = this;
                for (var i = 0, l; l = _listeners[event.type][i]; i++) {
                    l(event)
                }
                return TRUE
            }
            return FALSE
        };
        this.hasEventListener = function (type) {
            return (typeof _listeners[type] != UNDEFINED && _listeners[type].length > 0)
        };
        this.getBaseURL = function () {
            var url = _l.href;
            if (url.indexOf("#") != -1) {
                url = url.substr(0, url.indexOf("#"))
            }
            if (url.substr(url.length - 1) == "/") {
                url = url.substr(0, url.length - 1)
            }
            return url
        };
        this.getStrict = function () {
            return _opts.strict
        };
        this.setStrict = function (strict) {
            _opts.strict = strict
        };
        this.getHistory = function () {
            return _opts.history
        };
        this.setHistory = function (history) {
            _opts.history = history
        };
        this.getTracker = function () {
            return _opts.tracker
        };
        this.setTracker = function (tracker) {
            _opts.tracker = tracker
        };
        this.getTitle = function () {
            return _d.title
        };
        this.setTitle = function (title) {
            if (!_supported) {
                return null
            }
            if (typeof title == UNDEFINED) {
                return
            }
            if (title == "null") {
                title = ""
            }
            title = _dc(title);
            _st(function () {
                _title = _d.title = title;
                if (_juststart && _frame && _frame.contentWindow && _frame.contentWindow.document) {
                    _frame.contentWindow.document.title = title;
                    _juststart = FALSE
                }
                if (!_justset && _mozilla) {
                    _l.replace(_l.href.indexOf("#") != -1 ? _l.href : _l.href + "#")
                }
                _justset = FALSE
            }, 10)
        };
        this.getStatus = function () {
            return _t.status
        };
        this.setStatus = function (status) {
            if (!_supported) {
                return null
            }
            if (typeof status == UNDEFINED) {
                return
            }
            if (status == "null") {
                status = ""
            }
            status = _dc(status);
            if (!_safari) {
                status = _strictCheck((status != "null") ? status : "", TRUE);
                if (status == "/") {
                    status = ""
                }
                if (!(/http(s)?:\/\//.test(status))) {
                    var index = _l.href.indexOf("#");
                    status = (index == -1 ? _l.href : _l.href.substr(0, index)) + "#" + status
                }
                _t.status = status
            }
        };
        this.resetStatus = function () {
            _t.status = ""
        };
        this.getValue = function () {
            if (!_supported) {
                return null
            }
            return _dc(_strictCheck(_ieLocal(_value, FALSE), FALSE))
        };
        this.setValue = function (value) {
            if (!_supported) {
                return null
            }
            if (typeof value == UNDEFINED) {
                return
            }
            if (value == "null") {
                value = ""
            }
            value = _ec(_dc(_strictCheck(value, TRUE)));
            if (value == "/") {
                value = ""
            }
            if (_value == value) {
                return
            }
            _justset = TRUE;
            _value = value;
            _silent = TRUE;
            _update.call(FWDAddress, true);
            _stack[_h.length] = _value;
            
            if (_safari) {
                if (_opts.history) {
                    _l[ID][_l.pathname] = _stack.toString();
                    _length = _h.length + 1;
                    if (_version < 418) {
                        if (_l.search == "") {
                            _form.action = "#" + _value;
                            _form.submit()
                        }
                    } else {
                        if (_version < 523 || _value == "") {
                            var evt = _d.createEvent("MouseEvents");
                            evt.initEvent("click", TRUE, TRUE);
                            var anchor = _d.createElement("a");
                            anchor.href = "#" + _value;
                            anchor.dispatchEvent(evt)
                        } else {
                            _l.hash = "#" + _value
                        }
                    }
                } else {
                    _l.replace("#" + _value)
                }
            } else {
                if (_value != _getHash()) {
                    if (_opts.history) {
                        _l.hash = "#" + _dc(_ieLocal(_value, TRUE))
                    } else {
                        _l.replace("#" + _dc(_value))
                    }
                }
            } if ((_msie && _version < 8) && _opts.history) {
                _st(_htmlWrite, 50)
            }
            if (_safari) {
                _st(function () {
                    _silent = FALSE
                }, 1)
            } else {
                _silent = FALSE
            }
        
        };
        this.getPath = function () {
            var value = this.getValue();
            if (value.indexOf("?") != -1) {
                return value.split("?")[0]
            } else {
                if (value.indexOf("#") != -1) {
                    return value.split("#")[0]
                } else {
                    return value
                }
            }
        };
        this.getPathNames = function () {
            var path = this.getPath(),
                names = path.split("/");
            if (path.substr(0, 1) == "/" || path.length == 0) {
                names.splice(0, 1)
            }
            if (path.substr(path.length - 1, 1) == "/") {
                names.splice(names.length - 1, 1)
            }
            return names
        };
        this.getQueryString = function () {
            var value = this.getValue(),
                index = value.indexOf("?");
            if (index != -1 && index < value.length) {
                return value.substr(index + 1)
            }
        };
        this.getParameter = function (param) {
            var value = this.getValue();
            var index = value.indexOf("?");
            if (index != -1) {
                value = value.substr(index + 1);
                var p, params = value.split("&"),
                    i = params.length,
                    r = [];
                while (i--) {
                    p = params[i].split("=");
                    if (p[0] == param) {
                        r.push(p[1])
                    }
                }
                if (r.length != 0) {
                    return r.length != 1 ? r : r[0]
                }
            }
        };
        this.getParameterNames = function () {
            var value = this.getValue();
            var index = value.indexOf("?");
            var names = [];
            if (index != -1) {
                value = value.substr(index + 1);
                if (value != "" && value.indexOf("=") != -1) {
                    var params = value.split("&"),
                        i = 0;
                    while (i < params.length) {
                        names.push(params[i].split("=")[0]);
                        i++
                    }
                }
            }
            return names
        };
        this.onInit = null;
        this.onChange = null;
        this.onInternalChange = null;
        this.onExternalChange = null;
        (function () {
            var _args;
            if (typeof FlashObject != UNDEFINED) {
                SWFObject = FlashObject
            }
            if (typeof SWFObject != UNDEFINED && SWFObject.prototype && SWFObject.prototype.write) {
                var _s1 = SWFObject.prototype.write;
                SWFObject.prototype.write = function () {
                    _args = arguments;
                    if (this.getAttribute("version").major < 8) {
                        this.addVariable("$swfaddress", FWDAddress.getValue());
                        ((typeof _args[0] == "string") ? document.getElementById(_args[0]) : _args[0]).so = this
                    }
                    var success;
                    if (success = _s1.apply(this, _args)) {
                        _ref.addId(this.getAttribute("id"))
                    }
                    return success
                }
            }
            if (typeof swfobject != UNDEFINED) {
                var _s2r = swfobject.registerObject;
                swfobject.registerObject = function () {
                    _args = arguments;
                    _s2r.apply(this, _args);
                    _ref.addId(_args[0])
                };
                var _s2c = swfobject.createSWF;
                swfobject.createSWF = function () {
                    _args = arguments;
                    var swf = _s2c.apply(this, _args);
                    if (swf) {
                        _ref.addId(_args[0].id)
                    }
                    return swf
                };
                var _s2e = swfobject.embedSWF;
                swfobject.embedSWF = function () {
                    _args = arguments;
                    if (typeof _args[8] == UNDEFINED) {
                        _args[8] = {}
                    }
                    if (typeof _args[8].id == UNDEFINED) {
                        _args[8].id = _args[1]
                    }
                    _s2e.apply(this, _args);
                    _ref.addId(_args[8].id)
                }
            }
            if (typeof UFO != UNDEFINED) {
                var _u = UFO.create;
                UFO.create = function () {
                    _args = arguments;
                    _u.apply(this, _args);
                    _ref.addId(_args[0].id)
                }
            }
            if (typeof AC_FL_RunContent != UNDEFINED) {
                var _a = AC_FL_RunContent;
                AC_FL_RunContent = function () {
                    _args = arguments;
                    _a.apply(this, _args);
                    for (var i = 0, l = _args.length; i < l; i++) {
                        if (_args[i] == "id") {
                            _ref.addId(_args[i + 1])
                        }
                    }
                }
            }
        })()
    };
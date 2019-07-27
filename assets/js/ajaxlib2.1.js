/*jslint bitwise: true, eqeqeq: true, immed: true, newcap: true, nomen: true,
  onevar: true, plusplus: true, regexp: true, strict: true, undef: true,
  white: true, indent: 4*/
/**
 * AJAXlib 2.1
 *
 * Simple utility for using AJAX in Web2.0 applications providing both
 * low-level and high-level API.
 *
 * AJAXlib2 is compatible with browsers IE6.0+, Firefox 1.5+, Opera 9.0+,
 * Chrome 1+ and Safari 2+.
 *
 * If you want to encapsulate this lib within a container object, you should
 * add to this container object following properties referencing to properties
 * of global object with same names: XMLHttpRequest, ActiveXObject, document,
 * JSON.
 *
 * @author Martin Jurča
 * @copyright Copyright &copy; 2009, Martin Jurča
 * @version 2.1.1
 * @class AJAXlib2
 */
"use strict";
(function () {
    var ajax, serialize, setup, load, get, post, json, script,
            addStartListener, addSuccessListener, addFailListener,
            addCompleteListener, addSerializeListener, getDefaultOptions,
            applyOptionsChanges, getXmlHttpRequest, isValidOptionsObject,
            encodeObject, getJSONLoader, getScriptLoader, serializeInputs,
            insertToDataObject, serializeSelects, serializeTextAreas;

    ajax = function (options) {
        var ajaxOptions, xmlHttpRequest, data, url, i;
        ajaxOptions = getDefaultOptions.call(this);
        applyOptionsChanges(ajaxOptions, options);
        xmlHttpRequest = getXmlHttpRequest(ajaxOptions, this);
        data = typeof ajaxOptions.data === 'string' ? ajaxOptions.data :
                encodeObject(ajaxOptions.data);
        url = ajaxOptions.method === 'GET' ? ajaxOptions.url + '?' + data :
                ajaxOptions.url;
        xmlHttpRequest.open(ajaxOptions.method, url, true);
        for (i in ajaxOptions.headers) {
            if (ajaxOptions.headers.hasOwnProperty(i)) {
                xmlHttpRequest.setRequestHeader(i, ajaxOptions.headers[i]);
            }
        }
        if (ajaxOptions.method === 'POST') {
            xmlHttpRequest.setRequestHeader("content-type",
                    "application/x-www-form-urlencoded");
            xmlHttpRequest.setRequestHeader("content-length", data.length);
            xmlHttpRequest.setRequestHeader("connection", "close");
            xmlHttpRequest.send(data);
        } else {
            xmlHttpRequest.send(null);
        }
        for (i = 0; i < this.startListeners.length; i += 1) {
            this.startListeners[i]('start', xmlHttpRequest, ajaxOptions);
        }
        return xmlHttpRequest;
    };

    serialize = function (formNode) {
        var i, data;
        if ((typeof formNode !== 'object') ||
                (typeof formNode.nodeName !== 'string') ||
                (formNode.nodeName.toLowerCase() !== 'form')) {
            throw new TypeError("formNode must be an HTML form element");
        }
        for (i = 0; i < this.serializeListeners.length; i += 1) {
            this.serializeListeners[i]('serialize', formNode);
        }
        data = {};
        serializeInputs(data, formNode);
        serializeSelects(data, formNode);
        serializeTextAreas(data, formNode);
        return data;
    };

    setup = function (options) {
        var property;
        if (!isValidOptionsObject(options)) {
            throw new TypeError("options is not a valid options object");
        }
        for (property in options) {
            if (options.hasOwnProperty(property)) {
                this[property] = options[property];
            }
        }
    };

    load = function (url, data, element, callback) {
        var display, options;
        display = function (response, status, xmlHttpRequest) {
            element.innerHTML = response;
            if (callback instanceof Function) {
                callback(element, status, xmlHttpRequest);
            }
        };
        if (!(callback instanceof Function)) {
            callback = function (element, status, xmlHttpRequest) {};
        }
        options = {
            url: url,
            data: data,
            method: 'POST',
            onSuccess: display,
            onFail: callback
        };
        return this.ajax(options);
    };

    get = function (url, data, callback) {
        var options = {
            url: url,
            data: data,
            method: 'GET',
            onSuccess: callback,
            onFail: callback
        };
        return this.ajax(options);
    };

    post = function (url, data, callback) {
        var options = {
            url: url,
            data: data,
            method: 'POST',
            onSuccess: callback,
            onFail: callback
        };
        return this.ajax(options);
    };

    json = function (url, data, callback) {
        var options = {
            url: url,
            data: data,
            method: 'POST',
            onSuccess: getJSONLoader(callback),
            onFail: callback
        };
        return this.ajax(options);
    };

    script = function (url, data, callback) {
        var options = {
            url: url,
            data: data,
            method: 'POST',
            onSuccess: getScriptLoader(callback),
            onFail: callback
        };
        return this.ajax(options);
    };

    addStartListener = function (listener) {
        if (listener instanceof Function) {
            this.startListeners.push(listener);
            return;
        }
        throw new TypeError("listener must be a function");
    };

    addSuccessListener = function (listener) {
        if (listener instanceof Function) {
            this.successListeners.push(listener);
            return;
        }
        throw new TypeError("listener must be a function");
    };

    addFailListener = function (listener) {
        if (listener instanceof Function) {
            this.failListeners.push(listener);
            return;
        }
        throw new TypeError("listener must be a function");
    };

    addCompleteListener = function (listener) {
        if (listener instanceof Function) {
            this.completeListeners.push(listener);
            return;
        }
        throw new TypeError("listener must be a function");
    };

    addSerializeListener = function (listener) {
        if (listener instanceof Function) {
            this.serializeListeners.push(listener);
            return;
        }
        throw new TypeError("listener must be a function");
    };

    serializeInputs = function (data, formNode) {
        var inputs, i, length;
        inputs = formNode.getElementsByTagName('input');
        length = inputs.length;
        for (i = 0; i < length; i += 1) {
            if ((inputs[i].type === 'radio') ||
                    (inputs[i].type === 'checkbox')) {
                if (inputs[i].checked) {
                    insertToDataObject(data, inputs[i].name, inputs[i].value);
                }
            } else {
                insertToDataObject(data, inputs[i].name, inputs[i].value);
            }
        }
    };

    serializeSelects = function (data, formNode) {
        var selects, i, length, optionsLength, j;
        selects = formNode.getElementsByTagName('select');
        length = selects.length;
        for (i = 0; i < length; i += 1) {
            if (selects[i].multiple) {
                optionsLength = selects[i].options.length;
                for (j = 0; j < optionsLength; j += 1) {
                    if (selects[i].options[j].selected) {
                        insertToDataObject(data, selects[i].name,
                                selects[i].options[j].value);
                    }
                }
            } else {
                insertToDataObject(data, selects[i].name, selects[i].value);
            }
        }
    };

    serializeTextAreas = function (data, formNode) {
        var textareas, i, length;
        textareas = formNode.getElementsByTagName('textarea');
        length = textareas.length;
        for (i = 0; i < length; i += 1) {
            insertToDataObject(data, textareas[i].name, textareas[i].value);
        }
    };

    insertToDataObject = function (data, name, value) {
        var prefix, subname;
        if (typeof name !== 'string') {
            return;
        }
        if ((name.length === 0) && (data instanceof Array)) {
            data.push(value);
            return;
        }
        if (name.indexOf('[') > -1) {
            prefix = name.substring(0, name.indexOf('['));
            subname = name.replace(/^[^\]]*\[([^\]])*\]/, '$1');
            if (data[prefix] === undefined) {
                data[prefix] = [];
            }
            insertToDataObject(data[prefix], subname, value);
        } else {
            data[name] = value;
        }
    };

    getDefaultOptions = function () {
        var options = {
            method: this.method,
            url: this.url,
            data: this.data,
            headers: this.headers,
            onSuccess: this.onSuccess,
            onFail: this.onFail
        };
        return options;
    };

    applyOptionsChanges = function (targetOptions, newOptions) {
        if (!isValidOptionsObject(targetOptions) ||
                !isValidOptionsObject(newOptions)) {
            throw new TypeError("not valid options object");
        }
        for (var property in newOptions) {
            if (newOptions.hasOwnProperty(property)) {
                targetOptions[property] = newOptions[property];
            }
        }
    };

    isValidOptionsObject = function (options) {
        if (options === null) {
            return false;
        }
        var blankOptions = getDefaultOptions(), property;
        for (property in options) {
            if (!(property in blankOptions)) {
                return false;
            }
        }
        if ((options.method !== undefined) &&
                ((typeof options.method === 'string') &&
                ((options.method !== "GET") && (options.method !== "POST")))) {
            return false;
        }
        if ((options.url !== undefined) && (typeof options.url !== 'string')) {
            return false;
        }
        if ((options.data !== undefined) &&
                (typeof options.data !== 'string') &&
                (typeof options.data !== 'object')) {
            return false;
        }
        if ((options.headers !== undefined) &&
                !(options.headers instanceof Array)) {
            return false;
        }
        if ((options.onSuccess !== undefined) &&
                !(options.onSuccess instanceof Function)) {
            return false;
        }
        if ((options.onFail !== undefined) &&
                !(options.onFail instanceof Function)) {
            return false;
        }
        return true;
    };

    getXmlHttpRequest = function (options, that) {
        var xmlHttpRequest = this.XMLHttpRequest !== undefined ?
                new this.XMLHttpRequest() :
                new this.ActiveXObject("Microsoft.XMLHTTP");
        xmlHttpRequest.onreadystatechange = function () {
            var i;
            if (xmlHttpRequest.readyState !== 4) {
                return;
            }
            if (xmlHttpRequest.status === 200) {
                if (options.onSuccess instanceof Function) {
                    options.onSuccess(xmlHttpRequest.responseText, 200,
                            xmlHttpRequest);
                }
                for (i = 0; i < that.successListeners.length; i += 1) {
                    that.successListeners[i]('success', xmlHttpRequest,
                            options);
                }
            } else {
                if (options.onFail instanceof Function) {
                    options.onFail(xmlHttpRequest.responseText,
                            xmlHttpRequest.status, xmlHttpRequest);
                }
                for (i = 0; i < that.failListeners.length; i += 1) {
                    that.failListeners[i]('fail', xmlHttpRequest, options);
                }
            }
            for (i = 0; i < that.completeListeners.length; i += 1) {
                that.completeListeners[i]('complete', xmlHttpRequest, options);
            }
        };
        return xmlHttpRequest;
    };

    encodeObject = function (object, prefix) {
        var string = '', property;
        if (prefix === undefined) {
            prefix = '';
        }
        for (property in object) {
            if (object.hasOwnProperty(property)) {
                string += (string === '' ? '' : '&') +
                        ((typeof object[property] === 'object') ?
                        encodeObject(object[property],
                        prefix + (prefix === '' ? '' : '[') + property +
                        (prefix === '' ? '' : ']')) :
                        prefix + (prefix === '' ? '' : '[') +
                        encodeURIComponent(property) + (prefix === '' ? '' :
                        ']') + '=' + encodeURIComponent(object[property]));
            }
        }
        return string;
    };

    getScriptLoader = function (callback) {
        var document, loader;
        document = this.document;
        loader = function (response, status, xmlHttpRequest) {
            var head, script;
            try {
                head = document.getElementsByTagName("head")[0] ||
                        document.documentElement;
                script = document.createElement('script');
                script.setAttribute('type', 'text/javascript');
                if (script.innerText !== undefined) {
                    script.text = response;
                } else {
                    script.appendChild(document.createTextNode(response));
                }
                head.insertBefore(script, head.firstChild);
                head.removeChild(script);
            } catch (e) {
                callback(e, status, xmlHttpRequest);
            }
        };
        return loader;
    };

    getJSONLoader = function (callback) {
        var loader, JSON;
        JSON = this.JSON;
        loader = function (response, status, xmlHttpRequest) {
            var json;
            if ((JSON !== undefined) && (JSON.parse instanceof Function)) {
                json = JSON.parse(response);
            } else {
                try {
                    // Source: http://www.ietf.org/rfc/rfc4627.txt?number=4627
                    json = !(/[^,:{}\[\]0-9.\-+Eaeflnr-u \n\r\t]/.test(
                            response.replace(/"(\\([^a]|a)|[^"\\])*"/g,
                            ''))) && eval('(' + response + ')');
                } catch (e) {
                    json = e;
                }
            }
            callback(json, status, xmlHttpRequest);
        };
        return loader;
    };

    this.AJAXlib2 = function () {
        this.method = 'GET';
        this.url = '/';
        this.data = '';
        this.headers = [];
        this.startListeners = [];
        this.successListeners = [];
        this.failListeners = [];
        this.completeListeners = [];
        this.serializeListeners = [];
        this.onSuccess = function (reponse, status, xmlHttpRequest) {};
        this.onFail = function (resonse, status, xmlHttpRequest) {};
    };

    this.AJAXlib2.prototype = {
        ajax: ajax,
        serialize: serialize,
        setup: setup,
        load: load,
        get: get,
        post: post,
        json: json,
        script: script,
        encodeObject: encodeObject,
        addStartListener: addStartListener,
        addSuccessListener: addSuccessListener,
        addFailListener: addFailListener,
        addCompleteListener: addCompleteListener,
        addSerializeListener: addSerializeListener
    };
}());

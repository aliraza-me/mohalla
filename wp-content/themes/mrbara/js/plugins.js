/*
 * @author  Mudit Ameta
 * @license https://github.com/zeusdeux/isInViewport/blob/master/license.md MIT
 */
!function(a,b){function c(b){var c,d=a("<div></div>").css({width:"100%"});return b.append(d),c=b.width()-d.width(),d.remove(),c}function d(e,f){var g=e.getBoundingClientRect(),h=g.top,i=g.bottom,j=g.left,k=g.right,l=a.extend({tolerance:0,viewport:b},f),m=!1,n=l.viewport.jquery?l.viewport:a(l.viewport);n.length||(console.warn("isInViewport: The viewport selector you have provided matches no element on page."),console.warn("isInViewport: Defaulting to viewport as window"),n=a(b));var o=n.height(),p=n.width(),q=n[0].toString();if(n[0]!==b&&"[object Window]"!==q&&"[object DOMWindow]"!==q){var r=n[0].getBoundingClientRect();h-=r.top,i-=r.top,j-=r.left,k-=r.left,d.scrollBarWidth=d.scrollBarWidth||c(n),p-=d.scrollBarWidth}return l.tolerance=~~Math.round(parseFloat(l.tolerance)),l.tolerance<0&&(l.tolerance=o+l.tolerance),0>=k||j>=p?m:m=l.tolerance?h<=l.tolerance&&i>=l.tolerance:i>0&&o>=h}String.prototype.hasOwnProperty("trim")||(String.prototype.trim=function(){return this.replace(/^\s*(.*?)\s*$/,"$1")});var e=function(b){if(1===arguments.length&&"function"==typeof b&&(b=[b]),!(b instanceof Array))throw new SyntaxError("isInViewport: Argument(s) passed to .do/.run should be a function or an array of functions");for(var c=0;c<b.length;c++)if("function"==typeof b[c])for(var d=0;d<this.length;d++)b[c].call(a(this[d]));else console.warn("isInViewport: Argument(s) passed to .do/.run should be a function or an array of functions"),console.warn("isInViewport: Ignoring non-function values in array and moving on");return this};a.fn["do"]=function(a){return console.warn("isInViewport: .do is deprecated as it causes issues in IE and some browsers since it's a reserved word. Use $.fn.run instead i.e., $(el).run(fn)."),e(a)},a.fn.run=e;var f=function(b){if(b){var c=b.split(",");return 1===c.length&&isNaN(c[0])&&(c[1]=c[0],c[0]=void 0),{tolerance:c[0]?c[0].trim():void 0,viewport:c[1]?a(c[1].trim()):void 0}}return{}};a.extend(a.expr[":"],{"in-viewport":a.expr.createPseudo?a.expr.createPseudo(function(a){return function(b){return d(b,f(a))}}):function(a,b,c){return d(a,f(c[3]))}}),a.fn.isInViewport=function(a){return this.filter(function(b,c){return d(c,a)})}}(jQuery,window);
/*!
 * Isotope PACKAGED v2.2.2
 *
 * Licensed GPLv3 for open source use
 * or Isotope Commercial License for commercial use
 *
 * http://isotope.metafizzy.co
 * Copyright 2015 Metafizzy
 */

!function(a){function b(){}function c(a){function c(b){b.prototype.option||(b.prototype.option=function(b){a.isPlainObject(b)&&(this.options=a.extend(!0,this.options,b))})}function e(b,c){a.fn[b]=function(e){if("string"==typeof e){for(var g=d.call(arguments,1),h=0,i=this.length;i>h;h++){var j=this[h],k=a.data(j,b);if(k)if(a.isFunction(k[e])&&"_"!==e.charAt(0)){var l=k[e].apply(k,g);if(void 0!==l)return l}else f("no such method '"+e+"' for "+b+" instance");else f("cannot call methods on "+b+" prior to initialization; attempted to call '"+e+"'")}return this}return this.each(function(){var d=a.data(this,b);d?(d.option(e),d._init()):(d=new c(this,e),a.data(this,b,d))})}}if(a){var f="undefined"==typeof console?b:function(a){console.error(a)};return a.bridget=function(a,b){c(b),e(a,b)},a.bridget}}var d=Array.prototype.slice;"function"==typeof define&&define.amd?define("jquery-bridget/jquery.bridget",["jquery"],c):c("object"==typeof exports?require("jquery"):a.jQuery)}(window),function(a){function b(b){var c=a.event;return c.target=c.target||c.srcElement||b,c}var c=document.documentElement,d=function(){};c.addEventListener?d=function(a,b,c){a.addEventListener(b,c,!1)}:c.attachEvent&&(d=function(a,c,d){a[c+d]=d.handleEvent?function(){var c=b(a);d.handleEvent.call(d,c)}:function(){var c=b(a);d.call(a,c)},a.attachEvent("on"+c,a[c+d])});var e=function(){};c.removeEventListener?e=function(a,b,c){a.removeEventListener(b,c,!1)}:c.detachEvent&&(e=function(a,b,c){a.detachEvent("on"+b,a[b+c]);try{delete a[b+c]}catch(d){a[b+c]=void 0}});var f={bind:d,unbind:e};"function"==typeof define&&define.amd?define("eventie/eventie",f):"object"==typeof exports?module.exports=f:a.eventie=f}(window),function(){"use strict";function a(){}function b(a,b){for(var c=a.length;c--;)if(a[c].listener===b)return c;return-1}function c(a){return function(){return this[a].apply(this,arguments)}}var d=a.prototype,e=this,f=e.EventEmitter;d.getListeners=function(a){var b,c,d=this._getEvents();if(a instanceof RegExp){b={};for(c in d)d.hasOwnProperty(c)&&a.test(c)&&(b[c]=d[c])}else b=d[a]||(d[a]=[]);return b},d.flattenListeners=function(a){var b,c=[];for(b=0;b<a.length;b+=1)c.push(a[b].listener);return c},d.getListenersAsObject=function(a){var b,c=this.getListeners(a);return c instanceof Array&&(b={},b[a]=c),b||c},d.addListener=function(a,c){var d,e=this.getListenersAsObject(a),f="object"==typeof c;for(d in e)e.hasOwnProperty(d)&&-1===b(e[d],c)&&e[d].push(f?c:{listener:c,once:!1});return this},d.on=c("addListener"),d.addOnceListener=function(a,b){return this.addListener(a,{listener:b,once:!0})},d.once=c("addOnceListener"),d.defineEvent=function(a){return this.getListeners(a),this},d.defineEvents=function(a){for(var b=0;b<a.length;b+=1)this.defineEvent(a[b]);return this},d.removeListener=function(a,c){var d,e,f=this.getListenersAsObject(a);for(e in f)f.hasOwnProperty(e)&&(d=b(f[e],c),-1!==d&&f[e].splice(d,1));return this},d.off=c("removeListener"),d.addListeners=function(a,b){return this.manipulateListeners(!1,a,b)},d.removeListeners=function(a,b){return this.manipulateListeners(!0,a,b)},d.manipulateListeners=function(a,b,c){var d,e,f=a?this.removeListener:this.addListener,g=a?this.removeListeners:this.addListeners;if("object"!=typeof b||b instanceof RegExp)for(d=c.length;d--;)f.call(this,b,c[d]);else for(d in b)b.hasOwnProperty(d)&&(e=b[d])&&("function"==typeof e?f.call(this,d,e):g.call(this,d,e));return this},d.removeEvent=function(a){var b,c=typeof a,d=this._getEvents();if("string"===c)delete d[a];else if(a instanceof RegExp)for(b in d)d.hasOwnProperty(b)&&a.test(b)&&delete d[b];else delete this._events;return this},d.removeAllListeners=c("removeEvent"),d.emitEvent=function(a,b){var c,d,e,f,g=this.getListenersAsObject(a);for(e in g)if(g.hasOwnProperty(e))for(d=g[e].length;d--;)c=g[e][d],c.once===!0&&this.removeListener(a,c.listener),f=c.listener.apply(this,b||[]),f===this._getOnceReturnValue()&&this.removeListener(a,c.listener);return this},d.trigger=c("emitEvent"),d.emit=function(a){var b=Array.prototype.slice.call(arguments,1);return this.emitEvent(a,b)},d.setOnceReturnValue=function(a){return this._onceReturnValue=a,this},d._getOnceReturnValue=function(){return this.hasOwnProperty("_onceReturnValue")?this._onceReturnValue:!0},d._getEvents=function(){return this._events||(this._events={})},a.noConflict=function(){return e.EventEmitter=f,a},"function"==typeof define&&define.amd?define("eventEmitter/EventEmitter",[],function(){return a}):"object"==typeof module&&module.exports?module.exports=a:e.EventEmitter=a}.call(this),function(a){function b(a){if(a){if("string"==typeof d[a])return a;a=a.charAt(0).toUpperCase()+a.slice(1);for(var b,e=0,f=c.length;f>e;e++)if(b=c[e]+a,"string"==typeof d[b])return b}}var c="Webkit Moz ms Ms O".split(" "),d=document.documentElement.style;"function"==typeof define&&define.amd?define("get-style-property/get-style-property",[],function(){return b}):"object"==typeof exports?module.exports=b:a.getStyleProperty=b}(window),function(a,b){function c(a){var b=parseFloat(a),c=-1===a.indexOf("%")&&!isNaN(b);return c&&b}function d(){}function e(){for(var a={width:0,height:0,innerWidth:0,innerHeight:0,outerWidth:0,outerHeight:0},b=0,c=h.length;c>b;b++){var d=h[b];a[d]=0}return a}function f(b){function d(){if(!m){m=!0;var d=a.getComputedStyle;if(j=function(){var a=d?function(a){return d(a,null)}:function(a){return a.currentStyle};return function(b){var c=a(b);return c||g("Style returned "+c+". Are you running this code in a hidden iframe on Firefox? See http://bit.ly/getsizebug1"),c}}(),k=b("boxSizing")){var e=document.createElement("div");e.style.width="200px",e.style.padding="1px 2px 3px 4px",e.style.borderStyle="solid",e.style.borderWidth="1px 2px 3px 4px",e.style[k]="border-box";var f=document.body||document.documentElement;f.appendChild(e);var h=j(e);l=200===c(h.width),f.removeChild(e)}}}function f(a){if(d(),"string"==typeof a&&(a=document.querySelector(a)),a&&"object"==typeof a&&a.nodeType){var b=j(a);if("none"===b.display)return e();var f={};f.width=a.offsetWidth,f.height=a.offsetHeight;for(var g=f.isBorderBox=!(!k||!b[k]||"border-box"!==b[k]),m=0,n=h.length;n>m;m++){var o=h[m],p=b[o];p=i(a,p);var q=parseFloat(p);f[o]=isNaN(q)?0:q}var r=f.paddingLeft+f.paddingRight,s=f.paddingTop+f.paddingBottom,t=f.marginLeft+f.marginRight,u=f.marginTop+f.marginBottom,v=f.borderLeftWidth+f.borderRightWidth,w=f.borderTopWidth+f.borderBottomWidth,x=g&&l,y=c(b.width);y!==!1&&(f.width=y+(x?0:r+v));var z=c(b.height);return z!==!1&&(f.height=z+(x?0:s+w)),f.innerWidth=f.width-(r+v),f.innerHeight=f.height-(s+w),f.outerWidth=f.width+t,f.outerHeight=f.height+u,f}}function i(b,c){if(a.getComputedStyle||-1===c.indexOf("%"))return c;var d=b.style,e=d.left,f=b.runtimeStyle,g=f&&f.left;return g&&(f.left=b.currentStyle.left),d.left=c,c=d.pixelLeft,d.left=e,g&&(f.left=g),c}var j,k,l,m=!1;return f}var g="undefined"==typeof console?d:function(a){console.error(a)},h=["paddingLeft","paddingRight","paddingTop","paddingBottom","marginLeft","marginRight","marginTop","marginBottom","borderLeftWidth","borderRightWidth","borderTopWidth","borderBottomWidth"];"function"==typeof define&&define.amd?define("get-size/get-size",["get-style-property/get-style-property"],f):"object"==typeof exports?module.exports=f(require("desandro-get-style-property")):a.getSize=f(a.getStyleProperty)}(window),function(a){function b(a){"function"==typeof a&&(b.isReady?a():g.push(a))}function c(a){var c="readystatechange"===a.type&&"complete"!==f.readyState;b.isReady||c||d()}function d(){b.isReady=!0;for(var a=0,c=g.length;c>a;a++){var d=g[a];d()}}function e(e){return"complete"===f.readyState?d():(e.bind(f,"DOMContentLoaded",c),e.bind(f,"readystatechange",c),e.bind(a,"load",c)),b}var f=a.document,g=[];b.isReady=!1,"function"==typeof define&&define.amd?define("doc-ready/doc-ready",["eventie/eventie"],e):"object"==typeof exports?module.exports=e(require("eventie")):a.docReady=e(a.eventie)}(window),function(a){"use strict";function b(a,b){return a[g](b)}function c(a){if(!a.parentNode){var b=document.createDocumentFragment();b.appendChild(a)}}function d(a,b){c(a);for(var d=a.parentNode.querySelectorAll(b),e=0,f=d.length;f>e;e++)if(d[e]===a)return!0;return!1}function e(a,d){return c(a),b(a,d)}var f,g=function(){if(a.matches)return"matches";if(a.matchesSelector)return"matchesSelector";for(var b=["webkit","moz","ms","o"],c=0,d=b.length;d>c;c++){var e=b[c],f=e+"MatchesSelector";if(a[f])return f}}();if(g){var h=document.createElement("div"),i=b(h,"div");f=i?b:e}else f=d;"function"==typeof define&&define.amd?define("matches-selector/matches-selector",[],function(){return f}):"object"==typeof exports?module.exports=f:window.matchesSelector=f}(Element.prototype),function(a,b){"use strict";"function"==typeof define&&define.amd?define("fizzy-ui-utils/utils",["doc-ready/doc-ready","matches-selector/matches-selector"],function(c,d){return b(a,c,d)}):"object"==typeof exports?module.exports=b(a,require("doc-ready"),require("desandro-matches-selector")):a.fizzyUIUtils=b(a,a.docReady,a.matchesSelector)}(window,function(a,b,c){var d={};d.extend=function(a,b){for(var c in b)a[c]=b[c];return a},d.modulo=function(a,b){return(a%b+b)%b};var e=Object.prototype.toString;d.isArray=function(a){return"[object Array]"==e.call(a)},d.makeArray=function(a){var b=[];if(d.isArray(a))b=a;else if(a&&"number"==typeof a.length)for(var c=0,e=a.length;e>c;c++)b.push(a[c]);else b.push(a);return b},d.indexOf=Array.prototype.indexOf?function(a,b){return a.indexOf(b)}:function(a,b){for(var c=0,d=a.length;d>c;c++)if(a[c]===b)return c;return-1},d.removeFrom=function(a,b){var c=d.indexOf(a,b);-1!=c&&a.splice(c,1)},d.isElement="function"==typeof HTMLElement||"object"==typeof HTMLElement?function(a){return a instanceof HTMLElement}:function(a){return a&&"object"==typeof a&&1==a.nodeType&&"string"==typeof a.nodeName},d.setText=function(){function a(a,c){b=b||(void 0!==document.documentElement.textContent?"textContent":"innerText"),a[b]=c}var b;return a}(),d.getParent=function(a,b){for(;a!=document.body;)if(a=a.parentNode,c(a,b))return a},d.getQueryElement=function(a){return"string"==typeof a?document.querySelector(a):a},d.handleEvent=function(a){var b="on"+a.type;this[b]&&this[b](a)},d.filterFindElements=function(a,b){a=d.makeArray(a);for(var e=[],f=0,g=a.length;g>f;f++){var h=a[f];if(d.isElement(h))if(b){c(h,b)&&e.push(h);for(var i=h.querySelectorAll(b),j=0,k=i.length;k>j;j++)e.push(i[j])}else e.push(h)}return e},d.debounceMethod=function(a,b,c){var d=a.prototype[b],e=b+"Timeout";a.prototype[b]=function(){var a=this[e];a&&clearTimeout(a);var b=arguments,f=this;this[e]=setTimeout(function(){d.apply(f,b),delete f[e]},c||100)}},d.toDashed=function(a){return a.replace(/(.)([A-Z])/g,function(a,b,c){return b+"-"+c}).toLowerCase()};var f=a.console;return d.htmlInit=function(c,e){b(function(){for(var b=d.toDashed(e),g=document.querySelectorAll(".js-"+b),h="data-"+b+"-options",i=0,j=g.length;j>i;i++){var k,l=g[i],m=l.getAttribute(h);try{k=m&&JSON.parse(m)}catch(n){f&&f.error("Error parsing "+h+" on "+l.nodeName.toLowerCase()+(l.id?"#"+l.id:"")+": "+n);continue}var o=new c(l,k),p=a.jQuery;p&&p.data(l,e,o)}})},d}),function(a,b){"use strict";"function"==typeof define&&define.amd?define("outlayer/item",["eventEmitter/EventEmitter","get-size/get-size","get-style-property/get-style-property","fizzy-ui-utils/utils"],function(c,d,e,f){return b(a,c,d,e,f)}):"object"==typeof exports?module.exports=b(a,require("wolfy87-eventemitter"),require("get-size"),require("desandro-get-style-property"),require("fizzy-ui-utils")):(a.Outlayer={},a.Outlayer.Item=b(a,a.EventEmitter,a.getSize,a.getStyleProperty,a.fizzyUIUtils))}(window,function(a,b,c,d,e){"use strict";function f(a){for(var b in a)return!1;return b=null,!0}function g(a,b){a&&(this.element=a,this.layout=b,this.position={x:0,y:0},this._create())}function h(a){return a.replace(/([A-Z])/g,function(a){return"-"+a.toLowerCase()})}var i=a.getComputedStyle,j=i?function(a){return i(a,null)}:function(a){return a.currentStyle},k=d("transition"),l=d("transform"),m=k&&l,n=!!d("perspective"),o={WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"otransitionend",transition:"transitionend"}[k],p=["transform","transition","transitionDuration","transitionProperty"],q=function(){for(var a={},b=0,c=p.length;c>b;b++){var e=p[b],f=d(e);f&&f!==e&&(a[e]=f)}return a}();e.extend(g.prototype,b.prototype),g.prototype._create=function(){this._transn={ingProperties:{},clean:{},onEnd:{}},this.css({position:"absolute"})},g.prototype.handleEvent=function(a){var b="on"+a.type;this[b]&&this[b](a)},g.prototype.getSize=function(){this.size=c(this.element)},g.prototype.css=function(a){var b=this.element.style;for(var c in a){var d=q[c]||c;b[d]=a[c]}},g.prototype.getPosition=function(){var a=j(this.element),b=this.layout.options,c=b.isOriginLeft,d=b.isOriginTop,e=a[c?"left":"right"],f=a[d?"top":"bottom"],g=this.layout.size,h=-1!=e.indexOf("%")?parseFloat(e)/100*g.width:parseInt(e,10),i=-1!=f.indexOf("%")?parseFloat(f)/100*g.height:parseInt(f,10);h=isNaN(h)?0:h,i=isNaN(i)?0:i,h-=c?g.paddingLeft:g.paddingRight,i-=d?g.paddingTop:g.paddingBottom,this.position.x=h,this.position.y=i},g.prototype.layoutPosition=function(){var a=this.layout.size,b=this.layout.options,c={},d=b.isOriginLeft?"paddingLeft":"paddingRight",e=b.isOriginLeft?"left":"right",f=b.isOriginLeft?"right":"left",g=this.position.x+a[d];c[e]=this.getXValue(g),c[f]="";var h=b.isOriginTop?"paddingTop":"paddingBottom",i=b.isOriginTop?"top":"bottom",j=b.isOriginTop?"bottom":"top",k=this.position.y+a[h];c[i]=this.getYValue(k),c[j]="",this.css(c),this.emitEvent("layout",[this])},g.prototype.getXValue=function(a){var b=this.layout.options;return b.percentPosition&&!b.isHorizontal?a/this.layout.size.width*100+"%":a+"px"},g.prototype.getYValue=function(a){var b=this.layout.options;return b.percentPosition&&b.isHorizontal?a/this.layout.size.height*100+"%":a+"px"},g.prototype._transitionTo=function(a,b){this.getPosition();var c=this.position.x,d=this.position.y,e=parseInt(a,10),f=parseInt(b,10),g=e===this.position.x&&f===this.position.y;if(this.setPosition(a,b),g&&!this.isTransitioning)return void this.layoutPosition();var h=a-c,i=b-d,j={};j.transform=this.getTranslate(h,i),this.transition({to:j,onTransitionEnd:{transform:this.layoutPosition},isCleaning:!0})},g.prototype.getTranslate=function(a,b){var c=this.layout.options;return a=c.isOriginLeft?a:-a,b=c.isOriginTop?b:-b,n?"translate3d("+a+"px, "+b+"px, 0)":"translate("+a+"px, "+b+"px)"},g.prototype.goTo=function(a,b){this.setPosition(a,b),this.layoutPosition()},g.prototype.moveTo=m?g.prototype._transitionTo:g.prototype.goTo,g.prototype.setPosition=function(a,b){this.position.x=parseInt(a,10),this.position.y=parseInt(b,10)},g.prototype._nonTransition=function(a){this.css(a.to),a.isCleaning&&this._removeStyles(a.to);for(var b in a.onTransitionEnd)a.onTransitionEnd[b].call(this)},g.prototype._transition=function(a){if(!parseFloat(this.layout.options.transitionDuration))return void this._nonTransition(a);var b=this._transn;for(var c in a.onTransitionEnd)b.onEnd[c]=a.onTransitionEnd[c];for(c in a.to)b.ingProperties[c]=!0,a.isCleaning&&(b.clean[c]=!0);if(a.from){this.css(a.from);var d=this.element.offsetHeight;d=null}this.enableTransition(a.to),this.css(a.to),this.isTransitioning=!0};var r="opacity,"+h(q.transform||"transform");g.prototype.enableTransition=function(){this.isTransitioning||(this.css({transitionProperty:r,transitionDuration:this.layout.options.transitionDuration}),this.element.addEventListener(o,this,!1))},g.prototype.transition=g.prototype[k?"_transition":"_nonTransition"],g.prototype.onwebkitTransitionEnd=function(a){this.ontransitionend(a)},g.prototype.onotransitionend=function(a){this.ontransitionend(a)};var s={"-webkit-transform":"transform","-moz-transform":"transform","-o-transform":"transform"};g.prototype.ontransitionend=function(a){if(a.target===this.element){var b=this._transn,c=s[a.propertyName]||a.propertyName;if(delete b.ingProperties[c],f(b.ingProperties)&&this.disableTransition(),c in b.clean&&(this.element.style[a.propertyName]="",delete b.clean[c]),c in b.onEnd){var d=b.onEnd[c];d.call(this),delete b.onEnd[c]}this.emitEvent("transitionEnd",[this])}},g.prototype.disableTransition=function(){this.removeTransitionStyles(),this.element.removeEventListener(o,this,!1),this.isTransitioning=!1},g.prototype._removeStyles=function(a){var b={};for(var c in a)b[c]="";this.css(b)};var t={transitionProperty:"",transitionDuration:""};return g.prototype.removeTransitionStyles=function(){this.css(t)},g.prototype.removeElem=function(){this.element.parentNode.removeChild(this.element),this.css({display:""}),this.emitEvent("remove",[this])},g.prototype.remove=function(){if(!k||!parseFloat(this.layout.options.transitionDuration))return void this.removeElem();var a=this;this.once("transitionEnd",function(){a.removeElem()}),this.hide()},g.prototype.reveal=function(){delete this.isHidden,this.css({display:""});var a=this.layout.options,b={},c=this.getHideRevealTransitionEndProperty("visibleStyle");b[c]=this.onRevealTransitionEnd,this.transition({from:a.hiddenStyle,to:a.visibleStyle,isCleaning:!0,onTransitionEnd:b})},g.prototype.onRevealTransitionEnd=function(){this.isHidden||this.emitEvent("reveal")},g.prototype.getHideRevealTransitionEndProperty=function(a){var b=this.layout.options[a];if(b.opacity)return"opacity";for(var c in b)return c},g.prototype.hide=function(){this.isHidden=!0,this.css({display:""});var a=this.layout.options,b={},c=this.getHideRevealTransitionEndProperty("hiddenStyle");b[c]=this.onHideTransitionEnd,this.transition({from:a.visibleStyle,to:a.hiddenStyle,isCleaning:!0,onTransitionEnd:b})},g.prototype.onHideTransitionEnd=function(){this.isHidden&&(this.css({display:"none"}),this.emitEvent("hide"))},g.prototype.destroy=function(){this.css({position:"",left:"",right:"",top:"",bottom:"",transition:"",transform:""})},g}),function(a,b){"use strict";"function"==typeof define&&define.amd?define("outlayer/outlayer",["eventie/eventie","eventEmitter/EventEmitter","get-size/get-size","fizzy-ui-utils/utils","./item"],function(c,d,e,f,g){return b(a,c,d,e,f,g)}):"object"==typeof exports?module.exports=b(a,require("eventie"),require("wolfy87-eventemitter"),require("get-size"),require("fizzy-ui-utils"),require("./item")):a.Outlayer=b(a,a.eventie,a.EventEmitter,a.getSize,a.fizzyUIUtils,a.Outlayer.Item)}(window,function(a,b,c,d,e,f){"use strict";function g(a,b){var c=e.getQueryElement(a);if(!c)return void(h&&h.error("Bad element for "+this.constructor.namespace+": "+(c||a)));this.element=c,i&&(this.$element=i(this.element)),this.options=e.extend({},this.constructor.defaults),this.option(b);var d=++k;this.element.outlayerGUID=d,l[d]=this,this._create(),this.options.isInitLayout&&this.layout()}var h=a.console,i=a.jQuery,j=function(){},k=0,l={};return g.namespace="outlayer",g.Item=f,g.defaults={containerStyle:{position:"relative"},isInitLayout:!0,isOriginLeft:!0,isOriginTop:!0,isResizeBound:!0,isResizingContainer:!0,transitionDuration:"0.4s",hiddenStyle:{opacity:0,transform:"scale(0.001)"},visibleStyle:{opacity:1,transform:"scale(1)"}},e.extend(g.prototype,c.prototype),g.prototype.option=function(a){e.extend(this.options,a)},g.prototype._create=function(){this.reloadItems(),this.stamps=[],this.stamp(this.options.stamp),e.extend(this.element.style,this.options.containerStyle),this.options.isResizeBound&&this.bindResize()},g.prototype.reloadItems=function(){this.items=this._itemize(this.element.children)},g.prototype._itemize=function(a){for(var b=this._filterFindItemElements(a),c=this.constructor.Item,d=[],e=0,f=b.length;f>e;e++){var g=b[e],h=new c(g,this);d.push(h)}return d},g.prototype._filterFindItemElements=function(a){return e.filterFindElements(a,this.options.itemSelector)},g.prototype.getItemElements=function(){for(var a=[],b=0,c=this.items.length;c>b;b++)a.push(this.items[b].element);return a},g.prototype.layout=function(){this._resetLayout(),this._manageStamps();var a=void 0!==this.options.isLayoutInstant?this.options.isLayoutInstant:!this._isLayoutInited;this.layoutItems(this.items,a),this._isLayoutInited=!0},g.prototype._init=g.prototype.layout,g.prototype._resetLayout=function(){this.getSize()},g.prototype.getSize=function(){this.size=d(this.element)},g.prototype._getMeasurement=function(a,b){var c,f=this.options[a];f?("string"==typeof f?c=this.element.querySelector(f):e.isElement(f)&&(c=f),this[a]=c?d(c)[b]:f):this[a]=0},g.prototype.layoutItems=function(a,b){a=this._getItemsForLayout(a),this._layoutItems(a,b),this._postLayout()},g.prototype._getItemsForLayout=function(a){for(var b=[],c=0,d=a.length;d>c;c++){var e=a[c];e.isIgnored||b.push(e)}return b},g.prototype._layoutItems=function(a,b){if(this._emitCompleteOnItems("layout",a),a&&a.length){for(var c=[],d=0,e=a.length;e>d;d++){var f=a[d],g=this._getItemLayoutPosition(f);g.item=f,g.isInstant=b||f.isLayoutInstant,c.push(g)}this._processLayoutQueue(c)}},g.prototype._getItemLayoutPosition=function(){return{x:0,y:0}},g.prototype._processLayoutQueue=function(a){for(var b=0,c=a.length;c>b;b++){var d=a[b];this._positionItem(d.item,d.x,d.y,d.isInstant)}},g.prototype._positionItem=function(a,b,c,d){d?a.goTo(b,c):a.moveTo(b,c)},g.prototype._postLayout=function(){this.resizeContainer()},g.prototype.resizeContainer=function(){if(this.options.isResizingContainer){var a=this._getContainerSize();a&&(this._setContainerMeasure(a.width,!0),this._setContainerMeasure(a.height,!1))}},g.prototype._getContainerSize=j,g.prototype._setContainerMeasure=function(a,b){if(void 0!==a){var c=this.size;c.isBorderBox&&(a+=b?c.paddingLeft+c.paddingRight+c.borderLeftWidth+c.borderRightWidth:c.paddingBottom+c.paddingTop+c.borderTopWidth+c.borderBottomWidth),a=Math.max(a,0),this.element.style[b?"width":"height"]=a+"px"}},g.prototype._emitCompleteOnItems=function(a,b){function c(){e.dispatchEvent(a+"Complete",null,[b])}function d(){g++,g===f&&c()}var e=this,f=b.length;if(!b||!f)return void c();for(var g=0,h=0,i=b.length;i>h;h++){var j=b[h];j.once(a,d)}},g.prototype.dispatchEvent=function(a,b,c){var d=b?[b].concat(c):c;if(this.emitEvent(a,d),i)if(this.$element=this.$element||i(this.element),b){var e=i.Event(b);e.type=a,this.$element.trigger(e,c)}else this.$element.trigger(a,c)},g.prototype.ignore=function(a){var b=this.getItem(a);b&&(b.isIgnored=!0)},g.prototype.unignore=function(a){var b=this.getItem(a);b&&delete b.isIgnored},g.prototype.stamp=function(a){if(a=this._find(a)){this.stamps=this.stamps.concat(a);for(var b=0,c=a.length;c>b;b++){var d=a[b];this.ignore(d)}}},g.prototype.unstamp=function(a){if(a=this._find(a))for(var b=0,c=a.length;c>b;b++){var d=a[b];e.removeFrom(this.stamps,d),this.unignore(d)}},g.prototype._find=function(a){return a?("string"==typeof a&&(a=this.element.querySelectorAll(a)),a=e.makeArray(a)):void 0},g.prototype._manageStamps=function(){if(this.stamps&&this.stamps.length){this._getBoundingRect();for(var a=0,b=this.stamps.length;b>a;a++){var c=this.stamps[a];this._manageStamp(c)}}},g.prototype._getBoundingRect=function(){var a=this.element.getBoundingClientRect(),b=this.size;this._boundingRect={left:a.left+b.paddingLeft+b.borderLeftWidth,top:a.top+b.paddingTop+b.borderTopWidth,right:a.right-(b.paddingRight+b.borderRightWidth),bottom:a.bottom-(b.paddingBottom+b.borderBottomWidth)}},g.prototype._manageStamp=j,g.prototype._getElementOffset=function(a){var b=a.getBoundingClientRect(),c=this._boundingRect,e=d(a),f={left:b.left-c.left-e.marginLeft,top:b.top-c.top-e.marginTop,right:c.right-b.right-e.marginRight,bottom:c.bottom-b.bottom-e.marginBottom};return f},g.prototype.handleEvent=function(a){var b="on"+a.type;this[b]&&this[b](a)},g.prototype.bindResize=function(){this.isResizeBound||(b.bind(a,"resize",this),this.isResizeBound=!0)},g.prototype.unbindResize=function(){this.isResizeBound&&b.unbind(a,"resize",this),this.isResizeBound=!1},g.prototype.onresize=function(){function a(){b.resize(),delete b.resizeTimeout}this.resizeTimeout&&clearTimeout(this.resizeTimeout);var b=this;this.resizeTimeout=setTimeout(a,100)},g.prototype.resize=function(){this.isResizeBound&&this.needsResizeLayout()&&this.layout()},g.prototype.needsResizeLayout=function(){var a=d(this.element),b=this.size&&a;return b&&a.innerWidth!==this.size.innerWidth},g.prototype.addItems=function(a){var b=this._itemize(a);return b.length&&(this.items=this.items.concat(b)),b},g.prototype.appended=function(a){var b=this.addItems(a);b.length&&(this.layoutItems(b,!0),this.reveal(b))},g.prototype.prepended=function(a){var b=this._itemize(a);if(b.length){var c=this.items.slice(0);this.items=b.concat(c),this._resetLayout(),this._manageStamps(),this.layoutItems(b,!0),this.reveal(b),this.layoutItems(c)}},g.prototype.reveal=function(a){this._emitCompleteOnItems("reveal",a);for(var b=a&&a.length,c=0;b&&b>c;c++){var d=a[c];d.reveal()}},g.prototype.hide=function(a){this._emitCompleteOnItems("hide",a);for(var b=a&&a.length,c=0;b&&b>c;c++){var d=a[c];d.hide()}},g.prototype.revealItemElements=function(a){var b=this.getItems(a);this.reveal(b)},g.prototype.hideItemElements=function(a){var b=this.getItems(a);this.hide(b)},g.prototype.getItem=function(a){for(var b=0,c=this.items.length;c>b;b++){var d=this.items[b];if(d.element===a)return d}},g.prototype.getItems=function(a){a=e.makeArray(a);for(var b=[],c=0,d=a.length;d>c;c++){var f=a[c],g=this.getItem(f);g&&b.push(g)}return b},g.prototype.remove=function(a){var b=this.getItems(a);if(this._emitCompleteOnItems("remove",b),b&&b.length)for(var c=0,d=b.length;d>c;c++){var f=b[c];f.remove(),e.removeFrom(this.items,f)}},g.prototype.destroy=function(){var a=this.element.style;a.height="",a.position="",a.width="";for(var b=0,c=this.items.length;c>b;b++){var d=this.items[b];d.destroy()}this.unbindResize();var e=this.element.outlayerGUID;delete l[e],delete this.element.outlayerGUID,i&&i.removeData(this.element,this.constructor.namespace)},g.data=function(a){a=e.getQueryElement(a);var b=a&&a.outlayerGUID;return b&&l[b]},g.create=function(a,b){function c(){g.apply(this,arguments)}return Object.create?c.prototype=Object.create(g.prototype):e.extend(c.prototype,g.prototype),c.prototype.constructor=c,c.defaults=e.extend({},g.defaults),e.extend(c.defaults,b),c.prototype.settings={},c.namespace=a,c.data=g.data,c.Item=function(){f.apply(this,arguments)},c.Item.prototype=new f,e.htmlInit(c,a),i&&i.bridget&&i.bridget(a,c),c},g.Item=f,g}),function(a,b){"use strict";"function"==typeof define&&define.amd?define("isotope/js/item",["outlayer/outlayer"],b):"object"==typeof exports?module.exports=b(require("outlayer")):(a.Isotope=a.Isotope||{},a.Isotope.Item=b(a.Outlayer))}(window,function(a){"use strict";function b(){a.Item.apply(this,arguments)}b.prototype=new a.Item,b.prototype._create=function(){this.id=this.layout.itemGUID++,a.Item.prototype._create.call(this),this.sortData={}},b.prototype.updateSortData=function(){if(!this.isIgnored){this.sortData.id=this.id,this.sortData["original-order"]=this.id,this.sortData.random=Math.random();var a=this.layout.options.getSortData,b=this.layout._sorters;for(var c in a){var d=b[c];this.sortData[c]=d(this.element,this)}}};var c=b.prototype.destroy;return b.prototype.destroy=function(){c.apply(this,arguments),this.css({display:""})},b}),function(a,b){"use strict";"function"==typeof define&&define.amd?define("isotope/js/layout-mode",["get-size/get-size","outlayer/outlayer"],b):"object"==typeof exports?module.exports=b(require("get-size"),require("outlayer")):(a.Isotope=a.Isotope||{},a.Isotope.LayoutMode=b(a.getSize,a.Outlayer))}(window,function(a,b){"use strict";function c(a){this.isotope=a,a&&(this.options=a.options[this.namespace],this.element=a.element,this.items=a.filteredItems,this.size=a.size)}return function(){function a(a){return function(){return b.prototype[a].apply(this.isotope,arguments)}}for(var d=["_resetLayout","_getItemLayoutPosition","_manageStamp","_getContainerSize","_getElementOffset","needsResizeLayout"],e=0,f=d.length;f>e;e++){var g=d[e];c.prototype[g]=a(g)}}(),c.prototype.needsVerticalResizeLayout=function(){var b=a(this.isotope.element),c=this.isotope.size&&b;return c&&b.innerHeight!=this.isotope.size.innerHeight},c.prototype._getMeasurement=function(){this.isotope._getMeasurement.apply(this,arguments)},c.prototype.getColumnWidth=function(){this.getSegmentSize("column","Width")},c.prototype.getRowHeight=function(){this.getSegmentSize("row","Height")},c.prototype.getSegmentSize=function(a,b){var c=a+b,d="outer"+b;if(this._getMeasurement(c,d),!this[c]){var e=this.getFirstItemSize();this[c]=e&&e[d]||this.isotope.size["inner"+b]}},c.prototype.getFirstItemSize=function(){var b=this.isotope.filteredItems[0];return b&&b.element&&a(b.element)},c.prototype.layout=function(){this.isotope.layout.apply(this.isotope,arguments)},c.prototype.getSize=function(){this.isotope.getSize(),this.size=this.isotope.size},c.modes={},c.create=function(a,b){function d(){c.apply(this,arguments)}return d.prototype=new c,b&&(d.options=b),d.prototype.namespace=a,c.modes[a]=d,d},c}),function(a,b){"use strict";"function"==typeof define&&define.amd?define("masonry/masonry",["outlayer/outlayer","get-size/get-size","fizzy-ui-utils/utils"],b):"object"==typeof exports?module.exports=b(require("outlayer"),require("get-size"),require("fizzy-ui-utils")):a.Masonry=b(a.Outlayer,a.getSize,a.fizzyUIUtils)}(window,function(a,b,c){var d=a.create("masonry");return d.prototype._resetLayout=function(){this.getSize(),this._getMeasurement("columnWidth","outerWidth"),this._getMeasurement("gutter","outerWidth"),this.measureColumns();var a=this.cols;for(this.colYs=[];a--;)this.colYs.push(0);this.maxY=0},d.prototype.measureColumns=function(){if(this.getContainerWidth(),!this.columnWidth){var a=this.items[0],c=a&&a.element;this.columnWidth=c&&b(c).outerWidth||this.containerWidth}var d=this.columnWidth+=this.gutter,e=this.containerWidth+this.gutter,f=e/d,g=d-e%d,h=g&&1>g?"round":"floor";f=Math[h](f),this.cols=Math.max(f,1)},d.prototype.getContainerWidth=function(){var a=this.options.isFitWidth?this.element.parentNode:this.element,c=b(a);this.containerWidth=c&&c.innerWidth},d.prototype._getItemLayoutPosition=function(a){a.getSize();var b=a.size.outerWidth%this.columnWidth,d=b&&1>b?"round":"ceil",e=Math[d](a.size.outerWidth/this.columnWidth);e=Math.min(e,this.cols);for(var f=this._getColGroup(e),g=Math.min.apply(Math,f),h=c.indexOf(f,g),i={x:this.columnWidth*h,y:g},j=g+a.size.outerHeight,k=this.cols+1-f.length,l=0;k>l;l++)this.colYs[h+l]=j;return i},d.prototype._getColGroup=function(a){if(2>a)return this.colYs;for(var b=[],c=this.cols+1-a,d=0;c>d;d++){var e=this.colYs.slice(d,d+a);b[d]=Math.max.apply(Math,e)}return b},d.prototype._manageStamp=function(a){var c=b(a),d=this._getElementOffset(a),e=this.options.isOriginLeft?d.left:d.right,f=e+c.outerWidth,g=Math.floor(e/this.columnWidth);g=Math.max(0,g);var h=Math.floor(f/this.columnWidth);h-=f%this.columnWidth?0:1,h=Math.min(this.cols-1,h);for(var i=(this.options.isOriginTop?d.top:d.bottom)+c.outerHeight,j=g;h>=j;j++)this.colYs[j]=Math.max(i,this.colYs[j])},d.prototype._getContainerSize=function(){this.maxY=Math.max.apply(Math,this.colYs);var a={height:this.maxY};return this.options.isFitWidth&&(a.width=this._getContainerFitWidth()),a},d.prototype._getContainerFitWidth=function(){for(var a=0,b=this.cols;--b&&0===this.colYs[b];)a++;return(this.cols-a)*this.columnWidth-this.gutter},d.prototype.needsResizeLayout=function(){var a=this.containerWidth;return this.getContainerWidth(),a!==this.containerWidth},d}),function(a,b){"use strict";"function"==typeof define&&define.amd?define("isotope/js/layout-modes/masonry",["../layout-mode","masonry/masonry"],b):"object"==typeof exports?module.exports=b(require("../layout-mode"),require("masonry-layout")):b(a.Isotope.LayoutMode,a.Masonry)}(window,function(a,b){"use strict";function c(a,b){for(var c in b)a[c]=b[c];return a}var d=a.create("masonry"),e=d.prototype._getElementOffset,f=d.prototype.layout,g=d.prototype._getMeasurement;
c(d.prototype,b.prototype),d.prototype._getElementOffset=e,d.prototype.layout=f,d.prototype._getMeasurement=g;var h=d.prototype.measureColumns;d.prototype.measureColumns=function(){this.items=this.isotope.filteredItems,h.call(this)};var i=d.prototype._manageStamp;return d.prototype._manageStamp=function(){this.options.isOriginLeft=this.isotope.options.isOriginLeft,this.options.isOriginTop=this.isotope.options.isOriginTop,i.apply(this,arguments)},d}),function(a,b){"use strict";"function"==typeof define&&define.amd?define("isotope/js/layout-modes/fit-rows",["../layout-mode"],b):"object"==typeof exports?module.exports=b(require("../layout-mode")):b(a.Isotope.LayoutMode)}(window,function(a){"use strict";var b=a.create("fitRows");return b.prototype._resetLayout=function(){this.x=0,this.y=0,this.maxY=0,this._getMeasurement("gutter","outerWidth")},b.prototype._getItemLayoutPosition=function(a){a.getSize();var b=a.size.outerWidth+this.gutter,c=this.isotope.size.innerWidth+this.gutter;0!==this.x&&b+this.x>c&&(this.x=0,this.y=this.maxY);var d={x:this.x,y:this.y};return this.maxY=Math.max(this.maxY,this.y+a.size.outerHeight),this.x+=b,d},b.prototype._getContainerSize=function(){return{height:this.maxY}},b}),function(a,b){"use strict";"function"==typeof define&&define.amd?define("isotope/js/layout-modes/vertical",["../layout-mode"],b):"object"==typeof exports?module.exports=b(require("../layout-mode")):b(a.Isotope.LayoutMode)}(window,function(a){"use strict";var b=a.create("vertical",{horizontalAlignment:0});return b.prototype._resetLayout=function(){this.y=0},b.prototype._getItemLayoutPosition=function(a){a.getSize();var b=(this.isotope.size.innerWidth-a.size.outerWidth)*this.options.horizontalAlignment,c=this.y;return this.y+=a.size.outerHeight,{x:b,y:c}},b.prototype._getContainerSize=function(){return{height:this.y}},b}),function(a,b){"use strict";"function"==typeof define&&define.amd?define(["outlayer/outlayer","get-size/get-size","matches-selector/matches-selector","fizzy-ui-utils/utils","isotope/js/item","isotope/js/layout-mode","isotope/js/layout-modes/masonry","isotope/js/layout-modes/fit-rows","isotope/js/layout-modes/vertical"],function(c,d,e,f,g,h){return b(a,c,d,e,f,g,h)}):"object"==typeof exports?module.exports=b(a,require("outlayer"),require("get-size"),require("desandro-matches-selector"),require("fizzy-ui-utils"),require("./item"),require("./layout-mode"),require("./layout-modes/masonry"),require("./layout-modes/fit-rows"),require("./layout-modes/vertical")):a.Isotope=b(a,a.Outlayer,a.getSize,a.matchesSelector,a.fizzyUIUtils,a.Isotope.Item,a.Isotope.LayoutMode)}(window,function(a,b,c,d,e,f,g){function h(a,b){return function(c,d){for(var e=0,f=a.length;f>e;e++){var g=a[e],h=c.sortData[g],i=d.sortData[g];if(h>i||i>h){var j=void 0!==b[g]?b[g]:b,k=j?1:-1;return(h>i?1:-1)*k}}return 0}}var i=a.jQuery,j=String.prototype.trim?function(a){return a.trim()}:function(a){return a.replace(/^\s+|\s+$/g,"")},k=document.documentElement,l=k.textContent?function(a){return a.textContent}:function(a){return a.innerText},m=b.create("isotope",{layoutMode:"masonry",isJQueryFiltering:!0,sortAscending:!0});m.Item=f,m.LayoutMode=g,m.prototype._create=function(){this.itemGUID=0,this._sorters={},this._getSorters(),b.prototype._create.call(this),this.modes={},this.filteredItems=this.items,this.sortHistory=["original-order"];for(var a in g.modes)this._initLayoutMode(a)},m.prototype.reloadItems=function(){this.itemGUID=0,b.prototype.reloadItems.call(this)},m.prototype._itemize=function(){for(var a=b.prototype._itemize.apply(this,arguments),c=0,d=a.length;d>c;c++){var e=a[c];e.id=this.itemGUID++}return this._updateItemsSortData(a),a},m.prototype._initLayoutMode=function(a){var b=g.modes[a],c=this.options[a]||{};this.options[a]=b.options?e.extend(b.options,c):c,this.modes[a]=new b(this)},m.prototype.layout=function(){return!this._isLayoutInited&&this.options.isInitLayout?void this.arrange():void this._layout()},m.prototype._layout=function(){var a=this._getIsInstant();this._resetLayout(),this._manageStamps(),this.layoutItems(this.filteredItems,a),this._isLayoutInited=!0},m.prototype.arrange=function(a){function b(){d.reveal(c.needReveal),d.hide(c.needHide)}this.option(a),this._getIsInstant();var c=this._filter(this.items);this.filteredItems=c.matches;var d=this;this._bindArrangeComplete(),this._isInstant?this._noTransition(b):b(),this._sort(),this._layout()},m.prototype._init=m.prototype.arrange,m.prototype._getIsInstant=function(){var a=void 0!==this.options.isLayoutInstant?this.options.isLayoutInstant:!this._isLayoutInited;return this._isInstant=a,a},m.prototype._bindArrangeComplete=function(){function a(){b&&c&&d&&e.dispatchEvent("arrangeComplete",null,[e.filteredItems])}var b,c,d,e=this;this.once("layoutComplete",function(){b=!0,a()}),this.once("hideComplete",function(){c=!0,a()}),this.once("revealComplete",function(){d=!0,a()})},m.prototype._filter=function(a){var b=this.options.filter;b=b||"*";for(var c=[],d=[],e=[],f=this._getFilterTest(b),g=0,h=a.length;h>g;g++){var i=a[g];if(!i.isIgnored){var j=f(i);j&&c.push(i),j&&i.isHidden?d.push(i):j||i.isHidden||e.push(i)}}return{matches:c,needReveal:d,needHide:e}},m.prototype._getFilterTest=function(a){return i&&this.options.isJQueryFiltering?function(b){return i(b.element).is(a)}:"function"==typeof a?function(b){return a(b.element)}:function(b){return d(b.element,a)}},m.prototype.updateSortData=function(a){var b;a?(a=e.makeArray(a),b=this.getItems(a)):b=this.items,this._getSorters(),this._updateItemsSortData(b)},m.prototype._getSorters=function(){var a=this.options.getSortData;for(var b in a){var c=a[b];this._sorters[b]=n(c)}},m.prototype._updateItemsSortData=function(a){for(var b=a&&a.length,c=0;b&&b>c;c++){var d=a[c];d.updateSortData()}};var n=function(){function a(a){if("string"!=typeof a)return a;var c=j(a).split(" "),d=c[0],e=d.match(/^\[(.+)\]$/),f=e&&e[1],g=b(f,d),h=m.sortDataParsers[c[1]];return a=h?function(a){return a&&h(g(a))}:function(a){return a&&g(a)}}function b(a,b){var c;return c=a?function(b){return b.getAttribute(a)}:function(a){var c=a.querySelector(b);return c&&l(c)}}return a}();m.sortDataParsers={parseInt:function(a){return parseInt(a,10)},parseFloat:function(a){return parseFloat(a)}},m.prototype._sort=function(){var a=this.options.sortBy;if(a){var b=[].concat.apply(a,this.sortHistory),c=h(b,this.options.sortAscending);this.filteredItems.sort(c),a!=this.sortHistory[0]&&this.sortHistory.unshift(a)}},m.prototype._mode=function(){var a=this.options.layoutMode,b=this.modes[a];if(!b)throw new Error("No layout mode: "+a);return b.options=this.options[a],b},m.prototype._resetLayout=function(){b.prototype._resetLayout.call(this),this._mode()._resetLayout()},m.prototype._getItemLayoutPosition=function(a){return this._mode()._getItemLayoutPosition(a)},m.prototype._manageStamp=function(a){this._mode()._manageStamp(a)},m.prototype._getContainerSize=function(){return this._mode()._getContainerSize()},m.prototype.needsResizeLayout=function(){return this._mode().needsResizeLayout()},m.prototype.appended=function(a){var b=this.addItems(a);if(b.length){var c=this._filterRevealAdded(b);this.filteredItems=this.filteredItems.concat(c)}},m.prototype.prepended=function(a){var b=this._itemize(a);if(b.length){this._resetLayout(),this._manageStamps();var c=this._filterRevealAdded(b);this.layoutItems(this.filteredItems),this.filteredItems=c.concat(this.filteredItems),this.items=b.concat(this.items)}},m.prototype._filterRevealAdded=function(a){var b=this._filter(a);return this.hide(b.needHide),this.reveal(b.matches),this.layoutItems(b.matches,!0),b.matches},m.prototype.insert=function(a){var b=this.addItems(a);if(b.length){var c,d,e=b.length;for(c=0;e>c;c++)d=b[c],this.element.appendChild(d.element);var f=this._filter(b).matches;for(c=0;e>c;c++)b[c].isLayoutInstant=!0;for(this.arrange(),c=0;e>c;c++)delete b[c].isLayoutInstant;this.reveal(f)}};var o=m.prototype.remove;return m.prototype.remove=function(a){a=e.makeArray(a);var b=this.getItems(a);o.call(this,a);var c=b&&b.length;if(c)for(var d=0;c>d;d++){var f=b[d];e.removeFrom(this.filteredItems,f)}},m.prototype.shuffle=function(){for(var a=0,b=this.items.length;b>a;a++){var c=this.items[a];c.sortData.random=Math.random()}this.options.sortBy="random",this._sort(),this._layout()},m.prototype._noTransition=function(a){var b=this.options.transitionDuration;this.options.transitionDuration=0;var c=a.call(this);return this.options.transitionDuration=b,c},m.prototype.getFilteredItemElements=function(){for(var a=[],b=0,c=this.filteredItems.length;c>b;b++)a.push(this.filteredItems[b].element);return a},m});
/* ===========================================================
 * bootstrap-tooltip.js v2.1.1
 * http://twitter.github.com/bootstrap/javascript.html#tooltips
 * Inspired by the original jQuery.tipsy by Jason Frame
 * ===========================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================== */


!function (jQuery) {

  "use strict"; // jshint ;_;


 /* TOOLTIP PUBLIC CLASS DEFINITION
  * =============================== */

  var Tooltip = function (element, options) {
    this.init('tooltip', element, options)
  }

  Tooltip.prototype = {

    constructor: Tooltip

  , init: function (type, element, options) {
      var eventIn
        , eventOut

      this.type = type
      this.jQueryelement = jQuery(element)
      this.options = this.getOptions(options)
      this.enabled = true

      if (this.options.trigger == 'click') {
        this.jQueryelement.on('click.' + this.type, this.options.selector, jQuery.proxy(this.toggle, this))
      } else if (this.options.trigger != 'manual') {
        eventIn = this.options.trigger == 'hover' ? 'mouseenter' : 'focus'
        eventOut = this.options.trigger == 'hover' ? 'mouseleave' : 'blur'
        this.jQueryelement.on(eventIn + '.' + this.type, this.options.selector, jQuery.proxy(this.enter, this))
        this.jQueryelement.on(eventOut + '.' + this.type, this.options.selector, jQuery.proxy(this.leave, this))
      }

      this.options.selector ?
        (this._options = jQuery.extend({}, this.options, { trigger: 'manual', selector: '' })) :
        this.fixTitle()
    }

  , getOptions: function (options) {
      options = jQuery.extend({}, jQuery.fn[this.type].defaults, options, this.jQueryelement.data())

      if (options.delay && typeof options.delay == 'number') {
        options.delay = {
          show: options.delay
        , hide: options.delay
        }
      }

      return options
    }

  , enter: function (e) {
      var self = jQuery(e.currentTarget)[this.type](this._options).data(this.type)

      if (!self.options.delay || !self.options.delay.show) return self.show()

      clearTimeout(this.timeout)
      self.hoverState = 'in'
      this.timeout = setTimeout(function() {
        if (self.hoverState == 'in') self.show()
      }, self.options.delay.show)
    }

  , leave: function (e) {
      var self = jQuery(e.currentTarget)[this.type](this._options).data(this.type)

      if (this.timeout) clearTimeout(this.timeout)
      if (!self.options.delay || !self.options.delay.hide) return self.hide()

      self.hoverState = 'out'
      this.timeout = setTimeout(function() {
        if (self.hoverState == 'out') self.hide()
      }, self.options.delay.hide)
    }

  , show: function () {
      var jQuerytip
        , inside
        , pos
        , actualWidth
        , actualHeight
        , placement
        , tp

      if (this.hasContent() && this.enabled) {
        jQuerytip = this.tip()
        this.setContent()

        if (this.options.animation) {
          jQuerytip.addClass('fade')
        }

        placement = typeof this.options.placement == 'function' ?
          this.options.placement.call(this, jQuerytip[0], this.jQueryelement[0]) :
          this.options.placement

        inside = /in/.test(placement)

        jQuerytip
          .remove()
          .css({ top: 0, left: 0, display: 'block' })
          .appendTo(inside ? this.jQueryelement : document.body)

        pos = this.getPosition(inside)

        actualWidth = jQuerytip[0].offsetWidth
        actualHeight = jQuerytip[0].offsetHeight

        switch (inside ? placement.split(' ')[1] : placement) {
          case 'bottom':
            tp = {top: pos.top + pos.height, left: pos.left + pos.width / 2 - actualWidth / 2}
            break
          case 'top':
            tp = {top: pos.top - actualHeight + this.options.offsetTop, left: pos.left + pos.width / 2 - actualWidth / 2}
            break
          case 'left':
            tp = {top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left - actualWidth}
            break
          case 'right':
            tp = {top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left + pos.width}
            break
        }

        jQuerytip
          .css(tp)
          .addClass(placement)
          .addClass('in')
      }
    }

  , setContent: function () {
      var jQuerytip = this.tip()
        , title = this.getTitle()

      jQuerytip.find('.tooltip-inner')[this.options.html ? 'html' : 'text'](title)
      jQuerytip.removeClass('fade in top bottom left right')
    }

  , hide: function () {
      var that = this
        , jQuerytip = this.tip()

      jQuerytip.removeClass('in')

      function removeWithAnimation() {
        var timeout = setTimeout(function () {
          jQuerytip.off(jQuery.support.transition.end).remove()
        }, 500)

        jQuerytip.one(jQuery.support.transition.end, function () {
          clearTimeout(timeout)
          jQuerytip.remove()
        })
      }

      jQuery.support.transition && this.jQuerytip.hasClass('fade') ?
        removeWithAnimation() :
        jQuerytip.remove()

      return this
    }

  , fixTitle: function () {
      var jQuerye = this.jQueryelement
      if (jQuerye.attr('title') || typeof(jQuerye.attr('data-original-title')) != 'string') {
        jQuerye.attr('data-original-title', jQuerye.attr('title') || '').removeAttr('title')
      }
    }

  , hasContent: function () {
      return this.getTitle()
    }

  , getPosition: function (inside) {
      return jQuery.extend({}, (inside ? {top: 0, left: 0} : this.jQueryelement.offset()), {
        width: this.jQueryelement[0].offsetWidth
      , height: this.jQueryelement[0].offsetHeight
      })
    }

  , getTitle: function () {
      var title
        , jQuerye = this.jQueryelement
        , o = this.options

      title = jQuerye.attr('data-original-title')
        || (typeof o.title == 'function' ? o.title.call(jQuerye[0]) :  o.title)

      return title
    }

  , tip: function () {
      return this.jQuerytip = this.jQuerytip || jQuery(this.options.template)
    }

  , validate: function () {
      if (!this.jQueryelement[0].parentNode) {
        this.hide()
        this.jQueryelement = null
        this.options = null
      }
    }

  , enable: function () {
      this.enabled = true
    }

  , disable: function () {
      this.enabled = false
    }

  , toggleEnabled: function () {
      this.enabled = !this.enabled
    }

  , toggle: function () {
      this[this.tip().hasClass('in') ? 'hide' : 'show']()
    }

  , destroy: function () {
      this.hide().jQueryelement.off('.' + this.type).removeData(this.type)
    }

  }


 /* TOOLTIP PLUGIN DEFINITION
  * ========================= */

  jQuery.fn.tooltip = function ( option ) {
    return this.each(function () {
      var jQuerythis = jQuery(this)
        , data = jQuerythis.data('tooltip')
        , options = typeof option == 'object' && option
      if (!data) jQuerythis.data('tooltip', (data = new Tooltip(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  jQuery.fn.tooltip.Constructor = Tooltip

  jQuery.fn.tooltip.defaults = {
    animation: true
  , placement: 'top'
  , selector: false
  , template: '<div class="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
  , trigger: 'hover'
  , title: ''
  , delay: 0
  , html: true
  , offsetTop: 0
  }

}(window.jQuery);
/**
 * BxSlider v4.1.2 - Fully loaded, responsive content slider
 * http://bxslider.com
 *
 * Copyright 2014, Steven Wanderski - http://stevenwanderski.com - http://bxcreative.com
 * Written while drinking Belgian ales and listening to jazz
 *
 * Released under the MIT license - http://opensource.org/licenses/MIT
 */
!function(t){var e={},s={mode:"horizontal",slideSelector:"",infiniteLoop:!0,hideControlOnEnd:!1,speed:500,easing:null,slideMargin:0,startSlide:0,randomStart:!1,captions:!1,ticker:!1,tickerHover:!1,adaptiveHeight:!1,adaptiveHeightSpeed:500,video:!1,useCSS:!0,preloadImages:"visible",responsive:!0,slideZIndex:50,touchEnabled:!0,swipeThreshold:50,oneToOneTouch:!0,preventDefaultSwipeX:!0,preventDefaultSwipeY:!1,pager:!0,pagerType:"full",pagerShortSeparator:" / ",pagerSelector:null,buildPager:null,pagerCustom:null,controls:!0,nextText:"Next",prevText:"Prev",nextSelector:null,prevSelector:null,autoControls:!1,startText:"Start",stopText:"Stop",autoControlsCombine:!1,autoControlsSelector:null,auto:!1,pause:4e3,autoStart:!0,autoDirection:"next",autoHover:!1,autoDelay:0,minSlides:1,maxSlides:1,moveSlides:0,slideWidth:0,onSliderLoad:function(){},onSlideBefore:function(){},onSlideAfter:function(){},onSlideNext:function(){},onSlidePrev:function(){},onSliderResize:function(){}};t.fn.bxSlider=function(n){if(0==this.length)return this;if(this.length>1)return this.each(function(){t(this).bxSlider(n)}),this;var o={},r=this;e.el=this;var a=t(window).width(),l=t(window).height(),d=function(){o.settings=t.extend({},s,n),o.settings.slideWidth=parseInt(o.settings.slideWidth),o.children=r.children(o.settings.slideSelector),o.children.length<o.settings.minSlides&&(o.settings.minSlides=o.children.length),o.children.length<o.settings.maxSlides&&(o.settings.maxSlides=o.children.length),o.settings.randomStart&&(o.settings.startSlide=Math.floor(Math.random()*o.children.length)),o.active={index:o.settings.startSlide},o.carousel=o.settings.minSlides>1||o.settings.maxSlides>1,o.carousel&&(o.settings.preloadImages="all"),o.minThreshold=o.settings.minSlides*o.settings.slideWidth+(o.settings.minSlides-1)*o.settings.slideMargin,o.maxThreshold=o.settings.maxSlides*o.settings.slideWidth+(o.settings.maxSlides-1)*o.settings.slideMargin,o.working=!1,o.controls={},o.interval=null,o.animProp="vertical"==o.settings.mode?"top":"left",o.usingCSS=o.settings.useCSS&&"fade"!=o.settings.mode&&function(){var t=document.createElement("div"),e=["WebkitPerspective","MozPerspective","OPerspective","msPerspective"];for(var i in e)if(void 0!==t.style[e[i]])return o.cssPrefix=e[i].replace("Perspective","").toLowerCase(),o.animProp="-"+o.cssPrefix+"-transform",!0;return!1}(),"vertical"==o.settings.mode&&(o.settings.maxSlides=o.settings.minSlides),r.data("origStyle",r.attr("style")),r.children(o.settings.slideSelector).each(function(){t(this).data("origStyle",t(this).attr("style"))}),c()},c=function(){r.wrap('<div class="bx-wrapper"><div class="bx-viewport"></div></div>'),o.viewport=r.parent(),o.loader=t('<div class="bx-loading" />'),o.viewport.prepend(o.loader),r.css({width:"horizontal"==o.settings.mode?100*o.children.length+215+"%":"auto",position:"relative"}),o.usingCSS&&o.settings.easing?r.css("-"+o.cssPrefix+"-transition-timing-function",o.settings.easing):o.settings.easing||(o.settings.easing="swing"),f(),o.viewport.css({width:"100%",overflow:"hidden",position:"relative"}),o.viewport.parent().css({maxWidth:p()}),o.settings.pager||o.viewport.parent().css({margin:"0 auto 0px"}),o.children.css({"float":"horizontal"==o.settings.mode?"left":"none",listStyle:"none",position:"relative"}),o.children.css("width",u()),"horizontal"==o.settings.mode&&o.settings.slideMargin>0&&o.children.css("marginRight",o.settings.slideMargin),"vertical"==o.settings.mode&&o.settings.slideMargin>0&&o.children.css("marginBottom",o.settings.slideMargin),"fade"==o.settings.mode&&(o.children.css({position:"absolute",zIndex:0,display:"none"}),o.children.eq(o.settings.startSlide).css({zIndex:o.settings.slideZIndex,display:"block"})),o.controls.el=t('<div class="bx-controls" />'),o.settings.captions&&P(),o.active.last=o.settings.startSlide==x()-1,o.settings.video&&r.fitVids();var e=o.children.eq(o.settings.startSlide);"all"==o.settings.preloadImages&&(e=o.children),o.settings.ticker?o.settings.pager=!1:(o.settings.pager&&T(),o.settings.controls&&C(),o.settings.auto&&o.settings.autoControls&&E(),(o.settings.controls||o.settings.autoControls||o.settings.pager)&&o.viewport.after(o.controls.el)),g(e,h)},g=function(e,i){var s=e.find("img, iframe").length;if(0==s)return i(),void 0;var n=0;e.find("img, iframe").each(function(){t(this).one("load",function(){++n==s&&i()}).each(function(){this.complete&&t(this).load()})})},h=function(){if(o.settings.infiniteLoop&&"fade"!=o.settings.mode&&!o.settings.ticker){var e="vertical"==o.settings.mode?o.settings.minSlides:o.settings.maxSlides,i=o.children.slice(0,e).clone().addClass("bx-clone"),s=o.children.slice(-e).clone().addClass("bx-clone");r.append(i).prepend(s)}o.loader.remove(),S(),"vertical"==o.settings.mode&&(o.settings.adaptiveHeight=!0),o.viewport.height(v()),r.redrawSlider(),o.settings.onSliderLoad(o.active.index),o.initialized=!0,o.settings.responsive&&t(window).bind("resize",Z),o.settings.auto&&o.settings.autoStart&&H(),o.settings.ticker&&L(),o.settings.pager&&q(o.settings.startSlide),o.settings.controls&&W(),o.settings.touchEnabled&&!o.settings.ticker&&O()},v=function(){var e=0,s=t();if("vertical"==o.settings.mode||o.settings.adaptiveHeight)if(o.carousel){var n=1==o.settings.moveSlides?o.active.index:o.active.index*m();for(s=o.children.eq(n),i=1;i<=o.settings.maxSlides-1;i++)s=n+i>=o.children.length?s.add(o.children.eq(i-1)):s.add(o.children.eq(n+i))}else s=o.children.eq(o.active.index);else s=o.children;return"vertical"==o.settings.mode?(s.each(function(){e+=t(this).outerHeight()}),o.settings.slideMargin>0&&(e+=o.settings.slideMargin*(o.settings.minSlides-1))):e=Math.max.apply(Math,s.map(function(){return t(this).outerHeight(!1)}).get()),e},p=function(){var t="100%";return o.settings.slideWidth>0&&(t="horizontal"==o.settings.mode?o.settings.maxSlides*o.settings.slideWidth+(o.settings.maxSlides-1)*o.settings.slideMargin:o.settings.slideWidth),t},u=function(){var t=o.settings.slideWidth,e=o.viewport.width();return 0==o.settings.slideWidth||o.settings.slideWidth>e&&!o.carousel||"vertical"==o.settings.mode?t=e:o.settings.maxSlides>1&&"horizontal"==o.settings.mode&&(e>o.maxThreshold||e<o.minThreshold&&(t=(e-o.settings.slideMargin*(o.settings.minSlides-1))/o.settings.minSlides)),t},f=function(){var t=1;if("horizontal"==o.settings.mode&&o.settings.slideWidth>0)if(o.viewport.width()<o.minThreshold)t=o.settings.minSlides;else if(o.viewport.width()>o.maxThreshold)t=o.settings.maxSlides;else{var e=o.children.first().width();t=Math.floor(o.viewport.width()/e)}else"vertical"==o.settings.mode&&(t=o.settings.minSlides);return t},x=function(){var t=0;if(o.settings.moveSlides>0)if(o.settings.infiniteLoop)t=o.children.length/m();else for(var e=0,i=0;e<o.children.length;)++t,e=i+f(),i+=o.settings.moveSlides<=f()?o.settings.moveSlides:f();else t=Math.ceil(o.children.length/f());return t},m=function(){return o.settings.moveSlides>0&&o.settings.moveSlides<=f()?o.settings.moveSlides:f()},S=function(){if(o.children.length>o.settings.maxSlides&&o.active.last&&!o.settings.infiniteLoop){if("horizontal"==o.settings.mode){var t=o.children.last(),e=t.position();b(-(e.left-(o.viewport.width()-t.width())),"reset",0)}else if("vertical"==o.settings.mode){var i=o.children.length-o.settings.minSlides,e=o.children.eq(i).position();b(-e.top,"reset",0)}}else{var e=o.children.eq(o.active.index*m()).position();o.active.index==x()-1&&(o.active.last=!0),void 0!=e&&("horizontal"==o.settings.mode?b(-e.left,"reset",0):"vertical"==o.settings.mode&&b(-e.top,"reset",0))}},b=function(t,e,i,s){if(o.usingCSS){var n="vertical"==o.settings.mode?"translate3d(0, "+t+"px, 0)":"translate3d("+t+"px, 0, 0)";r.css("-"+o.cssPrefix+"-transition-duration",i/1e3+"s"),"slide"==e?(r.css(o.animProp,n),r.bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd",function(){r.unbind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd"),D()})):"reset"==e?r.css(o.animProp,n):"ticker"==e&&(r.css("-"+o.cssPrefix+"-transition-timing-function","linear"),r.css(o.animProp,n),r.bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd",function(){r.unbind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd"),b(s.resetValue,"reset",0),N()}))}else{var a={};a[o.animProp]=t,"slide"==e?r.animate(a,i,o.settings.easing,function(){D()}):"reset"==e?r.css(o.animProp,t):"ticker"==e&&r.animate(a,speed,"linear",function(){b(s.resetValue,"reset",0),N()})}},w=function(){for(var e="",i=x(),s=0;i>s;s++){var n="";o.settings.buildPager&&t.isFunction(o.settings.buildPager)?(n=o.settings.buildPager(s),o.pagerEl.addClass("bx-custom-pager")):(n=s+1,o.pagerEl.addClass("bx-default-pager")),e+='<div class="bx-pager-item"><a href="" data-slide-index="'+s+'" class="bx-pager-link">'+n+"</a></div>"}o.pagerEl.html(e)},T=function(){o.settings.pagerCustom?o.pagerEl=t(o.settings.pagerCustom):(o.pagerEl=t('<div class="bx-pager" />'),o.settings.pagerSelector?t(o.settings.pagerSelector).html(o.pagerEl):o.controls.el.addClass("bx-has-pager").append(o.pagerEl),w()),o.pagerEl.on("click","a",I)},C=function(){o.controls.next=t('<a class="bx-next" href="">'+o.settings.nextText+"</a>"),o.controls.prev=t('<a class="bx-prev" href="">'+o.settings.prevText+"</a>"),o.controls.next.bind("click",y),o.controls.prev.bind("click",z),o.settings.nextSelector&&t(o.settings.nextSelector).append(o.controls.next),o.settings.prevSelector&&t(o.settings.prevSelector).append(o.controls.prev),o.settings.nextSelector||o.settings.prevSelector||(o.controls.directionEl=t('<div class="bx-controls-direction" />'),o.controls.directionEl.append(o.controls.prev).append(o.controls.next),o.controls.el.addClass("bx-has-controls-direction").append(o.controls.directionEl))},E=function(){o.controls.start=t('<div class="bx-controls-auto-item"><a class="bx-start" href="">'+o.settings.startText+"</a></div>"),o.controls.stop=t('<div class="bx-controls-auto-item"><a class="bx-stop" href="">'+o.settings.stopText+"</a></div>"),o.controls.autoEl=t('<div class="bx-controls-auto" />'),o.controls.autoEl.on("click",".bx-start",k),o.controls.autoEl.on("click",".bx-stop",M),o.settings.autoControlsCombine?o.controls.autoEl.append(o.controls.start):o.controls.autoEl.append(o.controls.start).append(o.controls.stop),o.settings.autoControlsSelector?t(o.settings.autoControlsSelector).html(o.controls.autoEl):o.controls.el.addClass("bx-has-controls-auto").append(o.controls.autoEl),A(o.settings.autoStart?"stop":"start")},P=function(){o.children.each(function(){var e=t(this).find("img:first").attr("title");void 0!=e&&(""+e).length&&t(this).append('<div class="bx-caption"><span>'+e+"</span></div>")})},y=function(t){o.settings.auto&&r.stopAuto(),r.goToNextSlide(),t.preventDefault()},z=function(t){o.settings.auto&&r.stopAuto(),r.goToPrevSlide(),t.preventDefault()},k=function(t){r.startAuto(),t.preventDefault()},M=function(t){r.stopAuto(),t.preventDefault()},I=function(e){o.settings.auto&&r.stopAuto();var i=t(e.currentTarget),s=parseInt(i.attr("data-slide-index"));s!=o.active.index&&r.goToSlide(s),e.preventDefault()},q=function(e){var i=o.children.length;return"short"==o.settings.pagerType?(o.settings.maxSlides>1&&(i=Math.ceil(o.children.length/o.settings.maxSlides)),o.pagerEl.html(e+1+o.settings.pagerShortSeparator+i),void 0):(o.pagerEl.find("a").removeClass("active"),o.pagerEl.each(function(i,s){t(s).find("a").eq(e).addClass("active")}),void 0)},D=function(){if(o.settings.infiniteLoop){var t="";0==o.active.index?t=o.children.eq(0).position():o.active.index==x()-1&&o.carousel?t=o.children.eq((x()-1)*m()).position():o.active.index==o.children.length-1&&(t=o.children.eq(o.children.length-1).position()),t&&("horizontal"==o.settings.mode?b(-t.left,"reset",0):"vertical"==o.settings.mode&&b(-t.top,"reset",0))}o.working=!1,o.settings.onSlideAfter(o.children.eq(o.active.index),o.oldIndex,o.active.index)},A=function(t){o.settings.autoControlsCombine?o.controls.autoEl.html(o.controls[t]):(o.controls.autoEl.find("a").removeClass("active"),o.controls.autoEl.find("a:not(.bx-"+t+")").addClass("active"))},W=function(){1==x()?(o.controls.prev.addClass("disabled"),o.controls.next.addClass("disabled")):!o.settings.infiniteLoop&&o.settings.hideControlOnEnd&&(0==o.active.index?(o.controls.prev.addClass("disabled"),o.controls.next.removeClass("disabled")):o.active.index==x()-1?(o.controls.next.addClass("disabled"),o.controls.prev.removeClass("disabled")):(o.controls.prev.removeClass("disabled"),o.controls.next.removeClass("disabled")))},H=function(){o.settings.autoDelay>0?setTimeout(r.startAuto,o.settings.autoDelay):r.startAuto(),o.settings.autoHover&&r.hover(function(){o.interval&&(r.stopAuto(!0),o.autoPaused=!0)},function(){o.autoPaused&&(r.startAuto(!0),o.autoPaused=null)})},L=function(){var e=0;if("next"==o.settings.autoDirection)r.append(o.children.clone().addClass("bx-clone"));else{r.prepend(o.children.clone().addClass("bx-clone"));var i=o.children.first().position();e="horizontal"==o.settings.mode?-i.left:-i.top}b(e,"reset",0),o.settings.pager=!1,o.settings.controls=!1,o.settings.autoControls=!1,o.settings.tickerHover&&!o.usingCSS&&o.viewport.hover(function(){r.stop()},function(){var e=0;o.children.each(function(){e+="horizontal"==o.settings.mode?t(this).outerWidth(!0):t(this).outerHeight(!0)});var i=o.settings.speed/e,s="horizontal"==o.settings.mode?"left":"top",n=i*(e-Math.abs(parseInt(r.css(s))));N(n)}),N()},N=function(t){speed=t?t:o.settings.speed;var e={left:0,top:0},i={left:0,top:0};"next"==o.settings.autoDirection?e=r.find(".bx-clone").first().position():i=o.children.first().position();var s="horizontal"==o.settings.mode?-e.left:-e.top,n="horizontal"==o.settings.mode?-i.left:-i.top,a={resetValue:n};b(s,"ticker",speed,a)},O=function(){o.touch={start:{x:0,y:0},end:{x:0,y:0}},o.viewport.bind("touchstart",X)},X=function(t){if(o.working)t.preventDefault();else{o.touch.originalPos=r.position();var e=t.originalEvent;o.touch.start.x=e.changedTouches[0].pageX,o.touch.start.y=e.changedTouches[0].pageY,o.viewport.bind("touchmove",Y),o.viewport.bind("touchend",V)}},Y=function(t){var e=t.originalEvent,i=Math.abs(e.changedTouches[0].pageX-o.touch.start.x),s=Math.abs(e.changedTouches[0].pageY-o.touch.start.y);if(3*i>s&&o.settings.preventDefaultSwipeX?t.preventDefault():3*s>i&&o.settings.preventDefaultSwipeY&&t.preventDefault(),"fade"!=o.settings.mode&&o.settings.oneToOneTouch){var n=0;if("horizontal"==o.settings.mode){var r=e.changedTouches[0].pageX-o.touch.start.x;n=o.touch.originalPos.left+r}else{var r=e.changedTouches[0].pageY-o.touch.start.y;n=o.touch.originalPos.top+r}b(n,"reset",0)}},V=function(t){o.viewport.unbind("touchmove",Y);var e=t.originalEvent,i=0;if(o.touch.end.x=e.changedTouches[0].pageX,o.touch.end.y=e.changedTouches[0].pageY,"fade"==o.settings.mode){var s=Math.abs(o.touch.start.x-o.touch.end.x);s>=o.settings.swipeThreshold&&(o.touch.start.x>o.touch.end.x?r.goToNextSlide():r.goToPrevSlide(),r.stopAuto())}else{var s=0;"horizontal"==o.settings.mode?(s=o.touch.end.x-o.touch.start.x,i=o.touch.originalPos.left):(s=o.touch.end.y-o.touch.start.y,i=o.touch.originalPos.top),!o.settings.infiniteLoop&&(0==o.active.index&&s>0||o.active.last&&0>s)?b(i,"reset",200):Math.abs(s)>=o.settings.swipeThreshold?(0>s?r.goToNextSlide():r.goToPrevSlide(),r.stopAuto()):b(i,"reset",200)}o.viewport.unbind("touchend",V)},Z=function(){var e=t(window).width(),i=t(window).height();(a!=e||l!=i)&&(a=e,l=i,r.redrawSlider(),o.settings.onSliderResize.call(r,o.active.index))};return r.goToSlide=function(e,i){if(!o.working&&o.active.index!=e)if(o.working=!0,o.oldIndex=o.active.index,o.active.index=0>e?x()-1:e>=x()?0:e,o.settings.onSlideBefore(o.children.eq(o.active.index),o.oldIndex,o.active.index),"next"==i?o.settings.onSlideNext(o.children.eq(o.active.index),o.oldIndex,o.active.index):"prev"==i&&o.settings.onSlidePrev(o.children.eq(o.active.index),o.oldIndex,o.active.index),o.active.last=o.active.index>=x()-1,o.settings.pager&&q(o.active.index),o.settings.controls&&W(),"fade"==o.settings.mode)o.settings.adaptiveHeight&&o.viewport.height()!=v()&&o.viewport.animate({height:v()},o.settings.adaptiveHeightSpeed),o.children.filter(":visible").fadeOut(o.settings.speed).css({zIndex:0}),o.children.eq(o.active.index).css("zIndex",o.settings.slideZIndex+1).fadeIn(o.settings.speed,function(){t(this).css("zIndex",o.settings.slideZIndex),D()});else{o.settings.adaptiveHeight&&o.viewport.height()!=v()&&o.viewport.animate({height:v()},o.settings.adaptiveHeightSpeed);var s=0,n={left:0,top:0};if(!o.settings.infiniteLoop&&o.carousel&&o.active.last)if("horizontal"==o.settings.mode){var a=o.children.eq(o.children.length-1);n=a.position(),s=o.viewport.width()-a.outerWidth()}else{var l=o.children.length-o.settings.minSlides;n=o.children.eq(l).position()}else if(o.carousel&&o.active.last&&"prev"==i){var d=1==o.settings.moveSlides?o.settings.maxSlides-m():(x()-1)*m()-(o.children.length-o.settings.maxSlides),a=r.children(".bx-clone").eq(d);n=a.position()}else if("next"==i&&0==o.active.index)n=r.find("> .bx-clone").eq(o.settings.maxSlides).position(),o.active.last=!1;else if(e>=0){var c=e*m();n=o.children.eq(c).position()}if("undefined"!=typeof n){var g="horizontal"==o.settings.mode?-(n.left-s):-n.top;b(g,"slide",o.settings.speed)}}},r.goToNextSlide=function(){if(o.settings.infiniteLoop||!o.active.last){var t=parseInt(o.active.index)+1;r.goToSlide(t,"next")}},r.goToPrevSlide=function(){if(o.settings.infiniteLoop||0!=o.active.index){var t=parseInt(o.active.index)-1;r.goToSlide(t,"prev")}},r.startAuto=function(t){o.interval||(o.interval=setInterval(function(){"next"==o.settings.autoDirection?r.goToNextSlide():r.goToPrevSlide()},o.settings.pause),o.settings.autoControls&&1!=t&&A("stop"))},r.stopAuto=function(t){o.interval&&(clearInterval(o.interval),o.interval=null,o.settings.autoControls&&1!=t&&A("start"))},r.getCurrentSlide=function(){return o.active.index},r.getCurrentSlideElement=function(){return o.children.eq(o.active.index)},r.getSlideCount=function(){return o.children.length},r.redrawSlider=function(){o.children.add(r.find(".bx-clone")).outerWidth(u()),o.viewport.css("height",v()),o.settings.ticker||S(),o.active.last&&(o.active.index=x()-1),o.active.index>=x()&&(o.active.last=!0),o.settings.pager&&!o.settings.pagerCustom&&(w(),q(o.active.index))},r.destroySlider=function(){o.initialized&&(o.initialized=!1,t(".bx-clone",this).remove(),o.children.each(function(){void 0!=t(this).data("origStyle")?t(this).attr("style",t(this).data("origStyle")):t(this).removeAttr("style")}),void 0!=t(this).data("origStyle")?this.attr("style",t(this).data("origStyle")):t(this).removeAttr("style"),t(this).unwrap().unwrap(),o.controls.el&&o.controls.el.remove(),o.controls.next&&o.controls.next.remove(),o.controls.prev&&o.controls.prev.remove(),o.pagerEl&&o.settings.controls&&o.pagerEl.remove(),t(".bx-caption",this).remove(),o.controls.autoEl&&o.controls.autoEl.remove(),clearInterval(o.interval),o.settings.responsive&&t(window).unbind("resize",Z))},r.reloadSlider=function(t){void 0!=t&&(n=t),r.destroySlider(),d()},d(),this}}(jQuery);
/*
 * jQuery Easing v1.3 - http://gsgd.co.uk/sandbox/jquery/easing/
 *
 * Uses the built in easing capabilities added In jQuery 1.1
 * to offer multiple easing options
 *
 * TERMS OF USE - EASING EQUATIONS
 *
 * Open source under the BSD License.
 *
 * Copyright Â© 2001 Robert Penner
 * All rights reserved.
 *
 * TERMS OF USE - jQuery Easing
 *
 * Open source under the BSD License.
 *
 * Copyright Â© 2008 George McGinley Smith
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 * Redistributions of source code must retain the above copyright notice, this list of
 * conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list
 * of conditions and the following disclaimer in the documentation and/or other materials
 * provided with the distribution.
 *
 * Neither the name of the author nor the names of contributors may be used to endorse
 * or promote products derived from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 *  COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 *  EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
 *  GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 *  NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED
 * OF THE POSSIBILITY OF SUCH DAMAGE.
 *
*/
jQuery.easing.jswing=jQuery.easing.swing;jQuery.extend(jQuery.easing,{def:"easeOutQuad",swing:function(e,f,a,h,g){return jQuery.easing[jQuery.easing.def](e,f,a,h,g)},easeInQuad:function(e,f,a,h,g){return h*(f/=g)*f+a},easeOutQuad:function(e,f,a,h,g){return -h*(f/=g)*(f-2)+a},easeInOutQuad:function(e,f,a,h,g){if((f/=g/2)<1){return h/2*f*f+a}return -h/2*((--f)*(f-2)-1)+a},easeInCubic:function(e,f,a,h,g){return h*(f/=g)*f*f+a},easeOutCubic:function(e,f,a,h,g){return h*((f=f/g-1)*f*f+1)+a},easeInOutCubic:function(e,f,a,h,g){if((f/=g/2)<1){return h/2*f*f*f+a}return h/2*((f-=2)*f*f+2)+a},easeInQuart:function(e,f,a,h,g){return h*(f/=g)*f*f*f+a},easeOutQuart:function(e,f,a,h,g){return -h*((f=f/g-1)*f*f*f-1)+a},easeInOutQuart:function(e,f,a,h,g){if((f/=g/2)<1){return h/2*f*f*f*f+a}return -h/2*((f-=2)*f*f*f-2)+a},easeInQuint:function(e,f,a,h,g){return h*(f/=g)*f*f*f*f+a},easeOutQuint:function(e,f,a,h,g){return h*((f=f/g-1)*f*f*f*f+1)+a},easeInOutQuint:function(e,f,a,h,g){if((f/=g/2)<1){return h/2*f*f*f*f*f+a}return h/2*((f-=2)*f*f*f*f+2)+a},easeInSine:function(e,f,a,h,g){return -h*Math.cos(f/g*(Math.PI/2))+h+a},easeOutSine:function(e,f,a,h,g){return h*Math.sin(f/g*(Math.PI/2))+a},easeInOutSine:function(e,f,a,h,g){return -h/2*(Math.cos(Math.PI*f/g)-1)+a},easeInExpo:function(e,f,a,h,g){return(f==0)?a:h*Math.pow(2,10*(f/g-1))+a},easeOutExpo:function(e,f,a,h,g){return(f==g)?a+h:h*(-Math.pow(2,-10*f/g)+1)+a},easeInOutExpo:function(e,f,a,h,g){if(f==0){return a}if(f==g){return a+h}if((f/=g/2)<1){return h/2*Math.pow(2,10*(f-1))+a}return h/2*(-Math.pow(2,-10*--f)+2)+a},easeInCirc:function(e,f,a,h,g){return -h*(Math.sqrt(1-(f/=g)*f)-1)+a},easeOutCirc:function(e,f,a,h,g){return h*Math.sqrt(1-(f=f/g-1)*f)+a},easeInOutCirc:function(e,f,a,h,g){if((f/=g/2)<1){return -h/2*(Math.sqrt(1-f*f)-1)+a}return h/2*(Math.sqrt(1-(f-=2)*f)+1)+a},easeInElastic:function(f,h,e,l,k){var i=1.70158;var j=0;var g=l;if(h==0){return e}if((h/=k)==1){return e+l}if(!j){j=k*0.3}if(g<Math.abs(l)){g=l;var i=j/4}else{var i=j/(2*Math.PI)*Math.asin(l/g)}return -(g*Math.pow(2,10*(h-=1))*Math.sin((h*k-i)*(2*Math.PI)/j))+e},easeOutElastic:function(f,h,e,l,k){var i=1.70158;var j=0;var g=l;if(h==0){return e}if((h/=k)==1){return e+l}if(!j){j=k*0.3}if(g<Math.abs(l)){g=l;var i=j/4}else{var i=j/(2*Math.PI)*Math.asin(l/g)}return g*Math.pow(2,-10*h)*Math.sin((h*k-i)*(2*Math.PI)/j)+l+e},easeInOutElastic:function(f,h,e,l,k){var i=1.70158;var j=0;var g=l;if(h==0){return e}if((h/=k/2)==2){return e+l}if(!j){j=k*(0.3*1.5)}if(g<Math.abs(l)){g=l;var i=j/4}else{var i=j/(2*Math.PI)*Math.asin(l/g)}if(h<1){return -0.5*(g*Math.pow(2,10*(h-=1))*Math.sin((h*k-i)*(2*Math.PI)/j))+e}return g*Math.pow(2,-10*(h-=1))*Math.sin((h*k-i)*(2*Math.PI)/j)*0.5+l+e},easeInBack:function(e,f,a,i,h,g){if(g==undefined){g=1.70158}return i*(f/=h)*f*((g+1)*f-g)+a},easeOutBack:function(e,f,a,i,h,g){if(g==undefined){g=1.70158}return i*((f=f/h-1)*f*((g+1)*f+g)+1)+a},easeInOutBack:function(e,f,a,i,h,g){if(g==undefined){g=1.70158}if((f/=h/2)<1){return i/2*(f*f*(((g*=(1.525))+1)*f-g))+a}return i/2*((f-=2)*f*(((g*=(1.525))+1)*f+g)+2)+a},easeInBounce:function(e,f,a,h,g){return h-jQuery.easing.easeOutBounce(e,g-f,0,h,g)+a},easeOutBounce:function(e,f,a,h,g){if((f/=g)<(1/2.75)){return h*(7.5625*f*f)+a}else{if(f<(2/2.75)){return h*(7.5625*(f-=(1.5/2.75))*f+0.75)+a}else{if(f<(2.5/2.75)){return h*(7.5625*(f-=(2.25/2.75))*f+0.9375)+a}else{return h*(7.5625*(f-=(2.625/2.75))*f+0.984375)+a}}}},easeInOutBounce:function(e,f,a,h,g){if(f<g/2){return jQuery.easing.easeInBounce(e,f*2,0,h,g)*0.5+a}return jQuery.easing.easeOutBounce(e,f*2-g,0,h,g)*0.5+h*0.5+a}});
/*!
 * multiscroll.js 0.1.7 Beta
 * https://github.com/alvarotrigo/multiscroll.js
 * @license MIT licensed
 *
 * Copyright (C) 2016 alvarotrigo.com - A project by Alvaro Trigo
 */
(function ($, window, document, Math, undefined) {

	$.fn.multiscroll = function (options) {
		var MS = $.fn.multiscroll;

		// Create some defaults, extending them with any options that were provided
		options = $.extend({
			'verticalCentered'    : true,
			'scrollingSpeed'      : 700,
			'easing'              : 'easeInQuart',
			'delay'               : 0,
			'menu'                : false,
			'sectionsColor'       : [],
			'anchors'             : [],
			'navigation'          : false,
			'navigationPosition'  : 'right',
			'navigationColor'     : '#000',
			'navigationTooltips'  : [],
			'loopBottom'          : false,
			'loopTop'             : false,
			'css3'                : false,
			'paddingTop'          : 0,
			'paddingBottom'       : 0,
			'fixedElements'       : null,
			'normalScrollElements': null,
			'keyboardScrolling'   : true,
			'touchSensitivity'    : 5,

			// Custom selectors
			'sectionSelector': '.ms-section',
			'leftSelector'   : '.ms-left',
			'rightSelector'  : '.ms-right',

			//events
			'afterLoad'  : null,
			'onLeave'    : null,
			'afterRender': null,
			'afterResize': null
		}, options);

		//Defines the delay to take place before being able to scroll to the next section
		//BE CAREFUL! Not recommened to change it under 400 for a good behavior in laptops and
		//Apple devices (laptops, mouses...)
		var scrollDelay = 600;

		var isTouchStart = (('ontouchstart' in window) || (navigator.msMaxTouchPoints > 0) || (navigator.maxTouchPoints)),
		isTouch = false;

		// adding class namef for right and left blocks
		if (options.rightSelector !== '.ms-right') {
			$(options.rightSelector).addClass('ms-right');
		}

		if (options.leftSelector !== '.ms-left') {
			$(options.leftSelector).addClass('ms-left');
		}

		var numberSections = $('.ms-left').find('.ms-section').length;
		var isMoving = false;
		var nav;
		var windowHeight = $(window).height();


		addMouseWheelHandler();
		addTouchHandler();

		//if css3 is not supported, it will use jQuery animations
		if (options.css3) {
			options.css3 = support3d();
		}

		$('html, body').css({
			'overflow': 'hidden',
			'height'  : '100%'
		});

		//adding class names to each sections
		if (options.sectionSelector !== '.ms-section') {
			$(options.sectionSelector).each(function () {
				$(this).addClass('ms-section');
			});
		}

		//creating the navigation dots
		if (options.navigation) {
			$('body').append('<div id="multiscroll-nav"><ul></ul></div>');
			nav = $('#multiscroll-nav');

			nav.css('color', options.navigationColor);
			nav.addClass(options.navigationPosition);
		}

		$('.ms-right, .ms-left').css({
			'width'           : '50%',
			'position'        : 'absolute',
			'height'          : '100%',
			'-ms-touch-action': 'none'
		});

		$('.ms-right').css({
			'right'           : '1px', //http://stackoverflow.com/questions/23675457/chrome-and-opera-creating-small-padding-when-using-displaytable
			'top'             : '0',
			'-ms-touch-action': 'none',
			'touch-action'    : 'none'
		});

		$('.ms-left').css({
			'left'            : '0',
			'top'             : '0',
			'-ms-touch-action': 'none',
			'touch-action'    : 'none'
		});


		$('.ms-left .ms-section, .ms-right .ms-section').each(function () {
			var sectionIndex = $(this).index();

			if (options.paddingTop || options.paddingBottom) {
				$(this).css('padding', options.paddingTop + ' 0 ' + options.paddingBottom + ' 0');
			}

			if (typeof options.sectionsColor[sectionIndex] !== 'undefined') {
				$(this).css('background-color', options.sectionsColor[sectionIndex]);
			}

			if (typeof options.anchors[sectionIndex] !== 'undefined') {
				$(this).attr('data-anchor', options.anchors[sectionIndex]);
			}

			if (options.verticalCentered) {
				addTableClass($(this));
			}

			//only for the left panel
			if ($(this).closest('.ms-left').length && options.navigation) {
				var link = '';
				if (options.anchors.length) {
					link = options.anchors[sectionIndex];
				}
				var tooltip = options.navigationTooltips[sectionIndex];
				if (typeof tooltip === 'undefined') {
					tooltip = '';
				}
				if (options.navigation) {
					nav.find('ul').append('<li data-tooltip="' + tooltip + '"><a href="#' + link + '"><span></span></a></li>');
				}
			}
		});

		//inverting the right panel
		$('.ms-right').html($('.ms-right').find('.ms-section').get().reverse());

		$('.ms-left .ms-section, .ms-right .ms-section').each(function () {
			var sectionIndex = $(this).index();

			$(this).css({
				'height': '100%'
			});


			if (!sectionIndex && options.navigation) {
				//activating the navigation bullet
				nav.find('li').eq(sectionIndex).find('a').addClass('active');
			}
		}).promise().done(function () {

			//if no active section is defined, the 1st one will be the default one
			if (!$('.ms-left .ms-section.active').length) {
				$('.ms-right').find('.ms-section').last().addClass('active');
				$('.ms-left').find('.ms-section').first().addClass('active');
			}

			//vertical centered of the navigation + first bullet active
			if (options.navigation) {
				nav.css('margin-top', '-' + (nav.height() / 2) + 'px');
			}
			$.isFunction(options.afterRender) && options.afterRender.call(this);

			//scrolling to the defined active section and adjusting right and left panels
			silentScroll();

			//setting the class for the body element
			setBodyClass();

			$(window).on('load', function () {
				scrollToAnchor();
			});
		});


		//detecting any change on the URL to scroll to the given anchor link
		//(a way to detect back history button as we play with the hashes on the URL)
		$(window).on('hashchange', hashChangeHandler);

		function hashChangeHandler() {
			var value = window.location.hash.replace('#', '');
			var sectionAnchor = value;

			if (sectionAnchor.length) {
				var section = $('.ms-left').find('[data-anchor="' + sectionAnchor + '"]');

				var isFirstScrollMove = (typeof lastScrolledDestiny === 'undefined' );

				if (isFirstScrollMove || sectionAnchor !== lastScrolledDestiny) {
					scrollPage(section);
				}
			}
		};


		/**
		 * Sliding with arrow keys, both, vertical and horizontal
		 */
		$(document).keydown(keydownHandler);


		var keydownId;

		function keydownHandler(e) {
			clearTimeout(keydownId);

			var activeElement = $(document.activeElement);

			if (!activeElement.is('textarea') && !activeElement.is('input') && !activeElement.is('select') &&
				options.keyboardScrolling) {
				var keyCode = e.which;

				//preventing the scroll with arrow keys & spacebar & Page Up & Down keys
				var keyControls = [40, 38, 32, 33, 34];
				if ($.inArray(keyCode, keyControls) > -1) {
					e.preventDefault();
				}

				keydownId = setTimeout(function () {
					onkeydown(e);
				}, 150);
			}
		}

		/**
		 * Sliding with arrow keys, both, vertical and horizontal
		 */
		function onkeydown(e) {
			var shiftPressed = e.shiftKey;

			switch (e.which) {
				//up
				case 38:
				case 33:
					MS.moveSectionUp();
					break;

				//down
				case 32: //spacebar
					if (shiftPressed) {
						MS.moveSectionUp();
						break;
					}
				case 40:
				case 34:
					MS.moveSectionDown();
					break;

				//Home
				case 36:
					MS.moveTo(1);
					break;

				//End
				case 35:
					MS.moveTo($('.ms-left .ms-section').length);
					break;

				default:
					return; // exit this handler for other keys
			}
		}

		/**
		 * Disabling any action when pressing of the mouse wheel (Chrome, IE, Opera, Safari)
		 */
		$(document).mousedown(function (e) {
			if (e.button == 1) {
				e.preventDefault();
				return false;
			}
		});

		//navigation action
		$(document).on('click', '#multiscroll-nav a', function (e) {
			e.preventDefault();
			var index = $(this).parent().index();
			scrollPage($('.ms-left .ms-section').eq(index));
		});

		//navigation tooltips
		$(document).on({
			mouseenter: function () {
				var tooltip = $(this).data('tooltip');
				$('<div class="multiscroll-tooltip ' + options.navigationPosition + '">' + tooltip + '</div>').hide().appendTo($(this)).fadeIn(200);
			},
			mouseleave: function () {
				$(this).find('.multiscroll-tooltip').fadeOut(200, function () {
					$(this).remove();
				});
			}
		}, '#multiscroll-nav li');


		if (options.normalScrollElements) {
			$(document).on('mouseenter', options.normalScrollElements, function () {
				MS.setMouseWheelScrolling(false);
			});

			$(document).on('mouseleave', options.normalScrollElements, function () {
				MS.setMouseWheelScrolling(true);
			});
		}


		//when resizing the site, we adjust the heights of the sections
		$(window).on('resize', doneResizing);

		/**
		 * When resizing is finished, we adjust the slides sizes and positions
		 */
		function doneResizing() {
			windowHeight = $(window).height();
			$('.ms-tableCell').each(function () {
				$(this).css({height: getTableHeight($(this).parent())});
			});
			silentScroll();
			$.isFunction(options.afterResize) && options.afterResize.call(this);
		}

		function silentScroll() {
			//moving the right section to the bottom
			if (options.css3) {
				transformContainer($('.ms-left'), 'translate3d(0px, -' + $('.ms-left').find('.ms-section.active').position().top + 'px, 0px)', false);
				transformContainer($('.ms-right'), 'translate3d(0px, -' + $('.ms-right').find('.ms-section.active').position().top + 'px, 0px)', false);
			} else {
				$('.ms-left').css('top', -$('.ms-left').find('.ms-section.active').position().top);
				$('.ms-right').css('top', -$('.ms-right').find('.ms-section.active').position().top);
			}
		}

		MS.moveSectionUp = function () {
			var prev = $('.ms-left .ms-section.active').prev('.ms-section');

			if (!prev.length && options.loopTop) {
				prev = $('.ms-left .ms-section').last();
			}

			if (prev.length) {
				scrollPage(prev);
			}
		};

		MS.moveSectionDown = function () {
			var next = $('.ms-left .ms-section.active').next('.ms-section');

			if (!next.length && options.loopBottom) {
				next = $('.ms-left .ms-section').first();
			}

			if (next.length) {
				scrollPage(next);
			}
		};

		MS.moveTo = function (section) {
			var destiny = '';

			if (isNaN(section)) {
				destiny = $('.ms-left [data-anchor="' + section + '"]');
			} else {
				destiny = $('.ms-left .ms-section').eq((section - 1));
			}

			scrollPage(destiny);
		};

		function scrollPage(leftDestination) {
			var leftDestinationIndex = leftDestination.index();
			var rightDestination = $('.ms-right').find('.ms-section').eq(numberSections - 1 - leftDestinationIndex);
			var rightDestinationIndex = numberSections - 1 - leftDestinationIndex;
			var anchorLink = leftDestination.data('anchor');
			var activeSection = $('.ms-left .ms-section.active');
			var leavingSection = activeSection.index() + 1;
			var yMovement = getYmovement(leftDestination);

			//preventing from activating the MouseWheelHandler event
			//more than once if the page is scrolling
			isMoving = true;

			var topPos = {
				'left' : leftDestination.position().top,
				'right': rightDestination.position().top
			};

			rightDestination.addClass('active').siblings().removeClass('active');
			leftDestination.addClass('active').siblings().removeClass('active');

			setURLHash(anchorLink);

			// Use CSS3 translate functionality or...
			if (options.css3) {
				//callback (onLeave)
				$.isFunction(options.onLeave) && options.onLeave.call(this, leavingSection, (leftDestinationIndex + 1), yMovement);

				$(this).delay(options.delay).queue(function () {
					var translate3dLeft = 'translate3d(0px, -' + topPos['left'] + 'px, 0px)';
					var translate3dRight = 'translate3d(0px, -' + topPos['right'] + 'px, 0px)';

					transformContainer($('.ms-left'), translate3dLeft, true);
					transformContainer($('.ms-right'), translate3dRight, true);

					setTimeout(function () {
						//callback (afterLoad)
						$.isFunction(options.afterLoad) && options.afterLoad.call(this, anchorLink, (leftDestinationIndex + 1));

						setTimeout(function () {
							isMoving = false;
						}, scrollDelay);
					}, options.scrollingSpeed);
				});
			} else {
				//callback (onLeave)
				$.isFunction(options.onLeave) && options.onLeave.call(this, leavingSection, (leftDestinationIndex + 1), yMovement);

				$(this).delay(options.delay).queue(function () {
					$('.ms-left').animate({
						'top': -topPos['left']
					}, options.scrollingSpeed, options.easing, function () {
						$.isFunction(options.afterLoad) && options.afterLoad.call(this, anchorLink, (leftDestinationIndex + 1));

						setTimeout(function () {
							isMoving = false;
						}, scrollDelay);
					});

					$('.ms-right').animate({
						'top': -topPos['right']
					}, options.scrollingSpeed, options.easing);

					$(this).dequeue();
				});
			}

			//flag to avoid callingn `scrollPage()` twice in case of using anchor links
			lastScrolledDestiny = anchorLink;

			activateMenuElement(anchorLink);
			activateNavDots(anchorLink, leftDestinationIndex);
		}

		/**
		 * Removes the auto scrolling action fired by the mouse wheel and tackpad.
		 * After this function is called, the mousewheel and trackpad movements won't scroll through sections.
		 */
		function removeMouseWheelHandler() {
			if (document.addEventListener) {
				document.removeEventListener('mousewheel', MouseWheelHandler, false); //IE9, Chrome, Safari, Oper
				document.removeEventListener('wheel', MouseWheelHandler, false); //Firefox
			} else {
				document.detachEvent("onmousewheel", MouseWheelHandler); //IE 6/7/8
			}
		}

		/**
		 * Adds the auto scrolling action for the mouse wheel and tackpad.
		 * After this function is called, the mousewheel and trackpad movements will scroll through sections
		 */
		function addMouseWheelHandler() {
			if (document.addEventListener) {
				document.addEventListener("mousewheel", MouseWheelHandler, false); //IE9, Chrome, Safari, Oper
				document.addEventListener("wheel", MouseWheelHandler, false); //Firefox
			} else {
				document.attachEvent("onmousewheel", MouseWheelHandler); //IE 6/7/8
			}
		}

		/**
		 * Detecting mousewheel scrolling
		 *
		 * http://blogs.sitepointstatic.com/examples/tech/mouse-wheel/index.html
		 * http://www.sitepoint.com/html5-javascript-mouse-wheel/
		 */
		function MouseWheelHandler(e) {
			// cross-browser wheel delta
			e = window.event || e;
			var delta = Math.max(-1, Math.min(1,
				(e.wheelDelta || -e.deltaY || -e.detail)));

			if (!isMoving) { //if theres any #

				//scrolling down?
				if (delta < 0) {
					MS.moveSectionDown();
				}

				//scrolling up?
				else {
					MS.moveSectionUp();
				}
			}


			return false;
		}

		/**
		 * Adds a css3 transform property to the container class with or without animation depending on the animated param.
		 */
		function transformContainer(container, translate3d, animated) {
			container.toggleClass('ms-easing', animated);

			container.css(getTransforms(translate3d));
		}


		/**
		 * Returns the transform styles for all browsers
		 */
		function getTransforms(translate3d) {
			return {
				'-webkit-transform': translate3d,
				'-moz-transform'   : translate3d,
				'-ms-transform'    : translate3d,
				'transform'        : translate3d
			};
		}

		/**
		 * Activating the website navigation dots according to the given slide name.
		 */
		function activateNavDots(name, sectionIndex) {
			if (options.navigation) {
				$('#multiscroll-nav').find('.active').removeClass('active');
				if (name) {
					$('#multiscroll-nav').find('a[href="#' + name + '"]').addClass('active');
				} else {
					$('#multiscroll-nav').find('li').eq(sectionIndex).find('a').addClass('active');
				}
			}
		}

		/**
		 * Activating the website main menu elements according to the given slide name.
		 */
		function activateMenuElement(name) {
			if (options.menu) {
				$(options.menu).find('.active').removeClass('active');
				$(options.menu).find('[data-menuanchor="' + name + '"]').addClass('active');
			}
		}

		/**
		 * Retuns `up` or `down` depending on the scrolling movement to reach its destination
		 * from the current section.
		 */
		function getYmovement(destiny) {
			var fromIndex = $('.ms-left .ms-section.active').index();
			var toIndex = destiny.index();

			if (fromIndex > toIndex) {
				return 'up';
			}
			return 'down';
		}


		/**
		 * Sets the URL hash for a section with slides
		 */
		function setURLHash(anchorLink) {
			if (options.anchors.length) {
				location.hash = anchorLink;
			}

			setBodyClass();
		}

		/**
		 * Sets a class for the body of the page depending on the active section / slide
		 */
		function setBodyClass() {
			var section = $('.ms-left .ms-section.active');
			var sectionAnchor = section.data('anchor');
			var sectionIndex = section.index();

			var text = String(sectionIndex);

			if (options.anchors.length) {
				text = sectionAnchor;
			}

			//changing slash for dash to make it a valid CSS style
			text = text.replace('/', '-').replace('#', '');

			//removing previous anchor classes
			var classRe = new RegExp('\\b\\s?' + 'ms-viewing' + '-[^\\s]+\\b', "g");
			$('body')[0].className = $('body')[0].className.replace(classRe, '');

			//adding the current anchor
			$('body').addClass('ms-viewing-' + text);
		}


		/**
		 * Checks for translate3d support
		 * @return boolean
		 * http://stackoverflow.com/questions/5661671/detecting-transform-translate3d-support
		 */
		function support3d() {
			var el = document.createElement('p'),
				has3d,
				transforms = {
					'webkitTransform': '-webkit-transform',
					'OTransform'     : '-o-transform',
					'msTransform'    : '-ms-transform',
					'MozTransform'   : '-moz-transform',
					'transform'      : 'transform'
				};

			// Add it to the body to get the computed style.
			document.body.insertBefore(el, null);

			for (var t in transforms) {
				if (el.style[t] !== undefined) {
					el.style[t] = "translate3d(1px,1px,1px)";
					has3d = window.getComputedStyle(el).getPropertyValue(transforms[t]);
				}
			}

			document.body.removeChild(el);

			return (has3d !== undefined && has3d.length > 0 && has3d !== "none");
		}

		/**
		 * Wraps an element in order to center it vertically by using a class style.
		 */
		function addTableClass(element) {
			element.addClass('ms-table').wrapInner('<div class="ms-tableCell" style="height: ' + getTableHeight(element) + 'px" />');
		}

		/**
		 * Gets the height of the section after removing the paddings.
		 */
		function getTableHeight(section) {
			var sectionHeight = windowHeight;

			if (options.paddingTop || options.paddingBottom) {
				var paddings = parseInt(section.css('padding-top')) + parseInt(section.css('padding-bottom'));
				sectionHeight = (windowHeight - paddings);
			}

			return sectionHeight;
		}


		/**
		 * Scrolls the page to the existent anchor in the URL
		 */
		function scrollToAnchor() {
			//getting the anchor link in the URL and deleting the `#`
			var sectionAnchor = window.location.hash.replace('#', '');
			var section = $('.ms-left .ms-section[data-anchor="' + sectionAnchor + '"]');

			if (sectionAnchor.length) {  //if theres any #
				scrollPage(section);
			}
		}

		/**
		 * Adds or remove the possiblity of scrolling through sections by using the keyboard arrow keys
		 */
		MS.setKeyboardScrolling = function (value) {
			options.keyboardScrolling = value;
		};

		/**
		 * Adds or remove the possiblity of scrolling through sections by using the mouse wheel or the trackpad.
		 */
		MS.setMouseWheelScrolling = function (value) {
			if (value) {
				addMouseWheelHandler();
			} else {
				removeMouseWheelHandler();
			}
		};

		/**
		 * Defines the scrolling speed
		 */
		MS.setScrollingSpeed = function (value) {
			options.scrollingSpeed = value;
		};


		var touchStartY = 0;
		var touchStartX = 0;
		var touchEndY = 0;
		var touchEndX = 0;

		/* Detecting touch events

		 * As we are changing the top property of the page on scrolling, we can not use the traditional way to detect it.
		 * This way, the touchstart and the touch moves shows an small difference between them which is the
		 * used one to determine the direction.
		 */
		function touchMoveHandler(event) {
			var e = event.originalEvent;

			if (isReallyTouch(e)) {
				//preventing the easing on iOS devices
				event.preventDefault();

				var activeSection = $('.ms-left .ms-section.active');

				if (!isMoving) { //if theres any #
					var touchEvents = getEventsPage(e);
					touchEndY = touchEvents['y'];
					touchEndX = touchEvents['x'];


					//is the movement greater than the minimum resistance to scroll?
					if (Math.abs(touchStartY - touchEndY) > ($(window).height() / 100 * options.touchSensitivity)) {

						if (touchStartY > touchEndY) {
							MS.moveSectionDown();

						} else if (touchEndY > touchStartY) {
							MS.moveSectionUp();
						}
					}
				}
			}
		}

		/**
		 * As IE >= 10 fires both touch and mouse events when using a mouse in a touchscreen
		 * this way we make sure that is really a touch event what IE is detecting.
		 */
		function isReallyTouch(e) {
			//if is not IE   ||  IE is detecting `touch` or `pen`
			return typeof e.pointerType === 'undefined' || e.pointerType != 'mouse';
		}


		/**
		 * Handler to get he coordinates of the starting touch
		 */
		function touchStartHandler(event) {
			var e = event.originalEvent;

			if (isReallyTouch(e)) {
				var touchEvents = getEventsPage(e);
				touchStartY = touchEvents['y'];
				touchStartX = touchEvents['x'];
			}
		}


		/**
		 * Adds the possibility to auto scroll through sections on touch devices.
		 */
		function addTouchHandler() {
			if (isTouch) {
				//Microsoft pointers
				MSPointer = getMSPointer();

				$(document).off('touchstart ' + MSPointer.down).on('touchstart ' + MSPointer.down, touchStartHandler);
				$(document).off('touchmove ' + MSPointer.move).on('touchmove ' + MSPointer.move, touchMoveHandler);
			}
		}

		/**
		 * Removes the auto scrolling for touch devices.
		 */
		function removeTouchHandler() {
			if (isTouch) {
				//Microsoft pointers
				MSPointer = getMSPointer();

				$(document).off('touchstart ' + MSPointer.down);
				$(document).off('touchmove ' + MSPointer.move);
			}
		}

		/*
		 * Returns and object with Microsoft pointers (for IE<11 and for IE >= 11)
		 * http://msdn.microsoft.com/en-us/library/ie/dn304886(v=vs.85).aspx
		 */
		function getMSPointer() {
			var pointer;

			//IE >= 11
			if (window.PointerEvent) {
				pointer = {down: "pointerdown", move: "pointermove"};
			}

			//IE < 11
			else {
				pointer = {down: "MSPointerDown", move: "MSPointerMove"};
			}

			return pointer;
		}

		/**
		 * Gets the pageX and pageY properties depending on the browser.
		 * https://github.com/alvarotrigo/fullPage.js/issues/194#issuecomment-34069854
		 */
		function getEventsPage(e) {
			var events = [];

			events.y = (typeof e.pageY !== 'undefined' && (e.pageY || e.pageX) ? e.pageY : e.touches[0].pageY);
			events.x = (typeof e.pageX !== 'undefined' && (e.pageY || e.pageX) ? e.pageX : e.touches[0].pageX);

			//in touch devices with scrollBar:true, e.pageY is detected, but we have to deal with touch events. #1008
			if (isTouch && isReallyTouch(e)) {
				events.y = e.touches[0].pageY;
				events.x = e.touches[0].pageX;
			}

			return events;
		}

		/**
		 * Destroy multiscroll.js plugin's events
		 */
		MS.destroy = function () {
			MS.setKeyboardScrolling(false);
			MS.setMouseWheelScrolling(false);

			$(window)
				.off('hashchange', hashChangeHandler)
				.off('resize', doneResizing);

			$(document)
				.off('mouseenter', '#multiscroll-nav li')
				.off('mouseleave', '#multiscroll-nav li')
				.off('click', '#multiscroll-nav a');
		};

		/**
		 * Build multiscroll.js plugin's events after destroy
		 */
		MS.build = function () {
			MS.setKeyboardScrolling(true);
			MS.setMouseWheelScrolling(true);

			$(window)
				.on('hashchange', hashChangeHandler)
				.on('resize', doneResizing);

			$(document)
				.on('mouseenter', '#multiscroll-nav li')
				.on('mouseleave', '#multiscroll-nav li')
				.on('click', '#multiscroll-nav a');
		};

	};
})(jQuery, window, document, Math);
(function(e){var t=e(window);var n=t.height();t.resize(function(){n=t.height()});e.fn.parallax=function(r,i,s){function l(){o.each(function(){a=o.offset().top});if(s){u=function(e){return e.outerHeight(true)}}else{u=function(e){return e.height()}}if(arguments.length<1||r===null)r="50%";if(arguments.length<2||i===null)i=.5;if(arguments.length<3||s===null)s=true;var f=t.scrollTop();o.each(function(){var t=e(this);var s=t.offset().top;var l=u(t);if(s+l<f||s>f+n){return}o.css("backgroundPosition",r+" "+Math.round((a-f)*i)+"px")})}var o=e(this);var u;var a;var f=0;t.bind("scroll",l).resize(l);l()}})(jQuery);

/*
 Sticky-kit v1.1.2 | WTFPL | Leaf Corcoran 2015 | http://leafo.net
*/
(function(){var b,f;b=this.jQuery||window.jQuery;f=b(window);b.fn.stick_in_parent=function(d){var A,w,J,n,B,K,p,q,k,E,t;null==d&&(d={});t=d.sticky_class;B=d.inner_scrolling;E=d.recalc_every;k=d.parent;q=d.offset_top;p=d.spacer;w=d.bottoming;null==q&&(q=0);null==k&&(k=void 0);null==B&&(B=!0);null==t&&(t="is_stuck");A=b(document);null==w&&(w=!0);J=function(a,d,n,C,F,u,r,G){var v,H,m,D,I,c,g,x,y,z,h,l;if(!a.data("sticky_kit")){a.data("sticky_kit",!0);I=A.height();g=a.parent();null!=k&&(g=g.closest(k));
if(!g.length)throw"failed to find stick parent";v=m=!1;(h=null!=p?p&&a.closest(p):b("<div />"))&&h.css("position",a.css("position"));x=function(){var c,f,e;if(!G&&(I=A.height(),c=parseInt(g.css("border-top-width"),10),f=parseInt(g.css("padding-top"),10),d=parseInt(g.css("padding-bottom"),10),n=g.offset().top+c+f,C=g.height(),m&&(v=m=!1,null==p&&(a.insertAfter(h),h.detach()),a.css({position:"",top:"",width:"",bottom:""}).removeClass(t),e=!0),F=a.offset().top-(parseInt(a.css("margin-top"),10)||0)-q,
u=a.outerHeight(!0),r=a.css("float"),h&&h.css({width:a.outerWidth(!0),height:u,display:a.css("display"),"vertical-align":a.css("vertical-align"),"float":r}),e))return l()};x();if(u!==C)return D=void 0,c=q,z=E,l=function(){var b,l,e,k;if(!G&&(e=!1,null!=z&&(--z,0>=z&&(z=E,x(),e=!0)),e||A.height()===I||x(),e=f.scrollTop(),null!=D&&(l=e-D),D=e,m?(w&&(k=e+u+c>C+n,v&&!k&&(v=!1,a.css({position:"fixed",bottom:"",top:c}).trigger("sticky_kit:unbottom"))),e<F&&(m=!1,c=q,null==p&&("left"!==r&&"right"!==r||a.insertAfter(h),
h.detach()),b={position:"",width:"",top:""},a.css(b).removeClass(t).trigger("sticky_kit:unstick")),B&&(b=f.height(),u+q>b&&!v&&(c-=l,c=Math.max(b-u,c),c=Math.min(q,c),m&&a.css({top:c+"px"})))):e>F&&(m=!0,b={position:"fixed",top:c},b.width="border-box"===a.css("box-sizing")?a.outerWidth()+"px":a.width()+"px",a.css(b).addClass(t),null==p&&(a.after(h),"left"!==r&&"right"!==r||h.append(a)),a.trigger("sticky_kit:stick")),m&&w&&(null==k&&(k=e+u+c>C+n),!v&&k)))return v=!0,"static"===g.css("position")&&g.css({position:"relative"}),
a.css({position:"absolute",bottom:d,top:"auto"}).trigger("sticky_kit:bottom")},y=function(){x();return l()},H=function(){G=!0;f.off("touchmove",l);f.off("scroll",l);f.off("resize",y);b(document.body).off("sticky_kit:recalc",y);a.off("sticky_kit:detach",H);a.removeData("sticky_kit");a.css({position:"",bottom:"",top:"",width:""});g.position("position","");if(m)return null==p&&("left"!==r&&"right"!==r||a.insertAfter(h),h.remove()),a.removeClass(t)},f.on("touchmove",l),f.on("scroll",l),f.on("resize",
y),b(document.body).on("sticky_kit:recalc",y),a.on("sticky_kit:detach",H),setTimeout(l,0)}};n=0;for(K=this.length;n<K;n++)d=this[n],J(b(d));return this}}).call(this);

/**
 * jQuery Tabs plugin 1.0.0
 *
 * @author DrFuri
 */
( function( $ ) {
	$.fn.tabs = function() {
		return this.each( function() {
			var $element = $( this ),
				$nav     = $element.find( '.tabs-nav' ),
				$tabs    = $nav.find( 'a' ),
				$panels  = $element.find( '.tabs-panel' );

			$tabs.filter( ':first' ).addClass( 'active' );
			$panels.filter( ':first' ).addClass( 'active' );

			$tabs.on( 'click', function( e ) {
				e.preventDefault();

				var $tab = $( this ),
					index = $tab.parent().index();

				if ( $tab.hasClass( 'active' ) ) {
					return;
				}

				$tabs.removeClass( 'active' );
				$tab.addClass( 'active' );
				$panels.removeClass( 'active' );
				$panels.filter( ':eq(' + index + ')' ).addClass( 'active' );
			} );
		} );
	}

	/* Init tabs */
	$( function() {
		$( '.tabs' ).tabs();
	} );
} )( jQuery );
/*!
	Zoom 1.7.18
	license: MIT
	http://www.jacklmoore.com/zoom
*/
(function(o){var t={url:!1,callback:!1,target:!1,duration:120,on:"mouseover",touch:!0,onZoomIn:!1,onZoomOut:!1,magnify:1};o.zoom=function(t,n,e,i){var u,c,a,r,m,l,s,f=o(t),h=f.css("position"),d=o(n);return t.style.position=/(absolute|fixed)/.test(h)?h:"relative",t.style.overflow="hidden",e.style.width=e.style.height="",o(e).addClass("zoomImg").css({position:"absolute",top:0,left:0,opacity:0,width:e.width*i,height:e.height*i,border:"none",maxWidth:"none",maxHeight:"none"}).appendTo(t),{init:function(){c=f.outerWidth(),u=f.outerHeight(),n===t?(r=c,a=u):(r=d.outerWidth(),a=d.outerHeight()),m=(e.width-c)/r,l=(e.height-u)/a,s=d.offset()},move:function(o){var t=o.pageX-s.left,n=o.pageY-s.top;n=Math.max(Math.min(n,a),0),t=Math.max(Math.min(t,r),0),e.style.left=t*-m+"px",e.style.top=n*-l+"px"}}},o.fn.zoom=function(n){return this.each(function(){var e=o.extend({},t,n||{}),i=e.target&&o(e.target)[0]||this,u=this,c=o(u),a=document.createElement("img"),r=o(a),m="mousemove.zoom",l=!1,s=!1;if(!e.url){var f=u.querySelector("img");if(f&&(e.url=f.getAttribute("data-src")||f.currentSrc||f.src),!e.url)return}c.one("zoom.destroy",function(o,t){c.off(".zoom"),i.style.position=o,i.style.overflow=t,a.onload=null,r.remove()}.bind(this,i.style.position,i.style.overflow)),a.onload=function(){function t(t){f.init(),f.move(t),r.stop().fadeTo(o.support.opacity?e.duration:0,1,o.isFunction(e.onZoomIn)?e.onZoomIn.call(a):!1)}function n(){r.stop().fadeTo(e.duration,0,o.isFunction(e.onZoomOut)?e.onZoomOut.call(a):!1)}var f=o.zoom(i,u,a,e.magnify);"grab"===e.on?c.on("mousedown.zoom",function(e){1===e.which&&(o(document).one("mouseup.zoom",function(){n(),o(document).off(m,f.move)}),t(e),o(document).on(m,f.move),e.preventDefault())}):"click"===e.on?c.on("click.zoom",function(e){return l?void 0:(l=!0,t(e),o(document).on(m,f.move),o(document).one("click.zoom",function(){n(),l=!1,o(document).off(m,f.move)}),!1)}):"toggle"===e.on?c.on("click.zoom",function(o){l?n():t(o),l=!l}):"mouseover"===e.on&&(f.init(),c.on("mouseenter.zoom",t).on("mouseleave.zoom",n).on(m,f.move)),e.touch&&c.on("touchstart.zoom",function(o){o.preventDefault(),s?(s=!1,n()):(s=!0,t(o.originalEvent.touches[0]||o.originalEvent.changedTouches[0]))}).on("touchmove.zoom",function(o){o.preventDefault(),f.move(o.originalEvent.touches[0]||o.originalEvent.changedTouches[0])}).on("touchend.zoom",function(o){o.preventDefault(),s&&(s=!1,n())}),o.isFunction(e.callback)&&e.callback.call(a)},a.src=e.url})},o.fn.zoom.defaults=t})(window.jQuery);
/*
 *	jQuery OwlCarousel v1.31
 *
 *	Copyright (c) 2013 Bartosz Wojciechowski
 *	http://www.owlgraphic.com/owlcarousel/
 *
 *	Licensed under MIT
 *
 */

if ( typeof Object.create !== "function" ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}
(function( $, window, document, undefined ) {

	var Carousel = {
		init :function(options, el){
			var base = this;

			base.$elem = $(el);

			// options passed via js override options passed via data attributes
			base.options = $.extend({}, $.fn.owlCarousel.options, base.$elem.data(), options);

			base.userOptions = options;
			base.loadContent();
		},

		loadContent : function(){
			var base = this;

			if (typeof base.options.beforeInit === "function") {
				base.options.beforeInit.apply(this,[base.$elem]);
			}

			if (typeof base.options.jsonPath === "string") {
				var url = base.options.jsonPath;

				function getData(data) {
					if (typeof base.options.jsonSuccess === "function") {
						base.options.jsonSuccess.apply(this,[data]);
					} else {
						var content = "";
						for(var i in data["owl"]){
							content += data["owl"][i]["item"];
						}
						base.$elem.html(content);
					}
					base.logIn();
				}
				$.getJSON(url,getData);
			} else {
				base.logIn();
			}
		},

		logIn : function(action){
			var base = this;

			base.$elem.data("owl-originalStyles", base.$elem.attr("style"))
					  .data("owl-originalClasses", base.$elem.attr("class"));

			base.$elem.css({opacity: 0});
			base.orignalItems = base.options.items;
			base.checkBrowser();
			base.wrapperWidth = 0;
			base.checkVisible;
			base.setVars();
		},

		setVars : function(){
			var base = this;
			if(base.$elem.children().length === 0){return false;}
			base.baseClass();
			base.eventTypes();
			base.$userItems = base.$elem.children();
			base.itemsAmount = base.$userItems.length;
			base.wrapItems();
			base.$owlItems = base.$elem.find(".owl-item");
			base.$owlWrapper = base.$elem.find(".owl-wrapper");
			base.playDirection = "next";
			base.prevItem = 0;
			base.prevArr = [0];
			base.currentItem = 0;
			base.customEvents();
			base.onStartup();
		},

		onStartup : function(){
			var base = this;
			base.updateItems();
			base.calculateAll();
			base.buildControls();
			base.updateControls();
			base.response();
			base.moveEvents();
			base.stopOnHover();
			base.owlStatus();

			if(base.options.transitionStyle !== false){
				base.transitionTypes(base.options.transitionStyle);
			}
			if(base.options.autoPlay === true){
				base.options.autoPlay = 5000;
			}
			base.play();

			base.$elem.find(".owl-wrapper").css("display","block");

			if(!base.$elem.is(":visible")){
				base.watchVisibility();
			} else {
				base.$elem.css("opacity",1);
			}
			base.onstartup = false;
			base.eachMoveUpdate();
			if (typeof base.options.afterInit === "function") {
				base.options.afterInit.apply(this,[base.$elem]);
			}
		},

		eachMoveUpdate : function(){
			var base = this;

			if(base.options.lazyLoad === true){
				base.lazyLoad();
			}
			if(base.options.autoHeight === true){
				base.autoHeight();
			}
			base.onVisibleItems();

			if (typeof base.options.afterAction === "function") {
				base.options.afterAction.apply(this,[base.$elem]);
			}
		},

		updateVars : function(){
			var base = this;
			if(typeof base.options.beforeUpdate === "function") {
				base.options.beforeUpdate.apply(this,[base.$elem]);
			}
			base.watchVisibility();
			base.updateItems();
			base.calculateAll();
			base.updatePosition();
			base.updateControls();
			base.eachMoveUpdate();
			if(typeof base.options.afterUpdate === "function") {
				base.options.afterUpdate.apply(this,[base.$elem]);
			}
		},

		reload : function(elements){
			var base = this;
			setTimeout(function(){
				base.updateVars();
			},0);
		},

		watchVisibility : function(){
			var base = this;

			if(base.$elem.is(":visible") === false){
				base.$elem.css({opacity: 0});
				clearInterval(base.autoPlayInterval);
				clearInterval(base.checkVisible);
			} else {
				return false;
			}
			base.checkVisible = setInterval(function(){
				if (base.$elem.is(":visible")) {
					base.reload();
					base.$elem.animate({opacity: 1},200);
					clearInterval(base.checkVisible);
				}
			}, 500);
		},

		wrapItems : function(){
			var base = this;
			base.$userItems.wrapAll("<div class=\"owl-wrapper\">").wrap("<div class=\"owl-item\"></div>");
			base.$elem.find(".owl-wrapper").wrap("<div class=\"owl-wrapper-outer\">");
			base.wrapperOuter = base.$elem.find(".owl-wrapper-outer");
			base.$elem.css("display","block");
		},

		baseClass : function(){
			var base = this;
			var hasBaseClass = base.$elem.hasClass(base.options.baseClass);
			var hasThemeClass = base.$elem.hasClass(base.options.theme);

			if(!hasBaseClass){
				base.$elem.addClass(base.options.baseClass);
			}

			if(!hasThemeClass){
				base.$elem.addClass(base.options.theme);
			}
		},

		updateItems : function(){
			var base = this;

			if(base.options.responsive === false){
				return false;
			}
			if(base.options.singleItem === true){
				base.options.items = base.orignalItems = 1;
				base.options.itemsCustom = false;
				base.options.itemsDesktop = false;
				base.options.itemsDesktopSmall = false;
				base.options.itemsTablet = false;
				base.options.itemsTabletSmall = false;
				base.options.itemsMobile = false;
				return false;
			}

			var width = $(base.options.responsiveBaseWidth).width();

			if(width > (base.options.itemsDesktop[0] || base.orignalItems) ){
				base.options.items = base.orignalItems;
			}

			if(typeof(base.options.itemsCustom) !== 'undefined' && base.options.itemsCustom !== false){
				//Reorder array by screen size
				base.options.itemsCustom.sort(function(a,b){return a[0]-b[0];});
				for(var i in base.options.itemsCustom){
					if(typeof(base.options.itemsCustom[i]) !== 'undefined' && base.options.itemsCustom[i][0] <= width){
						base.options.items = base.options.itemsCustom[i][1];
					}
				}
			} else {

				if(width <= base.options.itemsDesktop[0] && base.options.itemsDesktop !== false){
					base.options.items = base.options.itemsDesktop[1];
				}

				if(width <= base.options.itemsDesktopSmall[0] && base.options.itemsDesktopSmall !== false){
					base.options.items = base.options.itemsDesktopSmall[1];
				}

				if(width <= base.options.itemsTablet[0]  && base.options.itemsTablet !== false){
					base.options.items = base.options.itemsTablet[1];
				}

				if(width <= base.options.itemsTabletSmall[0]  && base.options.itemsTabletSmall !== false){
					base.options.items = base.options.itemsTabletSmall[1];
				}

				if(width <= base.options.itemsMobile[0] && base.options.itemsMobile !== false){
					base.options.items = base.options.itemsMobile[1];
				}
			}

			//if number of items is less than declared
			if(base.options.items > base.itemsAmount && base.options.itemsScaleUp === true){
				base.options.items = base.itemsAmount;
			}
		},

		response : function(){
			var base = this,
				smallDelay;
			if(base.options.responsive !== true){
				return false;
			}
			var lastWindowWidth = $(window).width();

			base.resizer = function(){
				if($(window).width() !== lastWindowWidth){
					if(base.options.autoPlay !== false){
						clearInterval(base.autoPlayInterval);
					}
					clearTimeout(smallDelay);
					smallDelay = setTimeout(function(){
						lastWindowWidth = $(window).width();
						base.updateVars();
					},base.options.responsiveRefreshRate);
				}
			};
			$(window).resize(base.resizer);
		},

		updatePosition : function(){
			var base = this;
			base.jumpTo(base.currentItem);
			if(base.options.autoPlay !== false){
				base.checkAp();
			}
		},

		appendItemsSizes : function(){
			var base = this;

			var roundPages = 0;
			var lastItem = base.itemsAmount - base.options.items;

			base.$owlItems.each(function(index){
				var $this = $(this);
				$this
					.css({"width": base.itemWidth})
					.data("owl-item",Number(index));

				if(index % base.options.items === 0 || index === lastItem){
					if(!(index > lastItem)){
						roundPages +=1;
					}
				}
				$this.data("owl-roundPages",roundPages);
			});
		},

		appendWrapperSizes : function(){
			var base = this,
				width = base.$owlItems.length * base.itemWidth, 
				cssObj;

			base.options['direction']=="rtl" ? cssObj = {"right":0,direction:"rtl"} : cssObj = {"left":0};
			base.$owlWrapper.css({"width": width});
			base.$owlWrapper.css(cssObj);
			
			base.appendItemsSizes();
		},

		calculateAll : function(){
			var base = this;
			base.calculateWidth();
			base.appendWrapperSizes();
			base.loops();
			base.max();
		},

		calculateWidth : function(){
			var base = this;
			base.itemWidth = Math.round(base.$elem.width()/base.options.items);
		},

		max : function(){
			var base = this;
			var maximum = ((base.itemsAmount * base.itemWidth) - base.options.items * base.itemWidth) * -1;
			if(base.options.items > base.itemsAmount){
				base.maximumItem = 0;
				maximum = 0;
				base.maximumPixels = 0;
			} else {
				base.maximumItem = base.itemsAmount - base.options.items;
				base.maximumPixels = maximum;
			}
			return maximum;
		},

		min : function(){
			return 0;
		},

		loops : function(){
			var base = this;

			base.positionsInArray = [0];
			base.pagesInArray = [];
			var prev = 0;
			var elWidth = 0;

			for(var i = 0; i<base.itemsAmount; i++){
				elWidth += base.itemWidth;
				base.positionsInArray.push(-elWidth);

				if(base.options.scrollPerPage === true){
					var item = $(base.$owlItems[i]);
					var roundPageNum = item.data("owl-roundPages");
					if(roundPageNum !== prev){
						base.pagesInArray[prev] = base.positionsInArray[i];
						prev = roundPageNum;
					}
				}
			}
		},

		buildControls : function(){
			var base = this;
			if(base.options.navigation === true || base.options.pagination === true){
				base.owlControls = $("<div class=\"owl-controls\"/>").toggleClass("clickable", !base.browser.isTouch).appendTo(base.$elem);
			}
			if(base.options.pagination === true){
				base.buildPagination();
			}
			if(base.options.navigation === true){
				base.buildButtons();
			}
		},

		buildButtons : function(){
			var base = this;
			var buttonsWrapper = $("<div class=\"owl-buttons\"/>");
			base.owlControls.append(buttonsWrapper);

			base.buttonPrev = $("<div/>",{
				"class" : "owl-prev",
				"html" : base.options.navigationText[0] || ""
				});

			base.buttonNext = $("<div/>",{
				"class" : "owl-next",
				"html" : base.options.navigationText[1] || ""
				});

			buttonsWrapper
			.append(base.buttonPrev)
			.append(base.buttonNext);

			buttonsWrapper.on("touchstart.owlControls mousedown.owlControls", "div[class^=\"owl\"]", function(event){
				event.preventDefault();
			});

			buttonsWrapper.on("touchend.owlControls mouseup.owlControls", "div[class^=\"owl\"]", function(event){
				event.preventDefault();
				if($(this).hasClass("owl-next")){
					base.next();
				} else{
					base.prev();
				}
			});
		},

		buildPagination : function(){
			var base = this;

			base.paginationWrapper = $("<div class=\"owl-pagination\"/>");
			base.owlControls.append(base.paginationWrapper);

			base.paginationWrapper.on("touchend.owlControls mouseup.owlControls", ".owl-page", function(event){
				event.preventDefault();
				if(Number($(this).data("owl-page")) !== base.currentItem){
					base.goTo( Number($(this).data("owl-page")), true);
				}
			});
		},

		updatePagination : function(){
			var base = this;
			if(base.options.pagination === false){
				return false;
			}

			base.paginationWrapper.html("");

			var counter = 0;
			var lastPage = base.itemsAmount - base.itemsAmount % base.options.items;

			for(var i = 0; i<base.itemsAmount; i++){
				if(i % base.options.items === 0){
					counter +=1;
					if(lastPage === i){
						var lastItem = base.itemsAmount - base.options.items;
					}
					var paginationButton = $("<div/>",{
						"class" : "owl-page"
						});
					var paginationButtonInner = $("<span></span>",{
						"text": base.options.paginationNumbers === true ? counter : "",
						"class": base.options.paginationNumbers === true ? "owl-numbers" : ""
					});
					paginationButton.append(paginationButtonInner);

					paginationButton.data("owl-page",lastPage === i ? lastItem : i);
					paginationButton.data("owl-roundPages",counter);

					base.paginationWrapper.append(paginationButton);
				}
			}
			base.checkPagination();
		},
		checkPagination : function(){
			var base = this;
			if(base.options.pagination === false){
				return false;
			}
			base.paginationWrapper.find(".owl-page").each(function(i,v){
				if($(this).data("owl-roundPages") === $(base.$owlItems[base.currentItem]).data("owl-roundPages") ){
					base.paginationWrapper
						.find(".owl-page")
						.removeClass("active");
					$(this).addClass("active");
				}
			});
		},

		checkNavigation : function(){
			var base = this;

			if(base.options.navigation === false){
				return false;
			}
			if(base.options.rewindNav === false){
				if(base.currentItem === 0 && base.maximumItem === 0){
					base.buttonPrev.addClass("disabled");
					base.buttonNext.addClass("disabled");
				} else if(base.currentItem === 0 && base.maximumItem !== 0){
					base.buttonPrev.addClass("disabled");
					base.buttonNext.removeClass("disabled");
				} else if (base.currentItem === base.maximumItem){
					base.buttonPrev.removeClass("disabled");
					base.buttonNext.addClass("disabled");
				} else if(base.currentItem !== 0 && base.currentItem !== base.maximumItem){
					base.buttonPrev.removeClass("disabled");
					base.buttonNext.removeClass("disabled");
				}
			}
		},

		updateControls : function(){
			var base = this;
			base.updatePagination();
			base.checkNavigation();
			if(base.owlControls){
				if(base.options.items >= base.itemsAmount){
					base.owlControls.hide();
				} else {
					base.owlControls.show();
				}
			}
		},

		destroyControls : function(){
			var base = this;
			if(base.owlControls){
				base.owlControls.remove();
			}
		},

		next : function(speed){
			var base = this;

			if(base.isTransition){
				return false;
			}

			base.currentItem += base.options.scrollPerPage === true ? base.options.items : 1;
			if(base.currentItem > base.maximumItem + (base.options.scrollPerPage == true ? (base.options.items - 1) : 0)){
				if(base.options.rewindNav === true){
					base.currentItem = 0;
					speed = "rewind";
				} else {
					base.currentItem = base.maximumItem;
					return false;
				}
			}
			base.goTo(base.currentItem,speed);
		},

		prev : function(speed){
			var base = this;

			if(base.isTransition){
				return false;
			}

			if(base.options.scrollPerPage === true && base.currentItem > 0 && base.currentItem < base.options.items){
				base.currentItem = 0;
			} else {
				base.currentItem -= base.options.scrollPerPage === true ? base.options.items : 1;
			}
			if(base.currentItem < 0){
				if(base.options.rewindNav === true){
					base.currentItem = base.maximumItem;
					speed = "rewind";
				} else {
					base.currentItem =0;
					return false;
				}
			}
			base.goTo(base.currentItem,speed);
		},

		goTo : function(position,speed,drag){
			var base = this;

			if(base.isTransition){
				return false;
			}
			if(typeof base.options.beforeMove === "function") {
				base.options.beforeMove.apply(this,[base.$elem]);
			}
			if(position >= base.maximumItem){
				position = base.maximumItem;
			}
			else if( position <= 0 ){
				position = 0;
			}

			base.currentItem = base.owl.currentItem = position;
			if( base.options.transitionStyle !== false && drag !== "drag" && base.options.items === 1 && base.browser.support3d === true){
				base.swapSpeed(0);
				if(base.browser.support3d === true){
					base.transition3d(base.positionsInArray[position]);
				} else {
					base.css2slide(base.positionsInArray[position],1);
				}
				base.afterGo();
				base.singleItemTransition();
				
				return false;
			}
			var goToPixel = base.positionsInArray[position];

			if(base.browser.support3d === true){
				base.isCss3Finish = false;

				if(speed === true){
					base.swapSpeed("paginationSpeed");
					setTimeout(function() {
						base.isCss3Finish = true;
					}, base.options.paginationSpeed);

				} else if(speed === "rewind" ){
					base.swapSpeed(base.options.rewindSpeed);
					setTimeout(function() {
						base.isCss3Finish = true;
					}, base.options.rewindSpeed);

				} else {
					base.swapSpeed("slideSpeed");
					setTimeout(function() {
						base.isCss3Finish = true;
					}, base.options.slideSpeed);
				}
				base.transition3d(goToPixel);
			} else {
				if(speed === true){
					base.css2slide(goToPixel, base.options.paginationSpeed);
				} else if(speed === "rewind" ){
					base.css2slide(goToPixel, base.options.rewindSpeed);
				} else {
					base.css2slide(goToPixel, base.options.slideSpeed);
				}
			}
			base.afterGo();
		},

		jumpTo : function(position){
			var base = this;
			if(typeof base.options.beforeMove === "function") {
				base.options.beforeMove.apply(this,[base.$elem]);
			}
			if(position >= base.maximumItem || position === -1){
				position = base.maximumItem;
			}
			else if( position <= 0 ){
				position = 0;
			}
			base.swapSpeed(0);
			if(base.browser.support3d === true){
				base.transition3d(base.positionsInArray[position]);
			} else {
				base.css2slide(base.positionsInArray[position],1);
			}
			base.currentItem = base.owl.currentItem = position;
			base.afterGo();
		},

		afterGo : function(){
			var base = this;

			base.prevArr.push(base.currentItem);
			base.prevItem = base.owl.prevItem = base.prevArr[base.prevArr.length -2];
			base.prevArr.shift(0);

			if(base.prevItem !== base.currentItem){
				base.checkPagination();
				base.checkNavigation();
				base.eachMoveUpdate();

				if(base.options.autoPlay !== false){
					base.checkAp();
				}
			}
			if(typeof base.options.afterMove === "function" && base.prevItem !== base.currentItem) {
				base.options.afterMove.apply(this,[base.$elem]);
			}
		},

		stop : function(){
			var base = this;
			base.apStatus = "stop";
			clearInterval(base.autoPlayInterval);
		},

		checkAp : function(){
			var base = this;
			if(base.apStatus !== "stop"){
				base.play();
			}
		},

		play : function(){
			var base = this;
			base.apStatus = "play";
			if(base.options.autoPlay === false){
				return false;
			}
			clearInterval(base.autoPlayInterval);
			base.autoPlayInterval = setInterval(function(){
				base.next(true);
			},base.options.autoPlay);
		},

		swapSpeed : function(action){
			var base = this;
			if(action === "slideSpeed"){
				base.$owlWrapper.css(base.addCssSpeed(base.options.slideSpeed));
			} else if(action === "paginationSpeed" ){
				base.$owlWrapper.css(base.addCssSpeed(base.options.paginationSpeed));
			} else if(typeof action !== "string"){
				base.$owlWrapper.css(base.addCssSpeed(action));
			}
		},

		addCssSpeed : function(speed){
			var base = this;
			return {
				"-webkit-transition": "all "+ speed +"ms ease",
				"-moz-transition": "all "+ speed +"ms ease",
				"-o-transition": "all "+ speed +"ms ease",
				"transition": "all "+ speed +"ms ease"
			};
		},

		removeTransition : function(){
			return {
				"-webkit-transition": "",
				"-moz-transition": "",
				"-o-transition": "",
				"transition": ""
			};
		},

		doTranslate : function(pixels){
			var base = this;
			base.options['direction']=="rtl" ? pixels=-pixels : pixels=pixels ;
			return {
				"-webkit-transform": "translate3d("+pixels+"px, 0px, 0px)",
				"-moz-transform": "translate3d("+pixels+"px, 0px, 0px)",
				"-o-transform": "translate3d("+pixels+"px, 0px, 0px)",
				"-ms-transform": "translate3d("+pixels+"px, 0px, 0px)",
				"transform": "translate3d("+pixels+"px, 0px,0px)"
			};
		},

		transition3d : function(value){
			var base = this;
			base.$owlWrapper.css(base.doTranslate(value));
		},

		css2move : function(value){
			var base = this, cssObj;
			
			base.options['direction']=="rtl" ? cssObj = {"right":value} : cssObj = {"left":value};
			base.$owlWrapper.css(cssObj);
		},

		css2slide : function(value,speed){
			var base = this, cssObj;
			base.options['direction']=="rtl" ? cssObj = {"right":value} : cssObj = {"left":value};

			base.isCssFinish = false;
			base.$owlWrapper.stop(true,true).animate(cssObj, {
				duration : speed || base.options.slideSpeed ,
				complete : function(){
					base.isCssFinish = true;
				}
			});
		},

		checkBrowser : function(){
			var base = this;

			//Check 3d support
			var	translate3D = "translate3d(0px, 0px, 0px)",
				tempElem = document.createElement("div");

			tempElem.style.cssText= "  -moz-transform:"    + translate3D +
								  "; -ms-transform:"     + translate3D +
								  "; -o-transform:"      + translate3D +
								  "; -webkit-transform:" + translate3D +
								  "; transform:"         + translate3D;
			var	regex = /translate3d\(0px, 0px, 0px\)/g,
				asSupport = tempElem.style.cssText.match(regex),
				support3d = (asSupport !== null && asSupport.length === 1);

			var isTouch = "ontouchstart" in window || navigator.msMaxTouchPoints;

			base.browser = {
				"support3d" : support3d,
				"isTouch" : isTouch
			};
		},

		moveEvents : function(){
			var base = this;
			if(base.options.mouseDrag !== false || base.options.touchDrag !== false){
				base.gestures();
				base.disabledEvents();
			}
		},

		eventTypes : function(){
			var base = this;
			var types = ["s","e","x"];

			base.ev_types = {};

			if(base.options.mouseDrag === true && base.options.touchDrag === true){
				types = [
					"touchstart.owl mousedown.owl",
					"touchmove.owl mousemove.owl",
					"touchend.owl touchcancel.owl mouseup.owl"
				];
			} else if(base.options.mouseDrag === false && base.options.touchDrag === true){
				types = [
					"touchstart.owl",
					"touchmove.owl",
					"touchend.owl touchcancel.owl"
				];
			} else if(base.options.mouseDrag === true && base.options.touchDrag === false){
				types = [
					"mousedown.owl",
					"mousemove.owl",
					"mouseup.owl"
				];
			}

			base.ev_types["start"] = types[0];
			base.ev_types["move"] = types[1];
			base.ev_types["end"] = types[2];
		},

		disabledEvents :  function(){
			var base = this;
			base.$elem.on("dragstart.owl", function(event) { event.preventDefault();});
			base.$elem.on("mousedown.disableTextSelect", function(e) {
				return $(e.target).is('input, textarea, select, option');
			});
		},

		gestures : function(){
			var base = this;

			var locals = {
				offsetX : 0,
				offsetY : 0,
				baseElWidth : 0,
				relativePos : 0,
				position: null,
				minSwipe : null,
				maxSwipe: null,
				sliding : null,
				dargging: null,
				targetElement : null
			};

			base.isCssFinish = true;

			function getTouches(event){
				if(event.touches){
					return {
						x : event.touches[0].pageX,
						y : event.touches[0].pageY
					};
				} else {
					if(event.pageX !== undefined){
						return {
							x : event.pageX,
							y : event.pageY
						};
					} else {
						return {
							x : event.clientX,
							y : event.clientY
						};
					}
				}
			}

			function swapEvents(type){
				if(type === "on"){
					$(document).on(base.ev_types["move"], dragMove);
					$(document).on(base.ev_types["end"], dragEnd);
				} else if(type === "off"){
					$(document).off(base.ev_types["move"]);
					$(document).off(base.ev_types["end"]);
				}
			}

			function dragStart(event) {
				var event = event.originalEvent || event || window.event;

				if (event.which === 3) {
					return false;
				}
				if(base.itemsAmount <= base.options.items){
					return;
				}
				if(base.isCssFinish === false && !base.options.dragBeforeAnimFinish ){
					return false;
				}
				if(base.isCss3Finish === false && !base.options.dragBeforeAnimFinish ){
					return false;
				}

				if(base.options.autoPlay !== false){
					clearInterval(base.autoPlayInterval);
				}

				if(base.browser.isTouch !== true && !base.$owlWrapper.hasClass("grabbing")){
					base.$owlWrapper.addClass("grabbing");
				}

				base.newPosX = 0;
				base.newRelativeX = 0;

				$(this).css(base.removeTransition());
				/*Bilal*/
				var position = $(this).position();

                if(base.options['direction']=="rtl") { 
                	positionRight = base.$owlItems.eq(0).width()*base.currentItem; 
                	locals.relativePos = positionRight;
                	locals.offsetX = -getTouches(event).x + positionRight;
                }
                else {
                	locals.relativePos = position.left;
                	locals.offsetX = getTouches(event).x - position.left;
                }				

				locals.offsetY = getTouches(event).y - position.top;
				
				swapEvents("on");

				locals.sliding = false;
				locals.targetElement = event.target || event.srcElement;
			}

			function dragMove(event){
				var event = event.originalEvent || event || window.event;
				
				if(base.options['direction']=="rtl") {
					base.newPosX = -getTouches(event).x - locals.offsetX;
					base.newPosY = getTouches(event).y - locals.offsetY;
					base.newRelativeX = base.newPosX + locals.relativePos;
				}
				else {
					base.newPosX = getTouches(event).x - locals.offsetX;
					base.newPosY = getTouches(event).y - locals.offsetY;
					base.newRelativeX = base.newPosX - locals.relativePos;
				}
				
				if (typeof base.options.startDragging === "function" && locals.dragging !== true && base.newRelativeX !== 0) {
					locals.dragging = true;
					base.options.startDragging.apply(base,[base.$elem]);
				}

				if(base.newRelativeX > 8 || base.newRelativeX < -8 && base.browser.isTouch === true){
					event.preventDefault ? event.preventDefault() : event.returnValue = false;
					locals.sliding = true;
				}

				if((base.newPosY > 10 || base.newPosY < -10) && locals.sliding === false){
					$(document).off("touchmove.owl");
				}

				var minSwipe = function(){
					return  base.newRelativeX / 5;
				};
				var maxSwipe = function(){
					return  base.maximumPixels + base.newRelativeX / 5;
				};

				base.newPosX = Math.max(Math.min( base.newPosX, minSwipe() ), maxSwipe() );
				if(base.browser.support3d === true){
					base.transition3d(base.newPosX);
				} else {
					base.css2move(base.newPosX);
				}
			}

			function dragEnd(event){
				var event = event.originalEvent || event || window.event;
				event.target = event.target || event.srcElement;

				locals.dragging = false;

				if(base.browser.isTouch !== true){
					base.$owlWrapper.removeClass("grabbing");
				}

				if(base.options['direction']=="rtl") {
					if (base.newRelativeX < 0) { base.dragDirection = base.owl.dragDirection = "right"; }
					else { base.dragDirection = base.owl.dragDirection = "left"; }
				}
				else {
					if (base.newRelativeX < 0) { base.dragDirection = base.owl.dragDirection = "left"; }
					else { base.dragDirection = base.owl.dragDirection = "right"; }				
				}
				
				if(base.newRelativeX !== 0){
					var newPosition = base.getNewPosition();
					base.goTo(newPosition,false,"drag");
					if(locals.targetElement === event.target && base.browser.isTouch !== true){
						$(event.target).on("click.disable", function(ev){
							ev.stopImmediatePropagation();
							ev.stopPropagation();
							ev.preventDefault();
							$(event.target).off("click.disable");
						});
						var handlers = $._data(event.target, "events")["click"];
						var owlStopEvent = handlers.pop();
						handlers.splice(0, 0, owlStopEvent);
					}
				}
				swapEvents("off");
			}
			base.$elem.on(base.ev_types["start"], ".owl-wrapper", dragStart); 
		},

		getNewPosition : function(){
			var base = this,
				newPosition;
			
			newPosition = base.closestItem();

			if(newPosition>base.maximumItem){
				base.currentItem = base.maximumItem;
				newPosition  = base.maximumItem;
			} else if( base.newPosX >=0 ){
				newPosition = 0;
				base.currentItem = 0;
			}
			return newPosition;
		},
		closestItem : function(){
			var base = this,
				array = base.options.scrollPerPage === true ? base.pagesInArray : base.positionsInArray,
				goal = base.newPosX,
				closest = null;

			$.each(array, function(i,v){
				if( goal - (base.itemWidth/20) > array[i+1] && goal - (base.itemWidth/20)< v && base.moveDirection() === "left") {
					closest = v;
					if(base.options.scrollPerPage === true){
						base.currentItem = $.inArray(closest, base.positionsInArray);
					} else {
						base.currentItem = i;
					}
				} 
				else if (goal + (base.itemWidth/20) < v && goal + (base.itemWidth/20) > (array[i+1] || array[i]-base.itemWidth) && base.moveDirection() === "right"){
					if(base.options.scrollPerPage === true){
						closest = array[i+1] || array[array.length-1];
						base.currentItem = $.inArray(closest, base.positionsInArray);
					} else {
						closest = array[i+1];
						base.currentItem = i+1;
					}
				}
			});
			return base.currentItem;
		},

		moveDirection : function(){
			var base = this,
				direction;
			if(base.newRelativeX < 0 ){
				direction = "right";
				base.playDirection = "next";
			} else {
				direction = "left";
				base.playDirection = "prev";
			}
			return direction
		},

		customEvents : function(){
			var base = this;
			base.$elem.on("owl.next",function(){
				base.next();
			});
			base.$elem.on("owl.prev",function(){
				base.prev();
			});
			base.$elem.on("owl.play",function(event,speed){
				base.options.autoPlay = speed;
				base.play();
				base.hoverStatus = "play";
			});
			base.$elem.on("owl.stop",function(){
				base.stop();
				base.hoverStatus = "stop";
			});
			base.$elem.on("owl.goTo",function(event,item){
				base.goTo(item);
			});
			base.$elem.on("owl.jumpTo",function(event,item){
				base.jumpTo(item);
			});
		},
		
		stopOnHover : function(){
			var base = this;
			if(base.options.stopOnHover === true && base.browser.isTouch !== true && base.options.autoPlay !== false){
				base.$elem.on("mouseover", function(){
					base.stop();
				});
				base.$elem.on("mouseout", function(){
					if(base.hoverStatus !== "stop"){
						base.play();
					}
				});
			}
		},

		lazyLoad : function(){
			var base = this;

			if(base.options.lazyLoad === false){
				return false;
			}
			for(var i=0; i<base.itemsAmount; i++){
				var $item = $(base.$owlItems[i]);

				if($item.data("owl-loaded") === "loaded"){
					continue;
				}

				var	itemNumber = $item.data("owl-item"),
					$lazyImg = $item.find(".lazyOwl"),
					follow;

				if( typeof $lazyImg.data("src") !== "string"){
					$item.data("owl-loaded","loaded");
					continue;
				}				
				if($item.data("owl-loaded") === undefined){
					$lazyImg.hide();
					$item.addClass("loading").data("owl-loaded","checked");
				}
				if(base.options.lazyFollow === true){
					follow = itemNumber >= base.currentItem;
				} else {
					follow = true;
				}
				if(follow && itemNumber < base.currentItem + base.options.items && $lazyImg.length){
					base.lazyPreload($item,$lazyImg);
				}
			}
		},

		lazyPreload : function($item,$lazyImg){
			var base = this,
				iterations = 0;
				if ($lazyImg.prop("tagName") === "DIV") {
					$lazyImg.css("background-image", "url(" + $lazyImg.data("src")+ ")" );
					var isBackgroundImg=true;
				} else {
					$lazyImg[0].src = $lazyImg.data("src");
				}
				checkLazyImage();

			function checkLazyImage(){
				iterations += 1;
				if (base.completeImg($lazyImg.get(0)) || isBackgroundImg === true) {
					showImage();
				} else if(iterations <= 100){//if image loads in less than 10 seconds 
					setTimeout(checkLazyImage,100);
				} else {
					showImage();
				}
			}
			function showImage(){
				$item.data("owl-loaded", "loaded").removeClass("loading");
				$lazyImg.removeAttr("data-src");
				base.options.lazyEffect === "fade" ? $lazyImg.fadeIn(400) : $lazyImg.show();
				if(typeof base.options.afterLazyLoad === "function") {
					base.options.afterLazyLoad.apply(this,[base.$elem]);
				}
			}
		},

		autoHeight : function(){
			var base = this;
			var $currentimg = $(base.$owlItems[base.currentItem]).find("img");

			if($currentimg.get(0) !== undefined ){
				var iterations = 0;
				checkImage();
			} else {
				addHeight();
			}
			function checkImage(){
				iterations += 1;
				if ( base.completeImg($currentimg.get(0)) ) {
					addHeight();
				} else if(iterations <= 100){ //if image loads in less than 10 seconds 
					setTimeout(checkImage,100);
				} else {
					base.wrapperOuter.css("height", ""); //Else remove height attribute
				}
			}

			function addHeight(){
				var $currentItem = $(base.$owlItems[base.currentItem]).height();
				base.wrapperOuter.css("height",$currentItem+"px");
				if(!base.wrapperOuter.hasClass("autoHeight")){
					setTimeout(function(){
						base.wrapperOuter.addClass("autoHeight");
					},0);
				}
			}
		},

		completeImg : function(img) {
		    if (!img.complete) {
		        return false;
		    }
		    if (typeof img.naturalWidth !== "undefined" && img.naturalWidth == 0) {
		        return false;
		    }
		    return true;
		},

		onVisibleItems : function(){
			var base = this;

			if(base.options.addClassActive === true){
				base.$owlItems.removeClass("active");
			}
			base.visibleItems = [];
			for(var i=base.currentItem; i<base.currentItem + base.options.items; i++){
				base.visibleItems.push(i);

				if(base.options.addClassActive === true){
					$(base.$owlItems[i]).addClass("active");
				}
			}
			base.owl.visibleItems = base.visibleItems;
		},

		transitionTypes : function(className){
			var base = this;
			//Currently available: "fade","backSlide","goDown","fadeUp"
			base.outClass = "owl-"+className+"-out";
			base.inClass = "owl-"+className+"-in";
		},

		singleItemTransition : function(){
			var base = this;
			base.isTransition = true;

			var outClass = base.outClass,
				inClass = base.inClass,
				$currentItem = base.$owlItems.eq(base.currentItem),
				$prevItem = base.$owlItems.eq(base.prevItem),
				prevPos = Math.abs(base.positionsInArray[base.currentItem]) + base.positionsInArray[base.prevItem],
				origin = Math.abs(base.positionsInArray[base.currentItem])+base.itemWidth/2;

            base.$owlWrapper
	            .addClass('owl-origin')
	            .css({
	            	"-webkit-transform-origin" : origin+"px",
	            	"-moz-perspective-origin" : origin+"px",
	            	"perspective-origin" : origin+"px"
	            });
	        function transStyles(prevPos,zindex){
				return {
					"position" : "relative",
					"left" : prevPos+"px"
				};
			}

	        var animEnd = 'webkitAnimationEnd oAnimationEnd MSAnimationEnd animationend';

			$prevItem
			.css(transStyles(prevPos,10))
			.addClass(outClass)
			.on(animEnd, function() {
				base.endPrev = true;
				$prevItem.off(animEnd);
		    	base.clearTransStyle($prevItem,outClass);
			});

			$currentItem
			.addClass(inClass)
			.on(animEnd, function() {
				base.endCurrent = true;
				$currentItem.off(animEnd);
		    	base.clearTransStyle($currentItem,inClass);
		    });
		},

		clearTransStyle : function(item,classToRemove){
			var base = this;
			item.css({
					"position" : "",
					"left" : ""
				})
				.removeClass(classToRemove);
			if(base.endPrev && base.endCurrent){
				base.$owlWrapper.removeClass('owl-origin');
				base.endPrev = false;
				base.endCurrent = false;
				base.isTransition = false;
			}
		},

		owlStatus : function(){
			var base = this;
			base.owl = {
				"userOptions"	: base.userOptions,
				"baseElement" 	: base.$elem,
				"userItems"		: base.$userItems,
				"owlItems"		: base.$owlItems,
				"currentItem"	: base.currentItem,
				"prevItem"		: base.prevItem,
				"visibleItems"	: base.visibleItems,
				"isTouch" 		: base.browser.isTouch,
				"browser"		: base.browser,
				"dragDirection" : base.dragDirection
			};
		},

		clearEvents : function(){
			var base = this;
			base.$elem.off(".owl owl mousedown.disableTextSelect");
			$(document).off(".owl owl");
			$(window).off("resize", base.resizer);
		},

		unWrap : function(){
			var base = this;
			if(base.$elem.children().length !== 0){
				base.$owlWrapper.unwrap();
				base.$userItems.unwrap().unwrap();
				if(base.owlControls){
					base.owlControls.remove();
				}
			}
			base.clearEvents();
			base.$elem
				.attr("style", base.$elem.data("owl-originalStyles") || "")
				.attr("class", base.$elem.data("owl-originalClasses"));
		},

		destroy : function(){
			var base = this;
			base.stop();
			clearInterval(base.checkVisible);
			base.unWrap();
			base.$elem.removeData();
		},

		reinit : function(newOptions){
			var base = this;
			var options = $.extend({}, base.userOptions, newOptions);
		 	base.unWrap();
		 	base.init(options,base.$elem);
		},

		addItem : function(htmlString,targetPosition){
			var base = this,
				position;

			if(!htmlString){return false;}

			if(base.$elem.children().length === 0){
				base.$elem.append(htmlString);
				base.setVars();
				return false;
			}
			base.unWrap();
			if(targetPosition === undefined || targetPosition === -1){
				position = -1;
			} else {
				position = targetPosition;
			}
			if(position >= base.$userItems.length || position === -1){
				base.$userItems.eq(-1).after(htmlString);
			} else {
				base.$userItems.eq(position).before(htmlString);
			}

			base.setVars();
		},

		removeItem : function(targetPosition){
			var base = this,
				position;

			if(base.$elem.children().length === 0){return false;}
			
			if(targetPosition === undefined || targetPosition === -1){
				position = -1;
			} else {
				position = targetPosition;
			}

			base.unWrap();
			base.$userItems.eq(position).remove();
			base.setVars();
		}

	};

	$.fn.owlCarousel = function( options ){
		return this.each(function() {
			if($(this).data("owl-init") === true){
				return false;
			}
			$(this).data("owl-init", true);
			var carousel = Object.create( Carousel );
			carousel.init( options, this );
			$.data( this, "owlCarousel", carousel );
		});
	};

	$.fn.owlCarousel.options = {
		direction:'ltr',
		
		items : 5,
		itemsCustom : false,
		itemsDesktop : [1199,4],
		itemsDesktopSmall : [979,3],
		itemsTablet : [768,2],
		itemsTabletSmall : false,
		itemsMobile : [479,1],
		singleItem : false,
		itemsScaleUp : false,

		slideSpeed : 200,
		paginationSpeed : 800,
		rewindSpeed : 1000,

		autoPlay : false,
		stopOnHover : false,

		navigation : false,
		navigationText : ["prev","next"],
		rewindNav : true,
		scrollPerPage : false,

		pagination : true,
		paginationNumbers : false,

		responsive : true,
		responsiveRefreshRate : 200,
		responsiveBaseWidth	: window,
		

		baseClass : "owl-carousel",
		theme : "owl-theme",

		lazyLoad : false,
		lazyFollow : true,
		lazyEffect : "fade",

		autoHeight : false,

		jsonPath : false,
		jsonSuccess : false,

		dragBeforeAnimFinish : true,
		mouseDrag : true,
		touchDrag : true,

		addClassActive : false,
		transitionStyle : false,

		beforeUpdate : false,
		afterUpdate : false,
		beforeInit : false,
		afterInit : false,
		beforeMove : false,
		afterMove : false,
		afterAction : false,
		startDragging : false,
		afterLazyLoad: false
		
	};
})( jQuery, window, document );

/*! Select2 4.0.0 | https://github.com/select2/select2/blob/master/LICENSE.md */!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):a("object"==typeof exports?require("jquery"):jQuery)}(function(a){var b=function(){if(a&&a.fn&&a.fn.select2&&a.fn.select2.amd)var b=a.fn.select2.amd;var b;return function(){if(!b||!b.requirejs){b?c=b:b={};var a,c,d;!function(b){function e(a,b){return u.call(a,b)}function f(a,b){var c,d,e,f,g,h,i,j,k,l,m,n=b&&b.split("/"),o=s.map,p=o&&o["*"]||{};if(a&&"."===a.charAt(0))if(b){for(n=n.slice(0,n.length-1),a=a.split("/"),g=a.length-1,s.nodeIdCompat&&w.test(a[g])&&(a[g]=a[g].replace(w,"")),a=n.concat(a),k=0;k<a.length;k+=1)if(m=a[k],"."===m)a.splice(k,1),k-=1;else if(".."===m){if(1===k&&(".."===a[2]||".."===a[0]))break;k>0&&(a.splice(k-1,2),k-=2)}a=a.join("/")}else 0===a.indexOf("./")&&(a=a.substring(2));if((n||p)&&o){for(c=a.split("/"),k=c.length;k>0;k-=1){if(d=c.slice(0,k).join("/"),n)for(l=n.length;l>0;l-=1)if(e=o[n.slice(0,l).join("/")],e&&(e=e[d])){f=e,h=k;break}if(f)break;!i&&p&&p[d]&&(i=p[d],j=k)}!f&&i&&(f=i,h=j),f&&(c.splice(0,h,f),a=c.join("/"))}return a}function g(a,c){return function(){return n.apply(b,v.call(arguments,0).concat([a,c]))}}function h(a){return function(b){return f(b,a)}}function i(a){return function(b){q[a]=b}}function j(a){if(e(r,a)){var c=r[a];delete r[a],t[a]=!0,m.apply(b,c)}if(!e(q,a)&&!e(t,a))throw new Error("No "+a);return q[a]}function k(a){var b,c=a?a.indexOf("!"):-1;return c>-1&&(b=a.substring(0,c),a=a.substring(c+1,a.length)),[b,a]}function l(a){return function(){return s&&s.config&&s.config[a]||{}}}var m,n,o,p,q={},r={},s={},t={},u=Object.prototype.hasOwnProperty,v=[].slice,w=/\.js$/;o=function(a,b){var c,d=k(a),e=d[0];return a=d[1],e&&(e=f(e,b),c=j(e)),e?a=c&&c.normalize?c.normalize(a,h(b)):f(a,b):(a=f(a,b),d=k(a),e=d[0],a=d[1],e&&(c=j(e))),{f:e?e+"!"+a:a,n:a,pr:e,p:c}},p={require:function(a){return g(a)},exports:function(a){var b=q[a];return"undefined"!=typeof b?b:q[a]={}},module:function(a){return{id:a,uri:"",exports:q[a],config:l(a)}}},m=function(a,c,d,f){var h,k,l,m,n,s,u=[],v=typeof d;if(f=f||a,"undefined"===v||"function"===v){for(c=!c.length&&d.length?["require","exports","module"]:c,n=0;n<c.length;n+=1)if(m=o(c[n],f),k=m.f,"require"===k)u[n]=p.require(a);else if("exports"===k)u[n]=p.exports(a),s=!0;else if("module"===k)h=u[n]=p.module(a);else if(e(q,k)||e(r,k)||e(t,k))u[n]=j(k);else{if(!m.p)throw new Error(a+" missing "+k);m.p.load(m.n,g(f,!0),i(k),{}),u[n]=q[k]}l=d?d.apply(q[a],u):void 0,a&&(h&&h.exports!==b&&h.exports!==q[a]?q[a]=h.exports:l===b&&s||(q[a]=l))}else a&&(q[a]=d)},a=c=n=function(a,c,d,e,f){if("string"==typeof a)return p[a]?p[a](c):j(o(a,c).f);if(!a.splice){if(s=a,s.deps&&n(s.deps,s.callback),!c)return;c.splice?(a=c,c=d,d=null):a=b}return c=c||function(){},"function"==typeof d&&(d=e,e=f),e?m(b,a,c,d):setTimeout(function(){m(b,a,c,d)},4),n},n.config=function(a){return n(a)},a._defined=q,d=function(a,b,c){b.splice||(c=b,b=[]),e(q,a)||e(r,a)||(r[a]=[a,b,c])},d.amd={jQuery:!0}}(),b.requirejs=a,b.require=c,b.define=d}}(),b.define("almond",function(){}),b.define("jquery",[],function(){var b=a||$;return null==b&&console&&console.error&&console.error("Select2: An instance of jQuery or a jQuery-compatible library was not found. Make sure that you are including jQuery before Select2 on your web page."),b}),b.define("select2/utils",["jquery"],function(a){function b(a){var b=a.prototype,c=[];for(var d in b){var e=b[d];"function"==typeof e&&"constructor"!==d&&c.push(d)}return c}var c={};c.Extend=function(a,b){function c(){this.constructor=a}var d={}.hasOwnProperty;for(var e in b)d.call(b,e)&&(a[e]=b[e]);return c.prototype=b.prototype,a.prototype=new c,a.__super__=b.prototype,a},c.Decorate=function(a,c){function d(){var b=Array.prototype.unshift,d=c.prototype.constructor.length,e=a.prototype.constructor;d>0&&(b.call(arguments,a.prototype.constructor),e=c.prototype.constructor),e.apply(this,arguments)}function e(){this.constructor=d}var f=b(c),g=b(a);c.displayName=a.displayName,d.prototype=new e;for(var h=0;h<g.length;h++){var i=g[h];d.prototype[i]=a.prototype[i]}for(var j=(function(a){var b=function(){};a in d.prototype&&(b=d.prototype[a]);var e=c.prototype[a];return function(){var a=Array.prototype.unshift;return a.call(arguments,b),e.apply(this,arguments)}}),k=0;k<f.length;k++){var l=f[k];d.prototype[l]=j(l)}return d};var d=function(){this.listeners={}};return d.prototype.on=function(a,b){this.listeners=this.listeners||{},a in this.listeners?this.listeners[a].push(b):this.listeners[a]=[b]},d.prototype.trigger=function(a){var b=Array.prototype.slice;this.listeners=this.listeners||{},a in this.listeners&&this.invoke(this.listeners[a],b.call(arguments,1)),"*"in this.listeners&&this.invoke(this.listeners["*"],arguments)},d.prototype.invoke=function(a,b){for(var c=0,d=a.length;d>c;c++)a[c].apply(this,b)},c.Observable=d,c.generateChars=function(a){for(var b="",c=0;a>c;c++){var d=Math.floor(36*Math.random());b+=d.toString(36)}return b},c.bind=function(a,b){return function(){a.apply(b,arguments)}},c._convertData=function(a){for(var b in a){var c=b.split("-"),d=a;if(1!==c.length){for(var e=0;e<c.length;e++){var f=c[e];f=f.substring(0,1).toLowerCase()+f.substring(1),f in d||(d[f]={}),e==c.length-1&&(d[f]=a[b]),d=d[f]}delete a[b]}}return a},c.hasScroll=function(b,c){var d=a(c),e=c.style.overflowX,f=c.style.overflowY;return e!==f||"hidden"!==f&&"visible"!==f?"scroll"===e||"scroll"===f?!0:d.innerHeight()<c.scrollHeight||d.innerWidth()<c.scrollWidth:!1},c.escapeMarkup=function(a){var b={"\\":"&#92;","&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#39;","/":"&#47;"};return"string"!=typeof a?a:String(a).replace(/[&<>"'\/\\]/g,function(a){return b[a]})},c.appendMany=function(b,c){if("1.7"===a.fn.jquery.substr(0,3)){var d=a();a.map(c,function(a){d=d.add(a)}),c=d}b.append(c)},c}),b.define("select2/results",["jquery","./utils"],function(a,b){function c(a,b,d){this.$element=a,this.data=d,this.options=b,c.__super__.constructor.call(this)}return b.Extend(c,b.Observable),c.prototype.render=function(){var b=a('<ul class="select2-results__options" role="tree"></ul>');return this.options.get("multiple")&&b.attr("aria-multiselectable","true"),this.$results=b,b},c.prototype.clear=function(){this.$results.empty()},c.prototype.displayMessage=function(b){var c=this.options.get("escapeMarkup");this.clear(),this.hideLoading();var d=a('<li role="treeitem" class="select2-results__option"></li>'),e=this.options.get("translations").get(b.message);d.append(c(e(b.args))),this.$results.append(d)},c.prototype.append=function(a){this.hideLoading();var b=[];if(null==a.results||0===a.results.length)return void(0===this.$results.children().length&&this.trigger("results:message",{message:"noResults"}));a.results=this.sort(a.results);for(var c=0;c<a.results.length;c++){var d=a.results[c],e=this.option(d);b.push(e)}this.$results.append(b)},c.prototype.position=function(a,b){var c=b.find(".select2-results");c.append(a)},c.prototype.sort=function(a){var b=this.options.get("sorter");return b(a)},c.prototype.setClasses=function(){var b=this;this.data.current(function(c){var d=a.map(c,function(a){return a.id.toString()}),e=b.$results.find(".select2-results__option[aria-selected]");e.each(function(){var b=a(this),c=a.data(this,"data"),e=""+c.id;null!=c.element&&c.element.selected||null==c.element&&a.inArray(e,d)>-1?b.attr("aria-selected","true"):b.attr("aria-selected","false")});var f=e.filter("[aria-selected=true]");f.length>0?f.first().trigger("mouseenter"):e.first().trigger("mouseenter")})},c.prototype.showLoading=function(a){this.hideLoading();var b=this.options.get("translations").get("searching"),c={disabled:!0,loading:!0,text:b(a)},d=this.option(c);d.className+=" loading-results",this.$results.prepend(d)},c.prototype.hideLoading=function(){this.$results.find(".loading-results").remove()},c.prototype.option=function(b){var c=document.createElement("li");c.className="select2-results__option";var d={role:"treeitem","aria-selected":"false"};b.disabled&&(delete d["aria-selected"],d["aria-disabled"]="true"),null==b.id&&delete d["aria-selected"],null!=b._resultId&&(c.id=b._resultId),b.title&&(c.title=b.title),b.children&&(d.role="group",d["aria-label"]=b.text,delete d["aria-selected"]);for(var e in d){var f=d[e];c.setAttribute(e,f)}if(b.children){var g=a(c),h=document.createElement("strong");h.className="select2-results__group";{a(h)}this.template(b,h);for(var i=[],j=0;j<b.children.length;j++){var k=b.children[j],l=this.option(k);i.push(l)}var m=a("<ul></ul>",{"class":"select2-results__options select2-results__options--nested"});m.append(i),g.append(h),g.append(m)}else this.template(b,c);return a.data(c,"data",b),c},c.prototype.bind=function(b){var c=this,d=b.id+"-results";this.$results.attr("id",d),b.on("results:all",function(a){c.clear(),c.append(a.data),b.isOpen()&&c.setClasses()}),b.on("results:append",function(a){c.append(a.data),b.isOpen()&&c.setClasses()}),b.on("query",function(a){c.showLoading(a)}),b.on("select",function(){b.isOpen()&&c.setClasses()}),b.on("unselect",function(){b.isOpen()&&c.setClasses()}),b.on("open",function(){c.$results.attr("aria-expanded","true"),c.$results.attr("aria-hidden","false"),c.setClasses(),c.ensureHighlightVisible()}),b.on("close",function(){c.$results.attr("aria-expanded","false"),c.$results.attr("aria-hidden","true"),c.$results.removeAttr("aria-activedescendant")}),b.on("results:toggle",function(){var a=c.getHighlightedResults();0!==a.length&&a.trigger("mouseup")}),b.on("results:select",function(){var a=c.getHighlightedResults();if(0!==a.length){var b=a.data("data");"true"==a.attr("aria-selected")?c.trigger("close"):c.trigger("select",{data:b})}}),b.on("results:previous",function(){var a=c.getHighlightedResults(),b=c.$results.find("[aria-selected]"),d=b.index(a);if(0!==d){var e=d-1;0===a.length&&(e=0);var f=b.eq(e);f.trigger("mouseenter");var g=c.$results.offset().top,h=f.offset().top,i=c.$results.scrollTop()+(h-g);0===e?c.$results.scrollTop(0):0>h-g&&c.$results.scrollTop(i)}}),b.on("results:next",function(){var a=c.getHighlightedResults(),b=c.$results.find("[aria-selected]"),d=b.index(a),e=d+1;if(!(e>=b.length)){var f=b.eq(e);f.trigger("mouseenter");var g=c.$results.offset().top+c.$results.outerHeight(!1),h=f.offset().top+f.outerHeight(!1),i=c.$results.scrollTop()+h-g;0===e?c.$results.scrollTop(0):h>g&&c.$results.scrollTop(i)}}),b.on("results:focus",function(a){a.element.addClass("select2-results__option--highlighted")}),b.on("results:message",function(a){c.displayMessage(a)}),a.fn.mousewheel&&this.$results.on("mousewheel",function(a){var b=c.$results.scrollTop(),d=c.$results.get(0).scrollHeight-c.$results.scrollTop()+a.deltaY,e=a.deltaY>0&&b-a.deltaY<=0,f=a.deltaY<0&&d<=c.$results.height();e?(c.$results.scrollTop(0),a.preventDefault(),a.stopPropagation()):f&&(c.$results.scrollTop(c.$results.get(0).scrollHeight-c.$results.height()),a.preventDefault(),a.stopPropagation())}),this.$results.on("mouseup",".select2-results__option[aria-selected]",function(b){var d=a(this),e=d.data("data");return"true"===d.attr("aria-selected")?void(c.options.get("multiple")?c.trigger("unselect",{originalEvent:b,data:e}):c.trigger("close")):void c.trigger("select",{originalEvent:b,data:e})}),this.$results.on("mouseenter",".select2-results__option[aria-selected]",function(){var b=a(this).data("data");c.getHighlightedResults().removeClass("select2-results__option--highlighted"),c.trigger("results:focus",{data:b,element:a(this)})})},c.prototype.getHighlightedResults=function(){var a=this.$results.find(".select2-results__option--highlighted");return a},c.prototype.destroy=function(){this.$results.remove()},c.prototype.ensureHighlightVisible=function(){var a=this.getHighlightedResults();if(0!==a.length){var b=this.$results.find("[aria-selected]"),c=b.index(a),d=this.$results.offset().top,e=a.offset().top,f=this.$results.scrollTop()+(e-d),g=e-d;f-=2*a.outerHeight(!1),2>=c?this.$results.scrollTop(0):(g>this.$results.outerHeight()||0>g)&&this.$results.scrollTop(f)}},c.prototype.template=function(b,c){var d=this.options.get("templateResult"),e=this.options.get("escapeMarkup"),f=d(b);null==f?c.style.display="none":"string"==typeof f?c.innerHTML=e(f):a(c).append(f)},c}),b.define("select2/keys",[],function(){var a={BACKSPACE:8,TAB:9,ENTER:13,SHIFT:16,CTRL:17,ALT:18,ESC:27,SPACE:32,PAGE_UP:33,PAGE_DOWN:34,END:35,HOME:36,LEFT:37,UP:38,RIGHT:39,DOWN:40,DELETE:46};return a}),b.define("select2/selection/base",["jquery","../utils","../keys"],function(a,b,c){function d(a,b){this.$element=a,this.options=b,d.__super__.constructor.call(this)}return b.Extend(d,b.Observable),d.prototype.render=function(){var b=a('<span class="select2-selection" role="combobox" aria-autocomplete="list" aria-haspopup="true" aria-expanded="false"></span>');return this._tabindex=0,null!=this.$element.data("old-tabindex")?this._tabindex=this.$element.data("old-tabindex"):null!=this.$element.attr("tabindex")&&(this._tabindex=this.$element.attr("tabindex")),b.attr("title",this.$element.attr("title")),b.attr("tabindex",this._tabindex),this.$selection=b,b},d.prototype.bind=function(a){var b=this,d=(a.id+"-container",a.id+"-results");this.container=a,this.$selection.on("focus",function(a){b.trigger("focus",a)}),this.$selection.on("blur",function(a){b.trigger("blur",a)}),this.$selection.on("keydown",function(a){b.trigger("keypress",a),a.which===c.SPACE&&a.preventDefault()}),a.on("results:focus",function(a){b.$selection.attr("aria-activedescendant",a.data._resultId)}),a.on("selection:update",function(a){b.update(a.data)}),a.on("open",function(){b.$selection.attr("aria-expanded","true"),b.$selection.attr("aria-owns",d),b._attachCloseHandler(a)}),a.on("close",function(){b.$selection.attr("aria-expanded","false"),b.$selection.removeAttr("aria-activedescendant"),b.$selection.removeAttr("aria-owns"),b.$selection.focus(),b._detachCloseHandler(a)}),a.on("enable",function(){b.$selection.attr("tabindex",b._tabindex)}),a.on("disable",function(){b.$selection.attr("tabindex","-1")})},d.prototype._attachCloseHandler=function(b){a(document.body).on("mousedown.select2."+b.id,function(b){var c=a(b.target),d=c.closest(".select2"),e=a(".select2.select2-container--open");e.each(function(){var b=a(this);if(this!=d[0]){var c=b.data("element");c.select2("close")}})})},d.prototype._detachCloseHandler=function(b){a(document.body).off("mousedown.select2."+b.id)},d.prototype.position=function(a,b){var c=b.find(".selection");c.append(a)},d.prototype.destroy=function(){this._detachCloseHandler(this.container)},d.prototype.update=function(){throw new Error("The `update` method must be defined in child classes.")},d}),b.define("select2/selection/single",["jquery","./base","../utils","../keys"],function(a,b,c){function d(){d.__super__.constructor.apply(this,arguments)}return c.Extend(d,b),d.prototype.render=function(){var a=d.__super__.render.call(this);return a.addClass("select2-selection--single"),a.html('<span class="select2-selection__rendered"></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span>'),a},d.prototype.bind=function(a){var b=this;d.__super__.bind.apply(this,arguments);var c=a.id+"-container";this.$selection.find(".select2-selection__rendered").attr("id",c),this.$selection.attr("aria-labelledby",c),this.$selection.on("mousedown",function(a){1===a.which&&b.trigger("toggle",{originalEvent:a})}),this.$selection.on("focus",function(){}),this.$selection.on("blur",function(){}),a.on("selection:update",function(a){b.update(a.data)})},d.prototype.clear=function(){this.$selection.find(".select2-selection__rendered").empty()},d.prototype.display=function(a){var b=this.options.get("templateSelection"),c=this.options.get("escapeMarkup");return c(b(a))},d.prototype.selectionContainer=function(){return a("<span></span>")},d.prototype.update=function(a){if(0===a.length)return void this.clear();var b=a[0],c=this.display(b),d=this.$selection.find(".select2-selection__rendered");d.empty().append(c),d.prop("title",b.title||b.text)},d}),b.define("select2/selection/multiple",["jquery","./base","../utils"],function(a,b,c){function d(){d.__super__.constructor.apply(this,arguments)}return c.Extend(d,b),d.prototype.render=function(){var a=d.__super__.render.call(this);return a.addClass("select2-selection--multiple"),a.html('<ul class="select2-selection__rendered"></ul>'),a},d.prototype.bind=function(){var b=this;d.__super__.bind.apply(this,arguments),this.$selection.on("click",function(a){b.trigger("toggle",{originalEvent:a})}),this.$selection.on("click",".select2-selection__choice__remove",function(c){var d=a(this),e=d.parent(),f=e.data("data");b.trigger("unselect",{originalEvent:c,data:f})})},d.prototype.clear=function(){this.$selection.find(".select2-selection__rendered").empty()},d.prototype.display=function(a){var b=this.options.get("templateSelection"),c=this.options.get("escapeMarkup");return c(b(a))},d.prototype.selectionContainer=function(){var b=a('<li class="select2-selection__choice"><span class="select2-selection__choice__remove" role="presentation">&times;</span></li>');return b},d.prototype.update=function(a){if(this.clear(),0!==a.length){for(var b=[],d=0;d<a.length;d++){var e=a[d],f=this.display(e),g=this.selectionContainer();g.append(f),g.prop("title",e.title||e.text),g.data("data",e),b.push(g)}var h=this.$selection.find(".select2-selection__rendered");c.appendMany(h,b)}},d}),b.define("select2/selection/placeholder",["../utils"],function(){function a(a,b,c){this.placeholder=this.normalizePlaceholder(c.get("placeholder")),a.call(this,b,c)}return a.prototype.normalizePlaceholder=function(a,b){return"string"==typeof b&&(b={id:"",text:b}),b},a.prototype.createPlaceholder=function(a,b){var c=this.selectionContainer();return c.html(this.display(b)),c.addClass("select2-selection__placeholder").removeClass("select2-selection__choice"),c},a.prototype.update=function(a,b){var c=1==b.length&&b[0].id!=this.placeholder.id,d=b.length>1;if(d||c)return a.call(this,b);this.clear();var e=this.createPlaceholder(this.placeholder);this.$selection.find(".select2-selection__rendered").append(e)},a}),b.define("select2/selection/allowClear",["jquery","../keys"],function(a,b){function c(){}return c.prototype.bind=function(a,b,c){var d=this;a.call(this,b,c),null==this.placeholder&&this.options.get("debug")&&window.console&&console.error&&console.error("Select2: The `allowClear` option should be used in combination with the `placeholder` option."),this.$selection.on("mousedown",".select2-selection__clear",function(a){d._handleClear(a)}),b.on("keypress",function(a){d._handleKeyboardClear(a,b)})},c.prototype._handleClear=function(a,b){if(!this.options.get("disabled")){var c=this.$selection.find(".select2-selection__clear");if(0!==c.length){b.stopPropagation();for(var d=c.data("data"),e=0;e<d.length;e++){var f={data:d[e]};if(this.trigger("unselect",f),f.prevented)return}this.$element.val(this.placeholder.id).trigger("change"),this.trigger("toggle")}}},c.prototype._handleKeyboardClear=function(a,c,d){d.isOpen()||(c.which==b.DELETE||c.which==b.BACKSPACE)&&this._handleClear(c)},c.prototype.update=function(b,c){if(b.call(this,c),!(this.$selection.find(".select2-selection__placeholder").length>0||0===c.length)){var d=a('<span class="select2-selection__clear">&times;</span>');d.data("data",c),this.$selection.find(".select2-selection__rendered").prepend(d)}},c}),b.define("select2/selection/search",["jquery","../utils","../keys"],function(a,b,c){function d(a,b,c){a.call(this,b,c)}return d.prototype.render=function(b){var c=a('<li class="select2-search select2-search--inline"><input class="select2-search__field" type="search" tabindex="-1" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" role="textbox" /></li>');this.$searchContainer=c,this.$search=c.find("input");var d=b.call(this);return d},d.prototype.bind=function(a,b,d){var e=this;a.call(this,b,d),b.on("open",function(){e.$search.attr("tabindex",0),e.$search.focus()}),b.on("close",function(){e.$search.attr("tabindex",-1),e.$search.val(""),e.$search.focus()}),b.on("enable",function(){e.$search.prop("disabled",!1)}),b.on("disable",function(){e.$search.prop("disabled",!0)}),this.$selection.on("focusin",".select2-search--inline",function(a){e.trigger("focus",a)}),this.$selection.on("focusout",".select2-search--inline",function(a){e.trigger("blur",a)}),this.$selection.on("keydown",".select2-search--inline",function(a){a.stopPropagation(),e.trigger("keypress",a),e._keyUpPrevented=a.isDefaultPrevented();var b=a.which;if(b===c.BACKSPACE&&""===e.$search.val()){var d=e.$searchContainer.prev(".select2-selection__choice");if(d.length>0){var f=d.data("data");e.searchRemoveChoice(f),a.preventDefault()}}}),this.$selection.on("input",".select2-search--inline",function(){e.$selection.off("keyup.search")}),this.$selection.on("keyup.search input",".select2-search--inline",function(a){e.handleSearch(a)})},d.prototype.createPlaceholder=function(a,b){this.$search.attr("placeholder",b.text)},d.prototype.update=function(a,b){this.$search.attr("placeholder",""),a.call(this,b),this.$selection.find(".select2-selection__rendered").append(this.$searchContainer),this.resizeSearch()},d.prototype.handleSearch=function(){if(this.resizeSearch(),!this._keyUpPrevented){var a=this.$search.val();this.trigger("query",{term:a})}this._keyUpPrevented=!1},d.prototype.searchRemoveChoice=function(a,b){this.trigger("unselect",{data:b}),this.trigger("open"),this.$search.val(b.text+" ")},d.prototype.resizeSearch=function(){this.$search.css("width","25px");var a="";if(""!==this.$search.attr("placeholder"))a=this.$selection.find(".select2-selection__rendered").innerWidth();else{var b=this.$search.val().length+1;a=.75*b+"em"}this.$search.css("width",a)},d}),b.define("select2/selection/eventRelay",["jquery"],function(a){function b(){}return b.prototype.bind=function(b,c,d){var e=this,f=["open","opening","close","closing","select","selecting","unselect","unselecting"],g=["opening","closing","selecting","unselecting"];b.call(this,c,d),c.on("*",function(b,c){if(-1!==a.inArray(b,f)){c=c||{};var d=a.Event("select2:"+b,{params:c});e.$element.trigger(d),-1!==a.inArray(b,g)&&(c.prevented=d.isDefaultPrevented())}})},b}),b.define("select2/translation",["jquery","require"],function(a,b){function c(a){this.dict=a||{}}return c.prototype.all=function(){return this.dict},c.prototype.get=function(a){return this.dict[a]},c.prototype.extend=function(b){this.dict=a.extend({},b.all(),this.dict)},c._cache={},c.loadPath=function(a){if(!(a in c._cache)){var d=b(a);c._cache[a]=d}return new c(c._cache[a])},c}),b.define("select2/diacritics",[],function(){var a={"Ⓐ":"A","Ａ":"A","À":"A","Á":"A","Â":"A","Ầ":"A","Ấ":"A","Ẫ":"A","Ẩ":"A","Ã":"A","Ā":"A","Ă":"A","Ằ":"A","Ắ":"A","Ẵ":"A","Ẳ":"A","Ȧ":"A","Ǡ":"A","Ä":"A","Ǟ":"A","Ả":"A","Å":"A","Ǻ":"A","Ǎ":"A","Ȁ":"A","Ȃ":"A","Ạ":"A","Ậ":"A","Ặ":"A","Ḁ":"A","Ą":"A","Ⱥ":"A","Ɐ":"A","Ꜳ":"AA","Æ":"AE","Ǽ":"AE","Ǣ":"AE","Ꜵ":"AO","Ꜷ":"AU","Ꜹ":"AV","Ꜻ":"AV","Ꜽ":"AY","Ⓑ":"B","Ｂ":"B","Ḃ":"B","Ḅ":"B","Ḇ":"B","Ƀ":"B","Ƃ":"B","Ɓ":"B","Ⓒ":"C","Ｃ":"C","Ć":"C","Ĉ":"C","Ċ":"C","Č":"C","Ç":"C","Ḉ":"C","Ƈ":"C","Ȼ":"C","Ꜿ":"C","Ⓓ":"D","Ｄ":"D","Ḋ":"D","Ď":"D","Ḍ":"D","Ḑ":"D","Ḓ":"D","Ḏ":"D","Đ":"D","Ƌ":"D","Ɗ":"D","Ɖ":"D","Ꝺ":"D","Ǳ":"DZ","Ǆ":"DZ","ǲ":"Dz","ǅ":"Dz","Ⓔ":"E","Ｅ":"E","È":"E","É":"E","Ê":"E","Ề":"E","Ế":"E","Ễ":"E","Ể":"E","Ẽ":"E","Ē":"E","Ḕ":"E","Ḗ":"E","Ĕ":"E","Ė":"E","Ë":"E","Ẻ":"E","Ě":"E","Ȅ":"E","Ȇ":"E","Ẹ":"E","Ệ":"E","Ȩ":"E","Ḝ":"E","Ę":"E","Ḙ":"E","Ḛ":"E","Ɛ":"E","Ǝ":"E","Ⓕ":"F","Ｆ":"F","Ḟ":"F","Ƒ":"F","Ꝼ":"F","Ⓖ":"G","Ｇ":"G","Ǵ":"G","Ĝ":"G","Ḡ":"G","Ğ":"G","Ġ":"G","Ǧ":"G","Ģ":"G","Ǥ":"G","Ɠ":"G","Ꞡ":"G","Ᵹ":"G","Ꝿ":"G","Ⓗ":"H","Ｈ":"H","Ĥ":"H","Ḣ":"H","Ḧ":"H","Ȟ":"H","Ḥ":"H","Ḩ":"H","Ḫ":"H","Ħ":"H","Ⱨ":"H","Ⱶ":"H","Ɥ":"H","Ⓘ":"I","Ｉ":"I","Ì":"I","Í":"I","Î":"I","Ĩ":"I","Ī":"I","Ĭ":"I","İ":"I","Ï":"I","Ḯ":"I","Ỉ":"I","Ǐ":"I","Ȉ":"I","Ȋ":"I","Ị":"I","Į":"I","Ḭ":"I","Ɨ":"I","Ⓙ":"J","Ｊ":"J","Ĵ":"J","Ɉ":"J","Ⓚ":"K","Ｋ":"K","Ḱ":"K","Ǩ":"K","Ḳ":"K","Ķ":"K","Ḵ":"K","Ƙ":"K","Ⱪ":"K","Ꝁ":"K","Ꝃ":"K","Ꝅ":"K","Ꞣ":"K","Ⓛ":"L","Ｌ":"L","Ŀ":"L","Ĺ":"L","Ľ":"L","Ḷ":"L","Ḹ":"L","Ļ":"L","Ḽ":"L","Ḻ":"L","Ł":"L","Ƚ":"L","Ɫ":"L","Ⱡ":"L","Ꝉ":"L","Ꝇ":"L","Ꞁ":"L","Ǉ":"LJ","ǈ":"Lj","Ⓜ":"M","Ｍ":"M","Ḿ":"M","Ṁ":"M","Ṃ":"M","Ɱ":"M","Ɯ":"M","Ⓝ":"N","Ｎ":"N","Ǹ":"N","Ń":"N","Ñ":"N","Ṅ":"N","Ň":"N","Ṇ":"N","Ņ":"N","Ṋ":"N","Ṉ":"N","Ƞ":"N","Ɲ":"N","Ꞑ":"N","Ꞥ":"N","Ǌ":"NJ","ǋ":"Nj","Ⓞ":"O","Ｏ":"O","Ò":"O","Ó":"O","Ô":"O","Ồ":"O","Ố":"O","Ỗ":"O","Ổ":"O","Õ":"O","Ṍ":"O","Ȭ":"O","Ṏ":"O","Ō":"O","Ṑ":"O","Ṓ":"O","Ŏ":"O","Ȯ":"O","Ȱ":"O","Ö":"O","Ȫ":"O","Ỏ":"O","Ő":"O","Ǒ":"O","Ȍ":"O","Ȏ":"O","Ơ":"O","Ờ":"O","Ớ":"O","Ỡ":"O","Ở":"O","Ợ":"O","Ọ":"O","Ộ":"O","Ǫ":"O","Ǭ":"O","Ø":"O","Ǿ":"O","Ɔ":"O","Ɵ":"O","Ꝋ":"O","Ꝍ":"O","Ƣ":"OI","Ꝏ":"OO","Ȣ":"OU","Ⓟ":"P","Ｐ":"P","Ṕ":"P","Ṗ":"P","Ƥ":"P","Ᵽ":"P","Ꝑ":"P","Ꝓ":"P","Ꝕ":"P","Ⓠ":"Q","Ｑ":"Q","Ꝗ":"Q","Ꝙ":"Q","Ɋ":"Q","Ⓡ":"R","Ｒ":"R","Ŕ":"R","Ṙ":"R","Ř":"R","Ȑ":"R","Ȓ":"R","Ṛ":"R","Ṝ":"R","Ŗ":"R","Ṟ":"R","Ɍ":"R","Ɽ":"R","Ꝛ":"R","Ꞧ":"R","Ꞃ":"R","Ⓢ":"S","Ｓ":"S","ẞ":"S","Ś":"S","Ṥ":"S","Ŝ":"S","Ṡ":"S","Š":"S","Ṧ":"S","Ṣ":"S","Ṩ":"S","Ș":"S","Ş":"S","Ȿ":"S","Ꞩ":"S","Ꞅ":"S","Ⓣ":"T","Ｔ":"T","Ṫ":"T","Ť":"T","Ṭ":"T","Ț":"T","Ţ":"T","Ṱ":"T","Ṯ":"T","Ŧ":"T","Ƭ":"T","Ʈ":"T","Ⱦ":"T","Ꞇ":"T","Ꜩ":"TZ","Ⓤ":"U","Ｕ":"U","Ù":"U","Ú":"U","Û":"U","Ũ":"U","Ṹ":"U","Ū":"U","Ṻ":"U","Ŭ":"U","Ü":"U","Ǜ":"U","Ǘ":"U","Ǖ":"U","Ǚ":"U","Ủ":"U","Ů":"U","Ű":"U","Ǔ":"U","Ȕ":"U","Ȗ":"U","Ư":"U","Ừ":"U","Ứ":"U","Ữ":"U","Ử":"U","Ự":"U","Ụ":"U","Ṳ":"U","Ų":"U","Ṷ":"U","Ṵ":"U","Ʉ":"U","Ⓥ":"V","Ｖ":"V","Ṽ":"V","Ṿ":"V","Ʋ":"V","Ꝟ":"V","Ʌ":"V","Ꝡ":"VY","Ⓦ":"W","Ｗ":"W","Ẁ":"W","Ẃ":"W","Ŵ":"W","Ẇ":"W","Ẅ":"W","Ẉ":"W","Ⱳ":"W","Ⓧ":"X","Ｘ":"X","Ẋ":"X","Ẍ":"X","Ⓨ":"Y","Ｙ":"Y","Ỳ":"Y","Ý":"Y","Ŷ":"Y","Ỹ":"Y","Ȳ":"Y","Ẏ":"Y","Ÿ":"Y","Ỷ":"Y","Ỵ":"Y","Ƴ":"Y","Ɏ":"Y","Ỿ":"Y","Ⓩ":"Z","Ｚ":"Z","Ź":"Z","Ẑ":"Z","Ż":"Z","Ž":"Z","Ẓ":"Z","Ẕ":"Z","Ƶ":"Z","Ȥ":"Z","Ɀ":"Z","Ⱬ":"Z","Ꝣ":"Z","ⓐ":"a","ａ":"a","ẚ":"a","à":"a","á":"a","â":"a","ầ":"a","ấ":"a","ẫ":"a","ẩ":"a","ã":"a","ā":"a","ă":"a","ằ":"a","ắ":"a","ẵ":"a","ẳ":"a","ȧ":"a","ǡ":"a","ä":"a","ǟ":"a","ả":"a","å":"a","ǻ":"a","ǎ":"a","ȁ":"a","ȃ":"a","ạ":"a","ậ":"a","ặ":"a","ḁ":"a","ą":"a","ⱥ":"a","ɐ":"a","ꜳ":"aa","æ":"ae","ǽ":"ae","ǣ":"ae","ꜵ":"ao","ꜷ":"au","ꜹ":"av","ꜻ":"av","ꜽ":"ay","ⓑ":"b","ｂ":"b","ḃ":"b","ḅ":"b","ḇ":"b","ƀ":"b","ƃ":"b","ɓ":"b","ⓒ":"c","ｃ":"c","ć":"c","ĉ":"c","ċ":"c","č":"c","ç":"c","ḉ":"c","ƈ":"c","ȼ":"c","ꜿ":"c","ↄ":"c","ⓓ":"d","ｄ":"d","ḋ":"d","ď":"d","ḍ":"d","ḑ":"d","ḓ":"d","ḏ":"d","đ":"d","ƌ":"d","ɖ":"d","ɗ":"d","ꝺ":"d","ǳ":"dz","ǆ":"dz","ⓔ":"e","ｅ":"e","è":"e","é":"e","ê":"e","ề":"e","ế":"e","ễ":"e","ể":"e","ẽ":"e","ē":"e","ḕ":"e","ḗ":"e","ĕ":"e","ė":"e","ë":"e","ẻ":"e","ě":"e","ȅ":"e","ȇ":"e","ẹ":"e","ệ":"e","ȩ":"e","ḝ":"e","ę":"e","ḙ":"e","ḛ":"e","ɇ":"e","ɛ":"e","ǝ":"e","ⓕ":"f","ｆ":"f","ḟ":"f","ƒ":"f","ꝼ":"f","ⓖ":"g","ｇ":"g","ǵ":"g","ĝ":"g","ḡ":"g","ğ":"g","ġ":"g","ǧ":"g","ģ":"g","ǥ":"g","ɠ":"g","ꞡ":"g","ᵹ":"g","ꝿ":"g","ⓗ":"h","ｈ":"h","ĥ":"h","ḣ":"h","ḧ":"h","ȟ":"h","ḥ":"h","ḩ":"h","ḫ":"h","ẖ":"h","ħ":"h","ⱨ":"h","ⱶ":"h","ɥ":"h","ƕ":"hv","ⓘ":"i","ｉ":"i","ì":"i","í":"i","î":"i","ĩ":"i","ī":"i","ĭ":"i","ï":"i","ḯ":"i","ỉ":"i","ǐ":"i","ȉ":"i","ȋ":"i","ị":"i","į":"i","ḭ":"i","ɨ":"i","ı":"i","ⓙ":"j","ｊ":"j","ĵ":"j","ǰ":"j","ɉ":"j","ⓚ":"k","ｋ":"k","ḱ":"k","ǩ":"k","ḳ":"k","ķ":"k","ḵ":"k","ƙ":"k","ⱪ":"k","ꝁ":"k","ꝃ":"k","ꝅ":"k","ꞣ":"k","ⓛ":"l","ｌ":"l","ŀ":"l","ĺ":"l","ľ":"l","ḷ":"l","ḹ":"l","ļ":"l","ḽ":"l","ḻ":"l","ſ":"l","ł":"l","ƚ":"l","ɫ":"l","ⱡ":"l","ꝉ":"l","ꞁ":"l","ꝇ":"l","ǉ":"lj","ⓜ":"m","ｍ":"m","ḿ":"m","ṁ":"m","ṃ":"m","ɱ":"m","ɯ":"m","ⓝ":"n","ｎ":"n","ǹ":"n","ń":"n","ñ":"n","ṅ":"n","ň":"n","ṇ":"n","ņ":"n","ṋ":"n","ṉ":"n","ƞ":"n","ɲ":"n","ŉ":"n","ꞑ":"n","ꞥ":"n","ǌ":"nj","ⓞ":"o","ｏ":"o","ò":"o","ó":"o","ô":"o","ồ":"o","ố":"o","ỗ":"o","ổ":"o","õ":"o","ṍ":"o","ȭ":"o","ṏ":"o","ō":"o","ṑ":"o","ṓ":"o","ŏ":"o","ȯ":"o","ȱ":"o","ö":"o","ȫ":"o","ỏ":"o","ő":"o","ǒ":"o","ȍ":"o","ȏ":"o","ơ":"o","ờ":"o","ớ":"o","ỡ":"o","ở":"o","ợ":"o","ọ":"o","ộ":"o","ǫ":"o","ǭ":"o","ø":"o","ǿ":"o","ɔ":"o","ꝋ":"o","ꝍ":"o","ɵ":"o","ƣ":"oi","ȣ":"ou","ꝏ":"oo","ⓟ":"p","ｐ":"p","ṕ":"p","ṗ":"p","ƥ":"p","ᵽ":"p","ꝑ":"p","ꝓ":"p","ꝕ":"p","ⓠ":"q","ｑ":"q","ɋ":"q","ꝗ":"q","ꝙ":"q","ⓡ":"r","ｒ":"r","ŕ":"r","ṙ":"r","ř":"r","ȑ":"r","ȓ":"r","ṛ":"r","ṝ":"r","ŗ":"r","ṟ":"r","ɍ":"r","ɽ":"r","ꝛ":"r","ꞧ":"r","ꞃ":"r","ⓢ":"s","ｓ":"s","ß":"s","ś":"s","ṥ":"s","ŝ":"s","ṡ":"s","š":"s","ṧ":"s","ṣ":"s","ṩ":"s","ș":"s","ş":"s","ȿ":"s","ꞩ":"s","ꞅ":"s","ẛ":"s","ⓣ":"t","ｔ":"t","ṫ":"t","ẗ":"t","ť":"t","ṭ":"t","ț":"t","ţ":"t","ṱ":"t","ṯ":"t","ŧ":"t","ƭ":"t","ʈ":"t","ⱦ":"t","ꞇ":"t","ꜩ":"tz","ⓤ":"u","ｕ":"u","ù":"u","ú":"u","û":"u","ũ":"u","ṹ":"u","ū":"u","ṻ":"u","ŭ":"u","ü":"u","ǜ":"u","ǘ":"u","ǖ":"u","ǚ":"u","ủ":"u","ů":"u","ű":"u","ǔ":"u","ȕ":"u","ȗ":"u","ư":"u","ừ":"u","ứ":"u","ữ":"u","ử":"u","ự":"u","ụ":"u","ṳ":"u","ų":"u","ṷ":"u","ṵ":"u","ʉ":"u","ⓥ":"v","ｖ":"v","ṽ":"v","ṿ":"v","ʋ":"v","ꝟ":"v","ʌ":"v","ꝡ":"vy","ⓦ":"w","ｗ":"w","ẁ":"w","ẃ":"w","ŵ":"w","ẇ":"w","ẅ":"w","ẘ":"w","ẉ":"w","ⱳ":"w","ⓧ":"x","ｘ":"x","ẋ":"x","ẍ":"x","ⓨ":"y","ｙ":"y","ỳ":"y","ý":"y","ŷ":"y","ỹ":"y","ȳ":"y","ẏ":"y","ÿ":"y","ỷ":"y","ẙ":"y","ỵ":"y","ƴ":"y","ɏ":"y","ỿ":"y","ⓩ":"z","ｚ":"z","ź":"z","ẑ":"z","ż":"z","ž":"z","ẓ":"z","ẕ":"z","ƶ":"z","ȥ":"z","ɀ":"z","ⱬ":"z","ꝣ":"z","Ά":"Α","Έ":"Ε","Ή":"Η","Ί":"Ι","Ϊ":"Ι","Ό":"Ο","Ύ":"Υ","Ϋ":"Υ","Ώ":"Ω","ά":"α","έ":"ε","ή":"η","ί":"ι","ϊ":"ι","ΐ":"ι","ό":"ο","ύ":"υ","ϋ":"υ","ΰ":"υ","ω":"ω","ς":"σ"};return a}),b.define("select2/data/base",["../utils"],function(a){function b(){b.__super__.constructor.call(this)}return a.Extend(b,a.Observable),b.prototype.current=function(){throw new Error("The `current` method must be defined in child classes.")},b.prototype.query=function(){throw new Error("The `query` method must be defined in child classes.")},b.prototype.bind=function(){},b.prototype.destroy=function(){},b.prototype.generateResultId=function(b,c){var d=b.id+"-result-";return d+=a.generateChars(4),d+=null!=c.id?"-"+c.id.toString():"-"+a.generateChars(4)},b}),b.define("select2/data/select",["./base","../utils","jquery"],function(a,b,c){function d(a,b){this.$element=a,this.options=b,d.__super__.constructor.call(this)}return b.Extend(d,a),d.prototype.current=function(a){var b=[],d=this;this.$element.find(":selected").each(function(){var a=c(this),e=d.item(a);b.push(e)}),a(b)},d.prototype.select=function(a){var b=this;if(a.selected=!0,c(a.element).is("option"))return a.element.selected=!0,void this.$element.trigger("change");if(this.$element.prop("multiple"))this.current(function(d){var e=[];a=[a],a.push.apply(a,d);for(var f=0;f<a.length;f++){var g=a[f].id;-1===c.inArray(g,e)&&e.push(g)}b.$element.val(e),b.$element.trigger("change")});else{var d=a.id;this.$element.val(d),this.$element.trigger("change")}},d.prototype.unselect=function(a){var b=this;if(this.$element.prop("multiple"))return a.selected=!1,c(a.element).is("option")?(a.element.selected=!1,void this.$element.trigger("change")):void this.current(function(d){for(var e=[],f=0;f<d.length;f++){var g=d[f].id;g!==a.id&&-1===c.inArray(g,e)&&e.push(g)}b.$element.val(e),b.$element.trigger("change")})},d.prototype.bind=function(a){var b=this;this.container=a,a.on("select",function(a){b.select(a.data)}),a.on("unselect",function(a){b.unselect(a.data)})},d.prototype.destroy=function(){this.$element.find("*").each(function(){c.removeData(this,"data")})},d.prototype.query=function(a,b){var d=[],e=this,f=this.$element.children();f.each(function(){var b=c(this);if(b.is("option")||b.is("optgroup")){var f=e.item(b),g=e.matches(a,f);null!==g&&d.push(g)}}),b({results:d})},d.prototype.addOptions=function(a){b.appendMany(this.$element,a)},d.prototype.option=function(a){var b;a.children?(b=document.createElement("optgroup"),b.label=a.text):(b=document.createElement("option"),void 0!==b.textContent?b.textContent=a.text:b.innerText=a.text),a.id&&(b.value=a.id),a.disabled&&(b.disabled=!0),a.selected&&(b.selected=!0),a.title&&(b.title=a.title);var d=c(b),e=this._normalizeItem(a);return e.element=b,c.data(b,"data",e),d},d.prototype.item=function(a){var b={};
if(b=c.data(a[0],"data"),null!=b)return b;if(a.is("option"))b={id:a.val(),text:a.text(),disabled:a.prop("disabled"),selected:a.prop("selected"),title:a.prop("title")};else if(a.is("optgroup")){b={text:a.prop("label"),children:[],title:a.prop("title")};for(var d=a.children("option"),e=[],f=0;f<d.length;f++){var g=c(d[f]),h=this.item(g);e.push(h)}b.children=e}return b=this._normalizeItem(b),b.element=a[0],c.data(a[0],"data",b),b},d.prototype._normalizeItem=function(a){c.isPlainObject(a)||(a={id:a,text:a}),a=c.extend({},{text:""},a);var b={selected:!1,disabled:!1};return null!=a.id&&(a.id=a.id.toString()),null!=a.text&&(a.text=a.text.toString()),null==a._resultId&&a.id&&null!=this.container&&(a._resultId=this.generateResultId(this.container,a)),c.extend({},b,a)},d.prototype.matches=function(a,b){var c=this.options.get("matcher");return c(a,b)},d}),b.define("select2/data/array",["./select","../utils","jquery"],function(a,b,c){function d(a,b){var c=b.get("data")||[];d.__super__.constructor.call(this,a,b),this.addOptions(this.convertToOptions(c))}return b.Extend(d,a),d.prototype.select=function(a){var b=this.$element.find("option").filter(function(b,c){return c.value==a.id.toString()});0===b.length&&(b=this.option(a),this.addOptions(b)),d.__super__.select.call(this,a)},d.prototype.convertToOptions=function(a){function d(a){return function(){return c(this).val()==a.id}}for(var e=this,f=this.$element.find("option"),g=f.map(function(){return e.item(c(this)).id}).get(),h=[],i=0;i<a.length;i++){var j=this._normalizeItem(a[i]);if(c.inArray(j.id,g)>=0){var k=f.filter(d(j)),l=this.item(k),m=(c.extend(!0,{},l,j),this.option(l));k.replaceWith(m)}else{var n=this.option(j);if(j.children){var o=this.convertToOptions(j.children);b.appendMany(n,o)}h.push(n)}}return h},d}),b.define("select2/data/ajax",["./array","../utils","jquery"],function(a,b,c){function d(b,c){this.ajaxOptions=this._applyDefaults(c.get("ajax")),null!=this.ajaxOptions.processResults&&(this.processResults=this.ajaxOptions.processResults),a.__super__.constructor.call(this,b,c)}return b.Extend(d,a),d.prototype._applyDefaults=function(a){var b={data:function(a){return{q:a.term}},transport:function(a,b,d){var e=c.ajax(a);return e.then(b),e.fail(d),e}};return c.extend({},b,a,!0)},d.prototype.processResults=function(a){return a},d.prototype.query=function(a,b){function d(){var d=f.transport(f,function(d){var f=e.processResults(d,a);e.options.get("debug")&&window.console&&console.error&&(f&&f.results&&c.isArray(f.results)||console.error("Select2: The AJAX results did not return an array in the `results` key of the response.")),b(f)},function(){});e._request=d}var e=this;null!=this._request&&(c.isFunction(this._request.abort)&&this._request.abort(),this._request=null);var f=c.extend({type:"GET"},this.ajaxOptions);"function"==typeof f.url&&(f.url=f.url(a)),"function"==typeof f.data&&(f.data=f.data(a)),this.ajaxOptions.delay&&""!==a.term?(this._queryTimeout&&window.clearTimeout(this._queryTimeout),this._queryTimeout=window.setTimeout(d,this.ajaxOptions.delay)):d()},d}),b.define("select2/data/tags",["jquery"],function(a){function b(b,c,d){var e=d.get("tags"),f=d.get("createTag");if(void 0!==f&&(this.createTag=f),b.call(this,c,d),a.isArray(e))for(var g=0;g<e.length;g++){var h=e[g],i=this._normalizeItem(h),j=this.option(i);this.$element.append(j)}}return b.prototype.query=function(a,b,c){function d(a,f){for(var g=a.results,h=0;h<g.length;h++){var i=g[h],j=null!=i.children&&!d({results:i.children},!0),k=i.text===b.term;if(k||j)return f?!1:(a.data=g,void c(a))}if(f)return!0;var l=e.createTag(b);if(null!=l){var m=e.option(l);m.attr("data-select2-tag",!0),e.addOptions([m]),e.insertTag(g,l)}a.results=g,c(a)}var e=this;return this._removeOldTags(),null==b.term||null!=b.page?void a.call(this,b,c):void a.call(this,b,d)},b.prototype.createTag=function(b,c){var d=a.trim(c.term);return""===d?null:{id:d,text:d}},b.prototype.insertTag=function(a,b,c){b.unshift(c)},b.prototype._removeOldTags=function(){var b=(this._lastTag,this.$element.find("option[data-select2-tag]"));b.each(function(){this.selected||a(this).remove()})},b}),b.define("select2/data/tokenizer",["jquery"],function(a){function b(a,b,c){var d=c.get("tokenizer");void 0!==d&&(this.tokenizer=d),a.call(this,b,c)}return b.prototype.bind=function(a,b,c){a.call(this,b,c),this.$search=b.dropdown.$search||b.selection.$search||c.find(".select2-search__field")},b.prototype.query=function(a,b,c){function d(a){e.select(a)}var e=this;b.term=b.term||"";var f=this.tokenizer(b,this.options,d);f.term!==b.term&&(this.$search.length&&(this.$search.val(f.term),this.$search.focus()),b.term=f.term),a.call(this,b,c)},b.prototype.tokenizer=function(b,c,d,e){for(var f=d.get("tokenSeparators")||[],g=c.term,h=0,i=this.createTag||function(a){return{id:a.term,text:a.term}};h<g.length;){var j=g[h];if(-1!==a.inArray(j,f)){var k=g.substr(0,h),l=a.extend({},c,{term:k}),m=i(l);e(m),g=g.substr(h+1)||"",h=0}else h++}return{term:g}},b}),b.define("select2/data/minimumInputLength",[],function(){function a(a,b,c){this.minimumInputLength=c.get("minimumInputLength"),a.call(this,b,c)}return a.prototype.query=function(a,b,c){return b.term=b.term||"",b.term.length<this.minimumInputLength?void this.trigger("results:message",{message:"inputTooShort",args:{minimum:this.minimumInputLength,input:b.term,params:b}}):void a.call(this,b,c)},a}),b.define("select2/data/maximumInputLength",[],function(){function a(a,b,c){this.maximumInputLength=c.get("maximumInputLength"),a.call(this,b,c)}return a.prototype.query=function(a,b,c){return b.term=b.term||"",this.maximumInputLength>0&&b.term.length>this.maximumInputLength?void this.trigger("results:message",{message:"inputTooLong",args:{maximum:this.maximumInputLength,input:b.term,params:b}}):void a.call(this,b,c)},a}),b.define("select2/data/maximumSelectionLength",[],function(){function a(a,b,c){this.maximumSelectionLength=c.get("maximumSelectionLength"),a.call(this,b,c)}return a.prototype.query=function(a,b,c){var d=this;this.current(function(e){var f=null!=e?e.length:0;return d.maximumSelectionLength>0&&f>=d.maximumSelectionLength?void d.trigger("results:message",{message:"maximumSelected",args:{maximum:d.maximumSelectionLength}}):void a.call(d,b,c)})},a}),b.define("select2/dropdown",["jquery","./utils"],function(a,b){function c(a,b){this.$element=a,this.options=b,c.__super__.constructor.call(this)}return b.Extend(c,b.Observable),c.prototype.render=function(){var b=a('<span class="select2-dropdown"><span class="select2-results"></span></span>');return b.attr("dir",this.options.get("dir")),this.$dropdown=b,b},c.prototype.position=function(){},c.prototype.destroy=function(){this.$dropdown.remove()},c}),b.define("select2/dropdown/search",["jquery","../utils"],function(a){function b(){}return b.prototype.render=function(b){var c=b.call(this),d=a('<span class="select2-search select2-search--dropdown"><input class="select2-search__field" type="search" tabindex="-1" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" role="textbox" /></span>');return this.$searchContainer=d,this.$search=d.find("input"),c.prepend(d),c},b.prototype.bind=function(b,c,d){var e=this;b.call(this,c,d),this.$search.on("keydown",function(a){e.trigger("keypress",a),e._keyUpPrevented=a.isDefaultPrevented()}),this.$search.on("input",function(){a(this).off("keyup")}),this.$search.on("keyup input",function(a){e.handleSearch(a)}),c.on("open",function(){e.$search.attr("tabindex",0),e.$search.focus(),window.setTimeout(function(){e.$search.focus()},0)}),c.on("close",function(){e.$search.attr("tabindex",-1),e.$search.val("")}),c.on("results:all",function(a){if(null==a.query.term||""===a.query.term){var b=e.showSearch(a);b?e.$searchContainer.removeClass("select2-search--hide"):e.$searchContainer.addClass("select2-search--hide")}})},b.prototype.handleSearch=function(){if(!this._keyUpPrevented){var a=this.$search.val();this.trigger("query",{term:a})}this._keyUpPrevented=!1},b.prototype.showSearch=function(){return!0},b}),b.define("select2/dropdown/hidePlaceholder",[],function(){function a(a,b,c,d){this.placeholder=this.normalizePlaceholder(c.get("placeholder")),a.call(this,b,c,d)}return a.prototype.append=function(a,b){b.results=this.removePlaceholder(b.results),a.call(this,b)},a.prototype.normalizePlaceholder=function(a,b){return"string"==typeof b&&(b={id:"",text:b}),b},a.prototype.removePlaceholder=function(a,b){for(var c=b.slice(0),d=b.length-1;d>=0;d--){var e=b[d];this.placeholder.id===e.id&&c.splice(d,1)}return c},a}),b.define("select2/dropdown/infiniteScroll",["jquery"],function(a){function b(a,b,c,d){this.lastParams={},a.call(this,b,c,d),this.$loadingMore=this.createLoadingMore(),this.loading=!1}return b.prototype.append=function(a,b){this.$loadingMore.remove(),this.loading=!1,a.call(this,b),this.showLoadingMore(b)&&this.$results.append(this.$loadingMore)},b.prototype.bind=function(b,c,d){var e=this;b.call(this,c,d),c.on("query",function(a){e.lastParams=a,e.loading=!0}),c.on("query:append",function(a){e.lastParams=a,e.loading=!0}),this.$results.on("scroll",function(){var b=a.contains(document.documentElement,e.$loadingMore[0]);if(!e.loading&&b){var c=e.$results.offset().top+e.$results.outerHeight(!1),d=e.$loadingMore.offset().top+e.$loadingMore.outerHeight(!1);c+50>=d&&e.loadMore()}})},b.prototype.loadMore=function(){this.loading=!0;var b=a.extend({},{page:1},this.lastParams);b.page++,this.trigger("query:append",b)},b.prototype.showLoadingMore=function(a,b){return b.pagination&&b.pagination.more},b.prototype.createLoadingMore=function(){var b=a('<li class="option load-more" role="treeitem"></li>'),c=this.options.get("translations").get("loadingMore");return b.html(c(this.lastParams)),b},b}),b.define("select2/dropdown/attachBody",["jquery","../utils"],function(a,b){function c(a,b,c){this.$dropdownParent=c.get("dropdownParent")||document.body,a.call(this,b,c)}return c.prototype.bind=function(a,b,c){var d=this,e=!1;a.call(this,b,c),b.on("open",function(){d._showDropdown(),d._attachPositioningHandler(b),e||(e=!0,b.on("results:all",function(){d._positionDropdown(),d._resizeDropdown()}),b.on("results:append",function(){d._positionDropdown(),d._resizeDropdown()}))}),b.on("close",function(){d._hideDropdown(),d._detachPositioningHandler(b)}),this.$dropdownContainer.on("mousedown",function(a){a.stopPropagation()})},c.prototype.position=function(a,b,c){b.attr("class",c.attr("class")),b.removeClass("select2"),b.addClass("select2-container--open"),b.css({position:"absolute",top:-999999}),this.$container=c},c.prototype.render=function(b){var c=a("<span></span>"),d=b.call(this);return c.append(d),this.$dropdownContainer=c,c},c.prototype._hideDropdown=function(){this.$dropdownContainer.detach()},c.prototype._attachPositioningHandler=function(c){var d=this,e="scroll.select2."+c.id,f="resize.select2."+c.id,g="orientationchange.select2."+c.id,h=this.$container.parents().filter(b.hasScroll);h.each(function(){a(this).data("select2-scroll-position",{x:a(this).scrollLeft(),y:a(this).scrollTop()})}),h.on(e,function(){var b=a(this).data("select2-scroll-position");a(this).scrollTop(b.y)}),a(window).on(e+" "+f+" "+g,function(){d._positionDropdown(),d._resizeDropdown()})},c.prototype._detachPositioningHandler=function(c){var d="scroll.select2."+c.id,e="resize.select2."+c.id,f="orientationchange.select2."+c.id,g=this.$container.parents().filter(b.hasScroll);g.off(d),a(window).off(d+" "+e+" "+f)},c.prototype._positionDropdown=function(){var b=a(window),c=this.$dropdown.hasClass("select2-dropdown--above"),d=this.$dropdown.hasClass("select2-dropdown--below"),e=null,f=(this.$container.position(),this.$container.offset());f.bottom=f.top+this.$container.outerHeight(!1);var g={height:this.$container.outerHeight(!1)};g.top=f.top,g.bottom=f.top+g.height;var h={height:this.$dropdown.outerHeight(!1)},i={top:b.scrollTop(),bottom:b.scrollTop()+b.height()},j=i.top<f.top-h.height,k=i.bottom>f.bottom+h.height,l={left:f.left,top:g.bottom};c||d||(e="below"),k||!j||c?!j&&k&&c&&(e="below"):e="above",("above"==e||c&&"below"!==e)&&(l.top=g.top-h.height),null!=e&&(this.$dropdown.removeClass("select2-dropdown--below select2-dropdown--above").addClass("select2-dropdown--"+e),this.$container.removeClass("select2-container--below select2-container--above").addClass("select2-container--"+e)),this.$dropdownContainer.css(l)},c.prototype._resizeDropdown=function(){this.$dropdownContainer.width();var a={width:this.$container.outerWidth(!1)+"px"};this.options.get("dropdownAutoWidth")&&(a.minWidth=a.width,a.width="auto"),this.$dropdown.css(a)},c.prototype._showDropdown=function(){this.$dropdownContainer.appendTo(this.$dropdownParent),this._positionDropdown(),this._resizeDropdown()},c}),b.define("select2/dropdown/minimumResultsForSearch",[],function(){function a(b){for(var c=0,d=0;d<b.length;d++){var e=b[d];e.children?c+=a(e.children):c++}return c}function b(a,b,c,d){this.minimumResultsForSearch=c.get("minimumResultsForSearch"),this.minimumResultsForSearch<0&&(this.minimumResultsForSearch=1/0),a.call(this,b,c,d)}return b.prototype.showSearch=function(b,c){return a(c.data.results)<this.minimumResultsForSearch?!1:b.call(this,c)},b}),b.define("select2/dropdown/selectOnClose",[],function(){function a(){}return a.prototype.bind=function(a,b,c){var d=this;a.call(this,b,c),b.on("close",function(){d._handleSelectOnClose()})},a.prototype._handleSelectOnClose=function(){var a=this.getHighlightedResults();a.length<1||this.trigger("select",{data:a.data("data")})},a}),b.define("select2/dropdown/closeOnSelect",[],function(){function a(){}return a.prototype.bind=function(a,b,c){var d=this;a.call(this,b,c),b.on("select",function(a){d._selectTriggered(a)}),b.on("unselect",function(a){d._selectTriggered(a)})},a.prototype._selectTriggered=function(a,b){var c=b.originalEvent;c&&c.ctrlKey||this.trigger("close")},a}),b.define("select2/i18n/en",[],function(){return{errorLoading:function(){return"The results could not be loaded."},inputTooLong:function(a){var b=a.input.length-a.maximum,c="Please delete "+b+" character";return 1!=b&&(c+="s"),c},inputTooShort:function(a){var b=a.minimum-a.input.length,c="Please enter "+b+" or more characters";return c},loadingMore:function(){return"Loading more results…"},maximumSelected:function(a){var b="You can only select "+a.maximum+" item";return 1!=a.maximum&&(b+="s"),b},noResults:function(){return"No results found"},searching:function(){return"Searching…"}}}),b.define("select2/defaults",["jquery","require","./results","./selection/single","./selection/multiple","./selection/placeholder","./selection/allowClear","./selection/search","./selection/eventRelay","./utils","./translation","./diacritics","./data/select","./data/array","./data/ajax","./data/tags","./data/tokenizer","./data/minimumInputLength","./data/maximumInputLength","./data/maximumSelectionLength","./dropdown","./dropdown/search","./dropdown/hidePlaceholder","./dropdown/infiniteScroll","./dropdown/attachBody","./dropdown/minimumResultsForSearch","./dropdown/selectOnClose","./dropdown/closeOnSelect","./i18n/en"],function(a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z,A,B,C){function D(){this.reset()}D.prototype.apply=function(l){if(l=a.extend({},this.defaults,l),null==l.dataAdapter){if(l.dataAdapter=null!=l.ajax?o:null!=l.data?n:m,l.minimumInputLength>0&&(l.dataAdapter=j.Decorate(l.dataAdapter,r)),l.maximumInputLength>0&&(l.dataAdapter=j.Decorate(l.dataAdapter,s)),l.maximumSelectionLength>0&&(l.dataAdapter=j.Decorate(l.dataAdapter,t)),l.tags&&(l.dataAdapter=j.Decorate(l.dataAdapter,p)),(null!=l.tokenSeparators||null!=l.tokenizer)&&(l.dataAdapter=j.Decorate(l.dataAdapter,q)),null!=l.query){var C=b(l.amdBase+"compat/query");l.dataAdapter=j.Decorate(l.dataAdapter,C)}if(null!=l.initSelection){var D=b(l.amdBase+"compat/initSelection");l.dataAdapter=j.Decorate(l.dataAdapter,D)}}if(null==l.resultsAdapter&&(l.resultsAdapter=c,null!=l.ajax&&(l.resultsAdapter=j.Decorate(l.resultsAdapter,x)),null!=l.placeholder&&(l.resultsAdapter=j.Decorate(l.resultsAdapter,w)),l.selectOnClose&&(l.resultsAdapter=j.Decorate(l.resultsAdapter,A))),null==l.dropdownAdapter){if(l.multiple)l.dropdownAdapter=u;else{var E=j.Decorate(u,v);l.dropdownAdapter=E}if(0!==l.minimumResultsForSearch&&(l.dropdownAdapter=j.Decorate(l.dropdownAdapter,z)),l.closeOnSelect&&(l.dropdownAdapter=j.Decorate(l.dropdownAdapter,B)),null!=l.dropdownCssClass||null!=l.dropdownCss||null!=l.adaptDropdownCssClass){var F=b(l.amdBase+"compat/dropdownCss");l.dropdownAdapter=j.Decorate(l.dropdownAdapter,F)}l.dropdownAdapter=j.Decorate(l.dropdownAdapter,y)}if(null==l.selectionAdapter){if(l.selectionAdapter=l.multiple?e:d,null!=l.placeholder&&(l.selectionAdapter=j.Decorate(l.selectionAdapter,f)),l.allowClear&&(l.selectionAdapter=j.Decorate(l.selectionAdapter,g)),l.multiple&&(l.selectionAdapter=j.Decorate(l.selectionAdapter,h)),null!=l.containerCssClass||null!=l.containerCss||null!=l.adaptContainerCssClass){var G=b(l.amdBase+"compat/containerCss");l.selectionAdapter=j.Decorate(l.selectionAdapter,G)}l.selectionAdapter=j.Decorate(l.selectionAdapter,i)}if("string"==typeof l.language)if(l.language.indexOf("-")>0){var H=l.language.split("-"),I=H[0];l.language=[l.language,I]}else l.language=[l.language];if(a.isArray(l.language)){var J=new k;l.language.push("en");for(var K=l.language,L=0;L<K.length;L++){var M=K[L],N={};try{N=k.loadPath(M)}catch(O){try{M=this.defaults.amdLanguageBase+M,N=k.loadPath(M)}catch(P){l.debug&&window.console&&console.warn&&console.warn('Select2: The language file for "'+M+'" could not be automatically loaded. A fallback will be used instead.');continue}}J.extend(N)}l.translations=J}else{var Q=k.loadPath(this.defaults.amdLanguageBase+"en"),R=new k(l.language);R.extend(Q),l.translations=R}return l},D.prototype.reset=function(){function b(a){function b(a){return l[a]||a}return a.replace(/[^\u0000-\u007E]/g,b)}function c(d,e){if(""===a.trim(d.term))return e;if(e.children&&e.children.length>0){for(var f=a.extend(!0,{},e),g=e.children.length-1;g>=0;g--){var h=e.children[g],i=c(d,h);null==i&&f.children.splice(g,1)}return f.children.length>0?f:c(d,f)}var j=b(e.text).toUpperCase(),k=b(d.term).toUpperCase();return j.indexOf(k)>-1?e:null}this.defaults={amdBase:"./",amdLanguageBase:"./i18n/",closeOnSelect:!0,debug:!1,dropdownAutoWidth:!1,escapeMarkup:j.escapeMarkup,language:C,matcher:c,minimumInputLength:0,maximumInputLength:0,maximumSelectionLength:0,minimumResultsForSearch:0,selectOnClose:!1,sorter:function(a){return a},templateResult:function(a){return a.text},templateSelection:function(a){return a.text},theme:"default",width:"resolve"}},D.prototype.set=function(b,c){var d=a.camelCase(b),e={};e[d]=c;var f=j._convertData(e);a.extend(this.defaults,f)};var E=new D;return E}),b.define("select2/options",["require","jquery","./defaults","./utils"],function(a,b,c,d){function e(b,e){if(this.options=b,null!=e&&this.fromElement(e),this.options=c.apply(this.options),e&&e.is("input")){var f=a(this.get("amdBase")+"compat/inputData");this.options.dataAdapter=d.Decorate(this.options.dataAdapter,f)}}return e.prototype.fromElement=function(a){var c=["select2"];null==this.options.multiple&&(this.options.multiple=a.prop("multiple")),null==this.options.disabled&&(this.options.disabled=a.prop("disabled")),null==this.options.language&&(a.prop("lang")?this.options.language=a.prop("lang").toLowerCase():a.closest("[lang]").prop("lang")&&(this.options.language=a.closest("[lang]").prop("lang"))),null==this.options.dir&&(this.options.dir=a.prop("dir")?a.prop("dir"):a.closest("[dir]").prop("dir")?a.closest("[dir]").prop("dir"):"ltr"),a.prop("disabled",this.options.disabled),a.prop("multiple",this.options.multiple),a.data("select2Tags")&&(this.options.debug&&window.console&&console.warn&&console.warn('Select2: The `data-select2-tags` attribute has been changed to use the `data-data` and `data-tags="true"` attributes and will be removed in future versions of Select2.'),a.data("data",a.data("select2Tags")),a.data("tags",!0)),a.data("ajaxUrl")&&(this.options.debug&&window.console&&console.warn&&console.warn("Select2: The `data-ajax-url` attribute has been changed to `data-ajax--url` and support for the old attribute will be removed in future versions of Select2."),a.attr("ajax--url",a.data("ajaxUrl")),a.data("ajax--url",a.data("ajaxUrl")));var e={};e=b.fn.jquery&&"1."==b.fn.jquery.substr(0,2)&&a[0].dataset?b.extend(!0,{},a[0].dataset,a.data()):a.data();var f=b.extend(!0,{},e);f=d._convertData(f);for(var g in f)b.inArray(g,c)>-1||(b.isPlainObject(this.options[g])?b.extend(this.options[g],f[g]):this.options[g]=f[g]);return this},e.prototype.get=function(a){return this.options[a]},e.prototype.set=function(a,b){this.options[a]=b},e}),b.define("select2/core",["jquery","./options","./utils","./keys"],function(a,b,c,d){var e=function(a,c){null!=a.data("select2")&&a.data("select2").destroy(),this.$element=a,this.id=this._generateId(a),c=c||{},this.options=new b(c,a),e.__super__.constructor.call(this);var d=a.attr("tabindex")||0;a.data("old-tabindex",d),a.attr("tabindex","-1");var f=this.options.get("dataAdapter");this.dataAdapter=new f(a,this.options);var g=this.render();this._placeContainer(g);var h=this.options.get("selectionAdapter");this.selection=new h(a,this.options),this.$selection=this.selection.render(),this.selection.position(this.$selection,g);var i=this.options.get("dropdownAdapter");this.dropdown=new i(a,this.options),this.$dropdown=this.dropdown.render(),this.dropdown.position(this.$dropdown,g);var j=this.options.get("resultsAdapter");this.results=new j(a,this.options,this.dataAdapter),this.$results=this.results.render(),this.results.position(this.$results,this.$dropdown);var k=this;this._bindAdapters(),this._registerDomEvents(),this._registerDataEvents(),this._registerSelectionEvents(),this._registerDropdownEvents(),this._registerResultsEvents(),this._registerEvents(),this.dataAdapter.current(function(a){k.trigger("selection:update",{data:a})}),a.addClass("select2-hidden-accessible"),a.attr("aria-hidden","true"),this._syncAttributes(),a.data("select2",this)};return c.Extend(e,c.Observable),e.prototype._generateId=function(a){var b="";return b=null!=a.attr("id")?a.attr("id"):null!=a.attr("name")?a.attr("name")+"-"+c.generateChars(2):c.generateChars(4),b="select2-"+b},e.prototype._placeContainer=function(a){a.insertAfter(this.$element);var b=this._resolveWidth(this.$element,this.options.get("width"));null!=b&&a.css("width",b)},e.prototype._resolveWidth=function(a,b){var c=/^width:(([-+]?([0-9]*\.)?[0-9]+)(px|em|ex|%|in|cm|mm|pt|pc))/i;if("resolve"==b){var d=this._resolveWidth(a,"style");return null!=d?d:this._resolveWidth(a,"element")}if("element"==b){var e=a.outerWidth(!1);return 0>=e?"auto":e+"px"}if("style"==b){var f=a.attr("style");if("string"!=typeof f)return null;for(var g=f.split(";"),h=0,i=g.length;i>h;h+=1){var j=g[h].replace(/\s/g,""),k=j.match(c);if(null!==k&&k.length>=1)return k[1]}return null}return b},e.prototype._bindAdapters=function(){this.dataAdapter.bind(this,this.$container),this.selection.bind(this,this.$container),this.dropdown.bind(this,this.$container),this.results.bind(this,this.$container)},e.prototype._registerDomEvents=function(){var b=this;this.$element.on("change.select2",function(){b.dataAdapter.current(function(a){b.trigger("selection:update",{data:a})})}),this._sync=c.bind(this._syncAttributes,this),this.$element[0].attachEvent&&this.$element[0].attachEvent("onpropertychange",this._sync);var d=window.MutationObserver||window.WebKitMutationObserver||window.MozMutationObserver;null!=d?(this._observer=new d(function(c){a.each(c,b._sync)}),this._observer.observe(this.$element[0],{attributes:!0,subtree:!1})):this.$element[0].addEventListener&&this.$element[0].addEventListener("DOMAttrModified",b._sync,!1)},e.prototype._registerDataEvents=function(){var a=this;this.dataAdapter.on("*",function(b,c){a.trigger(b,c)})},e.prototype._registerSelectionEvents=function(){var b=this,c=["toggle"];this.selection.on("toggle",function(){b.toggleDropdown()}),this.selection.on("*",function(d,e){-1===a.inArray(d,c)&&b.trigger(d,e)})},e.prototype._registerDropdownEvents=function(){var a=this;this.dropdown.on("*",function(b,c){a.trigger(b,c)})},e.prototype._registerResultsEvents=function(){var a=this;this.results.on("*",function(b,c){a.trigger(b,c)})},e.prototype._registerEvents=function(){var a=this;this.on("open",function(){a.$container.addClass("select2-container--open")}),this.on("close",function(){a.$container.removeClass("select2-container--open")}),this.on("enable",function(){a.$container.removeClass("select2-container--disabled")}),this.on("disable",function(){a.$container.addClass("select2-container--disabled")}),this.on("focus",function(){a.$container.addClass("select2-container--focus")}),this.on("blur",function(){a.$container.removeClass("select2-container--focus")}),this.on("query",function(b){a.isOpen()||a.trigger("open"),this.dataAdapter.query(b,function(c){a.trigger("results:all",{data:c,query:b})})}),this.on("query:append",function(b){this.dataAdapter.query(b,function(c){a.trigger("results:append",{data:c,query:b})})}),this.on("keypress",function(b){var c=b.which;a.isOpen()?c===d.ENTER?(a.trigger("results:select"),b.preventDefault()):c===d.SPACE&&b.ctrlKey?(a.trigger("results:toggle"),b.preventDefault()):c===d.UP?(a.trigger("results:previous"),b.preventDefault()):c===d.DOWN?(a.trigger("results:next"),b.preventDefault()):(c===d.ESC||c===d.TAB)&&(a.close(),b.preventDefault()):(c===d.ENTER||c===d.SPACE||(c===d.DOWN||c===d.UP)&&b.altKey)&&(a.open(),b.preventDefault())})},e.prototype._syncAttributes=function(){this.options.set("disabled",this.$element.prop("disabled")),this.options.get("disabled")?(this.isOpen()&&this.close(),this.trigger("disable")):this.trigger("enable")},e.prototype.trigger=function(a,b){var c=e.__super__.trigger,d={open:"opening",close:"closing",select:"selecting",unselect:"unselecting"};if(a in d){var f=d[a],g={prevented:!1,name:a,args:b};if(c.call(this,f,g),g.prevented)return void(b.prevented=!0)}c.call(this,a,b)},e.prototype.toggleDropdown=function(){this.options.get("disabled")||(this.isOpen()?this.close():this.open())},e.prototype.open=function(){this.isOpen()||(this.trigger("query",{}),this.trigger("open"))},e.prototype.close=function(){this.isOpen()&&this.trigger("close")},e.prototype.isOpen=function(){return this.$container.hasClass("select2-container--open")},e.prototype.enable=function(a){this.options.get("debug")&&window.console&&console.warn&&console.warn('Select2: The `select2("enable")` method has been deprecated and will be removed in later Select2 versions. Use $element.prop("disabled") instead.'),(null==a||0===a.length)&&(a=[!0]);var b=!a[0];this.$element.prop("disabled",b)},e.prototype.data=function(){this.options.get("debug")&&arguments.length>0&&window.console&&console.warn&&console.warn('Select2: Data can no longer be set using `select2("data")`. You should consider setting the value instead using `$element.val()`.');var a=[];return this.dataAdapter.current(function(b){a=b}),a},e.prototype.val=function(b){if(this.options.get("debug")&&window.console&&console.warn&&console.warn('Select2: The `select2("val")` method has been deprecated and will be removed in later Select2 versions. Use $element.val() instead.'),null==b||0===b.length)return this.$element.val();var c=b[0];a.isArray(c)&&(c=a.map(c,function(a){return a.toString()})),this.$element.val(c).trigger("change")},e.prototype.destroy=function(){this.$container.remove(),this.$element[0].detachEvent&&this.$element[0].detachEvent("onpropertychange",this._sync),null!=this._observer?(this._observer.disconnect(),this._observer=null):this.$element[0].removeEventListener&&this.$element[0].removeEventListener("DOMAttrModified",this._sync,!1),this._sync=null,this.$element.off(".select2"),this.$element.attr("tabindex",this.$element.data("old-tabindex")),this.$element.removeClass("select2-hidden-accessible"),this.$element.attr("aria-hidden","false"),this.$element.removeData("select2"),this.dataAdapter.destroy(),this.selection.destroy(),this.dropdown.destroy(),this.results.destroy(),this.dataAdapter=null,this.selection=null,this.dropdown=null,this.results=null},e.prototype.render=function(){var b=a('<span class="select2 select2-container"><span class="selection"></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>');return b.attr("dir",this.options.get("dir")),this.$container=b,this.$container.addClass("select2-container--"+this.options.get("theme")),b.data("element",this.$element),b},e}),b.define("jquery.select2",["jquery","require","./select2/core","./select2/defaults"],function(a,b,c,d){if(b("jquery.mousewheel"),null==a.fn.select2){var e=["open","close","destroy"];a.fn.select2=function(b){if(b=b||{},"object"==typeof b)return this.each(function(){{var d=a.extend({},b,!0);new c(a(this),d)}}),this;if("string"==typeof b){var d=this.data("select2");null==d&&window.console&&console.error&&console.error("The select2('"+b+"') method was called on an element that is not using Select2.");var f=Array.prototype.slice.call(arguments,1),g=d[b](f);return a.inArray(b,e)>-1?this:g}throw new Error("Invalid arguments for Select2: "+b)}}return null==a.fn.select2.defaults&&(a.fn.select2.defaults=d),c}),b.define("jquery.mousewheel",["jquery"],function(a){return a}),{define:b.define,require:b.require}}(),c=b.require("jquery.select2");return a.fn.select2.amd=b,c});
/*
     _ _      _       _
 ___| (_) ___| | __  (_)___
/ __| | |/ __| |/ /  | / __|
\__ \ | | (__|   < _ | \__ \
|___/_|_|\___|_|\_(_)/ |___/
                   |__/

 Version: 1.6.0
  Author: Ken Wheeler
 Website: http://kenwheeler.github.io
    Docs: http://kenwheeler.github.io/slick
    Repo: http://github.com/kenwheeler/slick
  Issues: http://github.com/kenwheeler/slick/issues

 */
!function(a){"use strict";"function"==typeof define&&define.amd?define(["jquery"],a):"undefined"!=typeof exports?module.exports=a(require("jquery")):a(jQuery)}(function(a){"use strict";var b=window.Slick||{};b=function(){function c(c,d){var f,e=this;e.defaults={accessibility:!0,adaptiveHeight:!1,appendArrows:a(c),appendDots:a(c),arrows:!0,asNavFor:null,prevArrow:'<button type="button" data-role="none" class="slick-prev" aria-label="Previous" tabindex="0" role="button">Previous</button>',nextArrow:'<button type="button" data-role="none" class="slick-next" aria-label="Next" tabindex="0" role="button">Next</button>',autoplay:!1,autoplaySpeed:3e3,centerMode:!1,centerPadding:"50px",cssEase:"ease",customPaging:function(b,c){return a('<button type="button" data-role="none" role="button" tabindex="0" />').text(c+1)},dots:!1,dotsClass:"slick-dots",draggable:!0,easing:"linear",edgeFriction:.35,fade:!1,focusOnSelect:!1,infinite:!0,initialSlide:0,lazyLoad:"ondemand",mobileFirst:!1,pauseOnHover:!0,pauseOnFocus:!0,pauseOnDotsHover:!1,respondTo:"window",responsive:null,rows:1,rtl:!1,slide:"",slidesPerRow:1,slidesToShow:1,slidesToScroll:1,speed:500,swipe:!0,swipeToSlide:!1,touchMove:!0,touchThreshold:5,useCSS:!0,useTransform:!0,variableWidth:!1,vertical:!1,verticalSwiping:!1,waitForAnimate:!0,zIndex:1e3},e.initials={animating:!1,dragging:!1,autoPlayTimer:null,currentDirection:0,currentLeft:null,currentSlide:0,direction:1,$dots:null,listWidth:null,listHeight:null,loadIndex:0,$nextArrow:null,$prevArrow:null,slideCount:null,slideWidth:null,$slideTrack:null,$slides:null,sliding:!1,slideOffset:0,swipeLeft:null,$list:null,touchObject:{},transformsEnabled:!1,unslicked:!1},a.extend(e,e.initials),e.activeBreakpoint=null,e.animType=null,e.animProp=null,e.breakpoints=[],e.breakpointSettings=[],e.cssTransitions=!1,e.focussed=!1,e.interrupted=!1,e.hidden="hidden",e.paused=!0,e.positionProp=null,e.respondTo=null,e.rowCount=1,e.shouldClick=!0,e.$slider=a(c),e.$slidesCache=null,e.transformType=null,e.transitionType=null,e.visibilityChange="visibilitychange",e.windowWidth=0,e.windowTimer=null,f=a(c).data("slick")||{},e.options=a.extend({},e.defaults,d,f),e.currentSlide=e.options.initialSlide,e.originalSettings=e.options,"undefined"!=typeof document.mozHidden?(e.hidden="mozHidden",e.visibilityChange="mozvisibilitychange"):"undefined"!=typeof document.webkitHidden&&(e.hidden="webkitHidden",e.visibilityChange="webkitvisibilitychange"),e.autoPlay=a.proxy(e.autoPlay,e),e.autoPlayClear=a.proxy(e.autoPlayClear,e),e.autoPlayIterator=a.proxy(e.autoPlayIterator,e),e.changeSlide=a.proxy(e.changeSlide,e),e.clickHandler=a.proxy(e.clickHandler,e),e.selectHandler=a.proxy(e.selectHandler,e),e.setPosition=a.proxy(e.setPosition,e),e.swipeHandler=a.proxy(e.swipeHandler,e),e.dragHandler=a.proxy(e.dragHandler,e),e.keyHandler=a.proxy(e.keyHandler,e),e.instanceUid=b++,e.htmlExpr=/^(?:\s*(<[\w\W]+>)[^>]*)$/,e.registerBreakpoints(),e.init(!0)}var b=0;return c}(),b.prototype.activateADA=function(){var a=this;a.$slideTrack.find(".slick-active").attr({"aria-hidden":"false"}).find("a, input, button, select").attr({tabindex:"0"})},b.prototype.addSlide=b.prototype.slickAdd=function(b,c,d){var e=this;if("boolean"==typeof c)d=c,c=null;else if(0>c||c>=e.slideCount)return!1;e.unload(),"number"==typeof c?0===c&&0===e.$slides.length?a(b).appendTo(e.$slideTrack):d?a(b).insertBefore(e.$slides.eq(c)):a(b).insertAfter(e.$slides.eq(c)):d===!0?a(b).prependTo(e.$slideTrack):a(b).appendTo(e.$slideTrack),e.$slides=e.$slideTrack.children(this.options.slide),e.$slideTrack.children(this.options.slide).detach(),e.$slideTrack.append(e.$slides),e.$slides.each(function(b,c){a(c).attr("data-slick-index",b)}),e.$slidesCache=e.$slides,e.reinit()},b.prototype.animateHeight=function(){var a=this;if(1===a.options.slidesToShow&&a.options.adaptiveHeight===!0&&a.options.vertical===!1){var b=a.$slides.eq(a.currentSlide).outerHeight(!0);a.$list.animate({height:b},a.options.speed)}},b.prototype.animateSlide=function(b,c){var d={},e=this;e.animateHeight(),e.options.rtl===!0&&e.options.vertical===!1&&(b=-b),e.transformsEnabled===!1?e.options.vertical===!1?e.$slideTrack.animate({left:b},e.options.speed,e.options.easing,c):e.$slideTrack.animate({top:b},e.options.speed,e.options.easing,c):e.cssTransitions===!1?(e.options.rtl===!0&&(e.currentLeft=-e.currentLeft),a({animStart:e.currentLeft}).animate({animStart:b},{duration:e.options.speed,easing:e.options.easing,step:function(a){a=Math.ceil(a),e.options.vertical===!1?(d[e.animType]="translate("+a+"px, 0px)",e.$slideTrack.css(d)):(d[e.animType]="translate(0px,"+a+"px)",e.$slideTrack.css(d))},complete:function(){c&&c.call()}})):(e.applyTransition(),b=Math.ceil(b),e.options.vertical===!1?d[e.animType]="translate3d("+b+"px, 0px, 0px)":d[e.animType]="translate3d(0px,"+b+"px, 0px)",e.$slideTrack.css(d),c&&setTimeout(function(){e.disableTransition(),c.call()},e.options.speed))},b.prototype.getNavTarget=function(){var b=this,c=b.options.asNavFor;return c&&null!==c&&(c=a(c).not(b.$slider)),c},b.prototype.asNavFor=function(b){var c=this,d=c.getNavTarget();null!==d&&"object"==typeof d&&d.each(function(){var c=a(this).slick("getSlick");c.unslicked||c.slideHandler(b,!0)})},b.prototype.applyTransition=function(a){var b=this,c={};b.options.fade===!1?c[b.transitionType]=b.transformType+" "+b.options.speed+"ms "+b.options.cssEase:c[b.transitionType]="opacity "+b.options.speed+"ms "+b.options.cssEase,b.options.fade===!1?b.$slideTrack.css(c):b.$slides.eq(a).css(c)},b.prototype.autoPlay=function(){var a=this;a.autoPlayClear(),a.slideCount>a.options.slidesToShow&&(a.autoPlayTimer=setInterval(a.autoPlayIterator,a.options.autoplaySpeed))},b.prototype.autoPlayClear=function(){var a=this;a.autoPlayTimer&&clearInterval(a.autoPlayTimer)},b.prototype.autoPlayIterator=function(){var a=this,b=a.currentSlide+a.options.slidesToScroll;a.paused||a.interrupted||a.focussed||(a.options.infinite===!1&&(1===a.direction&&a.currentSlide+1===a.slideCount-1?a.direction=0:0===a.direction&&(b=a.currentSlide-a.options.slidesToScroll,a.currentSlide-1===0&&(a.direction=1))),a.slideHandler(b))},b.prototype.buildArrows=function(){var b=this;b.options.arrows===!0&&(b.$prevArrow=a(b.options.prevArrow).addClass("slick-arrow"),b.$nextArrow=a(b.options.nextArrow).addClass("slick-arrow"),b.slideCount>b.options.slidesToShow?(b.$prevArrow.removeClass("slick-hidden").removeAttr("aria-hidden tabindex"),b.$nextArrow.removeClass("slick-hidden").removeAttr("aria-hidden tabindex"),b.htmlExpr.test(b.options.prevArrow)&&b.$prevArrow.prependTo(b.options.appendArrows),b.htmlExpr.test(b.options.nextArrow)&&b.$nextArrow.appendTo(b.options.appendArrows),b.options.infinite!==!0&&b.$prevArrow.addClass("slick-disabled").attr("aria-disabled","true")):b.$prevArrow.add(b.$nextArrow).addClass("slick-hidden").attr({"aria-disabled":"true",tabindex:"-1"}))},b.prototype.buildDots=function(){var c,d,b=this;if(b.options.dots===!0&&b.slideCount>b.options.slidesToShow){for(b.$slider.addClass("slick-dotted"),d=a("<ul />").addClass(b.options.dotsClass),c=0;c<=b.getDotCount();c+=1)d.append(a("<li />").append(b.options.customPaging.call(this,b,c)));b.$dots=d.appendTo(b.options.appendDots),b.$dots.find("li").first().addClass("slick-active").attr("aria-hidden","false")}},b.prototype.buildOut=function(){var b=this;b.$slides=b.$slider.children(b.options.slide+":not(.slick-cloned)").addClass("slick-slide"),b.slideCount=b.$slides.length,b.$slides.each(function(b,c){a(c).attr("data-slick-index",b).data("originalStyling",a(c).attr("style")||"")}),b.$slider.addClass("slick-slider"),b.$slideTrack=0===b.slideCount?a('<div class="slick-track"/>').appendTo(b.$slider):b.$slides.wrapAll('<div class="slick-track"/>').parent(),b.$list=b.$slideTrack.wrap('<div aria-live="polite" class="slick-list"/>').parent(),b.$slideTrack.css("opacity",0),(b.options.centerMode===!0||b.options.swipeToSlide===!0)&&(b.options.slidesToScroll=1),a("img[data-lazy]",b.$slider).not("[src]").addClass("slick-loading"),b.setupInfinite(),b.buildArrows(),b.buildDots(),b.updateDots(),b.setSlideClasses("number"==typeof b.currentSlide?b.currentSlide:0),b.options.draggable===!0&&b.$list.addClass("draggable")},b.prototype.buildRows=function(){var b,c,d,e,f,g,h,a=this;if(e=document.createDocumentFragment(),g=a.$slider.children(),a.options.rows>1){for(h=a.options.slidesPerRow*a.options.rows,f=Math.ceil(g.length/h),b=0;f>b;b++){var i=document.createElement("div");for(c=0;c<a.options.rows;c++){var j=document.createElement("div");for(d=0;d<a.options.slidesPerRow;d++){var k=b*h+(c*a.options.slidesPerRow+d);g.get(k)&&j.appendChild(g.get(k))}i.appendChild(j)}e.appendChild(i)}a.$slider.empty().append(e),a.$slider.children().children().children().css({width:100/a.options.slidesPerRow+"%",display:"inline-block"})}},b.prototype.checkResponsive=function(b,c){var e,f,g,d=this,h=!1,i=d.$slider.width(),j=window.innerWidth||a(window).width();if("window"===d.respondTo?g=j:"slider"===d.respondTo?g=i:"min"===d.respondTo&&(g=Math.min(j,i)),d.options.responsive&&d.options.responsive.length&&null!==d.options.responsive){f=null;for(e in d.breakpoints)d.breakpoints.hasOwnProperty(e)&&(d.originalSettings.mobileFirst===!1?g<d.breakpoints[e]&&(f=d.breakpoints[e]):g>d.breakpoints[e]&&(f=d.breakpoints[e]));null!==f?null!==d.activeBreakpoint?(f!==d.activeBreakpoint||c)&&(d.activeBreakpoint=f,"unslick"===d.breakpointSettings[f]?d.unslick(f):(d.options=a.extend({},d.originalSettings,d.breakpointSettings[f]),b===!0&&(d.currentSlide=d.options.initialSlide),d.refresh(b)),h=f):(d.activeBreakpoint=f,"unslick"===d.breakpointSettings[f]?d.unslick(f):(d.options=a.extend({},d.originalSettings,d.breakpointSettings[f]),b===!0&&(d.currentSlide=d.options.initialSlide),d.refresh(b)),h=f):null!==d.activeBreakpoint&&(d.activeBreakpoint=null,d.options=d.originalSettings,b===!0&&(d.currentSlide=d.options.initialSlide),d.refresh(b),h=f),b||h===!1||d.$slider.trigger("breakpoint",[d,h])}},b.prototype.changeSlide=function(b,c){var f,g,h,d=this,e=a(b.currentTarget);switch(e.is("a")&&b.preventDefault(),e.is("li")||(e=e.closest("li")),h=d.slideCount%d.options.slidesToScroll!==0,f=h?0:(d.slideCount-d.currentSlide)%d.options.slidesToScroll,b.data.message){case"previous":g=0===f?d.options.slidesToScroll:d.options.slidesToShow-f,d.slideCount>d.options.slidesToShow&&d.slideHandler(d.currentSlide-g,!1,c);break;case"next":g=0===f?d.options.slidesToScroll:f,d.slideCount>d.options.slidesToShow&&d.slideHandler(d.currentSlide+g,!1,c);break;case"index":var i=0===b.data.index?0:b.data.index||e.index()*d.options.slidesToScroll;d.slideHandler(d.checkNavigable(i),!1,c),e.children().trigger("focus");break;default:return}},b.prototype.checkNavigable=function(a){var c,d,b=this;if(c=b.getNavigableIndexes(),d=0,a>c[c.length-1])a=c[c.length-1];else for(var e in c){if(a<c[e]){a=d;break}d=c[e]}return a},b.prototype.cleanUpEvents=function(){var b=this;b.options.dots&&null!==b.$dots&&a("li",b.$dots).off("click.slick",b.changeSlide).off("mouseenter.slick",a.proxy(b.interrupt,b,!0)).off("mouseleave.slick",a.proxy(b.interrupt,b,!1)),b.$slider.off("focus.slick blur.slick"),b.options.arrows===!0&&b.slideCount>b.options.slidesToShow&&(b.$prevArrow&&b.$prevArrow.off("click.slick",b.changeSlide),b.$nextArrow&&b.$nextArrow.off("click.slick",b.changeSlide)),b.$list.off("touchstart.slick mousedown.slick",b.swipeHandler),b.$list.off("touchmove.slick mousemove.slick",b.swipeHandler),b.$list.off("touchend.slick mouseup.slick",b.swipeHandler),b.$list.off("touchcancel.slick mouseleave.slick",b.swipeHandler),b.$list.off("click.slick",b.clickHandler),a(document).off(b.visibilityChange,b.visibility),b.cleanUpSlideEvents(),b.options.accessibility===!0&&b.$list.off("keydown.slick",b.keyHandler),b.options.focusOnSelect===!0&&a(b.$slideTrack).children().off("click.slick",b.selectHandler),a(window).off("orientationchange.slick.slick-"+b.instanceUid,b.orientationChange),a(window).off("resize.slick.slick-"+b.instanceUid,b.resize),a("[draggable!=true]",b.$slideTrack).off("dragstart",b.preventDefault),a(window).off("load.slick.slick-"+b.instanceUid,b.setPosition),a(document).off("ready.slick.slick-"+b.instanceUid,b.setPosition)},b.prototype.cleanUpSlideEvents=function(){var b=this;b.$list.off("mouseenter.slick",a.proxy(b.interrupt,b,!0)),b.$list.off("mouseleave.slick",a.proxy(b.interrupt,b,!1))},b.prototype.cleanUpRows=function(){var b,a=this;a.options.rows>1&&(b=a.$slides.children().children(),b.removeAttr("style"),a.$slider.empty().append(b))},b.prototype.clickHandler=function(a){var b=this;b.shouldClick===!1&&(a.stopImmediatePropagation(),a.stopPropagation(),a.preventDefault())},b.prototype.destroy=function(b){var c=this;c.autoPlayClear(),c.touchObject={},c.cleanUpEvents(),a(".slick-cloned",c.$slider).detach(),c.$dots&&c.$dots.remove(),c.$prevArrow&&c.$prevArrow.length&&(c.$prevArrow.removeClass("slick-disabled slick-arrow slick-hidden").removeAttr("aria-hidden aria-disabled tabindex").css("display",""),c.htmlExpr.test(c.options.prevArrow)&&c.$prevArrow.remove()),c.$nextArrow&&c.$nextArrow.length&&(c.$nextArrow.removeClass("slick-disabled slick-arrow slick-hidden").removeAttr("aria-hidden aria-disabled tabindex").css("display",""),c.htmlExpr.test(c.options.nextArrow)&&c.$nextArrow.remove()),c.$slides&&(c.$slides.removeClass("slick-slide slick-active slick-center slick-visible slick-current").removeAttr("aria-hidden").removeAttr("data-slick-index").each(function(){a(this).attr("style",a(this).data("originalStyling"))}),c.$slideTrack.children(this.options.slide).detach(),c.$slideTrack.detach(),c.$list.detach(),c.$slider.append(c.$slides)),c.cleanUpRows(),c.$slider.removeClass("slick-slider"),c.$slider.removeClass("slick-initialized"),c.$slider.removeClass("slick-dotted"),c.unslicked=!0,b||c.$slider.trigger("destroy",[c])},b.prototype.disableTransition=function(a){var b=this,c={};c[b.transitionType]="",b.options.fade===!1?b.$slideTrack.css(c):b.$slides.eq(a).css(c)},b.prototype.fadeSlide=function(a,b){var c=this;c.cssTransitions===!1?(c.$slides.eq(a).css({zIndex:c.options.zIndex}),c.$slides.eq(a).animate({opacity:1},c.options.speed,c.options.easing,b)):(c.applyTransition(a),c.$slides.eq(a).css({opacity:1,zIndex:c.options.zIndex}),b&&setTimeout(function(){c.disableTransition(a),b.call()},c.options.speed))},b.prototype.fadeSlideOut=function(a){var b=this;b.cssTransitions===!1?b.$slides.eq(a).animate({opacity:0,zIndex:b.options.zIndex-2},b.options.speed,b.options.easing):(b.applyTransition(a),b.$slides.eq(a).css({opacity:0,zIndex:b.options.zIndex-2}))},b.prototype.filterSlides=b.prototype.slickFilter=function(a){var b=this;null!==a&&(b.$slidesCache=b.$slides,b.unload(),b.$slideTrack.children(this.options.slide).detach(),b.$slidesCache.filter(a).appendTo(b.$slideTrack),b.reinit())},b.prototype.focusHandler=function(){var b=this;b.$slider.off("focus.slick blur.slick").on("focus.slick blur.slick","*:not(.slick-arrow)",function(c){c.stopImmediatePropagation();var d=a(this);setTimeout(function(){b.options.pauseOnFocus&&(b.focussed=d.is(":focus"),b.autoPlay())},0)})},b.prototype.getCurrent=b.prototype.slickCurrentSlide=function(){var a=this;return a.currentSlide},b.prototype.getDotCount=function(){var a=this,b=0,c=0,d=0;if(a.options.infinite===!0)for(;b<a.slideCount;)++d,b=c+a.options.slidesToScroll,c+=a.options.slidesToScroll<=a.options.slidesToShow?a.options.slidesToScroll:a.options.slidesToShow;else if(a.options.centerMode===!0)d=a.slideCount;else if(a.options.asNavFor)for(;b<a.slideCount;)++d,b=c+a.options.slidesToScroll,c+=a.options.slidesToScroll<=a.options.slidesToShow?a.options.slidesToScroll:a.options.slidesToShow;else d=1+Math.ceil((a.slideCount-a.options.slidesToShow)/a.options.slidesToScroll);return d-1},b.prototype.getLeft=function(a){var c,d,f,b=this,e=0;return b.slideOffset=0,d=b.$slides.first().outerHeight(!0),b.options.infinite===!0?(b.slideCount>b.options.slidesToShow&&(b.slideOffset=b.slideWidth*b.options.slidesToShow*-1,e=d*b.options.slidesToShow*-1),b.slideCount%b.options.slidesToScroll!==0&&a+b.options.slidesToScroll>b.slideCount&&b.slideCount>b.options.slidesToShow&&(a>b.slideCount?(b.slideOffset=(b.options.slidesToShow-(a-b.slideCount))*b.slideWidth*-1,e=(b.options.slidesToShow-(a-b.slideCount))*d*-1):(b.slideOffset=b.slideCount%b.options.slidesToScroll*b.slideWidth*-1,e=b.slideCount%b.options.slidesToScroll*d*-1))):a+b.options.slidesToShow>b.slideCount&&(b.slideOffset=(a+b.options.slidesToShow-b.slideCount)*b.slideWidth,e=(a+b.options.slidesToShow-b.slideCount)*d),b.slideCount<=b.options.slidesToShow&&(b.slideOffset=0,e=0),b.options.centerMode===!0&&b.options.infinite===!0?b.slideOffset+=b.slideWidth*Math.floor(b.options.slidesToShow/2)-b.slideWidth:b.options.centerMode===!0&&(b.slideOffset=0,b.slideOffset+=b.slideWidth*Math.floor(b.options.slidesToShow/2)),c=b.options.vertical===!1?a*b.slideWidth*-1+b.slideOffset:a*d*-1+e,b.options.variableWidth===!0&&(f=b.slideCount<=b.options.slidesToShow||b.options.infinite===!1?b.$slideTrack.children(".slick-slide").eq(a):b.$slideTrack.children(".slick-slide").eq(a+b.options.slidesToShow),c=b.options.rtl===!0?f[0]?-1*(b.$slideTrack.width()-f[0].offsetLeft-f.width()):0:f[0]?-1*f[0].offsetLeft:0,b.options.centerMode===!0&&(f=b.slideCount<=b.options.slidesToShow||b.options.infinite===!1?b.$slideTrack.children(".slick-slide").eq(a):b.$slideTrack.children(".slick-slide").eq(a+b.options.slidesToShow+1),c=b.options.rtl===!0?f[0]?-1*(b.$slideTrack.width()-f[0].offsetLeft-f.width()):0:f[0]?-1*f[0].offsetLeft:0,c+=(b.$list.width()-f.outerWidth())/2)),c},b.prototype.getOption=b.prototype.slickGetOption=function(a){var b=this;return b.options[a]},b.prototype.getNavigableIndexes=function(){var e,a=this,b=0,c=0,d=[];for(a.options.infinite===!1?e=a.slideCount:(b=-1*a.options.slidesToScroll,c=-1*a.options.slidesToScroll,e=2*a.slideCount);e>b;)d.push(b),b=c+a.options.slidesToScroll,c+=a.options.slidesToScroll<=a.options.slidesToShow?a.options.slidesToScroll:a.options.slidesToShow;return d},b.prototype.getSlick=function(){return this},b.prototype.getSlideCount=function(){var c,d,e,b=this;return e=b.options.centerMode===!0?b.slideWidth*Math.floor(b.options.slidesToShow/2):0,b.options.swipeToSlide===!0?(b.$slideTrack.find(".slick-slide").each(function(c,f){return f.offsetLeft-e+a(f).outerWidth()/2>-1*b.swipeLeft?(d=f,!1):void 0}),c=Math.abs(a(d).attr("data-slick-index")-b.currentSlide)||1):b.options.slidesToScroll},b.prototype.goTo=b.prototype.slickGoTo=function(a,b){var c=this;c.changeSlide({data:{message:"index",index:parseInt(a)}},b)},b.prototype.init=function(b){var c=this;a(c.$slider).hasClass("slick-initialized")||(a(c.$slider).addClass("slick-initialized"),c.buildRows(),c.buildOut(),c.setProps(),c.startLoad(),c.loadSlider(),c.initializeEvents(),c.updateArrows(),c.updateDots(),c.checkResponsive(!0),c.focusHandler()),b&&c.$slider.trigger("init",[c]),c.options.accessibility===!0&&c.initADA(),c.options.autoplay&&(c.paused=!1,c.autoPlay())},b.prototype.initADA=function(){var b=this;b.$slides.add(b.$slideTrack.find(".slick-cloned")).attr({"aria-hidden":"true",tabindex:"-1"}).find("a, input, button, select").attr({tabindex:"-1"}),b.$slideTrack.attr("role","listbox"),b.$slides.not(b.$slideTrack.find(".slick-cloned")).each(function(c){a(this).attr({role:"option","aria-describedby":"slick-slide"+b.instanceUid+c})}),null!==b.$dots&&b.$dots.attr("role","tablist").find("li").each(function(c){a(this).attr({role:"presentation","aria-selected":"false","aria-controls":"navigation"+b.instanceUid+c,id:"slick-slide"+b.instanceUid+c})}).first().attr("aria-selected","true").end().find("button").attr("role","button").end().closest("div").attr("role","toolbar"),b.activateADA()},b.prototype.initArrowEvents=function(){var a=this;a.options.arrows===!0&&a.slideCount>a.options.slidesToShow&&(a.$prevArrow.off("click.slick").on("click.slick",{message:"previous"},a.changeSlide),a.$nextArrow.off("click.slick").on("click.slick",{message:"next"},a.changeSlide))},b.prototype.initDotEvents=function(){var b=this;b.options.dots===!0&&b.slideCount>b.options.slidesToShow&&a("li",b.$dots).on("click.slick",{message:"index"},b.changeSlide),b.options.dots===!0&&b.options.pauseOnDotsHover===!0&&a("li",b.$dots).on("mouseenter.slick",a.proxy(b.interrupt,b,!0)).on("mouseleave.slick",a.proxy(b.interrupt,b,!1))},b.prototype.initSlideEvents=function(){var b=this;b.options.pauseOnHover&&(b.$list.on("mouseenter.slick",a.proxy(b.interrupt,b,!0)),b.$list.on("mouseleave.slick",a.proxy(b.interrupt,b,!1)))},b.prototype.initializeEvents=function(){var b=this;b.initArrowEvents(),b.initDotEvents(),b.initSlideEvents(),b.$list.on("touchstart.slick mousedown.slick",{action:"start"},b.swipeHandler),b.$list.on("touchmove.slick mousemove.slick",{action:"move"},b.swipeHandler),b.$list.on("touchend.slick mouseup.slick",{action:"end"},b.swipeHandler),b.$list.on("touchcancel.slick mouseleave.slick",{action:"end"},b.swipeHandler),b.$list.on("click.slick",b.clickHandler),a(document).on(b.visibilityChange,a.proxy(b.visibility,b)),b.options.accessibility===!0&&b.$list.on("keydown.slick",b.keyHandler),b.options.focusOnSelect===!0&&a(b.$slideTrack).children().on("click.slick",b.selectHandler),a(window).on("orientationchange.slick.slick-"+b.instanceUid,a.proxy(b.orientationChange,b)),a(window).on("resize.slick.slick-"+b.instanceUid,a.proxy(b.resize,b)),a("[draggable!=true]",b.$slideTrack).on("dragstart",b.preventDefault),a(window).on("load.slick.slick-"+b.instanceUid,b.setPosition),a(document).on("ready.slick.slick-"+b.instanceUid,b.setPosition)},b.prototype.initUI=function(){var a=this;a.options.arrows===!0&&a.slideCount>a.options.slidesToShow&&(a.$prevArrow.show(),a.$nextArrow.show()),a.options.dots===!0&&a.slideCount>a.options.slidesToShow&&a.$dots.show()},b.prototype.keyHandler=function(a){var b=this;a.target.tagName.match("TEXTAREA|INPUT|SELECT")||(37===a.keyCode&&b.options.accessibility===!0?b.changeSlide({data:{message:b.options.rtl===!0?"next":"previous"}}):39===a.keyCode&&b.options.accessibility===!0&&b.changeSlide({data:{message:b.options.rtl===!0?"previous":"next"}}))},b.prototype.lazyLoad=function(){function g(c){a("img[data-lazy]",c).each(function(){var c=a(this),d=a(this).attr("data-lazy"),e=document.createElement("img");e.onload=function(){c.animate({opacity:0},100,function(){c.attr("src",d).animate({opacity:1},200,function(){c.removeAttr("data-lazy").removeClass("slick-loading")}),b.$slider.trigger("lazyLoaded",[b,c,d])})},e.onerror=function(){c.removeAttr("data-lazy").removeClass("slick-loading").addClass("slick-lazyload-error"),b.$slider.trigger("lazyLoadError",[b,c,d])},e.src=d})}var c,d,e,f,b=this;b.options.centerMode===!0?b.options.infinite===!0?(e=b.currentSlide+(b.options.slidesToShow/2+1),f=e+b.options.slidesToShow+2):(e=Math.max(0,b.currentSlide-(b.options.slidesToShow/2+1)),f=2+(b.options.slidesToShow/2+1)+b.currentSlide):(e=b.options.infinite?b.options.slidesToShow+b.currentSlide:b.currentSlide,f=Math.ceil(e+b.options.slidesToShow),b.options.fade===!0&&(e>0&&e--,f<=b.slideCount&&f++)),c=b.$slider.find(".slick-slide").slice(e,f),g(c),b.slideCount<=b.options.slidesToShow?(d=b.$slider.find(".slick-slide"),g(d)):b.currentSlide>=b.slideCount-b.options.slidesToShow?(d=b.$slider.find(".slick-cloned").slice(0,b.options.slidesToShow),g(d)):0===b.currentSlide&&(d=b.$slider.find(".slick-cloned").slice(-1*b.options.slidesToShow),g(d))},b.prototype.loadSlider=function(){var a=this;a.setPosition(),a.$slideTrack.css({opacity:1}),a.$slider.removeClass("slick-loading"),a.initUI(),"progressive"===a.options.lazyLoad&&a.progressiveLazyLoad()},b.prototype.next=b.prototype.slickNext=function(){var a=this;a.changeSlide({data:{message:"next"}})},b.prototype.orientationChange=function(){var a=this;a.checkResponsive(),a.setPosition()},b.prototype.pause=b.prototype.slickPause=function(){var a=this;a.autoPlayClear(),a.paused=!0},b.prototype.play=b.prototype.slickPlay=function(){var a=this;a.autoPlay(),a.options.autoplay=!0,a.paused=!1,a.focussed=!1,a.interrupted=!1},b.prototype.postSlide=function(a){var b=this;b.unslicked||(b.$slider.trigger("afterChange",[b,a]),b.animating=!1,b.setPosition(),b.swipeLeft=null,b.options.autoplay&&b.autoPlay(),b.options.accessibility===!0&&b.initADA())},b.prototype.prev=b.prototype.slickPrev=function(){var a=this;a.changeSlide({data:{message:"previous"}})},b.prototype.preventDefault=function(a){a.preventDefault()},b.prototype.progressiveLazyLoad=function(b){b=b||1;var e,f,g,c=this,d=a("img[data-lazy]",c.$slider);d.length?(e=d.first(),f=e.attr("data-lazy"),g=document.createElement("img"),g.onload=function(){e.attr("src",f).removeAttr("data-lazy").removeClass("slick-loading"),c.options.adaptiveHeight===!0&&c.setPosition(),c.$slider.trigger("lazyLoaded",[c,e,f]),c.progressiveLazyLoad()},g.onerror=function(){3>b?setTimeout(function(){c.progressiveLazyLoad(b+1)},500):(e.removeAttr("data-lazy").removeClass("slick-loading").addClass("slick-lazyload-error"),c.$slider.trigger("lazyLoadError",[c,e,f]),c.progressiveLazyLoad())},g.src=f):c.$slider.trigger("allImagesLoaded",[c])},b.prototype.refresh=function(b){var d,e,c=this;e=c.slideCount-c.options.slidesToShow,!c.options.infinite&&c.currentSlide>e&&(c.currentSlide=e),c.slideCount<=c.options.slidesToShow&&(c.currentSlide=0),d=c.currentSlide,c.destroy(!0),a.extend(c,c.initials,{currentSlide:d}),c.init(),b||c.changeSlide({data:{message:"index",index:d}},!1)},b.prototype.registerBreakpoints=function(){var c,d,e,b=this,f=b.options.responsive||null;if("array"===a.type(f)&&f.length){b.respondTo=b.options.respondTo||"window";for(c in f)if(e=b.breakpoints.length-1,d=f[c].breakpoint,f.hasOwnProperty(c)){for(;e>=0;)b.breakpoints[e]&&b.breakpoints[e]===d&&b.breakpoints.splice(e,1),e--;b.breakpoints.push(d),b.breakpointSettings[d]=f[c].settings}b.breakpoints.sort(function(a,c){return b.options.mobileFirst?a-c:c-a})}},b.prototype.reinit=function(){var b=this;b.$slides=b.$slideTrack.children(b.options.slide).addClass("slick-slide"),b.slideCount=b.$slides.length,b.currentSlide>=b.slideCount&&0!==b.currentSlide&&(b.currentSlide=b.currentSlide-b.options.slidesToScroll),b.slideCount<=b.options.slidesToShow&&(b.currentSlide=0),b.registerBreakpoints(),b.setProps(),b.setupInfinite(),b.buildArrows(),b.updateArrows(),b.initArrowEvents(),b.buildDots(),b.updateDots(),b.initDotEvents(),b.cleanUpSlideEvents(),b.initSlideEvents(),b.checkResponsive(!1,!0),b.options.focusOnSelect===!0&&a(b.$slideTrack).children().on("click.slick",b.selectHandler),b.setSlideClasses("number"==typeof b.currentSlide?b.currentSlide:0),b.setPosition(),b.focusHandler(),b.paused=!b.options.autoplay,b.autoPlay(),b.$slider.trigger("reInit",[b])},b.prototype.resize=function(){var b=this;a(window).width()!==b.windowWidth&&(clearTimeout(b.windowDelay),b.windowDelay=window.setTimeout(function(){b.windowWidth=a(window).width(),b.checkResponsive(),b.unslicked||b.setPosition()},50))},b.prototype.removeSlide=b.prototype.slickRemove=function(a,b,c){var d=this;return"boolean"==typeof a?(b=a,a=b===!0?0:d.slideCount-1):a=b===!0?--a:a,d.slideCount<1||0>a||a>d.slideCount-1?!1:(d.unload(),c===!0?d.$slideTrack.children().remove():d.$slideTrack.children(this.options.slide).eq(a).remove(),d.$slides=d.$slideTrack.children(this.options.slide),d.$slideTrack.children(this.options.slide).detach(),d.$slideTrack.append(d.$slides),d.$slidesCache=d.$slides,void d.reinit())},b.prototype.setCSS=function(a){var d,e,b=this,c={};b.options.rtl===!0&&(a=-a),d="left"==b.positionProp?Math.ceil(a)+"px":"0px",e="top"==b.positionProp?Math.ceil(a)+"px":"0px",c[b.positionProp]=a,b.transformsEnabled===!1?b.$slideTrack.css(c):(c={},b.cssTransitions===!1?(c[b.animType]="translate("+d+", "+e+")",b.$slideTrack.css(c)):(c[b.animType]="translate3d("+d+", "+e+", 0px)",b.$slideTrack.css(c)))},b.prototype.setDimensions=function(){var a=this;a.options.vertical===!1?a.options.centerMode===!0&&a.$list.css({padding:"0px "+a.options.centerPadding}):(a.$list.height(a.$slides.first().outerHeight(!0)*a.options.slidesToShow),a.options.centerMode===!0&&a.$list.css({padding:a.options.centerPadding+" 0px"})),a.listWidth=a.$list.width(),a.listHeight=a.$list.height(),a.options.vertical===!1&&a.options.variableWidth===!1?(a.slideWidth=Math.ceil(a.listWidth/a.options.slidesToShow),a.$slideTrack.width(Math.ceil(a.slideWidth*a.$slideTrack.children(".slick-slide").length))):a.options.variableWidth===!0?a.$slideTrack.width(5e3*a.slideCount):(a.slideWidth=Math.ceil(a.listWidth),a.$slideTrack.height(Math.ceil(a.$slides.first().outerHeight(!0)*a.$slideTrack.children(".slick-slide").length)));var b=a.$slides.first().outerWidth(!0)-a.$slides.first().width();a.options.variableWidth===!1&&a.$slideTrack.children(".slick-slide").width(a.slideWidth-b)},b.prototype.setFade=function(){var c,b=this;b.$slides.each(function(d,e){c=b.slideWidth*d*-1,b.options.rtl===!0?a(e).css({position:"relative",right:c,top:0,zIndex:b.options.zIndex-2,opacity:0}):a(e).css({position:"relative",left:c,top:0,zIndex:b.options.zIndex-2,opacity:0})}),b.$slides.eq(b.currentSlide).css({zIndex:b.options.zIndex-1,opacity:1})},b.prototype.setHeight=function(){var a=this;if(1===a.options.slidesToShow&&a.options.adaptiveHeight===!0&&a.options.vertical===!1){var b=a.$slides.eq(a.currentSlide).outerHeight(!0);a.$list.css("height",b)}},b.prototype.setOption=b.prototype.slickSetOption=function(){var c,d,e,f,h,b=this,g=!1;if("object"===a.type(arguments[0])?(e=arguments[0],g=arguments[1],h="multiple"):"string"===a.type(arguments[0])&&(e=arguments[0],f=arguments[1],g=arguments[2],"responsive"===arguments[0]&&"array"===a.type(arguments[1])?h="responsive":"undefined"!=typeof arguments[1]&&(h="single")),"single"===h)b.options[e]=f;else if("multiple"===h)a.each(e,function(a,c){b.options[a]=c});else if("responsive"===h)for(d in f)if("array"!==a.type(b.options.responsive))b.options.responsive=[f[d]];else{for(c=b.options.responsive.length-1;c>=0;)b.options.responsive[c].breakpoint===f[d].breakpoint&&b.options.responsive.splice(c,1),c--;b.options.responsive.push(f[d])}g&&(b.unload(),b.reinit())},b.prototype.setPosition=function(){var a=this;a.setDimensions(),a.setHeight(),a.options.fade===!1?a.setCSS(a.getLeft(a.currentSlide)):a.setFade(),a.$slider.trigger("setPosition",[a])},b.prototype.setProps=function(){var a=this,b=document.body.style;a.positionProp=a.options.vertical===!0?"top":"left","top"===a.positionProp?a.$slider.addClass("slick-vertical"):a.$slider.removeClass("slick-vertical"),(void 0!==b.WebkitTransition||void 0!==b.MozTransition||void 0!==b.msTransition)&&a.options.useCSS===!0&&(a.cssTransitions=!0),a.options.fade&&("number"==typeof a.options.zIndex?a.options.zIndex<3&&(a.options.zIndex=3):a.options.zIndex=a.defaults.zIndex),void 0!==b.OTransform&&(a.animType="OTransform",a.transformType="-o-transform",a.transitionType="OTransition",void 0===b.perspectiveProperty&&void 0===b.webkitPerspective&&(a.animType=!1)),void 0!==b.MozTransform&&(a.animType="MozTransform",a.transformType="-moz-transform",a.transitionType="MozTransition",void 0===b.perspectiveProperty&&void 0===b.MozPerspective&&(a.animType=!1)),void 0!==b.webkitTransform&&(a.animType="webkitTransform",a.transformType="-webkit-transform",a.transitionType="webkitTransition",void 0===b.perspectiveProperty&&void 0===b.webkitPerspective&&(a.animType=!1)),void 0!==b.msTransform&&(a.animType="msTransform",a.transformType="-ms-transform",a.transitionType="msTransition",void 0===b.msTransform&&(a.animType=!1)),void 0!==b.transform&&a.animType!==!1&&(a.animType="transform",a.transformType="transform",a.transitionType="transition"),a.transformsEnabled=a.options.useTransform&&null!==a.animType&&a.animType!==!1},b.prototype.setSlideClasses=function(a){var c,d,e,f,b=this;d=b.$slider.find(".slick-slide").removeClass("slick-active slick-center slick-current").attr("aria-hidden","true"),b.$slides.eq(a).addClass("slick-current"),b.options.centerMode===!0?(c=Math.floor(b.options.slidesToShow/2),b.options.infinite===!0&&(a>=c&&a<=b.slideCount-1-c?b.$slides.slice(a-c,a+c+1).addClass("slick-active").attr("aria-hidden","false"):(e=b.options.slidesToShow+a,
d.slice(e-c+1,e+c+2).addClass("slick-active").attr("aria-hidden","false")),0===a?d.eq(d.length-1-b.options.slidesToShow).addClass("slick-center"):a===b.slideCount-1&&d.eq(b.options.slidesToShow).addClass("slick-center")),b.$slides.eq(a).addClass("slick-center")):a>=0&&a<=b.slideCount-b.options.slidesToShow?b.$slides.slice(a,a+b.options.slidesToShow).addClass("slick-active").attr("aria-hidden","false"):d.length<=b.options.slidesToShow?d.addClass("slick-active").attr("aria-hidden","false"):(f=b.slideCount%b.options.slidesToShow,e=b.options.infinite===!0?b.options.slidesToShow+a:a,b.options.slidesToShow==b.options.slidesToScroll&&b.slideCount-a<b.options.slidesToShow?d.slice(e-(b.options.slidesToShow-f),e+f).addClass("slick-active").attr("aria-hidden","false"):d.slice(e,e+b.options.slidesToShow).addClass("slick-active").attr("aria-hidden","false")),"ondemand"===b.options.lazyLoad&&b.lazyLoad()},b.prototype.setupInfinite=function(){var c,d,e,b=this;if(b.options.fade===!0&&(b.options.centerMode=!1),b.options.infinite===!0&&b.options.fade===!1&&(d=null,b.slideCount>b.options.slidesToShow)){for(e=b.options.centerMode===!0?b.options.slidesToShow+1:b.options.slidesToShow,c=b.slideCount;c>b.slideCount-e;c-=1)d=c-1,a(b.$slides[d]).clone(!0).attr("id","").attr("data-slick-index",d-b.slideCount).prependTo(b.$slideTrack).addClass("slick-cloned");for(c=0;e>c;c+=1)d=c,a(b.$slides[d]).clone(!0).attr("id","").attr("data-slick-index",d+b.slideCount).appendTo(b.$slideTrack).addClass("slick-cloned");b.$slideTrack.find(".slick-cloned").find("[id]").each(function(){a(this).attr("id","")})}},b.prototype.interrupt=function(a){var b=this;a||b.autoPlay(),b.interrupted=a},b.prototype.selectHandler=function(b){var c=this,d=a(b.target).is(".slick-slide")?a(b.target):a(b.target).parents(".slick-slide"),e=parseInt(d.attr("data-slick-index"));return e||(e=0),c.slideCount<=c.options.slidesToShow?(c.setSlideClasses(e),void c.asNavFor(e)):void c.slideHandler(e)},b.prototype.slideHandler=function(a,b,c){var d,e,f,g,j,h=null,i=this;return b=b||!1,i.animating===!0&&i.options.waitForAnimate===!0||i.options.fade===!0&&i.currentSlide===a||i.slideCount<=i.options.slidesToShow?void 0:(b===!1&&i.asNavFor(a),d=a,h=i.getLeft(d),g=i.getLeft(i.currentSlide),i.currentLeft=null===i.swipeLeft?g:i.swipeLeft,i.options.infinite===!1&&i.options.centerMode===!1&&(0>a||a>i.getDotCount()*i.options.slidesToScroll)?void(i.options.fade===!1&&(d=i.currentSlide,c!==!0?i.animateSlide(g,function(){i.postSlide(d)}):i.postSlide(d))):i.options.infinite===!1&&i.options.centerMode===!0&&(0>a||a>i.slideCount-i.options.slidesToScroll)?void(i.options.fade===!1&&(d=i.currentSlide,c!==!0?i.animateSlide(g,function(){i.postSlide(d)}):i.postSlide(d))):(i.options.autoplay&&clearInterval(i.autoPlayTimer),e=0>d?i.slideCount%i.options.slidesToScroll!==0?i.slideCount-i.slideCount%i.options.slidesToScroll:i.slideCount+d:d>=i.slideCount?i.slideCount%i.options.slidesToScroll!==0?0:d-i.slideCount:d,i.animating=!0,i.$slider.trigger("beforeChange",[i,i.currentSlide,e]),f=i.currentSlide,i.currentSlide=e,i.setSlideClasses(i.currentSlide),i.options.asNavFor&&(j=i.getNavTarget(),j=j.slick("getSlick"),j.slideCount<=j.options.slidesToShow&&j.setSlideClasses(i.currentSlide)),i.updateDots(),i.updateArrows(),i.options.fade===!0?(c!==!0?(i.fadeSlideOut(f),i.fadeSlide(e,function(){i.postSlide(e)})):i.postSlide(e),void i.animateHeight()):void(c!==!0?i.animateSlide(h,function(){i.postSlide(e)}):i.postSlide(e))))},b.prototype.startLoad=function(){var a=this;a.options.arrows===!0&&a.slideCount>a.options.slidesToShow&&(a.$prevArrow.hide(),a.$nextArrow.hide()),a.options.dots===!0&&a.slideCount>a.options.slidesToShow&&a.$dots.hide(),a.$slider.addClass("slick-loading")},b.prototype.swipeDirection=function(){var a,b,c,d,e=this;return a=e.touchObject.startX-e.touchObject.curX,b=e.touchObject.startY-e.touchObject.curY,c=Math.atan2(b,a),d=Math.round(180*c/Math.PI),0>d&&(d=360-Math.abs(d)),45>=d&&d>=0?e.options.rtl===!1?"left":"right":360>=d&&d>=315?e.options.rtl===!1?"left":"right":d>=135&&225>=d?e.options.rtl===!1?"right":"left":e.options.verticalSwiping===!0?d>=35&&135>=d?"down":"up":"vertical"},b.prototype.swipeEnd=function(a){var c,d,b=this;if(b.dragging=!1,b.interrupted=!1,b.shouldClick=b.touchObject.swipeLength>10?!1:!0,void 0===b.touchObject.curX)return!1;if(b.touchObject.edgeHit===!0&&b.$slider.trigger("edge",[b,b.swipeDirection()]),b.touchObject.swipeLength>=b.touchObject.minSwipe){switch(d=b.swipeDirection()){case"left":case"down":c=b.options.swipeToSlide?b.checkNavigable(b.currentSlide+b.getSlideCount()):b.currentSlide+b.getSlideCount(),b.currentDirection=0;break;case"right":case"up":c=b.options.swipeToSlide?b.checkNavigable(b.currentSlide-b.getSlideCount()):b.currentSlide-b.getSlideCount(),b.currentDirection=1}"vertical"!=d&&(b.slideHandler(c),b.touchObject={},b.$slider.trigger("swipe",[b,d]))}else b.touchObject.startX!==b.touchObject.curX&&(b.slideHandler(b.currentSlide),b.touchObject={})},b.prototype.swipeHandler=function(a){var b=this;if(!(b.options.swipe===!1||"ontouchend"in document&&b.options.swipe===!1||b.options.draggable===!1&&-1!==a.type.indexOf("mouse")))switch(b.touchObject.fingerCount=a.originalEvent&&void 0!==a.originalEvent.touches?a.originalEvent.touches.length:1,b.touchObject.minSwipe=b.listWidth/b.options.touchThreshold,b.options.verticalSwiping===!0&&(b.touchObject.minSwipe=b.listHeight/b.options.touchThreshold),a.data.action){case"start":b.swipeStart(a);break;case"move":b.swipeMove(a);break;case"end":b.swipeEnd(a)}},b.prototype.swipeMove=function(a){var d,e,f,g,h,b=this;return h=void 0!==a.originalEvent?a.originalEvent.touches:null,!b.dragging||h&&1!==h.length?!1:(d=b.getLeft(b.currentSlide),b.touchObject.curX=void 0!==h?h[0].pageX:a.clientX,b.touchObject.curY=void 0!==h?h[0].pageY:a.clientY,b.touchObject.swipeLength=Math.round(Math.sqrt(Math.pow(b.touchObject.curX-b.touchObject.startX,2))),b.options.verticalSwiping===!0&&(b.touchObject.swipeLength=Math.round(Math.sqrt(Math.pow(b.touchObject.curY-b.touchObject.startY,2)))),e=b.swipeDirection(),"vertical"!==e?(void 0!==a.originalEvent&&b.touchObject.swipeLength>4&&a.preventDefault(),g=(b.options.rtl===!1?1:-1)*(b.touchObject.curX>b.touchObject.startX?1:-1),b.options.verticalSwiping===!0&&(g=b.touchObject.curY>b.touchObject.startY?1:-1),f=b.touchObject.swipeLength,b.touchObject.edgeHit=!1,b.options.infinite===!1&&(0===b.currentSlide&&"right"===e||b.currentSlide>=b.getDotCount()&&"left"===e)&&(f=b.touchObject.swipeLength*b.options.edgeFriction,b.touchObject.edgeHit=!0),b.options.vertical===!1?b.swipeLeft=d+f*g:b.swipeLeft=d+f*(b.$list.height()/b.listWidth)*g,b.options.verticalSwiping===!0&&(b.swipeLeft=d+f*g),b.options.fade===!0||b.options.touchMove===!1?!1:b.animating===!0?(b.swipeLeft=null,!1):void b.setCSS(b.swipeLeft)):void 0)},b.prototype.swipeStart=function(a){var c,b=this;return b.interrupted=!0,1!==b.touchObject.fingerCount||b.slideCount<=b.options.slidesToShow?(b.touchObject={},!1):(void 0!==a.originalEvent&&void 0!==a.originalEvent.touches&&(c=a.originalEvent.touches[0]),b.touchObject.startX=b.touchObject.curX=void 0!==c?c.pageX:a.clientX,b.touchObject.startY=b.touchObject.curY=void 0!==c?c.pageY:a.clientY,void(b.dragging=!0))},b.prototype.unfilterSlides=b.prototype.slickUnfilter=function(){var a=this;null!==a.$slidesCache&&(a.unload(),a.$slideTrack.children(this.options.slide).detach(),a.$slidesCache.appendTo(a.$slideTrack),a.reinit())},b.prototype.unload=function(){var b=this;a(".slick-cloned",b.$slider).remove(),b.$dots&&b.$dots.remove(),b.$prevArrow&&b.htmlExpr.test(b.options.prevArrow)&&b.$prevArrow.remove(),b.$nextArrow&&b.htmlExpr.test(b.options.nextArrow)&&b.$nextArrow.remove(),b.$slides.removeClass("slick-slide slick-active slick-visible slick-current").attr("aria-hidden","true").css("width","")},b.prototype.unslick=function(a){var b=this;b.$slider.trigger("unslick",[b,a]),b.destroy()},b.prototype.updateArrows=function(){var b,a=this;b=Math.floor(a.options.slidesToShow/2),a.options.arrows===!0&&a.slideCount>a.options.slidesToShow&&!a.options.infinite&&(a.$prevArrow.removeClass("slick-disabled").attr("aria-disabled","false"),a.$nextArrow.removeClass("slick-disabled").attr("aria-disabled","false"),0===a.currentSlide?(a.$prevArrow.addClass("slick-disabled").attr("aria-disabled","true"),a.$nextArrow.removeClass("slick-disabled").attr("aria-disabled","false")):a.currentSlide>=a.slideCount-a.options.slidesToShow&&a.options.centerMode===!1?(a.$nextArrow.addClass("slick-disabled").attr("aria-disabled","true"),a.$prevArrow.removeClass("slick-disabled").attr("aria-disabled","false")):a.currentSlide>=a.slideCount-1&&a.options.centerMode===!0&&(a.$nextArrow.addClass("slick-disabled").attr("aria-disabled","true"),a.$prevArrow.removeClass("slick-disabled").attr("aria-disabled","false")))},b.prototype.updateDots=function(){var a=this;null!==a.$dots&&(a.$dots.find("li").removeClass("slick-active").attr("aria-hidden","true"),a.$dots.find("li").eq(Math.floor(a.currentSlide/a.options.slidesToScroll)).addClass("slick-active").attr("aria-hidden","false"))},b.prototype.visibility=function(){var a=this;a.options.autoplay&&(document[a.hidden]?a.interrupted=!0:a.interrupted=!1)},a.fn.slick=function(){var f,g,a=this,c=arguments[0],d=Array.prototype.slice.call(arguments,1),e=a.length;for(f=0;e>f;f++)if("object"==typeof c||"undefined"==typeof c?a[f].slick=new b(a[f],c):g=a[f].slick[c].apply(a[f].slick,d),"undefined"!=typeof g)return g;return a}});
/*! VelocityJS.org (1.3.1). (C) 2014 Julian Shapiro. MIT @license: en.wikipedia.org/wiki/MIT_License */
/*! VelocityJS.org jQuery Shim (1.0.1). (C) 2014 The jQuery Foundation. MIT @license: en.wikipedia.org/wiki/MIT_License. */
!function(a){"use strict";function b(a){var b=a.length,d=c.type(a);return"function"!==d&&!c.isWindow(a)&&(!(1!==a.nodeType||!b)||("array"===d||0===b||"number"==typeof b&&b>0&&b-1 in a))}if(!a.jQuery){var c=function(a,b){return new c.fn.init(a,b)};c.isWindow=function(a){return a&&a===a.window},c.type=function(a){return a?"object"==typeof a||"function"==typeof a?e[g.call(a)]||"object":typeof a:a+""},c.isArray=Array.isArray||function(a){return"array"===c.type(a)},c.isPlainObject=function(a){var b;if(!a||"object"!==c.type(a)||a.nodeType||c.isWindow(a))return!1;try{if(a.constructor&&!f.call(a,"constructor")&&!f.call(a.constructor.prototype,"isPrototypeOf"))return!1}catch(d){return!1}for(b in a);return void 0===b||f.call(a,b)},c.each=function(a,c,d){var e,f=0,g=a.length,h=b(a);if(d){if(h)for(;f<g&&(e=c.apply(a[f],d),e!==!1);f++);else for(f in a)if(a.hasOwnProperty(f)&&(e=c.apply(a[f],d),e===!1))break}else if(h)for(;f<g&&(e=c.call(a[f],f,a[f]),e!==!1);f++);else for(f in a)if(a.hasOwnProperty(f)&&(e=c.call(a[f],f,a[f]),e===!1))break;return a},c.data=function(a,b,e){if(void 0===e){var f=a[c.expando],g=f&&d[f];if(void 0===b)return g;if(g&&b in g)return g[b]}else if(void 0!==b){var h=a[c.expando]||(a[c.expando]=++c.uuid);return d[h]=d[h]||{},d[h][b]=e,e}},c.removeData=function(a,b){var e=a[c.expando],f=e&&d[e];f&&(b?c.each(b,function(a,b){delete f[b]}):delete d[e])},c.extend=function(){var a,b,d,e,f,g,h=arguments[0]||{},i=1,j=arguments.length,k=!1;for("boolean"==typeof h&&(k=h,h=arguments[i]||{},i++),"object"!=typeof h&&"function"!==c.type(h)&&(h={}),i===j&&(h=this,i--);i<j;i++)if(f=arguments[i])for(e in f)f.hasOwnProperty(e)&&(a=h[e],d=f[e],h!==d&&(k&&d&&(c.isPlainObject(d)||(b=c.isArray(d)))?(b?(b=!1,g=a&&c.isArray(a)?a:[]):g=a&&c.isPlainObject(a)?a:{},h[e]=c.extend(k,g,d)):void 0!==d&&(h[e]=d)));return h},c.queue=function(a,d,e){function f(a,c){var d=c||[];return a&&(b(Object(a))?!function(a,b){for(var c=+b.length,d=0,e=a.length;d<c;)a[e++]=b[d++];if(c!==c)for(;void 0!==b[d];)a[e++]=b[d++];return a.length=e,a}(d,"string"==typeof a?[a]:a):[].push.call(d,a)),d}if(a){d=(d||"fx")+"queue";var g=c.data(a,d);return e?(!g||c.isArray(e)?g=c.data(a,d,f(e)):g.push(e),g):g||[]}},c.dequeue=function(a,b){c.each(a.nodeType?[a]:a,function(a,d){b=b||"fx";var e=c.queue(d,b),f=e.shift();"inprogress"===f&&(f=e.shift()),f&&("fx"===b&&e.unshift("inprogress"),f.call(d,function(){c.dequeue(d,b)}))})},c.fn=c.prototype={init:function(a){if(a.nodeType)return this[0]=a,this;throw new Error("Not a DOM node.")},offset:function(){var b=this[0].getBoundingClientRect?this[0].getBoundingClientRect():{top:0,left:0};return{top:b.top+(a.pageYOffset||document.scrollTop||0)-(document.clientTop||0),left:b.left+(a.pageXOffset||document.scrollLeft||0)-(document.clientLeft||0)}},position:function(){function a(a){for(var b=a.offsetParent||document;b&&"html"!==b.nodeType.toLowerCase&&"static"===b.style.position;)b=b.offsetParent;return b||document}var b=this[0],d=a(b),e=this.offset(),f=/^(?:body|html)$/i.test(d.nodeName)?{top:0,left:0}:c(d).offset();return e.top-=parseFloat(b.style.marginTop)||0,e.left-=parseFloat(b.style.marginLeft)||0,d.style&&(f.top+=parseFloat(d.style.borderTopWidth)||0,f.left+=parseFloat(d.style.borderLeftWidth)||0),{top:e.top-f.top,left:e.left-f.left}}};var d={};c.expando="velocity"+(new Date).getTime(),c.uuid=0;for(var e={},f=e.hasOwnProperty,g=e.toString,h="Boolean Number String Function Array Date RegExp Object Error".split(" "),i=0;i<h.length;i++)e["[object "+h[i]+"]"]=h[i].toLowerCase();c.fn.init.prototype=c.fn,a.Velocity={Utilities:c}}}(window),function(a){"use strict";"object"==typeof module&&"object"==typeof module.exports?module.exports=a():"function"==typeof define&&define.amd?define(a):a()}(function(){"use strict";return function(a,b,c,d){function e(a){for(var b=-1,c=a?a.length:0,d=[];++b<c;){var e=a[b];e&&d.push(e)}return d}function f(a){return p.isWrapped(a)?a=[].slice.call(a):p.isNode(a)&&(a=[a]),a}function g(a){var b=m.data(a,"velocity");return null===b?d:b}function h(a){return function(b){return Math.round(b*a)*(1/a)}}function i(a,c,d,e){function f(a,b){return 1-3*b+3*a}function g(a,b){return 3*b-6*a}function h(a){return 3*a}function i(a,b,c){return((f(b,c)*a+g(b,c))*a+h(b))*a}function j(a,b,c){return 3*f(b,c)*a*a+2*g(b,c)*a+h(b)}function k(b,c){for(var e=0;e<p;++e){var f=j(c,a,d);if(0===f)return c;var g=i(c,a,d)-b;c-=g/f}return c}function l(){for(var b=0;b<t;++b)x[b]=i(b*u,a,d)}function m(b,c,e){var f,g,h=0;do g=c+(e-c)/2,f=i(g,a,d)-b,f>0?e=g:c=g;while(Math.abs(f)>r&&++h<s);return g}function n(b){for(var c=0,e=1,f=t-1;e!==f&&x[e]<=b;++e)c+=u;--e;var g=(b-x[e])/(x[e+1]-x[e]),h=c+g*u,i=j(h,a,d);return i>=q?k(b,h):0===i?h:m(b,c,c+u)}function o(){y=!0,a===c&&d===e||l()}var p=4,q=.001,r=1e-7,s=10,t=11,u=1/(t-1),v="Float32Array"in b;if(4!==arguments.length)return!1;for(var w=0;w<4;++w)if("number"!=typeof arguments[w]||isNaN(arguments[w])||!isFinite(arguments[w]))return!1;a=Math.min(a,1),d=Math.min(d,1),a=Math.max(a,0),d=Math.max(d,0);var x=v?new Float32Array(t):new Array(t),y=!1,z=function(b){return y||o(),a===c&&d===e?b:0===b?0:1===b?1:i(n(b),c,e)};z.getControlPoints=function(){return[{x:a,y:c},{x:d,y:e}]};var A="generateBezier("+[a,c,d,e]+")";return z.toString=function(){return A},z}function j(a,b){var c=a;return p.isString(a)?t.Easings[a]||(c=!1):c=p.isArray(a)&&1===a.length?h.apply(null,a):p.isArray(a)&&2===a.length?u.apply(null,a.concat([b])):!(!p.isArray(a)||4!==a.length)&&i.apply(null,a),c===!1&&(c=t.Easings[t.defaults.easing]?t.defaults.easing:s),c}function k(a){if(a){var b=t.timestamp&&a!==!0?a:(new Date).getTime(),c=t.State.calls.length;c>1e4&&(t.State.calls=e(t.State.calls),c=t.State.calls.length);for(var f=0;f<c;f++)if(t.State.calls[f]){var h=t.State.calls[f],i=h[0],j=h[2],n=h[3],o=!!n,q=null;n||(n=t.State.calls[f][3]=b-16);for(var r=Math.min((b-n)/j.duration,1),s=0,u=i.length;s<u;s++){var w=i[s],y=w.element;if(g(y)){var z=!1;if(j.display!==d&&null!==j.display&&"none"!==j.display){if("flex"===j.display){var A=["-webkit-box","-moz-box","-ms-flexbox","-webkit-flex"];m.each(A,function(a,b){v.setPropertyValue(y,"display",b)})}v.setPropertyValue(y,"display",j.display)}j.visibility!==d&&"hidden"!==j.visibility&&v.setPropertyValue(y,"visibility",j.visibility);for(var B in w)if(w.hasOwnProperty(B)&&"element"!==B){var C,D=w[B],E=p.isString(D.easing)?t.Easings[D.easing]:D.easing;if(1===r)C=D.endValue;else{var F=D.endValue-D.startValue;if(C=D.startValue+F*E(r,j,F),!o&&C===D.currentValue)continue}if(D.currentValue=C,"tween"===B)q=C;else{var G;if(v.Hooks.registered[B]){G=v.Hooks.getRoot(B);var H=g(y).rootPropertyValueCache[G];H&&(D.rootPropertyValue=H)}var I=v.setPropertyValue(y,B,D.currentValue+(0===parseFloat(C)?"":D.unitType),D.rootPropertyValue,D.scrollData);v.Hooks.registered[B]&&(v.Normalizations.registered[G]?g(y).rootPropertyValueCache[G]=v.Normalizations.registered[G]("extract",null,I[1]):g(y).rootPropertyValueCache[G]=I[1]),"transform"===I[0]&&(z=!0)}}j.mobileHA&&g(y).transformCache.translate3d===d&&(g(y).transformCache.translate3d="(0px, 0px, 0px)",z=!0),z&&v.flushTransformCache(y)}}j.display!==d&&"none"!==j.display&&(t.State.calls[f][2].display=!1),j.visibility!==d&&"hidden"!==j.visibility&&(t.State.calls[f][2].visibility=!1),j.progress&&j.progress.call(h[1],h[1],r,Math.max(0,n+j.duration-b),n,q),1===r&&l(f)}}t.State.isTicking&&x(k)}function l(a,b){if(!t.State.calls[a])return!1;for(var c=t.State.calls[a][0],e=t.State.calls[a][1],f=t.State.calls[a][2],h=t.State.calls[a][4],i=!1,j=0,k=c.length;j<k;j++){var l=c[j].element;b||f.loop||("none"===f.display&&v.setPropertyValue(l,"display",f.display),"hidden"===f.visibility&&v.setPropertyValue(l,"visibility",f.visibility));var n=g(l);if(f.loop!==!0&&(m.queue(l)[1]===d||!/\.velocityQueueEntryFlag/i.test(m.queue(l)[1]))&&n){n.isAnimating=!1,n.rootPropertyValueCache={};var o=!1;m.each(v.Lists.transforms3D,function(a,b){var c=/^scale/.test(b)?1:0,e=n.transformCache[b];n.transformCache[b]!==d&&new RegExp("^\\("+c+"[^.]").test(e)&&(o=!0,delete n.transformCache[b])}),f.mobileHA&&(o=!0,delete n.transformCache.translate3d),o&&v.flushTransformCache(l),v.Values.removeClass(l,"velocity-animating")}if(!b&&f.complete&&!f.loop&&j===k-1)try{f.complete.call(e,e)}catch(p){setTimeout(function(){throw p},1)}h&&f.loop!==!0&&h(e),n&&f.loop===!0&&!b&&(m.each(n.tweensContainer,function(a,b){if(/^rotate/.test(a)&&(parseFloat(b.startValue)-parseFloat(b.endValue))%360===0){var c=b.startValue;b.startValue=b.endValue,b.endValue=c}/^backgroundPosition/.test(a)&&100===parseFloat(b.endValue)&&"%"===b.unitType&&(b.endValue=0,b.startValue=100)}),t(l,"reverse",{loop:!0,delay:f.delay})),f.queue!==!1&&m.dequeue(l,f.queue)}t.State.calls[a]=!1;for(var q=0,r=t.State.calls.length;q<r;q++)if(t.State.calls[q]!==!1){i=!0;break}i===!1&&(t.State.isTicking=!1,delete t.State.calls,t.State.calls=[])}var m,n=function(){if(c.documentMode)return c.documentMode;for(var a=7;a>4;a--){var b=c.createElement("div");if(b.innerHTML="<!--[if IE "+a+"]><span></span><![endif]-->",b.getElementsByTagName("span").length)return b=null,a}return d}(),o=function(){var a=0;return b.webkitRequestAnimationFrame||b.mozRequestAnimationFrame||function(b){var c,d=(new Date).getTime();return c=Math.max(0,16-(d-a)),a=d+c,setTimeout(function(){b(d+c)},c)}}(),p={isString:function(a){return"string"==typeof a},isArray:Array.isArray||function(a){return"[object Array]"===Object.prototype.toString.call(a)},isFunction:function(a){return"[object Function]"===Object.prototype.toString.call(a)},isNode:function(a){return a&&a.nodeType},isNodeList:function(a){return"object"==typeof a&&/^\[object (HTMLCollection|NodeList|Object)\]$/.test(Object.prototype.toString.call(a))&&a.length!==d&&(0===a.length||"object"==typeof a[0]&&a[0].nodeType>0)},isWrapped:function(a){return a&&(a.jquery||b.Zepto&&b.Zepto.zepto.isZ(a))},isSVG:function(a){return b.SVGElement&&a instanceof b.SVGElement},isEmptyObject:function(a){for(var b in a)if(a.hasOwnProperty(b))return!1;return!0}},q=!1;if(a.fn&&a.fn.jquery?(m=a,q=!0):m=b.Velocity.Utilities,n<=8&&!q)throw new Error("Velocity: IE8 and below require jQuery to be loaded before Velocity.");if(n<=7)return void(jQuery.fn.velocity=jQuery.fn.animate);var r=400,s="swing",t={State:{isMobile:/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent),isAndroid:/Android/i.test(navigator.userAgent),isGingerbread:/Android 2\.3\.[3-7]/i.test(navigator.userAgent),isChrome:b.chrome,isFirefox:/Firefox/i.test(navigator.userAgent),prefixElement:c.createElement("div"),prefixMatches:{},scrollAnchor:null,scrollPropertyLeft:null,scrollPropertyTop:null,isTicking:!1,calls:[]},CSS:{},Utilities:m,Redirects:{},Easings:{},Promise:b.Promise,defaults:{queue:"",duration:r,easing:s,begin:d,complete:d,progress:d,display:d,visibility:d,loop:!1,delay:!1,mobileHA:!0,_cacheValues:!0,promiseRejectEmpty:!0},init:function(a){m.data(a,"velocity",{isSVG:p.isSVG(a),isAnimating:!1,computedStyle:null,tweensContainer:null,rootPropertyValueCache:{},transformCache:{}})},hook:null,mock:!1,version:{major:1,minor:3,patch:1},debug:!1,timestamp:!0};b.pageYOffset!==d?(t.State.scrollAnchor=b,t.State.scrollPropertyLeft="pageXOffset",t.State.scrollPropertyTop="pageYOffset"):(t.State.scrollAnchor=c.documentElement||c.body.parentNode||c.body,t.State.scrollPropertyLeft="scrollLeft",t.State.scrollPropertyTop="scrollTop");var u=function(){function a(a){return-a.tension*a.x-a.friction*a.v}function b(b,c,d){var e={x:b.x+d.dx*c,v:b.v+d.dv*c,tension:b.tension,friction:b.friction};return{dx:e.v,dv:a(e)}}function c(c,d){var e={dx:c.v,dv:a(c)},f=b(c,.5*d,e),g=b(c,.5*d,f),h=b(c,d,g),i=1/6*(e.dx+2*(f.dx+g.dx)+h.dx),j=1/6*(e.dv+2*(f.dv+g.dv)+h.dv);return c.x=c.x+i*d,c.v=c.v+j*d,c}return function d(a,b,e){var f,g,h,i={x:-1,v:0,tension:null,friction:null},j=[0],k=0,l=1e-4,m=.016;for(a=parseFloat(a)||500,b=parseFloat(b)||20,e=e||null,i.tension=a,i.friction=b,f=null!==e,f?(k=d(a,b),g=k/e*m):g=m;;)if(h=c(h||i,g),j.push(1+h.x),k+=16,!(Math.abs(h.x)>l&&Math.abs(h.v)>l))break;return f?function(a){return j[a*(j.length-1)|0]}:k}}();t.Easings={linear:function(a){return a},swing:function(a){return.5-Math.cos(a*Math.PI)/2},spring:function(a){return 1-Math.cos(4.5*a*Math.PI)*Math.exp(6*-a)}},m.each([["ease",[.25,.1,.25,1]],["ease-in",[.42,0,1,1]],["ease-out",[0,0,.58,1]],["ease-in-out",[.42,0,.58,1]],["easeInSine",[.47,0,.745,.715]],["easeOutSine",[.39,.575,.565,1]],["easeInOutSine",[.445,.05,.55,.95]],["easeInQuad",[.55,.085,.68,.53]],["easeOutQuad",[.25,.46,.45,.94]],["easeInOutQuad",[.455,.03,.515,.955]],["easeInCubic",[.55,.055,.675,.19]],["easeOutCubic",[.215,.61,.355,1]],["easeInOutCubic",[.645,.045,.355,1]],["easeInQuart",[.895,.03,.685,.22]],["easeOutQuart",[.165,.84,.44,1]],["easeInOutQuart",[.77,0,.175,1]],["easeInQuint",[.755,.05,.855,.06]],["easeOutQuint",[.23,1,.32,1]],["easeInOutQuint",[.86,0,.07,1]],["easeInExpo",[.95,.05,.795,.035]],["easeOutExpo",[.19,1,.22,1]],["easeInOutExpo",[1,0,0,1]],["easeInCirc",[.6,.04,.98,.335]],["easeOutCirc",[.075,.82,.165,1]],["easeInOutCirc",[.785,.135,.15,.86]]],function(a,b){t.Easings[b[0]]=i.apply(null,b[1])});var v=t.CSS={RegEx:{isHex:/^#([A-f\d]{3}){1,2}$/i,valueUnwrap:/^[A-z]+\((.*)\)$/i,wrappedValueAlreadyExtracted:/[0-9.]+ [0-9.]+ [0-9.]+( [0-9.]+)?/,valueSplit:/([A-z]+\(.+\))|(([A-z0-9#-.]+?)(?=\s|$))/gi},Lists:{colors:["fill","stroke","stopColor","color","backgroundColor","borderColor","borderTopColor","borderRightColor","borderBottomColor","borderLeftColor","outlineColor"],transformsBase:["translateX","translateY","scale","scaleX","scaleY","skewX","skewY","rotateZ"],transforms3D:["transformPerspective","translateZ","scaleZ","rotateX","rotateY"]},Hooks:{templates:{textShadow:["Color X Y Blur","black 0px 0px 0px"],boxShadow:["Color X Y Blur Spread","black 0px 0px 0px 0px"],clip:["Top Right Bottom Left","0px 0px 0px 0px"],backgroundPosition:["X Y","0% 0%"],transformOrigin:["X Y Z","50% 50% 0px"],perspectiveOrigin:["X Y","50% 50%"]},registered:{},register:function(){for(var a=0;a<v.Lists.colors.length;a++){var b="color"===v.Lists.colors[a]?"0 0 0 1":"255 255 255 1";v.Hooks.templates[v.Lists.colors[a]]=["Red Green Blue Alpha",b]}var c,d,e;if(n)for(c in v.Hooks.templates)if(v.Hooks.templates.hasOwnProperty(c)){d=v.Hooks.templates[c],e=d[0].split(" ");var f=d[1].match(v.RegEx.valueSplit);"Color"===e[0]&&(e.push(e.shift()),f.push(f.shift()),v.Hooks.templates[c]=[e.join(" "),f.join(" ")])}for(c in v.Hooks.templates)if(v.Hooks.templates.hasOwnProperty(c)){d=v.Hooks.templates[c],e=d[0].split(" ");for(var g in e)if(e.hasOwnProperty(g)){var h=c+e[g],i=g;v.Hooks.registered[h]=[c,i]}}},getRoot:function(a){var b=v.Hooks.registered[a];return b?b[0]:a},cleanRootPropertyValue:function(a,b){return v.RegEx.valueUnwrap.test(b)&&(b=b.match(v.RegEx.valueUnwrap)[1]),v.Values.isCSSNullValue(b)&&(b=v.Hooks.templates[a][1]),b},extractValue:function(a,b){var c=v.Hooks.registered[a];if(c){var d=c[0],e=c[1];return b=v.Hooks.cleanRootPropertyValue(d,b),b.toString().match(v.RegEx.valueSplit)[e]}return b},injectValue:function(a,b,c){var d=v.Hooks.registered[a];if(d){var e,f,g=d[0],h=d[1];return c=v.Hooks.cleanRootPropertyValue(g,c),e=c.toString().match(v.RegEx.valueSplit),e[h]=b,f=e.join(" ")}return c}},Normalizations:{registered:{clip:function(a,b,c){switch(a){case"name":return"clip";case"extract":var d;return v.RegEx.wrappedValueAlreadyExtracted.test(c)?d=c:(d=c.toString().match(v.RegEx.valueUnwrap),d=d?d[1].replace(/,(\s+)?/g," "):c),d;case"inject":return"rect("+c+")"}},blur:function(a,b,c){switch(a){case"name":return t.State.isFirefox?"filter":"-webkit-filter";case"extract":var d=parseFloat(c);if(!d&&0!==d){var e=c.toString().match(/blur\(([0-9]+[A-z]+)\)/i);d=e?e[1]:0}return d;case"inject":return parseFloat(c)?"blur("+c+")":"none"}},opacity:function(a,b,c){if(n<=8)switch(a){case"name":return"filter";case"extract":var d=c.toString().match(/alpha\(opacity=(.*)\)/i);return c=d?d[1]/100:1;case"inject":return b.style.zoom=1,parseFloat(c)>=1?"":"alpha(opacity="+parseInt(100*parseFloat(c),10)+")"}else switch(a){case"name":return"opacity";case"extract":return c;case"inject":return c}}},register:function(){function a(a,b,c){var d="border-box"===v.getPropertyValue(b,"boxSizing").toString().toLowerCase();if(d===(c||!1)){var e,f,g=0,h="width"===a?["Left","Right"]:["Top","Bottom"],i=["padding"+h[0],"padding"+h[1],"border"+h[0]+"Width","border"+h[1]+"Width"];for(e=0;e<i.length;e++)f=parseFloat(v.getPropertyValue(b,i[e])),isNaN(f)||(g+=f);return c?-g:g}return 0}function b(b,c){return function(d,e,f){switch(d){case"name":return b;case"extract":return parseFloat(f)+a(b,e,c);case"inject":return parseFloat(f)-a(b,e,c)+"px"}}}n&&!(n>9)||t.State.isGingerbread||(v.Lists.transformsBase=v.Lists.transformsBase.concat(v.Lists.transforms3D));for(var c=0;c<v.Lists.transformsBase.length;c++)!function(){var a=v.Lists.transformsBase[c];v.Normalizations.registered[a]=function(b,c,e){switch(b){case"name":return"transform";case"extract":return g(c)===d||g(c).transformCache[a]===d?/^scale/i.test(a)?1:0:g(c).transformCache[a].replace(/[()]/g,"");case"inject":var f=!1;switch(a.substr(0,a.length-1)){case"translate":f=!/(%|px|em|rem|vw|vh|\d)$/i.test(e);break;case"scal":case"scale":t.State.isAndroid&&g(c).transformCache[a]===d&&e<1&&(e=1),f=!/(\d)$/i.test(e);break;case"skew":f=!/(deg|\d)$/i.test(e);break;case"rotate":f=!/(deg|\d)$/i.test(e)}return f||(g(c).transformCache[a]="("+e+")"),g(c).transformCache[a]}}}();for(var e=0;e<v.Lists.colors.length;e++)!function(){var a=v.Lists.colors[e];v.Normalizations.registered[a]=function(b,c,e){switch(b){case"name":return a;case"extract":var f;if(v.RegEx.wrappedValueAlreadyExtracted.test(e))f=e;else{var g,h={black:"rgb(0, 0, 0)",blue:"rgb(0, 0, 255)",gray:"rgb(128, 128, 128)",green:"rgb(0, 128, 0)",red:"rgb(255, 0, 0)",white:"rgb(255, 255, 255)"};/^[A-z]+$/i.test(e)?g=h[e]!==d?h[e]:h.black:v.RegEx.isHex.test(e)?g="rgb("+v.Values.hexToRgb(e).join(" ")+")":/^rgba?\(/i.test(e)||(g=h.black),f=(g||e).toString().match(v.RegEx.valueUnwrap)[1].replace(/,(\s+)?/g," ")}return(!n||n>8)&&3===f.split(" ").length&&(f+=" 1"),f;case"inject":return n<=8?4===e.split(" ").length&&(e=e.split(/\s+/).slice(0,3).join(" ")):3===e.split(" ").length&&(e+=" 1"),(n<=8?"rgb":"rgba")+"("+e.replace(/\s+/g,",").replace(/\.(\d)+(?=,)/g,"")+")"}}}();v.Normalizations.registered.innerWidth=b("width",!0),v.Normalizations.registered.innerHeight=b("height",!0),v.Normalizations.registered.outerWidth=b("width"),v.Normalizations.registered.outerHeight=b("height")}},Names:{camelCase:function(a){return a.replace(/-(\w)/g,function(a,b){return b.toUpperCase()})},SVGAttribute:function(a){var b="width|height|x|y|cx|cy|r|rx|ry|x1|x2|y1|y2";return(n||t.State.isAndroid&&!t.State.isChrome)&&(b+="|transform"),new RegExp("^("+b+")$","i").test(a)},prefixCheck:function(a){if(t.State.prefixMatches[a])return[t.State.prefixMatches[a],!0];for(var b=["","Webkit","Moz","ms","O"],c=0,d=b.length;c<d;c++){var e;if(e=0===c?a:b[c]+a.replace(/^\w/,function(a){return a.toUpperCase()}),p.isString(t.State.prefixElement.style[e]))return t.State.prefixMatches[a]=e,[e,!0]}return[a,!1]}},Values:{hexToRgb:function(a){var b,c=/^#?([a-f\d])([a-f\d])([a-f\d])$/i,d=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i;return a=a.replace(c,function(a,b,c,d){return b+b+c+c+d+d}),b=d.exec(a),b?[parseInt(b[1],16),parseInt(b[2],16),parseInt(b[3],16)]:[0,0,0]},isCSSNullValue:function(a){return!a||/^(none|auto|transparent|(rgba\(0, ?0, ?0, ?0\)))$/i.test(a)},getUnitType:function(a){return/^(rotate|skew)/i.test(a)?"deg":/(^(scale|scaleX|scaleY|scaleZ|alpha|flexGrow|flexHeight|zIndex|fontWeight)$)|((opacity|red|green|blue|alpha)$)/i.test(a)?"":"px"},getDisplayType:function(a){var b=a&&a.tagName.toString().toLowerCase();return/^(b|big|i|small|tt|abbr|acronym|cite|code|dfn|em|kbd|strong|samp|var|a|bdo|br|img|map|object|q|script|span|sub|sup|button|input|label|select|textarea)$/i.test(b)?"inline":/^(li)$/i.test(b)?"list-item":/^(tr)$/i.test(b)?"table-row":/^(table)$/i.test(b)?"table":/^(tbody)$/i.test(b)?"table-row-group":"block"},addClass:function(a,b){a.classList?a.classList.add(b):a.className+=(a.className.length?" ":"")+b},removeClass:function(a,b){a.classList?a.classList.remove(b):a.className=a.className.toString().replace(new RegExp("(^|\\s)"+b.split(" ").join("|")+"(\\s|$)","gi")," ")}},getPropertyValue:function(a,c,e,f){function h(a,c){var e=0;if(n<=8)e=m.css(a,c);else{var i=!1;/^(width|height)$/.test(c)&&0===v.getPropertyValue(a,"display")&&(i=!0,v.setPropertyValue(a,"display",v.Values.getDisplayType(a)));var j=function(){i&&v.setPropertyValue(a,"display","none")};if(!f){if("height"===c&&"border-box"!==v.getPropertyValue(a,"boxSizing").toString().toLowerCase()){var k=a.offsetHeight-(parseFloat(v.getPropertyValue(a,"borderTopWidth"))||0)-(parseFloat(v.getPropertyValue(a,"borderBottomWidth"))||0)-(parseFloat(v.getPropertyValue(a,"paddingTop"))||0)-(parseFloat(v.getPropertyValue(a,"paddingBottom"))||0);return j(),k}if("width"===c&&"border-box"!==v.getPropertyValue(a,"boxSizing").toString().toLowerCase()){var l=a.offsetWidth-(parseFloat(v.getPropertyValue(a,"borderLeftWidth"))||0)-(parseFloat(v.getPropertyValue(a,"borderRightWidth"))||0)-(parseFloat(v.getPropertyValue(a,"paddingLeft"))||0)-(parseFloat(v.getPropertyValue(a,"paddingRight"))||0);return j(),l}}var o;o=g(a)===d?b.getComputedStyle(a,null):g(a).computedStyle?g(a).computedStyle:g(a).computedStyle=b.getComputedStyle(a,null),"borderColor"===c&&(c="borderTopColor"),e=9===n&&"filter"===c?o.getPropertyValue(c):o[c],""!==e&&null!==e||(e=a.style[c]),j()}if("auto"===e&&/^(top|right|bottom|left)$/i.test(c)){var p=h(a,"position");("fixed"===p||"absolute"===p&&/top|left/i.test(c))&&(e=m(a).position()[c]+"px")}return e}var i;if(v.Hooks.registered[c]){var j=c,k=v.Hooks.getRoot(j);e===d&&(e=v.getPropertyValue(a,v.Names.prefixCheck(k)[0])),v.Normalizations.registered[k]&&(e=v.Normalizations.registered[k]("extract",a,e)),i=v.Hooks.extractValue(j,e)}else if(v.Normalizations.registered[c]){var l,o;l=v.Normalizations.registered[c]("name",a),"transform"!==l&&(o=h(a,v.Names.prefixCheck(l)[0]),v.Values.isCSSNullValue(o)&&v.Hooks.templates[c]&&(o=v.Hooks.templates[c][1])),i=v.Normalizations.registered[c]("extract",a,o)}if(!/^[\d-]/.test(i)){var p=g(a);if(p&&p.isSVG&&v.Names.SVGAttribute(c))if(/^(height|width)$/i.test(c))try{i=a.getBBox()[c]}catch(q){i=0}else i=a.getAttribute(c);else i=h(a,v.Names.prefixCheck(c)[0])}return v.Values.isCSSNullValue(i)&&(i=0),t.debug>=2&&console.log("Get "+c+": "+i),i},setPropertyValue:function(a,c,d,e,f){var h=c;if("scroll"===c)f.container?f.container["scroll"+f.direction]=d:"Left"===f.direction?b.scrollTo(d,f.alternateValue):b.scrollTo(f.alternateValue,d);else if(v.Normalizations.registered[c]&&"transform"===v.Normalizations.registered[c]("name",a))v.Normalizations.registered[c]("inject",a,d),h="transform",d=g(a).transformCache[c];else{if(v.Hooks.registered[c]){var i=c,j=v.Hooks.getRoot(c);e=e||v.getPropertyValue(a,j),d=v.Hooks.injectValue(i,d,e),c=j}if(v.Normalizations.registered[c]&&(d=v.Normalizations.registered[c]("inject",a,d),c=v.Normalizations.registered[c]("name",a)),h=v.Names.prefixCheck(c)[0],n<=8)try{a.style[h]=d}catch(k){t.debug&&console.log("Browser does not support ["+d+"] for ["+h+"]")}else{var l=g(a);l&&l.isSVG&&v.Names.SVGAttribute(c)?a.setAttribute(c,d):a.style[h]=d}t.debug>=2&&console.log("Set "+c+" ("+h+"): "+d)}return[h,d]},flushTransformCache:function(a){var b="",c=g(a);if((n||t.State.isAndroid&&!t.State.isChrome)&&c&&c.isSVG){var d=function(b){return parseFloat(v.getPropertyValue(a,b))},e={translate:[d("translateX"),d("translateY")],skewX:[d("skewX")],skewY:[d("skewY")],scale:1!==d("scale")?[d("scale"),d("scale")]:[d("scaleX"),d("scaleY")],rotate:[d("rotateZ"),0,0]};m.each(g(a).transformCache,function(a){/^translate/i.test(a)?a="translate":/^scale/i.test(a)?a="scale":/^rotate/i.test(a)&&(a="rotate"),e[a]&&(b+=a+"("+e[a].join(" ")+") ",delete e[a])})}else{var f,h;m.each(g(a).transformCache,function(c){return f=g(a).transformCache[c],"transformPerspective"===c?(h=f,!0):(9===n&&"rotateZ"===c&&(c="rotate"),void(b+=c+f+" "))}),h&&(b="perspective"+h+" "+b)}v.setPropertyValue(a,"transform",b)}};v.Hooks.register(),v.Normalizations.register(),t.hook=function(a,b,c){var e;return a=f(a),m.each(a,function(a,f){if(g(f)===d&&t.init(f),c===d)e===d&&(e=v.getPropertyValue(f,b));else{var h=v.setPropertyValue(f,b,c);"transform"===h[0]&&t.CSS.flushTransformCache(f),e=h}}),e};var w=function(){function a(){return i?y.promise||null:n}function e(a,e){function f(f){var n,o;if(i.begin&&0===A)try{i.begin.call(q,q)}catch(r){setTimeout(function(){throw r},1)}if("scroll"===D){var w,x,B,C=/^x$/i.test(i.axis)?"Left":"Top",E=parseFloat(i.offset)||0;i.container?p.isWrapped(i.container)||p.isNode(i.container)?(i.container=i.container[0]||i.container,w=i.container["scroll"+C],B=w+m(a).position()[C.toLowerCase()]+E):i.container=null:(w=t.State.scrollAnchor[t.State["scrollProperty"+C]],x=t.State.scrollAnchor[t.State["scrollProperty"+("Left"===C?"Top":"Left")]],B=m(a).offset()[C.toLowerCase()]+E),l={scroll:{rootPropertyValue:!1,startValue:w,currentValue:w,endValue:B,unitType:"",easing:i.easing,scrollData:{container:i.container,direction:C,alternateValue:x}},element:a},t.debug&&console.log("tweensContainer (scroll): ",l.scroll,a)}else if("reverse"===D){if(n=g(a),!n)return;if(!n.tweensContainer)return void m.dequeue(a,i.queue);"none"===n.opts.display&&(n.opts.display="auto"),"hidden"===n.opts.visibility&&(n.opts.visibility="visible"),n.opts.loop=!1,n.opts.begin=null,n.opts.complete=null,u.easing||delete i.easing,u.duration||delete i.duration,i=m.extend({},n.opts,i),o=m.extend(!0,{},n?n.tweensContainer:null);for(var F in o)if(o.hasOwnProperty(F)&&"element"!==F){var G=o[F].startValue;o[F].startValue=o[F].currentValue=o[F].endValue,o[F].endValue=G,p.isEmptyObject(u)||(o[F].easing=i.easing),t.debug&&console.log("reverse tweensContainer ("+F+"): "+JSON.stringify(o[F]),a)}l=o}else if("start"===D){n=g(a),n&&n.tweensContainer&&n.isAnimating===!0&&(o=n.tweensContainer);var H=function(b,c){var f,g,h;return p.isFunction(b)&&(b=b.call(a,e,z)),p.isArray(b)?(f=b[0],!p.isArray(b[1])&&/^[\d-]/.test(b[1])||p.isFunction(b[1])||v.RegEx.isHex.test(b[1])?h=b[1]:(p.isString(b[1])&&!v.RegEx.isHex.test(b[1])||p.isArray(b[1]))&&(g=c?b[1]:j(b[1],i.duration),b[2]!==d&&(h=b[2]))):f=b,c||(g=g||i.easing),p.isFunction(f)&&(f=f.call(a,e,z)),p.isFunction(h)&&(h=h.call(a,e,z)),[f||0,g,h]},K=function(e,f){var g=v.Hooks.getRoot(e),j=!1,k=f[0],p=f[1],q=f[2];if(!(n&&n.isSVG||"tween"===g||v.Names.prefixCheck(g)[1]!==!1||v.Normalizations.registered[g]!==d))return void(t.debug&&console.log("Skipping ["+g+"] due to a lack of browser support."));(i.display!==d&&null!==i.display&&"none"!==i.display||i.visibility!==d&&"hidden"!==i.visibility)&&/opacity|filter/.test(e)&&!q&&0!==k&&(q=0),i._cacheValues&&o&&o[e]?(q===d&&(q=o[e].endValue+o[e].unitType),j=n.rootPropertyValueCache[g]):v.Hooks.registered[e]?q===d?(j=v.getPropertyValue(a,g),q=v.getPropertyValue(a,e,j)):j=v.Hooks.templates[g][1]:q===d&&(q=v.getPropertyValue(a,e));var r,s,u,w=!1,x=function(a,b){var c,d;return d=(b||"0").toString().toLowerCase().replace(/[%A-z]+$/,function(a){return c=a,""}),c||(c=v.Values.getUnitType(a)),[d,c]};r=x(e,q),q=r[0],u=r[1],r=x(e,k),k=r[0].replace(/^([+-\/*])=/,function(a,b){return w=b,""}),s=r[1],q=parseFloat(q)||0,k=parseFloat(k)||0,"%"===s&&(/^(fontSize|lineHeight)$/.test(e)?(k/=100,s="em"):/^scale/.test(e)?(k/=100,s=""):/(Red|Green|Blue)$/i.test(e)&&(k=k/100*255,s=""));var y=function(){var d={myParent:a.parentNode||c.body,position:v.getPropertyValue(a,"position"),fontSize:v.getPropertyValue(a,"fontSize")},e=d.position===I.lastPosition&&d.myParent===I.lastParent,f=d.fontSize===I.lastFontSize;I.lastParent=d.myParent,I.lastPosition=d.position,I.lastFontSize=d.fontSize;var g=100,h={};if(f&&e)h.emToPx=I.lastEmToPx,h.percentToPxWidth=I.lastPercentToPxWidth,h.percentToPxHeight=I.lastPercentToPxHeight;else{var i=n&&n.isSVG?c.createElementNS("http://www.w3.org/2000/svg","rect"):c.createElement("div");t.init(i),d.myParent.appendChild(i),m.each(["overflow","overflowX","overflowY"],function(a,b){t.CSS.setPropertyValue(i,b,"hidden")}),t.CSS.setPropertyValue(i,"position",d.position),t.CSS.setPropertyValue(i,"fontSize",d.fontSize),t.CSS.setPropertyValue(i,"boxSizing","content-box"),m.each(["minWidth","maxWidth","width","minHeight","maxHeight","height"],function(a,b){t.CSS.setPropertyValue(i,b,g+"%")}),t.CSS.setPropertyValue(i,"paddingLeft",g+"em"),h.percentToPxWidth=I.lastPercentToPxWidth=(parseFloat(v.getPropertyValue(i,"width",null,!0))||1)/g,h.percentToPxHeight=I.lastPercentToPxHeight=(parseFloat(v.getPropertyValue(i,"height",null,!0))||1)/g,h.emToPx=I.lastEmToPx=(parseFloat(v.getPropertyValue(i,"paddingLeft"))||1)/g,d.myParent.removeChild(i)}return null===I.remToPx&&(I.remToPx=parseFloat(v.getPropertyValue(c.body,"fontSize"))||16),null===I.vwToPx&&(I.vwToPx=parseFloat(b.innerWidth)/100,I.vhToPx=parseFloat(b.innerHeight)/100),h.remToPx=I.remToPx,h.vwToPx=I.vwToPx,h.vhToPx=I.vhToPx,t.debug>=1&&console.log("Unit ratios: "+JSON.stringify(h),a),h};if(/[\/*]/.test(w))s=u;else if(u!==s&&0!==q)if(0===k)s=u;else{h=h||y();var z=/margin|padding|left|right|width|text|word|letter/i.test(e)||/X$/.test(e)||"x"===e?"x":"y";switch(u){case"%":q*="x"===z?h.percentToPxWidth:h.percentToPxHeight;break;case"px":break;default:q*=h[u+"ToPx"]}switch(s){case"%":q*=1/("x"===z?h.percentToPxWidth:h.percentToPxHeight);break;case"px":break;default:q*=1/h[s+"ToPx"]}}switch(w){case"+":k=q+k;break;case"-":k=q-k;break;case"*":k=q*k;break;case"/":k=q/k}l[e]={rootPropertyValue:j,startValue:q,currentValue:q,endValue:k,unitType:s,easing:p},t.debug&&console.log("tweensContainer ("+e+"): "+JSON.stringify(l[e]),a)};for(var L in s)if(s.hasOwnProperty(L)){var M=v.Names.camelCase(L),N=H(s[L]);if(v.Lists.colors.indexOf(M)>=0){var O=N[0],P=N[1],Q=N[2];if(v.RegEx.isHex.test(O)){for(var R=["Red","Green","Blue"],S=v.Values.hexToRgb(O),T=Q?v.Values.hexToRgb(Q):d,U=0;U<R.length;U++){var V=[S[U]];P&&V.push(P),T!==d&&V.push(T[U]),K(M+R[U],V)}continue}}K(M,N)}l.element=a}l.element&&(v.Values.addClass(a,"velocity-animating"),J.push(l),n=g(a),n&&(""===i.queue&&(n.tweensContainer=l,n.opts=i),n.isAnimating=!0),A===z-1?(t.State.calls.push([J,q,i,null,y.resolver]),t.State.isTicking===!1&&(t.State.isTicking=!0,k())):A++)}var h,i=m.extend({},t.defaults,u),l={};switch(g(a)===d&&t.init(a),parseFloat(i.delay)&&i.queue!==!1&&m.queue(a,i.queue,function(b){t.velocityQueueEntryFlag=!0,g(a).delayTimer={setTimeout:setTimeout(b,parseFloat(i.delay)),next:b}}),i.duration.toString().toLowerCase()){case"fast":i.duration=200;break;case"normal":i.duration=r;break;case"slow":i.duration=600;break;default:i.duration=parseFloat(i.duration)||1}t.mock!==!1&&(t.mock===!0?i.duration=i.delay=1:(i.duration*=parseFloat(t.mock)||1,i.delay*=parseFloat(t.mock)||1)),i.easing=j(i.easing,i.duration),i.begin&&!p.isFunction(i.begin)&&(i.begin=null),i.progress&&!p.isFunction(i.progress)&&(i.progress=null),i.complete&&!p.isFunction(i.complete)&&(i.complete=null),i.display!==d&&null!==i.display&&(i.display=i.display.toString().toLowerCase(),"auto"===i.display&&(i.display=t.CSS.Values.getDisplayType(a))),i.visibility!==d&&null!==i.visibility&&(i.visibility=i.visibility.toString().toLowerCase()),i.mobileHA=i.mobileHA&&t.State.isMobile&&!t.State.isGingerbread,i.queue===!1?i.delay?setTimeout(f,i.delay):f():m.queue(a,i.queue,function(a,b){return b===!0?(y.promise&&y.resolver(q),!0):(t.velocityQueueEntryFlag=!0,void f(a))}),""!==i.queue&&"fx"!==i.queue||"inprogress"===m.queue(a)[0]||m.dequeue(a)}var h,i,n,o,q,s,u,x=arguments[0]&&(arguments[0].p||m.isPlainObject(arguments[0].properties)&&!arguments[0].properties.names||p.isString(arguments[0].properties));p.isWrapped(this)?(i=!1,o=0,q=this,n=this):(i=!0,o=1,q=x?arguments[0].elements||arguments[0].e:arguments[0]);var y={promise:null,resolver:null,rejecter:null};if(i&&t.Promise&&(y.promise=new t.Promise(function(a,b){
		y.resolver=a,y.rejecter=b})),x?(s=arguments[0].properties||arguments[0].p,u=arguments[0].options||arguments[0].o):(s=arguments[o],u=arguments[o+1]),q=f(q),!q)return void(y.promise&&(s&&u&&u.promiseRejectEmpty===!1?y.resolver():y.rejecter()));var z=q.length,A=0;if(!/^(stop|finish|finishAll)$/i.test(s)&&!m.isPlainObject(u)){var B=o+1;u={};for(var C=B;C<arguments.length;C++)p.isArray(arguments[C])||!/^(fast|normal|slow)$/i.test(arguments[C])&&!/^\d/.test(arguments[C])?p.isString(arguments[C])||p.isArray(arguments[C])?u.easing=arguments[C]:p.isFunction(arguments[C])&&(u.complete=arguments[C]):u.duration=arguments[C]}var D;switch(s){case"scroll":D="scroll";break;case"reverse":D="reverse";break;case"finish":case"finishAll":case"stop":m.each(q,function(a,b){g(b)&&g(b).delayTimer&&(clearTimeout(g(b).delayTimer.setTimeout),g(b).delayTimer.next&&g(b).delayTimer.next(),delete g(b).delayTimer),"finishAll"!==s||u!==!0&&!p.isString(u)||(m.each(m.queue(b,p.isString(u)?u:""),function(a,b){p.isFunction(b)&&b()}),m.queue(b,p.isString(u)?u:"",[]))});var E=[];return m.each(t.State.calls,function(a,b){b&&m.each(b[1],function(c,e){var f=u===d?"":u;return f!==!0&&b[2].queue!==f&&(u!==d||b[2].queue!==!1)||void m.each(q,function(c,d){if(d===e)if((u===!0||p.isString(u))&&(m.each(m.queue(d,p.isString(u)?u:""),function(a,b){p.isFunction(b)&&b(null,!0)}),m.queue(d,p.isString(u)?u:"",[])),"stop"===s){var h=g(d);h&&h.tweensContainer&&f!==!1&&m.each(h.tweensContainer,function(a,b){b.endValue=b.currentValue}),E.push(a)}else"finish"!==s&&"finishAll"!==s||(b[2].duration=1)})})}),"stop"===s&&(m.each(E,function(a,b){l(b,!0)}),y.promise&&y.resolver(q)),a();default:if(!m.isPlainObject(s)||p.isEmptyObject(s)){if(p.isString(s)&&t.Redirects[s]){h=m.extend({},u);var F=h.duration,G=h.delay||0;return h.backwards===!0&&(q=m.extend(!0,[],q).reverse()),m.each(q,function(a,b){parseFloat(h.stagger)?h.delay=G+parseFloat(h.stagger)*a:p.isFunction(h.stagger)&&(h.delay=G+h.stagger.call(b,a,z)),h.drag&&(h.duration=parseFloat(F)||(/^(callout|transition)/.test(s)?1e3:r),h.duration=Math.max(h.duration*(h.backwards?1-a/z:(a+1)/z),.75*h.duration,200)),t.Redirects[s].call(b,b,h||{},a,z,q,y.promise?y:d)}),a()}var H="Velocity: First argument ("+s+") was not a property map, a known action, or a registered redirect. Aborting.";return y.promise?y.rejecter(new Error(H)):console.log(H),a()}D="start"}var I={lastParent:null,lastPosition:null,lastFontSize:null,lastPercentToPxWidth:null,lastPercentToPxHeight:null,lastEmToPx:null,remToPx:null,vwToPx:null,vhToPx:null},J=[];m.each(q,function(a,b){p.isNode(b)&&e(b,a)}),h=m.extend({},t.defaults,u),h.loop=parseInt(h.loop,10);var K=2*h.loop-1;if(h.loop)for(var L=0;L<K;L++){var M={delay:h.delay,progress:h.progress};L===K-1&&(M.display=h.display,M.visibility=h.visibility,M.complete=h.complete),w(q,"reverse",M)}return a()};t=m.extend(w,t),t.animate=w;var x=b.requestAnimationFrame||o;return t.State.isMobile||c.hidden===d||c.addEventListener("visibilitychange",function(){c.hidden?(x=function(a){return setTimeout(function(){a(!0)},16)},k()):x=b.requestAnimationFrame||o}),a.Velocity=t,a!==b&&(a.fn.velocity=w,a.fn.velocity.defaults=t.defaults),m.each(["Down","Up"],function(a,b){t.Redirects["slide"+b]=function(a,c,e,f,g,h){var i=m.extend({},c),j=i.begin,k=i.complete,l={},n={height:"",marginTop:"",marginBottom:"",paddingTop:"",paddingBottom:""};i.display===d&&(i.display="Down"===b?"inline"===t.CSS.Values.getDisplayType(a)?"inline-block":"block":"none"),i.begin=function(){0===e&&j&&j.call(g,g);for(var c in n)if(n.hasOwnProperty(c)){l[c]=a.style[c];var d=v.getPropertyValue(a,c);n[c]="Down"===b?[d,0]:[0,d]}l.overflow=a.style.overflow,a.style.overflow="hidden"},i.complete=function(){for(var b in l)l.hasOwnProperty(b)&&(a.style[b]=l[b]);e===f-1&&(k&&k.call(g,g),h&&h.resolver(g))},t(a,n,i)}}),m.each(["In","Out"],function(a,b){t.Redirects["fade"+b]=function(a,c,e,f,g,h){var i=m.extend({},c),j=i.complete,k={opacity:"In"===b?1:0};0!==e&&(i.begin=null),e!==f-1?i.complete=null:i.complete=function(){j&&j.call(g,g),h&&h.resolver(g)},i.display===d&&(i.display="In"===b?"auto":"none"),t(this,k,i)}}),t}(window.jQuery||window.Zepto||window,window,document)});

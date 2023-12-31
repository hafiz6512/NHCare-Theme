

jQuery(document).ready(function($){
//Start All StickySidebar
    !function(){for(var n=0,i=["ms","moz","webkit","o"],e=0;e<i.length&&!window.requestAnimationFrame;++e)window.requestAnimationFrame=window[i[e]+"RequestAnimationFrame"],window.cancelAnimationFrame=window[i[e]+"CancelAnimationFrame"]||window[i[e]+"CancelRequestAnimationFrame"];window.requestAnimationFrame||(window.requestAnimationFrame=function(i,e){var a=(new Date).getTime(),o=Math.max(0,16-(a-n)),t=window.setTimeout(function(){i(a+o)},o);return n=a+o,t}),window.cancelAnimationFrame||(window.cancelAnimationFrame=function(n){clearTimeout(n)})}();

//resize extras
    !function(e,t){"function"==typeof define&&define.amd?define(t):"object"==typeof exports?module.exports=t():e.ResizeSensor=t()}("undefined"!=typeof window?window:this,function(){if("undefined"==typeof window)return null;var e=window.requestAnimationFrame||window.mozRequestAnimationFrame||window.webkitRequestAnimationFrame||function(e){return window.setTimeout(e,20)};function t(e,t){var i=Object.prototype.toString.call(e),n="[object Array]"===i||"[object NodeList]"===i||"[object HTMLCollection]"===i||"[object Object]"===i||"undefined"!=typeof jQuery&&e instanceof jQuery||"undefined"!=typeof Elements&&e instanceof Elements,o=0,s=e.length;if(n)for(;o<s;o++)t(e[o]);else t(e)}var i=function(n,o){function s(){var e,t,i=[];this.add=function(e){i.push(e)},this.call=function(){for(e=0,t=i.length;e<t;e++)i[e].call()},this.remove=function(n){var o=[];for(e=0,t=i.length;e<t;e++)i[e]!==n&&o.push(i[e]);i=o},this.length=function(){return i.length}}t(n,function(t){!function(t,i){if(t)if(t.resizedAttached)t.resizedAttached.add(i);else{t.resizedAttached=new s,t.resizedAttached.add(i),t.resizeSensor=document.createElement("div"),t.resizeSensor.className="resize-sensor";var n="position: absolute; left: 0; top: 0; right: 0; bottom: 0; overflow: hidden; z-index: -1; visibility: hidden;",o="position: absolute; left: 0; top: 0; transition: 0s;";t.resizeSensor.style.cssText=n,t.resizeSensor.innerHTML='<div class="resize-sensor-expand" style="'+n+'"><div style="'+o+'"></div></div><div class="resize-sensor-shrink" style="'+n+'"><div style="'+o+' width: 200%; height: 200%"></div></div>',t.appendChild(t.resizeSensor),t.resizeSensor.offsetParent!==t&&(t.style.position="relative");var r,d,c,l,f=t.resizeSensor.childNodes[0],a=f.childNodes[0],h=t.resizeSensor.childNodes[1],u=t.offsetWidth,z=t.offsetHeight,v=function(){a.style.width="100000px",a.style.height="100000px",f.scrollLeft=1e5,f.scrollTop=1e5,h.scrollLeft=1e5,h.scrollTop=1e5};v();var p=function(){d=0,r&&(u=c,z=l,t.resizedAttached&&t.resizedAttached.call())},y=function(){c=t.offsetWidth,l=t.offsetHeight,(r=c!=u||l!=z)&&!d&&(d=e(p)),v()},m=function(e,t,i){e.attachEvent?e.attachEvent("on"+t,i):e.addEventListener(t,i)};m(f,"scroll",y),m(h,"scroll",y)}}(t,o)}),this.detach=function(e){i.detach(n,e)}};return i.detach=function(e,i){t(e,function(e){e&&(e.resizedAttached&&"function"==typeof i&&(e.resizedAttached.remove(i),e.resizedAttached.length())||e.resizeSensor&&(e.contains(e.resizeSensor)&&e.removeChild(e.resizeSensor),delete e.resizeSensor,delete e.resizedAttached))})},i});

//sticky sidebar code
    !function(t,e){"object"==typeof exports&&"undefined"!=typeof module?e(exports):"function"==typeof define&&define.amd?define(["exports"],e):e(t.StickySidebar={})}(this,function(t){"use strict";"undefined"!=typeof window?window:"undefined"!=typeof global?global:"undefined"!=typeof self&&self;var e,i,n=(function(t,e){!function(t){Object.defineProperty(t,"__esModule",{value:!0});var e,i,n=function(){function t(t,e){for(var i=0;i<e.length;i++){var n=e[i];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(t,n.key,n)}}return function(e,i,n){return i&&t(e.prototype,i),n&&t(e,n),e}}(),o=(e=".stickySidebar",i={topSpacing:0,bottomSpacing:0,containerSelector:!1,innerWrapperSelector:".inner-wrapper-sticky",stickyClass:"is-affixed",resizeSensor:!0,minWidth:!1},function(){function t(e){var n=this,o=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};if(function(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}(this,t),this.options=t.extend(i,o),this.sidebar="string"==typeof e?document.querySelector(e):e,void 0===this.sidebar)throw new Error("There is no specific sidebar element.");this.sidebarInner=!1,this.container=this.sidebar.parentElement,this.affixedType="STATIC",this.direction="down",this.support={transform:!1,transform3d:!1},this._initialized=!1,this._reStyle=!1,this._breakpoint=!1,this.dimensions={translateY:0,maxTranslateY:0,topSpacing:0,lastTopSpacing:0,bottomSpacing:0,lastBottomSpacing:0,sidebarHeight:0,sidebarWidth:0,containerTop:0,containerHeight:0,viewportHeight:0,viewportTop:0,lastViewportTop:0},["handleEvent"].forEach(function(t){n[t]=n[t].bind(n)}),this.initialize()}return n(t,[{key:"initialize",value:function(){var t=this;if(this._setSupportFeatures(),this.options.innerWrapperSelector&&(this.sidebarInner=this.sidebar.querySelector(this.options.innerWrapperSelector),null===this.sidebarInner&&(this.sidebarInner=!1)),!this.sidebarInner){var e=document.createElement("div");for(e.setAttribute("class","inner-wrapper-sticky"),this.sidebar.appendChild(e);this.sidebar.firstChild!=e;)e.appendChild(this.sidebar.firstChild);this.sidebarInner=this.sidebar.querySelector(".inner-wrapper-sticky")}if(this.options.containerSelector){var i=document.querySelectorAll(this.options.containerSelector);if((i=Array.prototype.slice.call(i)).forEach(function(e,i){e.contains(t.sidebar)&&(t.container=e)}),!i.length)throw new Error("The container does not contains on the sidebar.")}"function"!=typeof this.options.topSpacing&&(this.options.topSpacing=parseInt(this.options.topSpacing)||0),"function"!=typeof this.options.bottomSpacing&&(this.options.bottomSpacing=parseInt(this.options.bottomSpacing)||0),this._widthBreakpoint(),this.calcDimensions(),this.stickyPosition(),this.bindEvents(),this._initialized=!0}},{key:"bindEvents",value:function(){window.addEventListener("resize",this,{passive:!0,capture:!1}),window.addEventListener("scroll",this,{passive:!0,capture:!1}),this.sidebar.addEventListener("update"+e,this),this.options.resizeSensor&&"undefined"!=typeof ResizeSensor&&(new ResizeSensor(this.sidebarInner,this.handleEvent),new ResizeSensor(this.container,this.handleEvent))}},{key:"handleEvent",value:function(t){this.updateSticky(t)}},{key:"calcDimensions",value:function(){if(!this._breakpoint){var e=this.dimensions;e.containerTop=t.offsetRelative(this.container).top,e.containerHeight=this.container.clientHeight,e.containerBottom=e.containerTop+e.containerHeight,e.sidebarHeight=this.sidebarInner.offsetHeight,e.sidebarWidth=this.sidebarInner.offsetWidth,e.viewportHeight=window.innerHeight,e.maxTranslateY=e.containerHeight-e.sidebarHeight,this._calcDimensionsWithScroll()}}},{key:"_calcDimensionsWithScroll",value:function(){var e=this.dimensions;e.sidebarLeft=t.offsetRelative(this.sidebar).left,e.viewportTop=document.documentElement.scrollTop||document.body.scrollTop,e.viewportBottom=e.viewportTop+e.viewportHeight,e.viewportLeft=document.documentElement.scrollLeft||document.body.scrollLeft,e.topSpacing=this.options.topSpacing,e.bottomSpacing=this.options.bottomSpacing,"function"==typeof e.topSpacing&&(e.topSpacing=parseInt(e.topSpacing(this.sidebar))||0),"function"==typeof e.bottomSpacing&&(e.bottomSpacing=parseInt(e.bottomSpacing(this.sidebar))||0),"VIEWPORT-TOP"===this.affixedType?e.topSpacing<e.lastTopSpacing&&(e.translateY+=e.lastTopSpacing-e.topSpacing,this._reStyle=!0):"VIEWPORT-BOTTOM"===this.affixedType&&e.bottomSpacing<e.lastBottomSpacing&&(e.translateY+=e.lastBottomSpacing-e.bottomSpacing,this._reStyle=!0),e.lastTopSpacing=e.topSpacing,e.lastBottomSpacing=e.bottomSpacing}},{key:"isSidebarFitsViewport",value:function(){var t=this.dimensions,e="down"===this.scrollDirection?t.lastBottomSpacing:t.lastTopSpacing;return this.dimensions.sidebarHeight+e<this.dimensions.viewportHeight}},{key:"observeScrollDir",value:function(){var t=this.dimensions;if(t.lastViewportTop!==t.viewportTop){var e="down"===this.direction?Math.min:Math.max;t.viewportTop===e(t.viewportTop,t.lastViewportTop)&&(this.direction="down"===this.direction?"up":"down")}}},{key:"getAffixType",value:function(){this._calcDimensionsWithScroll();var t=this.dimensions,e=t.viewportTop+t.topSpacing,i=this.affixedType;return e<=t.containerTop||t.containerHeight<=t.sidebarHeight?(t.translateY=0,i="STATIC"):i="up"===this.direction?this._getAffixTypeScrollingUp():this._getAffixTypeScrollingDown(),t.translateY=Math.max(0,t.translateY),t.translateY=Math.min(t.containerHeight,t.translateY),t.translateY=Math.round(t.translateY),t.lastViewportTop=t.viewportTop,i}},{key:"_getAffixTypeScrollingDown",value:function(){var t=this.dimensions,e=t.sidebarHeight+t.containerTop,i=t.viewportTop+t.topSpacing,n=t.viewportBottom-t.bottomSpacing,o=this.affixedType;return this.isSidebarFitsViewport()?t.sidebarHeight+i>=t.containerBottom?(t.translateY=t.containerBottom-e,o="CONTAINER-BOTTOM"):i>=t.containerTop&&(t.translateY=i-t.containerTop,o="VIEWPORT-TOP"):t.containerBottom<=n?(t.translateY=t.containerBottom-e,o="CONTAINER-BOTTOM"):e+t.translateY<=n?(t.translateY=n-e,o="VIEWPORT-BOTTOM"):t.containerTop+t.translateY<=i&&0!==t.translateY&&t.maxTranslateY!==t.translateY&&(o="VIEWPORT-UNBOTTOM"),o}},{key:"_getAffixTypeScrollingUp",value:function(){var t=this.dimensions,e=t.sidebarHeight+t.containerTop,i=t.viewportTop+t.topSpacing,n=t.viewportBottom-t.bottomSpacing,o=this.affixedType;return i<=t.translateY+t.containerTop?(t.translateY=i-t.containerTop,o="VIEWPORT-TOP"):t.containerBottom<=n?(t.translateY=t.containerBottom-e,o="CONTAINER-BOTTOM"):this.isSidebarFitsViewport()||t.containerTop<=i&&0!==t.translateY&&t.maxTranslateY!==t.translateY&&(o="VIEWPORT-UNBOTTOM"),o}},{key:"_getStyle",value:function(e){if(void 0!==e){var i={inner:{},outer:{}},n=this.dimensions;switch(e){case"VIEWPORT-TOP":i.inner={position:"fixed",top:n.topSpacing,left:n.sidebarLeft-n.viewportLeft,width:n.sidebarWidth};break;case"VIEWPORT-BOTTOM":i.inner={position:"fixed",top:"auto",left:n.sidebarLeft,bottom:n.bottomSpacing,width:n.sidebarWidth};break;case"CONTAINER-BOTTOM":case"VIEWPORT-UNBOTTOM":var o=this._getTranslate(0,n.translateY+"px");i.inner=o?{transform:o}:{position:"absolute",top:n.translateY,width:n.sidebarWidth}}switch(e){case"VIEWPORT-TOP":case"VIEWPORT-BOTTOM":case"VIEWPORT-UNBOTTOM":case"CONTAINER-BOTTOM":i.outer={height:n.sidebarHeight,position:"relative"}}return i.outer=t.extend({height:"",position:""},i.outer),i.inner=t.extend({position:"relative",top:"",left:"",bottom:"",width:"",transform:""},i.inner),i}}},{key:"stickyPosition",value:function(i){if(!this._breakpoint){i=this._reStyle||i||!1,this.options.topSpacing,this.options.bottomSpacing;var n=this.getAffixType(),o=this._getStyle(n);if((this.affixedType!=n||i)&&n){var s="affix."+n.toLowerCase().replace("viewport-","")+e;for(var r in t.eventTrigger(this.sidebar,s),"STATIC"===n?t.removeClass(this.sidebar,this.options.stickyClass):t.addClass(this.sidebar,this.options.stickyClass),o.outer){var a="number"==typeof o.outer[r]?"px":"";this.sidebar.style[r]=o.outer[r]+a}for(var p in o.inner){var c="number"==typeof o.inner[p]?"px":"";this.sidebarInner.style[p]=o.inner[p]+c}var l="affixed."+n.toLowerCase().replace("viewport-","")+e;t.eventTrigger(this.sidebar,l)}else this._initialized&&(this.sidebarInner.style.left=o.inner.left);this.affixedType=n}}},{key:"_widthBreakpoint",value:function(){window.innerWidth<=this.options.minWidth?(this._breakpoint=!0,this.affixedType="STATIC",this.sidebar.removeAttribute("style"),t.removeClass(this.sidebar,this.options.stickyClass),this.sidebarInner.removeAttribute("style")):this._breakpoint=!1}},{key:"updateSticky",value:function(){var t,e=this,i=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{};this._running||(this._running=!0,t=i.type,requestAnimationFrame(function(){switch(t){case"scroll":e._calcDimensionsWithScroll(),e.observeScrollDir(),e.stickyPosition();break;case"resize":default:e._widthBreakpoint(),e.calcDimensions(),e.stickyPosition(!0)}e._running=!1}))}},{key:"_setSupportFeatures",value:function(){var e=this.support;e.transform=t.supportTransform(),e.transform3d=t.supportTransform(!0)}},{key:"_getTranslate",value:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:0,e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:0,i=arguments.length>2&&void 0!==arguments[2]?arguments[2]:0;return this.support.transform3d?"translate3d("+t+", "+e+", "+i+")":!!this.support.translate&&"translate("+t+", "+e+")"}},{key:"destroy",value:function(){window.removeEventListener("resize",this,{capture:!1}),window.removeEventListener("scroll",this,{capture:!1}),this.sidebar.classList.remove(this.options.stickyClass),this.sidebar.style.minHeight="",this.sidebar.removeEventListener("update"+e,this);var t={inner:{},outer:{}};for(var i in t.inner={position:"",top:"",left:"",bottom:"",width:"",transform:""},t.outer={height:"",position:""},t.outer)this.sidebar.style[i]=t.outer[i];for(var n in t.inner)this.sidebarInner.style[n]=t.inner[n];this.options.resizeSensor&&"undefined"!=typeof ResizeSensor&&(ResizeSensor.detach(this.sidebarInner,this.handleEvent),ResizeSensor.detach(this.container,this.handleEvent))}}],[{key:"supportTransform",value:function(t){var e=!1,i=t?"perspective":"transform",n=i.charAt(0).toUpperCase()+i.slice(1),o=document.createElement("support").style;return(i+" "+["Webkit","Moz","O","ms"].join(n+" ")+n).split(" ").forEach(function(t,i){if(void 0!==o[t])return e=t,!1}),e}},{key:"eventTrigger",value:function(t,e,i){try{var n=new CustomEvent(e,{detail:i})}catch(t){(n=document.createEvent("CustomEvent")).initCustomEvent(e,!0,!0,i)}t.dispatchEvent(n)}},{key:"extend",value:function(t,e){var i={};for(var n in t)void 0!==e[n]?i[n]=e[n]:i[n]=t[n];return i}},{key:"offsetRelative",value:function(t){var e={left:0,top:0};do{var i=t.offsetTop,n=t.offsetLeft;isNaN(i)||(e.top+=i),isNaN(n)||(e.left+=n),t="BODY"===t.tagName?t.parentElement:t.offsetParent}while(t);return e}},{key:"addClass",value:function(e,i){t.hasClass(e,i)||(e.classList?e.classList.add(i):e.className+=" "+i)}},{key:"removeClass",value:function(e,i){t.hasClass(e,i)&&(e.classList?e.classList.remove(i):e.className=e.className.replace(new RegExp("(^|\\b)"+i.split(" ").join("|")+"(\\b|$)","gi")," "))}},{key:"hasClass",value:function(t,e){return t.classList?t.classList.contains(e):new RegExp("(^| )"+e+"( |$)","gi").test(t.className)}},{key:"defaults",get:function(){return i}}]),t}());t.default=o,window.StickySidebar=o}(e)}(e={exports:{}},e.exports),e.exports),o=(i=n)&&i.__esModule&&Object.prototype.hasOwnProperty.call(i,"default")?i.default:i;t.default=o,t.__moduleExports=n,Object.defineProperty(t,"__esModule",{value:!0})});
//END All StickySidebar

    var sidebar = new StickySidebar('.stickynav', {
        containerSelector: '.container-stickynav',
        innerWrapperSelector: '.stickynav .thenav',
        topSpacing: 100,
        bottomSpacing: 100
    });

    // Cache selectors
    var lastId
    var pastId
    topMenu = $(".navwrap"),
        topMenuHeight = topMenu.outerHeight()+1,
        // All list items
        menuItems = topMenu.find("a"),
        // Anchors corresponding to menu items
        scrollItems = menuItems.map(function(){
            var item = $($(this).attr("href"));
            if (item.length) { return item; }
        });

    // Bind click handler to menu items
    // so we can get a fancy scroll animation
    menuItems.click(function(e){
	    //var href = $(this).attr("href"), offsetTop = href === "#" ? 0 : $(href).offset().top;
	    //$('html, body').stop().animate({scrollTop: offsetTop}, 1200, "swing");e.preventDefault();

		//if ($('body').find('.services.resources').length > 0) {     
       //$(this).delay(1000).queue(function() {
        if ($(this).parent().is('.stay')){
	        var href = $(this).attr("href"), offsetTop = href === "#" ? 0 : $(href).offset().top - 60;
        }else{
	        var href = $(this).attr("href"), offsetTop = href === "#" ? 0 : $(href).offset().top;
	    }
	    $('html, body').stop().animate({scrollTop: offsetTop}, 1000, "swing");e.preventDefault();

	    //});
	    //}
        

    });

    var curItem = menuItems.parent();

    // Bind to scroll
    $(window).scroll(function(){
        // Get container scroll position
        if ($('body').find('.services.resources').length > 0) {
        var fromTop = $(this).scrollTop()+topMenuHeight - 400;
        }else {var fromTop = $(this).scrollTop()+topMenuHeight - 250;}

        // Get id of current scroll item
        var cur = scrollItems.map(function(){
            if ($(this).offset().top < fromTop)
                return this;
        });
        // Get the id of the current element
        cur = cur[cur.length-1];
        var id = cur && cur.length ? cur[0].id : "";

        if (lastId !== id) {
            lastId = id;
            // Set/remove active class
            menuItems
                .parent().removeClass("active")
                .end().filter("[href=\\#"+id+"]").parent().addClass("active");

            if (curItem.is(".active")) {topMenu.find('.nav-op.active').prevAll().addClass("stay");topMenu.find('.nav-op.active').nextAll().removeClass("stay");}
            if (!curItem.is(".active")) {topMenu.find('.nav-op:first-of-type').removeClass("stay");}
            if (curItem.is(".active") && curItem.first()) {$('.navwrap').addClass("start");} else{$('.navwrap').removeClass("start");}
            if (curItem.is(".active:last-child")) {$('.navwrap').addClass("end");} else{$('.navwrap').removeClass("end");}
        }

    });


});

/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/assets/js/app.js":
/*!************************************!*\
  !*** ./resources/assets/js/app.js ***!
  \************************************/
/***/ (() => {

/*
Template Name: Minia - Bootstrap 5 Admin & Dashboard Template
Author: Themesbrand
Version: 1.2.0.
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Main Js File
*/
(function ($) {
  'use strict';

  var language = localStorage.getItem('minia-language'); // Default Language

  var default_lang = 'en';

  function setLanguage(lang) {
    if (document.getElementById("header-lang-img")) {
      if (lang == 'en') {
        document.getElementById("header-lang-img").src = "assets/images/flags/us.jpg";
      } else if (lang == 'sp') {
        document.getElementById("header-lang-img").src = "assets/images/flags/spain.jpg";
      } else if (lang == 'gr') {
        document.getElementById("header-lang-img").src = "assets/images/flags/germany.jpg";
      } else if (lang == 'it') {
        document.getElementById("header-lang-img").src = "assets/images/flags/italy.jpg";
      } else if (lang == 'ru') {
        document.getElementById("header-lang-img").src = "assets/images/flags/russia.jpg";
      }

      localStorage.setItem('minia-language', lang);
      language = localStorage.getItem('minia-language');
      getLanguage();
    }
  } // Multi language setting


  function getLanguage() {
    language == null ? setLanguage(default_lang) : false;
    $.getJSON('assets/lang/' + language + '.json', function (lang) {
      $('html').attr('lang', language);
      $.each(lang, function (index, val) {
        index === 'head' ? $(document).attr("title", val['title']) : false;
        $("[data-key='" + index + "']").text(val);
      });
    });
  }

  function initMetisMenu() {
    //metis menu
    $("#side-menu").metisMenu();
  }

  function initCounterNumber() {
    var counter = document.querySelectorAll('.counter-value');
    var speed = 250; // The lower the slower

    counter.forEach(function (counter_value) {
      function updateCount() {
        var target = +counter_value.getAttribute('data-target');
        var count = +counter_value.innerText;
        var inc = target / speed;

        if (inc < 1) {
          inc = 1;
        } // Check if target is reached


        if (count < target) {
          // Add inc to count and output in counter_value
          counter_value.innerText = (count + inc).toFixed(0); // Call function every ms

          setTimeout(updateCount, 1);
        } else {
          counter_value.innerText = target;
        }
      }

      ;
      updateCount();
    });
  }

  function initLeftMenuCollapse() {
    var currentSIdebarSize = document.body.getAttribute('data-sidebar-size');
    $(window).on('load', function () {
      $('.switch').on('switch-change', function () {
        toggleWeather();
      });

      if (window.innerWidth >= 1024 && window.innerWidth <= 1366) {
        document.body.setAttribute('data-sidebar-size', 'sm');
        updateRadio('sidebar-size-small');
      }
    });
    $('#vertical-menu-btn').on('click', function (event) {
      event.preventDefault();
      $('body').toggleClass('sidebar-enable');

      if ($(window).width() >= 992) {
        if (currentSIdebarSize == null) {
          document.body.getAttribute('data-sidebar-size') == null || document.body.getAttribute('data-sidebar-size') == "lg" ? document.body.setAttribute('data-sidebar-size', 'sm') : document.body.setAttribute('data-sidebar-size', 'lg');
        } else if (currentSIdebarSize == "md") {
          document.body.getAttribute('data-sidebar-size') == "md" ? document.body.setAttribute('data-sidebar-size', 'sm') : document.body.setAttribute('data-sidebar-size', 'md');
        } else {
          document.body.getAttribute('data-sidebar-size') == "sm" ? document.body.setAttribute('data-sidebar-size', 'lg') : document.body.setAttribute('data-sidebar-size', 'sm');
        }
      }
    });
  }

  function initActiveMenu() {
    // === following js will activate the menu in left side bar based on url ====
    $("#sidebar-menu a").each(function () {
      var pageUrl = window.location.href.split(/[?#]/)[0];

      if (this.href == pageUrl) {
        $(this).addClass("active");
        $(this).parent().addClass("mm-active"); // add active to li of the current link

        $(this).parent().parent().addClass("mm-show");
        $(this).parent().parent().prev().addClass("mm-active"); // add active class to an anchor

        $(this).parent().parent().parent().addClass("mm-active");
        $(this).parent().parent().parent().parent().addClass("mm-show"); // add active to li of the current link

        $(this).parent().parent().parent().parent().parent().addClass("mm-active");
      }
    });
  }

  function initMenuItemScroll() {
    // focus active menu in left sidebar
    $(document).ready(function () {
      if ($("#sidebar-menu").length > 0 && $("#sidebar-menu .mm-active .active").length > 0) {
        var activeMenu = $("#sidebar-menu .mm-active .active").offset().top;

        if (activeMenu > 300) {
          activeMenu = activeMenu - 300;
          $(".vertical-menu .simplebar-content-wrapper").animate({
            scrollTop: activeMenu
          }, "slow");
        }
      }
    });
  }

  function initHoriMenuActive() {
    $(".navbar-nav a").each(function () {
      var pageUrl = window.location.href.split(/[?#]/)[0];

      if (this.href == pageUrl) {
        $(this).addClass("active");
        $(this).parent().addClass("active");
        $(this).parent().parent().addClass("active");
        $(this).parent().parent().parent().addClass("active");
        $(this).parent().parent().parent().parent().addClass("active");
        $(this).parent().parent().parent().parent().parent().addClass("active");
        $(this).parent().parent().parent().parent().parent().parent().addClass("active");
      }
    });
  }

  function initFullScreen() {
    $('[data-toggle="fullscreen"]').on("click", function (e) {
      e.preventDefault();
      $('body').toggleClass('fullscreen-enable');

      if (!document.fullscreenElement &&
      /* alternative standard method */
      !document.mozFullScreenElement && !document.webkitFullscreenElement) {
        // current working methods
        if (document.documentElement.requestFullscreen) {
          document.documentElement.requestFullscreen();
        } else if (document.documentElement.mozRequestFullScreen) {
          document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullscreen) {
          document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
        }
      } else {
        if (document.cancelFullScreen) {
          document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
          document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
          document.webkitCancelFullScreen();
        }
      }
    });
    document.addEventListener('fullscreenchange', exitHandler);
    document.addEventListener("webkitfullscreenchange", exitHandler);
    document.addEventListener("mozfullscreenchange", exitHandler);

    function exitHandler() {
      if (!document.webkitIsFullScreen && !document.mozFullScreen && !document.msFullscreenElement) {
        $('body').removeClass('fullscreen-enable');
      }
    }
  }

  function initDropdownMenu() {
    if (document.getElementById("topnav-menu-content")) {
      var elements = document.getElementById("topnav-menu-content").getElementsByTagName("a");

      for (var i = 0, len = elements.length; i < len; i++) {
        elements[i].onclick = function (elem) {
          if (elem && elem.target && elem.target.getAttribute("href") === "#") {
            elem.target.parentElement.classList.toggle("active");
            if (elem.target.nextElementSibling) elem.target.nextElementSibling.classList.toggle("show");
          }
        };
      }

      window.addEventListener("resize", updateMenu);
    }
  }

  function updateMenu() {
    var elements = document.getElementById("topnav-menu-content").getElementsByTagName("a");

    for (var i = 0, len = elements.length; i < len; i++) {
      if (elements[i] && elements[i].parentElement && elements[i].parentElement.getAttribute("class") === "nav-item dropdown active") {
        elements[i].parentElement.classList.remove("active");
        if (elements[i].nextElementSibling) elements[i].nextElementSibling.classList.remove("show");
      }
    }
  }

  function initComponents() {
    // tooltip
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl);
    }); // popover

    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
      return new bootstrap.Popover(popoverTriggerEl);
    }); // toast

    var toastElList = [].slice.call(document.querySelectorAll('.toast'));
    var toastList = toastElList.map(function (toastEl) {
      return new bootstrap.Toast(toastEl);
    });
  }

  function initPreloader() {
    $(window).on('load', function () {
      $('#status').fadeOut();
      $('#preloader').delay(350).fadeOut('slow');
    });
  }

  function initSettings() {
    if (window.sessionStorage) {
      var alreadyVisited = sessionStorage.getItem("is_visited");

      if (!alreadyVisited) {
        sessionStorage.setItem("is_visited", "layout-ltr");
      } else {
        $("#" + alreadyVisited).prop('checked', true); // changeDirection(alreadyVisited);
      }
    }
  }

  function initLanguage() {
    // Auto Loader
    if (language && language != "null" && language !== default_lang) setLanguage(language);
    $('.language').on('click', function (e) {
      setLanguage($(this).attr('data-lang'));
    });
  }

  function initCheckAll() {
    $('#checkAll').on('change', function () {
      $('.table-check .form-check-input').prop('checked', $(this).prop("checked"));
    });
    $('.table-check .form-check-input').change(function () {
      if ($('.table-check .form-check-input:checked').length == $('.table-check .form-check-input').length) {
        $('#checkAll').prop('checked', true);
      } else {
        $('#checkAll').prop('checked', false);
      }
    });
  }

  function updateRadio(radioId) {
    document.getElementById(radioId).checked = true;
  }

  function layoutSetting() {
    var body = document.getElementsByTagName("body")[0]; // right side-bar toggle

    $('.right-bar-toggle').on('click', function (e) {
      $('body').toggleClass('right-bar-enabled');
    });
    $('#mode-setting-btn').on('click', function (e) {
      if (body.hasAttribute("data-layout-mode") && body.getAttribute("data-layout-mode") == "dark") {
        document.body.setAttribute('data-layout-mode', 'light');
        document.body.setAttribute('data-topbar', 'light');
        document.body.setAttribute('data-sidebar', 'light');
        body.hasAttribute("data-layout") && body.getAttribute("data-layout") == "horizontal" ? '' : document.body.setAttribute('data-sidebar', 'light');
        updateRadio('topbar-color-light');
        updateRadio('sidebar-color-light');
        updateRadio('topbar-color-light');
      } else {
        document.body.setAttribute('data-layout-mode', 'dark');
        document.body.setAttribute('data-topbar', 'dark');
        document.body.setAttribute('data-sidebar', 'dark');
        body.hasAttribute("data-layout") && body.getAttribute("data-layout") == "horizontal" ? '' : document.body.setAttribute('data-sidebar', 'dark');
        updateRadio('layout-mode-dark');
        updateRadio('sidebar-color-dark');
        updateRadio('topbar-color-dark');
      }
    });
    $(document).on('click', 'body', function (e) {
      if ($(e.target).closest('.right-bar-toggle, .right-bar').length > 0) {
        return;
      }

      $('body').removeClass('right-bar-enabled');
      return;
    });

    if (body.hasAttribute("data-layout") && body.getAttribute("data-layout") == "horizontal") {
      updateRadio('layout-horizontal');
      $(".sidebar-setting").hide();
    } else {
      updateRadio('layout-vertical');
    }

    body.hasAttribute("data-layout-mode") && body.getAttribute("data-layout-mode") == "dark" ? updateRadio('layout-mode-dark') : updateRadio('layout-mode-light');
    body.hasAttribute("data-layout-size") && body.getAttribute("data-layout-size") == "boxed" ? updateRadio('layout-width-boxed') : updateRadio('layout-width-fuild');
    body.hasAttribute("data-layout-scrollable") && body.getAttribute("data-layout-scrollable") == "true" ? updateRadio('layout-position-scrollable') : updateRadio('layout-position-fixed');
    body.hasAttribute("data-topbar") && body.getAttribute("data-topbar") == "dark" ? updateRadio('topbar-color-dark') : updateRadio('topbar-color-light');
    body.hasAttribute("data-sidebar-size") && body.getAttribute("data-sidebar-size") == "sm" ? updateRadio('sidebar-size-small') : body.hasAttribute("data-sidebar-size") && body.getAttribute("data-sidebar-size") == "md" ? updateRadio('sidebar-size-compact') : updateRadio('sidebar-size-default');
    body.hasAttribute("data-sidebar") && body.getAttribute("data-sidebar") == "brand" ? updateRadio('sidebar-color-brand') : body.hasAttribute("data-sidebar") && body.getAttribute("data-sidebar") == "dark" ? updateRadio('sidebar-color-dark') : updateRadio('sidebar-color-light');
    document.getElementsByTagName("html")[0].hasAttribute("dir") && document.getElementsByTagName("html")[0].getAttribute("dir") == "rtl" ? updateRadio('layout-direction-rtl') : updateRadio('layout-direction-ltr'); // on layou change

    $("input[name='layout']").on('change', function () {
      window.location.href = $(this).val() == "vertical" ? "index.html" : "layouts-horizontal.html";
    }); // on layout mode change

    $("input[name='layout-mode']").on('change', function () {
      if ($(this).val() == "light") {
        document.body.setAttribute('data-layout-mode', 'light');
        document.body.setAttribute('data-topbar', 'light');
        document.body.setAttribute('data-sidebar', 'light');
        body.hasAttribute("data-layout") && body.getAttribute("data-layout") == "horizontal" ? '' : document.body.setAttribute('data-sidebar', 'light');
        updateRadio('topbar-color-light');
        updateRadio('sidebar-color-light');
      } else {
        document.body.setAttribute('data-layout-mode', 'dark');
        document.body.setAttribute('data-topbar', 'dark');
        document.body.setAttribute('data-sidebar', 'dark');
        body.hasAttribute("data-layout") && body.getAttribute("data-layout") == "horizontal" ? '' : document.body.setAttribute('data-sidebar', 'dark');
        updateRadio('topbar-color-dark');
        updateRadio('sidebar-color-dark');
      }
    }); // on RTL-LTR mode change

    $("input[name='layout-direction']").on('change', function () {
      if ($(this).val() == "ltr") {
        document.getElementsByTagName("html")[0].removeAttribute("dir");
        document.getElementById('bootstrap-style').setAttribute('href', 'assets/css/bootstrap.min.css');
        document.getElementById('app-style').setAttribute('href', 'assets/css/app.min.css');
      } else {
        document.getElementById('bootstrap-style').setAttribute('href', 'assets/css/bootstrap-rtl.min.css');
        document.getElementById('app-style').setAttribute('href', 'assets/css/app-rtl.min.css');
        document.getElementsByTagName("html")[0].setAttribute("dir", "rtl");
      }
    });
  }

  function init() {
    initMetisMenu();
    initCounterNumber();
    initLeftMenuCollapse();
    initActiveMenu();
    initMenuItemScroll();
    initHoriMenuActive();
    initFullScreen();
    initDropdownMenu();
    initComponents();
    initSettings();
    initLanguage();
    initPreloader();
    layoutSetting();
    Waves.init();
    initCheckAll();
  }

  init();
})(jQuery);

feather.replace();

/***/ }),

/***/ "./resources/assets/scss/bootstrap.scss":
/*!**********************************************!*\
  !*** ./resources/assets/scss/bootstrap.scss ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/assets/scss/preloader.scss":
/*!**********************************************!*\
  !*** ./resources/assets/scss/preloader.scss ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/assets/scss/icons.scss":
/*!******************************************!*\
  !*** ./resources/assets/scss/icons.scss ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/assets/scss/app.scss":
/*!****************************************!*\
  !*** ./resources/assets/scss/app.scss ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/assets/js/app": 0,
/******/ 			"assets/css/app": 0,
/******/ 			"assets/css/icons": 0,
/******/ 			"assets/css/preloader": 0,
/******/ 			"assets/css/bootstrap": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkIds[i]] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["assets/css/app","assets/css/icons","assets/css/preloader","assets/css/bootstrap"], () => (__webpack_require__("./resources/assets/js/app.js")))
/******/ 	__webpack_require__.O(undefined, ["assets/css/app","assets/css/icons","assets/css/preloader","assets/css/bootstrap"], () => (__webpack_require__("./resources/assets/scss/bootstrap.scss")))
/******/ 	__webpack_require__.O(undefined, ["assets/css/app","assets/css/icons","assets/css/preloader","assets/css/bootstrap"], () => (__webpack_require__("./resources/assets/scss/preloader.scss")))
/******/ 	__webpack_require__.O(undefined, ["assets/css/app","assets/css/icons","assets/css/preloader","assets/css/bootstrap"], () => (__webpack_require__("./resources/assets/scss/icons.scss")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["assets/css/app","assets/css/icons","assets/css/preloader","assets/css/bootstrap"], () => (__webpack_require__("./resources/assets/scss/app.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
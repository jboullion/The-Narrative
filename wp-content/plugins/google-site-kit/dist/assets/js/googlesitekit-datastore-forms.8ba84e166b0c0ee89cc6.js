!function(e){function t(t){for(var n,i,u=t[0],c=t[1],l=t[2],f=0,d=[];f<u.length;f++)i=u[f],Object.prototype.hasOwnProperty.call(o,i)&&o[i]&&d.push(o[i][0]),o[i]=0;for(n in c)Object.prototype.hasOwnProperty.call(c,n)&&(e[n]=c[n]);for(s&&s(t);d.length;)d.shift()();return a.push.apply(a,l||[]),r()}function r(){for(var e,t=0;t<a.length;t++){for(var r=a[t],n=!0,i=1;i<r.length;i++){var u=r[i];0!==o[u]&&(n=!1)}n&&(a.splice(t--,1),e=__webpack_require__(__webpack_require__.s=r[0]))}return e}var n={},o={9:0},a=[];function __webpack_require__(t){if(n[t])return n[t].exports;var r=n[t]={i:t,l:!1,exports:{}};return e[t].call(r.exports,r,r.exports,__webpack_require__),r.l=!0,r.exports}__webpack_require__.m=e,__webpack_require__.c=n,__webpack_require__.d=function(e,t,r){__webpack_require__.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},__webpack_require__.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},__webpack_require__.t=function(e,t){if(1&t&&(e=__webpack_require__(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(__webpack_require__.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var n in e)__webpack_require__.d(r,n,function(t){return e[t]}.bind(null,n));return r},__webpack_require__.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return __webpack_require__.d(t,"a",t),t},__webpack_require__.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},__webpack_require__.p="";var i=window.__googlesitekit_webpackJsonp=window.__googlesitekit_webpackJsonp||[],u=i.push.bind(i);i.push=t,i=i.slice();for(var c=0;c<i.length;c++)t(i[c]);var s=u;a.push([803,0]),r()}({0:function(e,t){e.exports=googlesitekit.i18n},1:function(e,t,r){"use strict";(function(e){r.d(t,"c",(function(){return i})),r.d(t,"a",(function(){return u})),r.d(t,"d",(function(){return s})),r.d(t,"e",(function(){return l})),r.d(t,"f",(function(){return f})),r.d(t,"g",(function(){return d})),r.d(t,"h",(function(){return p})),r.d(t,"b",(function(){return v})),r.d(t,"i",(function(){return h})),r.d(t,"j",(function(){return E})),r.d(t,"k",(function(){return P})),r.d(t,"l",(function(){return x})),r.d(t,"m",(function(){return C})),r.d(t,"n",(function(){return I})),r.d(t,"o",(function(){return T})),r.d(t,"p",(function(){return F})),r.d(t,"q",(function(){return L})),r.d(t,"r",(function(){return M}));var n=r(124);void 0===e.googlesitekit&&(e.googlesitekit={});var o=e.googlesitekit._element||n,a=o.Children,i=o.cloneElement,u=o.Component,c=o.concatChildren,s=o.createContext,l=o.createElement,f=o.createInterpolateElement,d=o.createPortal,p=o.createRef,g=o.findDOMNode,b=o.forwardRef,v=o.Fragment,m=o.isEmptyElement,h=o.isValidElement,y=o.lazy,_=o.memo,O=o.Platform,k=o.RawHTML,E=o.render,w=o.renderToString,S=o.StrictMode,j=o.Suspense,R=o.switchChildrenNodeName,A=o.unmountComponentAtNode,P=o.useCallback,x=o.useContext,D=o.useDebugValue,C=o.useEffect,N=o.useImperativeHandle,I=o.useLayoutEffect,T=o.useMemo,F=o.useReducer,L=o.useRef,M=o.useState;void 0===e.googlesitekit._element&&(e.googlesitekit._element={Children:a,cloneElement:i,Component:u,concatChildren:c,createContext:s,createElement:l,createInterpolateElement:f,createPortal:d,createRef:p,findDOMNode:g,forwardRef:b,Fragment:v,isEmptyElement:m,isValidElement:h,lazy:y,memo:_,Platform:O,RawHTML:k,render:E,renderToString:w,StrictMode:S,Suspense:j,switchChildrenNodeName:R,unmountComponentAtNode:A,useCallback:P,useContext:x,useDebugValue:D,useEffect:C,useImperativeHandle:N,useLayoutEffect:I,useMemo:T,useReducer:F,useRef:L,useState:M})}).call(this,r(16))},105:function(e,t,r){"use strict";r.d(t,"a",(function(){return b})),r.d(t,"c",(function(){return m})),r.d(t,"b",(function(){return h}));var n=r(36),o=r.n(n),a=r(8),i=r.n(a),u=r(5),c=r.n(u),s=r(22),l=r.n(s),f=r(7),d=r.n(f),p=r(83),g=d.a.createRegistryControl,b=function(e){var t;l()(e,"storeName is required to create a snapshot store.");var r={},n={deleteSnapshot:c.a.mark((function e(){var t;return c.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,{payload:{},type:"DELETE_SNAPSHOT"};case 2:return t=e.sent,e.abrupt("return",t);case 4:case"end":return e.stop()}}),e)})),restoreSnapshot:c.a.mark((function e(){var t,r,n,o,a,i,u=arguments;return c.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return t=u.length>0&&void 0!==u[0]?u[0]:{},r=t.clearAfterRestore,n=void 0===r||r,e.next=4,{payload:{},type:"RESTORE_SNAPSHOT"};case 4:if(o=e.sent,a=o.cacheHit,i=o.value,!a){e.next=13;break}return e.next=10,{payload:{snapshot:i},type:"SET_STATE_FROM_SNAPSHOT"};case 10:if(!n){e.next=13;break}return e.next=13,{payload:{},type:"DELETE_SNAPSHOT"};case 13:return e.abrupt("return",a);case 14:case"end":return e.stop()}}),e)})),createSnapshot:c.a.mark((function e(){var t;return c.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,{payload:{},type:"CREATE_SNAPSHOT"};case 2:return t=e.sent,e.abrupt("return",t);case 4:case"end":return e.stop()}}),e)}))},a=(t={},i()(t,"DELETE_SNAPSHOT",(function(){return Object(p.a)("datastore::cache::".concat(e))})),i()(t,"CREATE_SNAPSHOT",g((function(t){return function(){return Object(p.d)("datastore::cache::".concat(e),t.stores[e].store.getState())}}))),i()(t,"RESTORE_SNAPSHOT",(function(){return Object(p.b)("datastore::cache::".concat(e),3600)})),t);return{initialState:r,actions:n,controls:a,reducer:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:r,t=arguments.length>1?arguments[1]:void 0,n=t.type,a=t.payload;switch(n){case"SET_STATE_FROM_SNAPSHOT":var i=a.snapshot,u=(i.error,o()(i,["error"]));return u;default:return e}}}},v=function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:d.a;return Object.values(e.stores).filter((function(e){return Object.keys(e.getActions()).includes("restoreSnapshot")}))},m=function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:d.a;return Promise.all(v(e).map((function(e){return e.getActions().createSnapshot()})))},h=function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:d.a;return Promise.all(v(e).map((function(e){return e.getActions().restoreSnapshot()})))}},17:function(e,t,r){"use strict";(function(e){r.d(t,"a",(function(){return a})),r.d(t,"b",(function(){return i})),r.d(t,"f",(function(){return u})),r.d(t,"g",(function(){return c})),r.d(t,"e",(function(){return s})),r.d(t,"d",(function(){return p})),r.d(t,"c",(function(){return g}));var n=r(118);void 0===e.googlesitekit&&(e.googlesitekit={});var o=e.googlesitekit._hooks||n,a=o.addAction,i=o.addFilter,u=o.removeAction,c=o.removeFilter,s=o.hasAction,l=o.hasFilter,f=o.removeAllActions,d=o.removeAllFilters,p=o.doAction,g=o.applyFilters,b=o.currentAction,v=o.currentFilter,m=o.doingAction,h=o.doingFilter,y=o.didAction,_=o.didFilter,O=o.actions,k=o.filters;void 0===e.googlesitekit._hooks&&(e.googlesitekit._hooks={addAction:a,addFilter:i,removeAction:u,removeFilter:c,hasAction:s,hasFilter:l,removeAllActions:f,removeAllFilters:d,doAction:p,applyFilters:g,currentAction:b,currentFilter:v,doingAction:m,doingFilter:h,didAction:y,didFilter:_,actions:O,filters:k})}).call(this,r(16))},25:function(e,t,r){"use strict";(function(e){r.d(t,"a",(function(){return i})),r.d(t,"b",(function(){return u}));var n=r(41),o=r.n(n),a=r(1),i=function(e){return function(t){return function FilteredComponent(r){return Object(a.e)(a.b,{},"",Object(a.e)(t,r),e)}}},u=function(t,r){return function(n){return function InnerComponent(a){return e.createElement(t,o()({},a,r,{OriginalComponent:n}))}}}}).call(this,r(3))},3:function(e,t,r){"use strict";r.r(t),function(e){r.d(t,"Children",(function(){return l})),r.d(t,"createRef",(function(){return f})),r.d(t,"Component",(function(){return d})),r.d(t,"PureComponent",(function(){return p})),r.d(t,"createContext",(function(){return g})),r.d(t,"forwardRef",(function(){return b})),r.d(t,"lazy",(function(){return v})),r.d(t,"memo",(function(){return m})),r.d(t,"useCallback",(function(){return h})),r.d(t,"useContext",(function(){return y})),r.d(t,"useEffect",(function(){return _})),r.d(t,"useImperativeHandle",(function(){return O})),r.d(t,"useDebugValue",(function(){return k})),r.d(t,"useLayoutEffect",(function(){return E})),r.d(t,"useMemo",(function(){return w})),r.d(t,"useReducer",(function(){return S})),r.d(t,"useRef",(function(){return j})),r.d(t,"useState",(function(){return R})),r.d(t,"Fragment",(function(){return A})),r.d(t,"Profiler",(function(){return P})),r.d(t,"StrictMode",(function(){return x})),r.d(t,"Suspense",(function(){return D})),r.d(t,"createElement",(function(){return C})),r.d(t,"cloneElement",(function(){return N})),r.d(t,"createFactory",(function(){return I})),r.d(t,"isValidElement",(function(){return T})),r.d(t,"version",(function(){return F})),r.d(t,"__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED",(function(){return L}));var n=r(8),o=r.n(n),a=r(69),i=r.n(a);function u(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,n)}return r}void 0===e.googlesitekit&&(e.googlesitekit={});var c=e.googlesitekit._react||function(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?u(Object(r),!0).forEach((function(t){o()(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):u(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}({default:i.a},a),s=c.default,l=c.Children,f=c.createRef,d=c.Component,p=c.PureComponent,g=c.createContext,b=c.forwardRef,v=c.lazy,m=c.memo,h=c.useCallback,y=c.useContext,_=c.useEffect,O=c.useImperativeHandle,k=c.useDebugValue,E=c.useLayoutEffect,w=c.useMemo,S=c.useReducer,j=c.useRef,R=c.useState,A=c.Fragment,P=c.Profiler,x=c.StrictMode,D=c.Suspense,C=c.createElement,N=c.cloneElement,I=c.createFactory,T=c.isValidElement,F=c.version,L=c.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED;void 0===e.googlesitekit._react&&(e.googlesitekit._react={default:i.a,Children:l,createRef:f,Component:d,PureComponent:p,createContext:g,forwardRef:b,lazy:v,memo:m,useCallback:h,useContext:y,useEffect:_,useImperativeHandle:O,useDebugValue:k,useLayoutEffect:E,useMemo:w,useReducer:S,useRef:j,useState:R,Fragment:A,Profiler:P,StrictMode:x,Suspense:D,createElement:C,cloneElement:N,createFactory:I,isValidElement:T,version:F,__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED:L}),t.default=s}.call(this,r(16))},4:function(e,t,r){"use strict";(function(e){r.d(t,"o",(function(){return j})),r.d(t,"m",(function(){return R})),r.d(t,"l",(function(){return P})),r.d(t,"n",(function(){return x})),r.d(t,"f",(function(){return D})),r.d(t,"b",(function(){return C})),r.d(t,"h",(function(){return N})),r.d(t,"j",(function(){return I})),r.d(t,"k",(function(){return T})),r.d(t,"u",(function(){return F})),r.d(t,"a",(function(){return L})),r.d(t,"q",(function(){return M})),r.d(t,"d",(function(){return q})),r.d(t,"g",(function(){return H}));var n=r(5),o=r.n(n),a=r(15),i=r.n(a),u=r(8),c=r.n(u),s=r(36),l=r.n(s),f=r(34),d=r.n(f),p=r(14),g=r(17),b=r(0),v=r(56),m=r(192),h=r(58);r.d(t,"s",(function(){return h.c}));var y=r(25),_=r(63);r.d(t,"p",(function(){return _.a})),r.d(t,"t",(function(){return _.b}));var O=r(64);r.d(t,"r",(function(){return O.a}));var k=r(67);r.d(t,"c",(function(){return k.b})),r.d(t,"i",(function(){return k.c}));r(42),r(54);function E(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,n)}return r}function w(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?E(Object(r),!0).forEach((function(t){c()(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):E(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}r.d(t,"e",(function(){return y.b}));var S=function(e){return 1e6<=e?Math.round(e/1e5)/10:1e4<=e?Math.round(e/1e3):1e3<=e?Math.round(e/100)/10:e},j=function(e){var t=arguments.length>1&&void 0!==arguments[1]&&arguments[1];if(e=Object(p.isFinite)(e)?e:Number(e),Object(p.isFinite)(e)||(console.warn("Invalid number",e,d()(e)),e=0),t)return R(e,{style:"currency",currency:t});var r={minimumFractionDigits:1,maximumFractionDigits:1};return 1e6<=e?Object(b.sprintf)(// translators: %s: an abbreviated number in millions.
Object(b.__)("%sM","google-site-kit"),R(S(e),e%10==0?{}:r)):1e4<=e?Object(b.sprintf)(// translators: %s: an abbreviated number in thousands.
Object(b.__)("%sK","google-site-kit"),R(S(e))):1e3<=e?Object(b.sprintf)(// translators: %s: an abbreviated number in thousands.
Object(b.__)("%sK","google-site-kit"),R(S(e),e%10==0?{}:r)):e.toString()},R=function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},r=t.locale,n=void 0===r?A():r,o=l()(t,["locale"]);return new Intl.NumberFormat(n,o).format(e)},A=function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:e,r=Object(p.get)(t,["_googlesitekitLegacyData","locale","","lang"]);if(r){var n=r.match(/^(\w{2})?(_)?(\w{2})/);if(n&&n[0])return n[0].replace(/_/g,"-")}return t.navigator.language},P=function(e){switch(e){case"minute":return 60;case"hour":return 3600;case"day":return 86400;case"week":return 604800;case"month":return 2592e3;case"year":return 31536e3}},x=function(e){if(e=parseInt(e,10),isNaN(e)||0===e)return"0.0s";var t={};return t.hours=Math.floor(e/60/60),t.minutes=Math.floor(e/60%60),t.seconds=Math.floor(e%60),((t.hours?t.hours+"h ":"")+(t.minutes?t.minutes+"m ":"")+(t.seconds?t.seconds+"s ":"")).trim()},D=function(e,t){var r=1e3*P("day"),n=e.getTime(),o=t.getTime();return Math.round(Math.abs(n-o)/r)},C=function(e,t){if("0"===e||0===e||isNaN(e))return"";var r=((t-e)/e*100).toFixed(1);return isNaN(r)||"Infinity"===r?"":r},N=function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:e._googlesitekitLegacyData,r=t.modules;return r?Object.keys(r).reduce((function(e,t){return"object"!==d()(r[t])||void 0===r[t].slug||void 0===r[t].name||r[t].slug!==t?e:w(w({},e),{},c()({},t,r[t]))}),{}):{}},I=function(t,r){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:e._googlesitekitLegacyData,o=n.admin,a=o.connectURL,i=o.adminRoot,u=n.setup.needReauthenticate,c=N(n)[t].screenID,s="pagespeed-insights"===t?{notification:"authentication_success",reAuth:void 0}:{},l=Object(v.a)(i,w({page:t&&r&&c?c:"googlesitekit-dashboard",slug:t,reAuth:r},s));if(!u)return l;var f=encodeURIComponent(Object(m.a)(l));return l=i+"?"+f,Object(v.a)(a,{redirect:l,status:r})},T=function(t,r){var n=e._googlesitekitLegacyData.admin.adminRoot;return t||(t="googlesitekit-dashboard"),r=w({page:t},r),Object(v.a)(n,r)},F=function(e){try{return JSON.parse(e)&&!!e}catch(e){return!1}},L=function(){var e=i()(o.a.mark((function e(t,r,n){var a,i,u,c,s=arguments;return o.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return a=s.length>3&&void 0!==s[3]?s[3]:h.c,i=s.length>4&&void 0!==s[4]?s[4]:N,e.next=4,t.setModuleActive(r,n);case 4:return u=e.sent,(c=i())[r]&&(c[r].active=n),e.next=9,a("".concat(r,"_setup"),n?"module_activate":"module_deactivate",r);case 9:return e.abrupt("return",u);case 10:case"end":return e.stop()}}),e)})));return function(t,r,n){return e.apply(this,arguments)}}(),M=function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};Object(g.b)("googlesitekit.ErrorNotification","googlesitekit.ErrorNotification",Object(y.b)(e,t),1)},q=function(e){if(!e)return"";var t=e.replace(/&#(\d+);/g,(function(e,t){return String.fromCharCode(t)})).replace(/(\\)/g,"");return Object(p.unescape)(t)};function H(t){var r=arguments.length>1&&void 0!==arguments[1]?arguments[1]:e._googlesitekitBaseData,n=r.blogPrefix,o=r.isNetworkMode;return o?t:n+t}}).call(this,r(16))},40:function(e,t,r){"use strict";r.d(t,"a",(function(){return n})),r.d(t,"b",(function(){return o}));var n="_googlesitekitDataLayer",o="data-googlesitekit-gtag"},42:function(e,t,r){"use strict";(function(e){r.d(t,"a",(function(){return l}));var n,o=r(9),a=r.n(o),i=r(10),u=r.n(i),c=function(t){var r=e[t];if(!r)return!1;try{var n="__storage_test__";return r.setItem(n,n),r.removeItem(n),!0}catch(e){return e instanceof DOMException&&(22===e.code||1014===e.code||"QuotaExceededError"===e.name||"NS_ERROR_DOM_QUOTA_REACHED"===e.name)&&0!==r.length}},s=function(){function NullStorage(){a()(this,NullStorage)}return u()(NullStorage,[{key:"key",value:function(){return null}},{key:"getItem",value:function(){return null}},{key:"setItem",value:function(){}},{key:"removeItem",value:function(){}},{key:"clear",value:function(){}},{key:"length",get:function(){return 0}}]),NullStorage}(),l=function(){return n||(n=c("sessionStorage")?e.sessionStorage:c("localStorage")?e.localStorage:new s),n}}).call(this,r(16))},54:function(e,t,r){"use strict";(function(e){r.d(t,"b",(function(){return i})),r.d(t,"a",(function(){return u}));var n=r(36),o=r.n(n),a=r(14),i=function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},r=t.locale,n=void 0===r?u():r,a=o()(t,["locale"]);return new Intl.NumberFormat(n,a).format(e)},u=function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:e,r=Object(a.get)(t,["_googlesitekitLegacyData","locale"]);if(r){var n=r.match(/^(\w{2})?(_)?(\w{2})/);if(n&&n[0])return n[0].replace(/_/g,"-")}return t.navigator.language}}).call(this,r(16))},58:function(e,t,r){"use strict";(function(e){r.d(t,"a",(function(){return f})),r.d(t,"b",(function(){return p})),r.d(t,"c",(function(){return d}));var n=r(86),o=e._googlesitekitBaseData||{},a=o.isFirstAdmin,i=o.trackingAllowed,u={isFirstAdmin:a,trackingEnabled:o.trackingEnabled,trackingID:o.trackingID,referenceSiteURL:o.referenceSiteURL,userIDHash:o.userIDHash},c=Object(n.a)(u),s=c.enableTracking,l=c.disableTracking,f=c.isTrackingEnabled,d=c.trackEvent;function p(e){e?s():l()}!0===i&&p(f())}).call(this,r(16))},60:function(e,t,r){"use strict";r.d(t,"a",(function(){return o}));var n=r(40);function o(e){return function(){e[n.a]=e[n.a]||[],e[n.a].push(arguments)}}},63:function(e,t,r){"use strict";r.d(t,"a",(function(){return o})),r.d(t,"b",(function(){return a}));var n=r(89),o=function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};return{__html:n.a.sanitize(e,t)}},a=function(e){var t;return null==e||null===(t=e.replace)||void 0===t?void 0:t.call(e,/\/+$/,"")}},64:function(e,t,r){"use strict";r.d(t,"a",(function(){return u}));var n=r(34),o=r.n(n),a=r(85),i=r.n(a),u=function(e){return i()(JSON.stringify(function e(t){var r={};return Object.keys(t).sort().forEach((function(n){var a=t[n];a&&"object"===o()(a)&&!Array.isArray(a)&&(a=e(a)),r[n]=a})),r}(e)))}},67:function(e,t,r){"use strict";(function(e){r.d(t,"a",(function(){return c})),r.d(t,"b",(function(){return s})),r.d(t,"c",(function(){return f}));var n=r(20),o=r.n(n),a=r(0);function i(e,t){var r;if("undefined"==typeof Symbol||null==e[Symbol.iterator]){if(Array.isArray(e)||(r=function(e,t){if(!e)return;if("string"==typeof e)return u(e,t);var r=Object.prototype.toString.call(e).slice(8,-1);"Object"===r&&e.constructor&&(r=e.constructor.name);if("Map"===r||"Set"===r)return Array.from(e);if("Arguments"===r||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(r))return u(e,t)}(e))||t&&e&&"number"==typeof e.length){r&&(e=r);var n=0,o=function(){};return{s:o,n:function(){return n>=e.length?{done:!0}:{done:!1,value:e[n++]}},e:function(e){throw e},f:o}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var a,i=!0,c=!1;return{s:function(){r=e[Symbol.iterator]()},n:function(){var e=r.next();return i=e.done,e},e:function(e){c=!0,a=e},f:function(){try{i||null==r.return||r.return()}finally{if(c)throw a}}}}function u(e,t){(null==t||t>e.length)&&(t=e.length);for(var r=0,n=new Array(t);r<t;r++)n[r]=e[r];return n}var c=function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:0,t=null,r=null,n=document.querySelector("#toplevel_page_googlesitekit-dashboard .googlesitekit-notifications-counter"),o=document.querySelector("#wp-admin-bar-google-site-kit .googlesitekit-notifications-counter");if(n&&o)return!1;if(t=document.querySelector("#toplevel_page_googlesitekit-dashboard .wp-menu-name"),r=document.querySelector("#wp-admin-bar-google-site-kit .ab-item"),null===t&&null===r)return!1;var i=document.createElement("span");i.setAttribute("class","googlesitekit-notifications-counter update-plugins count-".concat(e));var u=document.createElement("span");u.setAttribute("class","plugin-count"),u.setAttribute("aria-hidden","true"),u.textContent=e;var c=document.createElement("span");return c.setAttribute("class","screen-reader-text"),c.textContent=Object(a.sprintf)(
/* translators: %d is the number of notifications */
Object(a._n)("%d notification","%d notifications",e,"google-site-kit"),e),i.appendChild(u),i.appendChild(c),t&&null===n&&t.appendChild(i),r&&null===o&&r.appendChild(i),i},s=function(){e.localStorage&&e.localStorage.clear(),e.sessionStorage&&e.sessionStorage.clear()},l=function(e){for(var t=location.search.substr(1).split("&"),r={},n=0;n<t.length;n++)r[t[n].split("=")[0]]=decodeURIComponent(t[n].split("=")[1]);return e?r.hasOwnProperty(e)?decodeURIComponent(r[e].replace(/\+/g," ")):"":r},f=function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:location,r=new URL(t.href);if(e)return r.searchParams&&r.searchParams.get?r.searchParams.get(e):l(e);var n,a={},u=i(r.searchParams.entries());try{for(u.s();!(n=u.n()).done;){var c=o()(n.value,2),s=c[0],f=c[1];a[s]=f}}catch(e){u.e(e)}finally{u.f()}return a}}).call(this,r(16))},7:function(e,t){e.exports=googlesitekit.data},71:function(e,t,r){"use strict";r.d(t,"a",(function(){return b})),r.d(t,"b",(function(){return v}));var n=r(8),o=r.n(n),a=r(34),i=r.n(a),u=r(22),c=r.n(u),s=r(85),l=r.n(s),f=r(4);function d(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,n)}return r}function p(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?d(Object(r),!0).forEach((function(t){o()(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):d(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}function g(e,t){if(t&&Array.isArray(t)){var r=t.map((function(e){return"object"===i()(e)?Object(f.r)(e):e}));return"".concat(e,"::").concat(l()(JSON.stringify(r)))}return e}var b={receiveError:function(e,t,r){return c()(e,"error is required."),t&&c()(r&&Array.isArray(r),"args is required (and must be an array) when baseName is specified."),{type:"RECEIVE_ERROR",payload:{error:e,baseName:t,args:r}}},clearError:function(e,t){return e&&c()(t&&Array.isArray(t),"args is required (and must be an array) when baseName is specified."),{type:"CLEAR_ERROR",payload:{baseName:e,args:t}}},clearErrors:function(e){return{type:"CLEAR_ERRORS",payload:{baseName:e}}}};function v(){var e={getErrorForSelector:function(t,r){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:[];return c()(r,"selectorName is required."),e.getError(t,r,n)},getErrorForAction:function(t,r){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:[];return c()(r,"actionName is required."),e.getError(t,r,n)},getError:function(e,t,r){var n=e.error,o=e.errors;return t||r?(c()(t,"baseName is required."),o[g(t,r)]):n},getErrors:function(e){var t=new Set(Object.values(e.errors));return void 0!==e.error&&t.add(e.error),Array.from(t)},hasErrors:function(t){return e.getErrors(t).length>0}};return{initialState:{errors:{},error:void 0},actions:b,controls:{},reducer:function(e,t){var r=t.type,n=t.payload;switch(r){case"RECEIVE_ERROR":var a=n.baseName,i=n.args,u=n.error;return p(p({},e),{},a?{errors:p(p({},e.errors||{}),{},o()({},g(a,i),u))}:{error:u});case"CLEAR_ERROR":var c=n.baseName,s=n.args,l=p({},e);if(c){var f=g(c,s);l.errors=p({},e.errors||{}),delete l.errors[f]}else l.error=void 0;return l;case"CLEAR_ERRORS":var d=n.baseName,b=p({},e);if(d)for(var v in b.errors=p({},e.errors||{}),b.errors)(v===d||v.startsWith("".concat(d,"::")))&&delete b.errors[v];else b.errors={},b.error=void 0;return b;default:return e}},resolvers:{},selectors:e}}},803:function(e,t,r){"use strict";r.r(t);var n=r(7),o=r.n(n),a=r(71),i=r(105),u=r(8),c=r.n(u),s=r(22),l=r.n(s),f=r(75),d=r.n(f);function p(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,n)}return r}function g(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?p(Object(r),!0).forEach((function(t){c()(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):p(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}var b={initialState:{},actions:{setValues:function(e,t){return l()(e&&"string"==typeof e,"a valid formName is required for setting values."),l()(d()(t),"formData must be an object."),{payload:{formName:e,formData:t},type:"SET_FORM_VALUES"}}},controls:{},reducer:function(e,t){var r=t.type,n=t.payload;switch(r){case"SET_FORM_VALUES":var o=n.formName,a=n.formData;return g(g({},e),{},c()({},o,g(g({},e[o]||{}),a)));default:return e}},resolvers:{},selectors:{getValue:function(e,t,r){return(e[t]||{})[r]},hasForm:function(e,t){return!!e[t]}}},v=r(91),m=o.a.combineStores(o.a.commonStore,b,Object(i.a)(v.a),Object(a.b)());m.initialState,m.actions,m.controls,m.reducer,m.resolvers,m.selectors;o.a.registerStore(v.a,m)},83:function(e,t,r){"use strict";(function(e){r.d(t,"b",(function(){return g})),r.d(t,"d",(function(){return b})),r.d(t,"a",(function(){return v})),r.d(t,"c",(function(){return m}));var n=r(5),o=r.n(n),a=r(15),i=r.n(a);r(50);function u(e,t){var r;if("undefined"==typeof Symbol||null==e[Symbol.iterator]){if(Array.isArray(e)||(r=function(e,t){if(!e)return;if("string"==typeof e)return c(e,t);var r=Object.prototype.toString.call(e).slice(8,-1);"Object"===r&&e.constructor&&(r=e.constructor.name);if("Map"===r||"Set"===r)return Array.from(e);if("Arguments"===r||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(r))return c(e,t)}(e))||t&&e&&"number"==typeof e.length){r&&(e=r);var n=0,o=function(){};return{s:o,n:function(){return n>=e.length?{done:!0}:{done:!1,value:e[n++]}},e:function(e){throw e},f:o}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var a,i=!0,u=!1;return{s:function(){r=e[Symbol.iterator]()},n:function(){var e=r.next();return i=e.done,e},e:function(e){u=!0,a=e},f:function(){try{i||null==r.return||r.return()}finally{if(u)throw a}}}}function c(e,t){(null==t||t>e.length)&&(t=e.length);for(var r=0,n=new Array(t);r<t;r++)n[r]=e[r];return n}var s,l=["sessionStorage","localStorage"],f=[].concat(l),d=function(){var t=i()(o.a.mark((function t(r){var n,a;return o.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(n=e[r]){t.next=3;break}return t.abrupt("return",!1);case 3:return t.prev=3,a="__storage_test__",n.setItem(a,a),n.removeItem(a),t.abrupt("return",!0);case 10:return t.prev=10,t.t0=t.catch(3),t.abrupt("return",t.t0 instanceof DOMException&&(22===t.t0.code||1014===t.t0.code||"QuotaExceededError"===t.t0.name||"NS_ERROR_DOM_QUOTA_REACHED"===t.t0.name)&&0!==n.length);case 13:case"end":return t.stop()}}),t,null,[[3,10]])})));return function(e){return t.apply(this,arguments)}}(),p=function(){var t=i()(o.a.mark((function t(){var r,n,a,i,c;return o.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(!(null===(r=e._googlesitekitLegacyData)||void 0===r||null===(n=r.admin)||void 0===n?void 0:n.nojscache)){t.next=2;break}return t.abrupt("return",null);case 2:if(void 0!==s){t.next=25;break}a=u(f),t.prev=4,a.s();case 6:if((i=a.n()).done){t.next=16;break}if(c=i.value,!s){t.next=10;break}return t.abrupt("continue",14);case 10:return t.next=12,d(c);case 12:if(!t.sent){t.next=14;break}s=e[c];case 14:t.next=6;break;case 16:t.next=21;break;case 18:t.prev=18,t.t0=t.catch(4),a.e(t.t0);case 21:return t.prev=21,a.f(),t.finish(21);case 24:void 0===s&&(s=null);case 25:return t.abrupt("return",s);case 26:case"end":return t.stop()}}),t,null,[[4,18,21,24]])})));return function(){return t.apply(this,arguments)}}(),g=function(){var e=i()(o.a.mark((function e(t){var r,n,a,i,u=arguments;return o.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return r=u.length>1&&void 0!==u[1]?u[1]:null,e.next=3,p();case 3:if(!(n=e.sent)){e.next=10;break}if(!(a=n.getItem("".concat("googlesitekit_").concat(t)))){e.next=10;break}if(!(i=JSON.parse(a)).timestamp||!(null===r||Math.round(Date.now()/1e3)-i.timestamp<r)){e.next=10;break}return e.abrupt("return",{cacheHit:!0,value:i.value});case 10:return e.abrupt("return",{cacheHit:!1,value:void 0});case 11:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}(),b=function(){var t=i()(o.a.mark((function t(r,n){var a,i,u=arguments;return o.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return a=u.length>2&&void 0!==u[2]?u[2]:void 0,t.next=3,p();case 3:if(!(i=t.sent)){t.next=14;break}return t.prev=5,i.setItem("".concat("googlesitekit_").concat(r),JSON.stringify({timestamp:a||Math.round(Date.now()/1e3),value:n})),t.abrupt("return",!0);case 10:return t.prev=10,t.t0=t.catch(5),e.console.warn("Encountered an unexpected storage error:",t.t0),t.abrupt("return",!1);case 14:return t.abrupt("return",!1);case 15:case"end":return t.stop()}}),t,null,[[5,10]])})));return function(e,r){return t.apply(this,arguments)}}(),v=function(){var t=i()(o.a.mark((function t(r){var n;return o.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,p();case 2:if(!(n=t.sent)){t.next=13;break}return t.prev=4,n.removeItem("".concat("googlesitekit_").concat(r)),t.abrupt("return",!0);case 9:return t.prev=9,t.t0=t.catch(4),e.console.warn("Encountered an unexpected storage error:",t.t0),t.abrupt("return",!1);case 13:return t.abrupt("return",!1);case 14:case"end":return t.stop()}}),t,null,[[4,9]])})));return function(e){return t.apply(this,arguments)}}(),m=function(){var t=i()(o.a.mark((function t(){var r,n,a,i;return o.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,p();case 2:if(!(r=t.sent)){t.next=14;break}for(t.prev=4,n=[],a=0;a<r.length;a++)0===(i=r.key(a)).indexOf("googlesitekit_")&&n.push(i.substring("googlesitekit_".length));return t.abrupt("return",n);case 10:return t.prev=10,t.t0=t.catch(4),e.console.warn("Encountered an unexpected storage error:",t.t0),t.abrupt("return",[]);case 14:return t.abrupt("return",[]);case 15:case"end":return t.stop()}}),t,null,[[4,10]])})));return function(){return t.apply(this,arguments)}}()}).call(this,r(16))},86:function(e,t,r){"use strict";(function(e){r.d(t,"a",(function(){return l}));var n=r(8),o=r.n(n),a=r(87),i=r(88);function u(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,n)}return r}function c(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?u(Object(r),!0).forEach((function(t){o()(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):u(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}var s={isFirstAdmin:!1,trackingEnabled:!1,trackingID:"",referenceSiteURL:"",userIDHash:""};function l(t){var r=arguments.length>1&&void 0!==arguments[1]?arguments[1]:e,n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:e,o=c(c({},s),t);return o.referenceSiteURL&&(o.referenceSiteURL=o.referenceSiteURL.toString().replace(/\/+$/,"")),{enableTracking:Object(a.a)(o,r),disableTracking:function(){o.trackingEnabled=!1},isTrackingEnabled:function(){return!!o.trackingEnabled},trackEvent:Object(i.a)(o,r,n)}}}).call(this,r(16))},87:function(e,t,r){"use strict";(function(e){r.d(t,"a",(function(){return a}));var n=r(60),o=r(40);function a(t,r){var a=Object(n.a)(r);return function(){t.trackingEnabled=!0;var r=e.document;if(!r.querySelector("script[".concat(o.b,"]"))){var n=r.createElement("script");n.setAttribute(o.b,""),n.async=!0,n.src="https://www.googletagmanager.com/gtag/js?id=".concat(t.trackingID,"&l=").concat(o.a),r.head.appendChild(n),a("js",new Date),a("config",t.trackingID)}}}}).call(this,r(16))},88:function(e,t,r){"use strict";(function(e){r.d(t,"a",(function(){return d}));var n=r(5),o=r.n(n),a=r(8),i=r.n(a),u=r(15),c=r.n(u),s=r(60);function l(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,n)}return r}function f(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?l(Object(r),!0).forEach((function(t){i()(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):l(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}function d(t,r,n){var a=Object(s.a)(r);return function(){var r=c()(o.a.mark((function r(i,u,c,s){var l,d,p,g,b,v,m,h;return o.a.wrap((function(r){for(;;)switch(r.prev=r.next){case 0:if(p=t.isFirstAdmin,g=t.referenceSiteURL,b=t.trackingEnabled,v=t.trackingID,m=t.userIDHash,!(null===(l=n._gaUserPrefs)||void 0===l||null===(d=l.ioo)||void 0===d?void 0:d.call(l))){r.next=3;break}return r.abrupt("return");case 3:if(b){r.next=5;break}return r.abrupt("return");case 5:return h={send_to:v,event_category:i,event_label:c,value:s,dimension1:g,dimension2:p?"true":"false",dimension3:m},r.abrupt("return",new Promise((function(t){var r=setTimeout((function(){e.console.warn('Tracking event "'.concat(u,'" (category "').concat(i,'") took too long to fire.')),t()}),1e3);a("event",u,f(f({},h),{},{event_callback:function(){clearTimeout(r),t()}}))})));case 7:case"end":return r.stop()}}),r)})));return function(e,t,n,o){return r.apply(this,arguments)}}()}}).call(this,r(16))},89:function(e,t,r){"use strict";(function(e){r.d(t,"a",(function(){return o}));var n=r(126),o=r.n(n)()(e)}).call(this,r(16))},91:function(e,t,r){"use strict";r.d(t,"a",(function(){return n}));var n="core/forms"}});
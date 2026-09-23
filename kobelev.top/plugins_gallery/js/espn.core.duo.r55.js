// File: ESPN Core Duo
//
//  ID - $Id: //vss_espneng/Templates/FrontEnd/scripts/espn.core.duo.js#54 $
//  DateTime - $DateTime: 2010/04/06
//  Revision - $Revision: #54 $

//  Topic: Requirements
//  List of files required by this script
//
//    * jQuery-1.3.2.jsf
//    * plugins/json2.js
//    * plugins/teacrypt.js
//    * plugins/jquery.metadata.js
//    * plugins/jquery.bgiframe.js
//    * plugins/jquery.easing.1.3.js
//    * plugins/jquery.hoverIntent.js
//    * plugins/jquery.jcarousel.js
//    * plugins/jquery.tinysort.js
//    * plugins/ba-debug-0.3.js
//    * plugins/jquery.pubsub.js
//    * ui/1.7.2/ui.core.js
//    * ui/1.7.2/ui.tabs.js
//    * espn.l10n.js


// start core closure
var presByOriginalWidth;
(function(jQuery,window,document,undefined) {

document.documentElement.className += ' js '; // <3 stevr

/*  Topic: No Conflict Mode
    jQuery is run in no conflict mode.  This means that the $ function is not available by default.  This is done
    in order to remain compatible to older pages that use the prototypejs library.  You may still use jQuery by
    referencing the full jQuery name, assigning jQuery to a new variable or passing jQuery into a closure.

  Usage:
  (start code)
    // assign jQuery to the $j variable
    var $j = jQuery;

    // pass jQuery into a closure
    (function($) {
      // code inside the closure can use $
    })(jQuery);
  (end code)
*/

jQuery.noConflict();

// force IE to cache background images
try { document.execCommand("BackgroundImageCache", false, true); } catch(err) {}

/* Topic: Default Ajax Settings
    Default settings for all XHR Requests made via jQuery

  data - {'xhr':1}
  cache - true

*/
jQuery.ajaxSetup({
  data: {'xhr':1},
  cache: true
});


//  Section: Touch Support

// Boolean: jQuery.support.touch;
jQuery.support.touch = ('ontouchstart' in window);
//debug.log('touch support', jQuery.support.touch);

// Boolean: jQuery.support.WebKitCSSMatrix;
jQuery.support.WebKitCSSMatrix = (typeof WebKitCSSMatrix == "object");

// Boolean: jQuery.support.WebKitAnimationEvent;
jQuery.support.WebKitAnimationEvent = (typeof WebKitTransitionEvent == "object");

//   Section: Legacy Code

//  Function: newWin
//    Used mostly for fantasy player cards
//
//  Parameters:
//    url - (String) a url to open in a new window
window.newWin = function(url) {
  var sNewWin = "newWin",
  options = 'width=800,height=525,resizable=yes,scrollbars=yes,location=yes,status=yes,toolbar=yes,menubar=yes,directories=yes',
  subWindow,
  w=window;
  if (url.indexOf('http')<0){
          url = "http://games.espn.go.com"+url;
  }
  if (!subWindow || subWindow.closed) {
      subWindow = w.open(url,sNewWin,options);
  } else {
      subWindow.focus();
      subWindow = w.open(url,sNewWin,options);
  }
}

window.initPresBy = function () {
	var $presby = jQuery('#sub-branding .presby, .mod-feature-header .presby'),
		$parent = $presby.parents('#sub-branding,.mod-feature-header')
		parentWidth = $parent.width(),
		parentHeight = $parent.height();
	
	if (typeof(presByOriginalWidth) == 'undefined') {
		presByOriginalWidth = $presby.width();
	}
		
	$parent.css({'position': 'relative'});
	
	$presby.css({
		'width' : parentWidth + 'px',
		'height' : parentHeight + 'px',
		'margin' : '0px',
		'overflow' : 'hidden',
		'position' : 'absolute',
		'right' : '0px',
		'text-align' : 'right'
	});
}
window.reducePresBy = function () {
	var $presby = jQuery('#sub-branding .presby, .mod-feature-header .presby');
	
	$presby.css({'width' : presByOriginalWidth + 'px'});
}

//  Method: Sporkle Quiz Function
//	resizes sporkle iframe
//
//  Parameters:
// 	height - px
window.rIF = function(ht){document.getElementById('spFrame').height=parseInt(ht)+40;}

//  Function: gotosite
//    Used to redirect the user to a new page via JavaScript
//
//  Parameters:
//    url - (String) a url to redirect to
//
//   TODO:
//    deprecate/remove this when it is no longer in use
//
window.gotosite = function(l) { if(!!l) { location.href = l; } };

// Section: String helpers

//   Method: String.prototype.namespace
//    simple method to create namespaces
//
//   Usage:
//  >  'my.super.long.namespace'.namespace();
String.prototype.namespace = function(separator) {
  var ns = this.split(separator || '.'), p = window, i, len;
  for (i = 0, len = ns.length; i < len; i++) {
    p = p[ns[i]] = p[ns[i]] || {};
  }
};

//   Method: String.prototype.repeat
//    simple method to repeat a string n times
//
//   Usage:
//  >  'repeat this'.repeat(10);
String.prototype.repeat = function(n) {
  return new Array(n+1).join(this);
};

// Method: String.prototype.escapeSingleQuotes
// a method to help escape single quotes in text for JSON in classes
//
// Usage:
// >  text.escapeSingleQuotes();
String.prototype.escapeSingleQuotes = function() {
  return this.replace(/'/gmi,"\\'");
};

// Method: String.prototype.escapeDoubleQuotes
// a method to help escape double quotes in text for JSON in classes
//
// Usage:
// >  text.escapeDoubleQuotes();
String.prototype.escapeDoubleQuotes = function() {
  return this.replace(/"/gmi,'\\"');
};

/*
  Section: ESPN Core jQuery Plugins

  Method: jQuery.getScriptCache
    A jQuery plugin to load an external script and use caching.
    This is an extension of jQuery.getScript().

  Parameters:
    url - (String) the url of the script you want to load
    callback - (Function) the function to execute when the script has finished loading
*/
jQuery.getScriptCache = function(url,callback) {
  // perform a cached ajax call
  jQuery.ajax({
    url: url,
    cache: true,
    success: callback,
    type: 'GET',
    dataType: 'script'
  });
};

/*
  Method: jQuery.parseUri
    Parses a URI and returns all the data you would expect.  You can use it to find GET parameters, etc.

  Parameters:
    uri - (String) the uri you want to parse. ex: document.location.href

  Returns:
    object - an object with data about the uri

  Usage:
    > jQuery.parseUri(document.location.href);

    Would produce something like the following:

    (start code)
    {
      anchor: "hello",
      authority: "espn.go.com",
      directory: "/",
      file: "",
      host: "espn.go.com",
      password: "",
      path: "/",
      port: "",
      protocol: "http",
      query: "foo=bar&baz=bat",
      queryKey: {
        baz: "bat",
        foo: "bar"
      },
      relative: "/?foo=bar&baz=bat",
      source: "http://espn.go.com/?foo=bar&baz=bat#hello",
      user: "",
      userInfo: ""
    }
    (end code)
*/
jQuery.parseUri = function(str) {
  var  o   = jQuery.parseUri.options,
    m   = o.parser[o.strictMode ? "strict" : "loose"].exec(str),
    uri = {},
    i   = 14;

  while (i--) uri[o.key[i]] = m[i] || "";

  uri[o.q.name] = {};
  uri[o.key[12]].replace(o.q.parser, function ($0, $1, $2) {
    if ($1) uri[o.q.name][$1] = $2;
  });

  return uri;
};

jQuery.parseUri.options = {
  strictMode: false,
  key: ["source","protocol","authority","userInfo","user","password","host","port","relative","path","directory","file","query","anchor"],
  q:   {
    name:   "queryKey",
    parser: /(?:^|&)([^&=]*)=?([^&]*)/g
  },
  parser: {
    strict: /^(?:([^:\/?#]+):)?(?:\/\/((?:(([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?))?((((?:[^?#\/]*\/)*)([^?#]*))(?:\?([^#]*))?(?:#(.*))?)/,
    loose:  /^(?:(?![^:@]+:[^:@\/]*@)([^:\/?#.]+):)?(?:\/\/)?((?:(([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?)(((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[?#]|$)))*\/?)?([^?#\/]*))(?:\?([^#]*))?(?:#(.*))?)/
  }
};

// set the default for debug message to 0
debug.setLevel(0);
if(!!jQuery.parseUri(window.location).queryKey.debug || !!jQuery.parseUri(window.location).queryKey.development) {
  debug.setLevel(5);
}

/*
  Method: jQuery.cookie
    A jQuery plugin to help handle cookies.
    You can use this for more verbose cookie operations or utilize the shortcut methods listed in the next section.

  Parameters:
    key - (String) the name of the cookie we're operating on
    value - (String) the value of the cookie
    options - (Object) an object containing cookie options

  Usage:

  (start code)

  // getting a cookie
  var foo = jQuery.cookie('foo');

  // setting a cookie using default options
  jQuery.cookie('foo','bar');

  // setting a cookie and overriding the defaults
  jQuery.cookie(
    'foo',  // name of the cookie
    'bar',  // value of the cookie
    {
      "domain": ".foo.com", // set a new domain for the cookie        ( default = '.espn.go.com' )
      "path": "/foo/bar",   // change the path the cookie is valid in ( default = '/' )
      "secure" : true,      // make the cookie secure (https)         ( default = window.location.protocol === 'https:' )
      "expires": 10         // set the cookie to expire in 10 days    ( default = null )
    }
  );

  // deleting a cookie
  jQuery.cookie('foo','',{'expires':-1});

  (end code)
*/
jQuery.cookie = function(key,value,options) {

  // set up variables used later in this method
  var settings = jQuery.extend({
      'domain':'.espn.go.com',
      'path': '/',
      'secure': window.location.protocol === 'https:',
      'expires': null
    },options),
    regex, r, date, expires,
    path = settings.path !== null ? '; path='+settings.path : '',
    domain = settings.domain !== null ? '; domain='+settings.domain : '',
    secure = settings.path === true ? '; secure=' : '';

  // if only a key was passed in, look to see if we have that cookie and pass back the value.
  if (typeof value === 'undefined') {
    regex = new RegExp('(^|;) ?' + key + '=([^;]+)(;|$)','g');
    r = regex.exec(document.cookie);
    if (r !== null) {
      return decodeURIComponent(r[2]);
    }
    return null;
  }

  // set the value of a cookie down here
  if (settings.expires !== null && (typeof settings.expires === 'number' || settings.expires.toUTCString)) {
    if (typeof settings.expires === 'number') {
      date = new Date();
      date.setTime(date.getTime() + (settings.expires * 24 * 60 * 60 * 1000));
    } else {
      date = settings.expires;
    }
    expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
  }
  document.cookie = [key, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
  return document.cookie;
};

//   Namespace: espn.cookie
//    Basic functions to help get, set and delete cookies
'espn.cookie'.namespace();

espn.cookie = {
  /*
      Function: espn.cookie.get
        Get the value for a specific cookie

      Parameters:
        key - (String) the name of the cookie being retrieved

      Returns:
        value - (String) The value of the cookie

      Usage:
      >  espn.cookie.get('foo');
  */
  get: function(key) {
    return jQuery.cookie(key);
  },

  /*
      Function: espn.cookie.set
        Set the value for a specific cookie

      Parameters:
        key - (String) the name of the cookie being set
        value - (String) the value of the cookie being set
        days - (Number) the number of days the cookie should live.  Leave blank for session.

      Usage:
      >  espn.cookie.set('foo','bar',10);
  */
  set: function(key,value,days) {
    jQuery.cookie(key,value,{'expires':days});
  },

  /*
      Function: espn.cookie.del
        Delete a specific cookie.  This is a shrotcut for the full fledged method.

      Parameters:
        key - (String) the name of the cookie to delete

      Usage:
      >  espn.cookie.del('foo');
  */
  del: function(key) {
    jQuery.cookie(key,'',{'expires':-1});
  }
};

// some global cookie shortcuts
window.getCookie = espn.cookie.get;
window.setCookie = espn.cookie.set;
window.deleteCookie = espn.cookie.del;

//
//   Namespace: espn.refresh
//    The follwing helper function will stop and restart the auto meta refresh on the page.  This only works when
//    javascript is enabled and requires the following code in the HEAD of the HTML document.
//
//  (start code)
//    <script>
//      ESPN_refresh=window.setTimeout(function(){window.location.href=window.location.href},900000);
//    </script>
//    <noscript>
//      <meta http-equiv="refresh" content="900" />
//    </noscript>
//  (end code)
//
'espn.refresh'.namespace();

//   Function: espn.refresh.stop
//     Removes the javascript meta refresh from the page
espn.refresh.stop = window.ESPN_refresh_stop = function() {
  if(typeof ESPN_refresh !== 'undefined') {
    clearTimeout(ESPN_refresh);
  }
};

//   Function: espn.refresh.start
//     Restores the javascript meta refresh for the page
//
//   Parameters:
//    msec - [optional] (Number) the number of milliseconds to set page refresh to [Default = 900000]
espn.refresh.start = window.ESPN_refresh_start = function(msec) {
  ESPN_refresh = window.setTimeout(function() {
    window.location.href = window.location.href;
  },
  msec || 900000);
};

//
// Namespace: espn.sport
//
'espn.sport'.namespace();
(function() {
  var sportIdCache=[];
  //  Function: espn.sport.id
  //    Returns the value for the sport id located in the body tag's metadata
  //
  //  Returns:
  //    (Number) - Value of the Sport's ID
  //    (Array) - array of multiple Sport IDs
  //
  espn.sport.id = function() {
    var sportId = 'sportId';
    if(!sportIdCache[sportId]) {
      sportIdCache[sportId] = jQuery('body').metadata()[sportId];
    }
    return sportIdCache[sportId];
  };
})();

//  Function: espn.sport.is
//    Checks to see if the current page is a certain sport
//
//  Returns:
//    (boolean) True or False is the page is of a particular sport id
//
espn.sport.is = function(id) {
  var sportId = espn.sport.id(), idType = typeof sportId;
  return (idType === "number" || idType === "string") ? +id === +sportId : jQuery.inArray(id,sportId) > -1;
};

//   Namespace: espn.core
'espn.core'.namespace();

//   Group: Core Variables

//  Variable: espn.core.mobileApple
//    If this device is an iPod, iPhone or iPad
//
//  Returns:
//    boolean - if the device is an iPod, iPad or iPhone
espn.core.mobileApple = /iP(od|ad|hone)/i.test(navigator.userAgent);

//  Variable: espn.core.ipod
//    If this device is an iPod
//
//  Returns:
//    boolean - if the device is an iPod
espn.core.ipod = /iPod/i.test(navigator.userAgent);

//  Variable: espn.core.iphone
//    If this device is an iPhone
//
//  Returns:
//    boolean - if the device is an iPhone
espn.core.iphone = /iPhone/i.test(navigator.userAgent);

//  Variable: espn.core.ipad
//    If this device is an iPad
//
//  Returns:
//    boolean - if the device is an iPad
espn.core.ipad = /iPad/i.test(navigator.userAgent);

//  Variable: espn.core.android
//    If this device is an android
//
//  Returns:
//    boolean - if the device is an android
espn.core.android = /Android/i.test(navigator.userAgent);

//  Variable: espn.core.android
//    If this device is an android
//
//  Returns:
//    boolean - if the device is an android
espn.core.googletv = /GoogleTV/i.test(navigator.userAgent)

//  Variable: espn.core.palm
//    If this device is a webOS Palm device
//
//  Returns:
//    boolean - if the device is a webOS Palm device
espn.core.palm = /webOS/i.test(navigator.userAgent);

//  Variable: espn.core.blackberry
//    If this device is a Blackberry device
//
//  Returns:
//    boolean - if the device is a Blackberry device
espn.core.blackberry = /BlackBerry/i.test(navigator.userAgent);

//   Variable: espn.core.SWID
//     The current fan's SWID
//
//   Returns:
//    string - the value in the fan's SWID cookie
espn.core.SWID = espn.cookie.get('SWID') || '';

//   Variable: espn.core.loggedIn
//     Checks to see if the user is logged in
//
//   Returns:
//    boolean - is the user logged in
//
espn.core.loggedIn = /^\{[\w-]+\}/.test(espn.core.SWID);

//   Variable: espn.core.cdnHTTPPath
//     the HTTP path to the cdn
//
//   Returns:
//    string - the http path to the cdn with trailing slash
espn.core.cdnHTTPPath = "http://a.espncdn.com/";

//   Variable: espn.core.cdnHTTPSPath
//     the HTTPS path to the cdn
//
//   Returns:
//    string - the https path to the cdn with trailing slash
espn.core.cdnHTTPSPath = "https://a248.e.akamai.net/f/12/621/5m/proxy.espn.go.com/";

//   Variable: espn.core.secure
//     Checks to see if we're being served from a secure url
//
//   Returns:
//    boolean - if the current http session is secure
espn.core.secure = !!("https:" === document.location.protocol);

//   Variable: espn.core.asset_path
//     Checks to see if we're being served from a secure url before returning the proper url
//
//   Returns:
//    string - The URL to the assets on the CDN
espn.core.asset_path = espn.core.secure ? espn.core.cdnHTTPSPath + 'prod/' : espn.core.cdnHTTPPath + 'prod/';

//   Variable: espn.core.combiner_path
//     Checks to see if we're being served from a secure url before returning the proper url
//
//   Returns:
//    string - The URL to the resource combiner with trailing slash
espn.core.combiner_path = espn.core.secure ? espn.core.cdnHTTPSPath + 'combiner/c/' : espn.core.cdnHTTPPath + 'combiner/c/';

//   Variable: espn.core.jquery_ui_path
//     Creates the URL to the current jquery ui components
//
//   Returns:
//    string - The URL to the jquery ui components on the CDN with trailing slash
espn.core.jquery_ui_path = espn.core.asset_path + 'scripts/ui/1.8.2/minified/';

//   Group: Core Functions

//   Function: espn.core.benchmark
//
//     This function will allow you to benchmark code blocks before implementing them
//     allowing you to determine which method is more efficient
//
//   Parameters:
//
//     func - (Function) The function to benchmark
//     iterations - (Number) number of times to run the code
//     label - (String) used for logging to the console
//
espn.core.benchmark = function(func, iterations, label) {
  iterations+=1;// increment by one for the reverse while loop
  var start = +new Date(), stop;
  while(--iterations) { func.call(this) }
  stop = +new Date();
  if(window.console && window.console.log) {
    window.console.log(label,stop-start);
  } else {
    alert(label+' '+stop-start);
  }
};

/*
  Function: espn.core.type
    This will return the type of the object passed in.  You can use it
    to test for any native JavaScript type. Object, Array, Date, Function, String, Number, etc.

    *This method is not to be used to test if something is undefined of null*

    Note: the espn.core.is function will be faster

  Parameters:
    obj - the object you wish to find the type of

  Returns:
    string - the type of the object (Array|Boolean|Date|Function|HTMLDocument|Number|Object|String|Window)

  Usage:
    (start code)

      ( "Array" === espn.core.type([]) ) // Array test

      ( "Boolean" === espn.core.type(true) ) // Boolean test

      ( "Date" === espn.core.type(new Date) ) // Date test

      ( "Function" === espn.core.type(function(){}) ) // Function test

      ( "HTMLDocument" === espn.core.type(document) ) // HTMLDocument test

      ( "Number" === espn.core.type(1) ) // Number test

      ( "Object" === espn.core.type({}) ) // Object test

      ( "String" === espn.core.type("hello, world") ) // String test

      ( "Window" === espn.core.type(window) ) // Window test

    (end code)
*/
espn.core.type = function(obj) {
  return Object.prototype.toString.call(obj).match(/^\[object (.*)\]$/i)[1];
};

/*
  Function: espn.core.is
    This will return the type of the object passed in.  You can use it
    to test for any native JavaScript type. Object, Array, Date, Function, String, Number, etc.

    *This method is not to be used to test if something is undefined of null*

  Parameters:
    obj - the object you are testing
    type - the type you are testing for

  Returns:
    boolean - object === type (Array|Boolean|Date|Function|HTMLDocument|Number|Object|String|Window)

  Usage:
    (start code)

      ( espn.core.is([], 'Array') // Array test

      ( espn.core.is(true, 'Boolean') ) // Boolean test

      ( espn.core.is(new Date, 'Date') ) // Date test

      ( espn.core.is(function(){}, 'Function') ) // Function test

      ( espn.core.is(document, 'HTMLDocument') ) // HTMLDocument test

      ( espn.core.is(1, 'Number') ) // Number test

      ( espn.core.is({}, 'Object') ) // Object test

      ( espn.core.is("hello, world", 'String') ) // String test

      ( espn.core.is(window, 'Window') ) // Window test

    (end code)
*/
espn.core.is = function(obj,type) {
  return Object.prototype.toString.call(obj) === "[object "+ type +"]";
};

/*
 *  ESPN CORE STARTS NOW
 */
(function($) {
  //'$:nomunge'; // Used by YUI compressor.

  /* define all our vars in this scope for compression*/
  var global = this,
      b,
      debug = window.debug, // shortcut to debug methods
      UNDEF = 'undefined',
      asset_path = ("https:" === document.location.protocol) ? 'https://a248.e.akamai.net/f/12/621/5m/proxy.espn.go.com/prod/' : 'http://a.espncdn.com/prod/',
      activeNav = null,
      script_loaded = [],
      SWID = "",
      loggedIn = false,
      bodyClass,
      initMyHeadlines,
      initMyFaves,
      tabControl,
      userABValue,
      userABCookie;

  // this is totally redundant and should be changed
  SWID = espn.core.SWID;
  loggedIn = espn.core.loggedIn;

   /*
      Function: espn.cookie.ad_segments
        gets ad segements to pass to doubleclick

      Returns:
        o - (String) key value pairs for double click

      Usage:
      >  espn.cookie.ad_segments();
  */


  function ad_segments () {
    // Real cookie.
    var o="",c=jQuery.cookie('CRBLM');

    // 709=10,56=1
    //var o="",c="CBLM-001:AsUAAAAKADgAAAAB";

    // 0=1, 37=100, 698=1, 75=2, 757=1, 758=1, 699=1, 709=1, 792=1, 800=1, 818=1, 826=1 var o="",c="CBLM-001:AAAAAAABACUAAABkAroAAAABAEsAAAACAvUAAAABAvYAAAABArsAAAABAsUAAAABAxgAAAABAyAAAAABAzIAAAABAzoAAAAB";

    if (c) {
      var c = c.substring(9);
      var index = 0, value = 0, count = 0, key = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
      // Ensure input is a multiple of 4 bytes.
      for (var i = 0, n = c.length, nn = n - (n % 4); i < nn;) {
        var enc1 = key.indexOf(c.charAt(i++));
        var enc2 = key.indexOf(c.charAt(i++));
        // Base64 decode and shift 0 or 8 bits. Increment index.
        value |= (enc1 << 2 | enc2 >> 4) << (index++ ? 0 : 8);
        // Add value to output if index is not 2.
        if (!(index - 2) && value) {
          o += "seg=" + value + ";";
          if (++count == 12) break; // Quit after 6 segments.
        }
        // If index is 6, set to 0. If index is 0 (segment value) or 2 (segment ID), set value to 0.
        value *= (index %= 6) && index - 2  ? 1 : 0;
        var enc3 = key.indexOf(c.charAt(i++));
        if (enc3 != 64) {
          value |= ((enc2 & 15) << 4 | enc3 >> 2) << (index++ ? 0 : 8);
          if (!(index - 2) && value) {
            o += "seg=" + value + ";";
            if (++count == 12) break;
          }
          value *= (index %= 6) && index - 2  ? 1 : 0;
        }
        var enc4 = key.indexOf(c.charAt(i++));
        if (enc4 != 64) {
          value |= ((enc3 & 3) << 6 | enc4) << (index++ ? 0 : 8);
          if (!(index - 2) && value) {
            o += "seg=" + value + ";";
            if (++count == 12) break;
          }
          value *= (index %= 6) && index - 2  ? 1 : 0;
        }
      }
    }
	return o;
  }
  espn.core.ad_segments = ad_segments;



  /**
   *  SET INTERVAL DOM CHECKS
   */
  // we can break this component out or lazy load it as well
  function initAccordion(el) {
    findAccordions(el);
  };

  function findAccordions(el) {
    var a = (el) ? $(el) : $('div.mod-accordion').not('.ui-accordion'), // if an element was passed in, use it - otherwise find all uninitialized accordions
      ac ='active', /*define active class name*/
      activate = function(e) {
        $(e.target)
          .parent()
            .siblings('a.active')
              .removeClass(ac)
            .end()
          .end()
          .addClass(ac);
      },
      stylize = function(event, ui) {
        ui.newHeader.addClass(ac);
        ui.newContent.addClass(ac);
        ui.oldHeader.removeClass(ac);
        ui.oldContent.removeClass(ac);
      },
      len = a.length,
      acc;

    if(len) {
      // use a loop since we're not actually doing anything with
      while(len--) {
        acc = a.get(len); // cache the current accordion reference
        $('div.mod-sub-accordion',acc).accordion({
          header: 'a.mod-sub-accordion-trigger',
          active: '.active',
          autoHeight: false,
          fillSpace: false
        }).bind('accordionchange', function(event, ui) { stylize(event,ui); });
        $('a.mod-sub-accordion-trigger',acc).click(function(e) { activate(e); });
      }
      a.accordion({
        header: 'a.mod-accordion-trigger',
        active: '.active',
        autoHeight: false,
        fillSpace: false
      }).bind('accordionchange', function(event, ui) { stylize(event,ui); });
      $('a.mod-accordion-trigger').click(function(e) { activate(e); });
    }
  };


  userABCookie = $.cookie('userAB');
  if (SWID !== "" && userABCookie === null) {
    if (SWID.charAt(SWID.length-1) === '}') {
      userABValue = SWID.charAt(SWID.length-2);
    } else {
      userABValue = SWID.charAt(SWID.length-1);
    }
    $.cookie('userAB',userABValue,{'domain':'.espn.go.com', 'expires':7});
  }




  $.fn.espnSelectRedirect = function() {
    return this.each(function() {
      $(this).bind('change', function() {
        var option = $(this).find('option').get(this.selectedIndex),
          href = option.value,
          data = $(option).metadata();
        if(href !== "#" && href !== '') {
          if(typeof data.popup !== UNDEF) {
            window.open(href, data.popup.name || 'espnpop', data.popup.features || null);
          } else {
            window.location.href = href; // throw it to the top!
          }
        }
      })
    });
  };




//$.fn.espn.flashHeader = function() {
  function initFlashSubHeader(section) {
    if (window.Jiffy) { Jiffy.mark('initFlashSubheaderStart'); }
    //if(arguments.callee.done === true) { return; } // we be done
    // set the sub header if available
    var title, indexUrl, data, gh, flashVars, params, attributes, suspendRender, useNonFlashHeader,
      cufon_load_only_once = true;

    if(section.length) {
      title = section.find('span').html();
      indexUrl = section.attr('href');
      data = section.metadata();
      useNonFlashHeader = !!espn.core.mobileApple || !!espn.core.android || !!jQuery.parseUri(window.location).queryKey.useNonFlashHeader;
      if (!useNonFlashHeader) {
        gh = new flashObj();
        gh.flashFile = data.src || "swf/globalHeader_redesign.swf";
        gh.flashVars = "&title="+title+
          "&titlex="+(data.titlex||'')+
          "&titley="+(data.titley||'')+
          "&renderLogo="+(data.renderLogo||'')+
          "&indexUrl="+(indexUrl||'')+
          "&logo1url="+(data.logo1url||'')+
          "&clicktag="+(data.clicktag||'')+
          "&logo1Align="+(data.logo1Align ||'')+
          "&logo2url="+(data.logo2url||'')+
          "&clicktag2="+(data.clicktag2||'')+
          "&logo2Align="+(data.logo2Align ||'')+
          "&header="+(data.header||'')+
          "&headerPadding="+(data.headerPadding||'')+
          "&section="+(data.section||'')+
          "&sectionUrl="+(data.sectionUrl||'')+
          "&sectionPadding="+(data.sectionPadding||'')+
          "&gradientTopColor="+(data.gradientTopColor||'')+
          "&gradientBottomColor="+(data.gradientBottomColor ||'')+
          (data.adTag||'');

        gh.width = data.width || "924";
        gh.height = data.height || "45";
        gh.scale = data.scale || "noScale";
        gh.salign = data.salign || "lt";
        gh.wmode = data.wmode || 'opaque';
        gh.DenyIEdl = data.DenyIEdl || "true";
        gh.allowScriptAccess = data.allowScriptAccess || "Always";
        gh.allowNetworking = data.allowNetworking || "All";
        gh.FlashVer = data.FlashVer || 7;
        gh.cabVersion = data.cabVersion || "7,0,19,0";
        gh.altTxt = section.html();
        gh.ID = data.id || !!section.attr('id') ? section.attr('id') : "section-title";

        //gh.useDOM = true;
        //gh.targetElement = section.attr('id');

        suspendRender = function(gh,section) {
          if(gh.compiled === true && gh.src) {
            // let's make sure the original isn't on the page
            //$('object#'+gh.ID).remove();
            section.replaceWith(gh.src);
          } else {
            setTimeout(function() { suspendRender(gh,section); },10);
          }
        }
        if(gh.render !== window.____FLASH_RENDERER_____) {
          gh.render = window.____FLASH_RENDERER_____;
        }
        gh.render(); // render the html for the object
        suspendRender(gh,section); // wait for the src so we can inject it
        //section.replaceWith(gh.render());
        //arguments.callee.done = true;
      } else {
        if(!window.Cufon && !espn.core.init.nonFlashHeader) {
          $.subscribe('espn.cufon.loaded', function() {
            espn.core.init.nonFlashHeader(section, data);
          });
          if(cufon_load_only_once) {
            cufon_load_only_once = false;
            $('head').append('<link rel="stylesheet" href="' + espn.core.combiner_path + '27?css=modules/nonflash.css" type="text/css" media="screen" charset="utf-8" />');
            $.getScriptCache (espn.core.combiner_path+'?js=cufon-yui.js,fonts/DejaVu_Sans_oblique_700.font.js,espn.nonflash.r3.js',function() {
              $.publish('espn.cufon.loaded');
            });
          }
        } else {
          espn.core.init.nonFlashHeader(section, data);
        }
      }
    }
    if (window.Jiffy) { Jiffy.measure('initFlashSubheaderDone','initFlashSubheaderStart'); }
  };

  // Namespace: espn.core.track
  'espn.core.track'.namespace();

  function trackButtonClicks(e, type) {
    if (typeof anTrackLink !== 'function') { return; } // can't track anything anyway
    var lpos, target, mod, lid, bId, lposrx, lidrx;
    if(type === "carousel"){
      lpos = "carousel";
      target = $(e.target);
      mod = ":topstory";
      bId = "rightarrow";

      if(window.location.href === "http://espn.go.com/" || window.location.href === "http://espn.go.com/index"){
        lpos = "fp"+ lpos;
      } else {
        //remove meta data
    bodyClass = b.attr("class").replace(/\{[^{]*\}|[\W_]/g, '');
    if(bodyClass.indexOf('espn360') > -1){
      bodyClass = bodyClass.replace('espn360','');
        }
        lpos = bodyClass+"index"+lpos;
      }

      if($("div.videoplayer-show",'#top-stories').length > 0){
        mod = ":topvideos";
      }
      lpos += mod;

      if(target.hasClass('jcarousel-prev')){
        bId = "leftarrow";
      }
      lid = bId;
      anTrackLink(target, 'espn', lpos, lid);
    } else {
      //This is for tabs essentially. You should be passing ui.tab as e and "tab" as the type
      //Tabs have lpos and lid in the name attribute of the anchor element clicked
      lposrx = /\=([A-Za-z-\+]+)&/;
      lidrx = /\=([A-Za-z-\+]+)$/;
      lpos = lposrx.exec(e.name) || [];
      lid = lidrx.exec(e.name) || [];
      if(lpos.length > 1 && lid.length > 1) {
          anTrackLink(e, 'espn', lpos[1], lid[1]+"+tab");
      }
    }
  };

  // THIS IS BEING REMOVED
/*

*/

    tabControl = { videoPlayer: null, espn360Player: null, topStories: false };
    function initTabs(sel,tabSettings) {
      // filter out the scoreboard and already initialized tabs
      var tabContainer = $(sel).parent().filter(function() {
        var $this = $(this);
        return ($this.parents('#scoreboard').length > 0 || $this.data('initialized') === true) ? false : true;
      });
      var settings = $.extend({
        cache: true,
        spinner: '',
        select: function(event,ui) {
          var panel = $(ui.panel);
          //$(document).triggerHandler('espn.tabs.select');
          debug.log('select',event,ui);
          /*
          if (!!panel.parents('#top-stories').length) {
            debug.info('select: top-stories');
            tabControl.topStories = true;
            //  TODO:: Move To PubSub
            tabControl.videoPlayer = $('div.videoplayer-show');
            tabControl.espn360Player = $('div.espn360Player-show');
          }
          */
          /*Added analytics tracking */
          // TODO::PubSub Hooks for analytics
          trackButtonClicks(ui.tab, "tab");
          $.publish('espn.tabs.select',[panel,ui]); // pass the current tab panel and ui object
        },
        load: function(event,ui) {
          var panel = $(ui.panel);
          debug.log('load',event,ui);
          //$(document).triggerHandler('espn.tabs.load');

          //   TODO::I should probably hook carousels to use PubSub
          //setTimeout(function() { initCarousels(panel); }, 100);

          $.publish('espn.tabs.load',[panel,ui]); // pass the current tab panel and ui object
        },
        show: function(event,ui) {
          debug.log('show',event,ui);
          var panel = $(ui.panel), videoitem, mediaId,linkdata;
          // init the carousel in the tab if it exists
          // let's announce to the world that we've triggered a tab, pass in the current panel
          //$(document).triggerHandler('espn.tabs.show', [panel]);


          //   TODO::I should probably hook carousels to use PubSub
          //setTimeout(function() { initCarousels(panel); }, 100);
          /*
          if (tabControl.topStories === true) {
            //console.log('show: top-stories');
            tabControl.topStories = false;
            //  TODO::Move this to PubSub hooks
            tabControl.videoPlayer.removeClass('videoplayer-show');
            tabControl.espn360Player.removeClass('espn360Player-show');
            // make sure the controls to any video player are hidden
            if(espn.video.player.useHTML5Video) {
              espn.video.html5.hideControls();
            }

            //  TODO::Hook into PubSub
            try {
              if (typeof window.com !== UNDEF) {
                espn.video.pause();
                espn.video.player.state = VIDEO_STATE.PAUSE;
              }
            } catch (error) {
              //debug.error(error);
            }
            videoitem = panel.find('ul li.active a[rel=js-video]');
            //espn360item = panel.find('ul li.active a[rel=js-espn360]');

            if(videoitem.length > 0) {
              mediaId = $.parseUri(videoitem.attr('href')).queryKey['id'];
              if (mediaId == null || mediaId == 'null'){
                mediaId = $.parseUri(videoitem.attr('href')).queryKey['mId'] || null;
              }
              linkdata = videoitem.metadata();
              linkdata.userAction=true;
              espn.video.play(mediaId,linkdata,true);
            }
          }
          */
          //  TODO::the myheadlines code should hook into this
          //if (panel.find('.mod-myheadlines').length > 0) {
          //  initMyHeadlines(ui);
          //}
          // publish that we're shown the tab
          $.publish('espn.tabs.show', [panel,ui]); // pass the current panel and ui object
        }
      },tabSettings);

    if(window.Jiffy) { Jiffy.mark('initTabsStart'); }
      tabContainer.data('initialized',true);
      tabContainer.tabs(settings);
      if(window.Jiffy) { Jiffy.measure('initTabsEnd','initTabsStart'); }
    };

    //   Namespace: espn.core.init
    //    Functionality used to initialize core components of a page
    'espn.core.init'.namespace();

    // Function: espn.core.init.tabs
    // initializes a set of tabs
    //
    // Parameters:
    //
    //  selector - the css selector of the tab set to initialize
    //
    // Usage:
    //
    // - The example below initializes tabs without changing any markup. You just need to drop this snippet tea
    //   code and script tag into your template after the closing div tag of mod-tabs. In this example, the
    //   script tag has an id the script searches for a sibling of this script tag that has a mod-tabs class and
    //   contains a mod-header class:
    // > <div class="mod-container mod-tabs mod-no-footer">
    // >     <div class="mod-header">
    // >         ...
    // >     </div>
    // > ...
    // > </div>
    // > <!-- copy the following into your template -->
    // > <% tabInitScriptTime = currentDate().time; %>
    // > <script id="tabInitScript<%tabInitScriptTime%>">
    // >     espn.core.init.tabs(jQuery('#tabInitScript<%tabInitScriptTime%>').siblings('.mod-tabs').find('.mod-header'));
    // > </script>
    espn.core.init.tabs = initTabs;

    // Function: espn.core.init.nav
    // initializes the main navigation component
    //espn.core.init.nav = initNav;

    // Function: espn.core.init.carousel
    // legacy carousel support
    //
    // Parameters:
    //
    //  parent - parent dom element the carousel sits in
    //
    // Usage:
    //
    // - This loads the jcarousel plugin and the espn.carousel.js file to initialize legacy carousels
    espn.core.init.carousel = function loadCarousel(parent) {
		$.getScriptCache(espn.core.combiner_path+'?js=plugins/jquery.jcarousel.js,espn.carousel.r2.js', function() {
			espn.core.init.carousel(parent);
		});
	};

    // Function: espn.core.init.accordion
    // initializes a set of tabs
    //
    // Parameters:
    //
    // selector - the css selector of the accordion to initialize
    //
    // Usage:
    //
    // - The example below initializes an accordion without changing any markup. You just need to drop this
    //   snippet tea code and script tag into your template after the closing div of the element that contains
    //   mod-accordion. In this example, the script tag has an id and the script searches for a sibling of the
    //   script tag that contains a mod-accordion div:
    // > <div class="mod-accordion">
    // >     ...
    // > </div>
    // > <!-- copy the following into your template -->
    // > <% currentTimeForScript = currentDate().time; %>
    // > <script id="accordionInitScript<% currentTimeForScript %>">
    // >     espn.core.init.accordion(jQuery('#accordionInitScript<% currentTimeForScript %>').siblings().find('.mod-accordion') );
    // > </script>
    espn.core.init.accordion = initAccordion;

    // Function: espn.core.init.flashHeader
    // initialized flash headers on Tier II and Tier III pages
    //
    // Parameters:
    //
    // section - jQuery object of section to turn into a flash header [ $('#section-title') ]
    //
    // Usage:
    //
    // - The example below initializes an flash header without changing any markup.
    // > <div class="espn-logo">
    // >     <h1>
    // >         <a href="http://espn.go.com"><span>ESPN</span></a>
    // >         <a id="section-title" class="{wmode:'transparent',src: 'http://a.espncdn.com/prod/swf/globalHeader_v3.swf',height: '45', adTag: '<InLineReplace name=ad type=SponsoredByLogoHeader>'}" href="http://sports-ak.espn.go.com/mlb/index"><span>MLB</span></a>
    // >     </h1>
    // > </div>
    // > <script>
    // >     espn.core.init.flashHeader(jQuery('#section-title'));
    // > </script>
    espn.core.init.flashHeader = initFlashSubHeader;

    // Deprecated: object to expose some of our stuff
    $.espn = {
      'initTabs':       initTabs,
      //'initNav':         initNav,
      //'initCarousels':   initCarousels,
      'initMyFaves':     initMyFaves,
      'initAccordion':   initAccordion,
      'initMyHeadlines':initMyHeadlines
    };

  // init top carousel

  function init() {
    if(window.Jiffy) { Jiffy.mark('onDOMReady'); }
    // resets from the dom ready loader
    if (arguments.callee.done) { return; }
    arguments.callee.done = true;
    b = $('body');
    // TODO: can we .live() or .delegate() this?
    $('form.js-goto').find('select').espnSelectRedirect();

    // hide open selects when the myESPN button is hovered over
    $('#myespn').bind('mouseover', function() {
      $('select').each(function() {
        if(this.size < 1 || typeof this.size === UNDEF) {
          this.blur(); this.size=0;
        }
      })
    });

    if(window.Jiffy) { Jiffy.measure('onDOMReady::Complete','onDOMReady'); }
  };


  // *******************************************************************************
  // start onDOMReady
  // *******************************************************************************
  $(function() {
    init();
  });
  // *******************************************************************************
  // end onDOMReady
  // *******************************************************************************

  $(window).on('unload',function(){
    document.onkeypress = null;
  });


})(jQuery);

//  Package: Deprecated
//    The following functions are deprecated and you should transition to the new functions

//  Method: jQuery.debug
//    Please transition to using the debug methods in the global namespace.
//
//  New Function:
//  >  debug.debug();
jQuery.debug = debug.debug;

//  Method: jQuery.log
//    Please transition to using the debug methods in the global namespace.
//
//  New Function:
//  >  debug.log();
jQuery.log = debug.log;

//  Method: jQuery.info
//    Please transition to using the debug methods in the global namespace.
//
//  New Function:
//  >  debug.info();
jQuery.info = debug.info;

//  Method: jQuery.warn
//    Please transition to using the debug methods in the global namespace.
//
//  New Function:
//  >  debug.warn();
jQuery.warn = debug.warn;

//  Method: jQuery.error
//    Please transition to using the debug methods in the global namespace.
//
//  New Function:
//  >  debug.error();
jQuery.error = debug.error;

//  Method: jQuery.assert
//    Please transition to using the debug methods in the global namespace.
//
//  New Function:
//  >  debug.assert();
jQuery.assert = debug.assert;

//  Method: jQuery.trace
//    Please transition to using the debug methods in the global namespace.
//
//  New Function:
//  >  debug.trace();
jQuery.trace = debug.trace;

//  Method: jQuery.group
//    Please transition to using the debug methods in the global namespace.
//
//  New Function:
//  >  debug.group();
jQuery.group = debug.group;

//  Method: jQuery.groupEnd
//    Please transition to using the debug methods in the global namespace.
//
//  New Function:
//  >  debug.groupEnd();
jQuery.groupEnd = debug.groupEnd;

//  Method: jQuery.time
//    Please transition to using the debug methods in the global namespace.
//
//  New Function:
//  >  debug.time();
jQuery.time = debug.time;

//  Method: jQuery.timeEnd
//    Please transition to using the debug methods in the global namespace.
//
//  New Function:
//  >  debug.timeEnd();
jQuery.timeEnd = debug.timeEnd;

//  Method: jQuery.profile
//    Please transition to using the debug methods in the global namespace.
//
//  New Function:
//  >  debug.profile();
jQuery.profile = debug.profile;

//  Method: jQuery.profileEnd
//    Please transition to using the debug methods in the global namespace.
//
//  New Function:
//  >  debug.profileEnd();
jQuery.profileEnd = debug.profileEnd;

//  Method: jQuery.count
//    Please transition to using the debug methods in the global namespace.
//
//  New Function:
//  >  debug.count();
jQuery.count = debug.count;

// end of the closure, pass in variables to crush
})(jQuery,window,document);

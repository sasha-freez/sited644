// File: ESPN Core Duo
//
//  ID - $Id: //vss_espneng/Templates/FrontEnd/scripts/grantland.core.js#1 $
//  DateTime - $DateTime: 2011/06/06
//  Revision - $Revision: #1 $

// define or assign the espn namespace
window.espn = window.espn || {};

// wait, what? 
// jQuery isn't defined at this point in the loading of jquery. the jquery cookie function, does not
// really need jQuery so we're going to fake this
window.jQuery = window.jQuery || {};

// namespace function
String.prototype.namespace = function(separator) {
	var ns = this.split(separator || '.'), p = window, i, len;
	for (i = 0, len = ns.length; i < len; i++) {
		p = p[ns[i]] = p[ns[i]] || {};
	}
};


jQuery.cookie = function(key,value) {
	// set up variables used later in this method
	var settings = {
			'domain':'.espn.go.com',
			'path': '/',
			'secure': window.location.protocol === 'https:',
			'expires': null
		},
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

// Namespace: espn.core
'espn.core'.namespace();

function ad_segments () {	 
	// Real cookie.
	var o="",c=jQuery.cookie('CRBLM');

	// 709=10,56=1
	//var o="",c="CBLM-001:AsUAAAAKADgAAAAB";

	// 0=1, 37=100, 698=1, 75=2, 757=1, 758=1, 699=1, 709=1, 792=1, 800=1, 818=1, 826=1 var o="",c="CBLM-001:AAAAAAABACUAAABkAroAAAABAEsAAAACAvUAAAABAvYAAAABArsAAAABAsUAAAABAxgAAAABAyAAAAABAzIAAAABAzoAAAAB";

	if (c) {
		c = c.substring(9);
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
				if (++count == 6) break; // Quit after 6 segments.
			}
			// If index is 6, set to 0. If index is 0 (segment value) or 2 (segment ID), set value to 0.
			value *= (index %= 6) && index - 2	? 1 : 0;
			var enc3 = key.indexOf(c.charAt(i++));
			if (enc3 != 64) {
				value |= ((enc2 & 15) << 4 | enc3 >> 2) << (index++ ? 0 : 8);
				if (!(index - 2) && value) {
					o += "seg=" + value + ";";
					if (++count == 6) break;
				}
				value *= (index %= 6) && index - 2	? 1 : 0;
			}
			var enc4 = key.indexOf(c.charAt(i++));
			if (enc4 != 64) {
				value |= ((enc3 & 3) << 6 | enc4) << (index++ ? 0 : 8);
				if (!(index - 2) && value) {
					o += "seg=" + value + ";";
					if (++count == 6) break;
				}
				value *= (index %= 6) && index - 2	? 1 : 0;
			}
		}
	}
	return o;
}
espn.core.ad_segments = ad_segments;    
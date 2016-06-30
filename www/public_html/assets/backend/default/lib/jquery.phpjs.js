/**
 * 
 */
(function ($) {
	$.phpjs = $.phpjs || {
		/** Number */
		//  ###
		number_format: function(e,t,n,r){e=(e+"").replace(/[^0-9+\-Ee.]/g,"");var i=!isFinite(+e)?0:+e,s=!isFinite(+t)?0:Math.abs(t),o=typeof r==="undefined"?",":r,u=typeof n==="undefined"?".":n,a="",f=function(e,t){var n=Math.pow(10,t);return""+Math.round(e*n)/n};a=(s?f(i,s):""+Math.round(i)).split(".");if(a[0].length>3){a[0]=a[0].replace(/\B(?=(?:\d{3})+(?!\d))/g,o)}if((a[1]||"").length<s){a[1]=a[1]||"";a[1]+=(new Array(s-a[1].length+1)).join("0")}return a.join(u)},
		
		/** String */
		//  ### 
		strip_tags: function(e,t){t=(((t||"")+"").toLowerCase().match(/<[a-z][a-z0-9]*>/g)||[]).join("");var n=/<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,r=/<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;return e.replace(r,"").replace(n,function(e,n){return t.indexOf("<"+n.toLowerCase()+">")>-1?e:""})},
		//  ###
		htmlspecialchars: function(e,t,n,r){var i=0,s=0,o=false;if(typeof t==="undefined"||t===null){t=2}e=e.toString();if(r!==false){e=e.replace(/&/g, '&amp;')}e=e.replace(/</g, '&lt;').replace(/>/g, '&gt;');var u={ENT_NOQUOTES:0,ENT_HTML_QUOTE_SINGLE:1,ENT_HTML_QUOTE_DOUBLE:2,ENT_COMPAT:2,ENT_QUOTES:3,ENT_IGNORE:4};if(t===0){o=true}if(typeof t!=="number"){t=[].concat(t);for(s=0;s<t.length;s++){if(u[t[s]]===0){o=true}else if(u[t[s]]){i=i|u[t[s]]}}t=i}if(t&u.ENT_HTML_QUOTE_SINGLE){e=e.replace(/'/g, '&#039;')}if(!o){e=e.replace((/"/g, '&quot;'))}return e},
		//  ###
		strcmp: function(n,r){return n==r?0:n>r?1:-1},
		strnatcmp: function(t,n,r){var e=0;void 0==r&&(r=!1);var i=function(t){var n=[],r="",e="",i=0,g=0,h=!0;for(g=t.length,i=0;g>i;i++)e=t.substring(i,i+1),e.match(/\d/)?(h&&(r.length>0&&(n[n.length]=r,r=""),h=!1),r+=e):0==h&&"."===e&&i<t.length-1&&t.substring(i+1,i+2).match(/\d/)?(n[n.length]=r,r=""):(0==h&&(r.length>0&&(n[n.length]=parseInt(r,10),r=""),h=!0),r+=e);return r.length>0&&(n[n.length]=h?r:parseInt(r,10)),n},g=i(t+""),h=i(n+""),s=g.length,l=!0,a=-1,f=0;for(s>h.length&&(s=h.length,a=1),e=0;s>e;e++)if(isNaN(g[e])){if(!isNaN(h[e]))return l?1:-1;if(l=!0,0!=(f=this.strcmp(g[e],h[e])))return f}else{if(isNaN(h[e]))return l?-1:1;if(l||r){if(0!=(f=g[e]-h[e]))return f}else if(0!=(f=this.strcmp(g[e].toString(),h[e].toString())))return f;l=!1}return a},

		/** Date - Time */
		date: function(e,t){var n=this,r,s,o=/\\?([a-z])/gi,u,a=function(e,t){e=e.toString();return e.length<t?a("0"+e,t,"0"):e},f=["Sun","Mon","Tues","Wednes","Thurs","Fri","Satur","January","February","March","April","May","June","July","August","September","October","November","December"];u=function(e,t){return s[e]?s[e]():t};s={d:function(){return a(s.j(),2)},D:function(){return s.l().slice(0,3)},j:function(){return r.getDate()},l:function(){return f[s.w()]+"day"},N:function(){return s.w()||7},S:function(){var e=s.j();i=e%10;if(i<=3&&parseInt(e%100/10)==1)i=0;return["st","nd","rd"][i-1]||"th"},w:function(){return r.getDay()},z:function(){var e=new Date(s.Y(),s.n()-1,s.j()),t=new Date(s.Y(),0,1);return Math.round((e-t)/864e5)},W:function(){var e=new Date(s.Y(),s.n()-1,s.j()-s.N()+3),t=new Date(e.getFullYear(),0,4);return a(1+Math.round((e-t)/864e5/7),2)},F:function(){return f[6+s.n()]},m:function(){return a(s.n(),2)},M:function(){return s.F().slice(0,3)},n:function(){return r.getMonth()+1},t:function(){return(new Date(s.Y(),s.n(),0)).getDate()},L:function(){var e=s.Y();return e%4===0&e%100!==0|e%400===0},o:function(){var e=s.n(),t=s.W(),n=s.Y();return n+(e===12&&t<9?1:e===1&&t>9?-1:0)},Y:function(){return r.getFullYear()},y:function(){return s.Y().toString().slice(-2)},a:function(){return r.getHours()>11?"pm":"am"},A:function(){return s.a().toUpperCase()},B:function(){var e=r.getUTCHours()*3600,t=r.getUTCMinutes()*60,n=r.getUTCSeconds();return a(Math.floor((e+t+n+3600)/86.4)%1e3,3)},g:function(){return s.G()%12||12},G:function(){return r.getHours()},h:function(){return a(s.g(),2)},H:function(){return a(s.G(),2)},i:function(){return a(r.getMinutes(),2)},s:function(){return a(r.getSeconds(),2)},u:function(){return a(r.getMilliseconds()*1e3,6)},e:function(){throw"Not supported (see source code of date() for timezone on how to add support)"},I:function(){var e=new Date(s.Y(),0),t=Date.UTC(s.Y(),0),n=new Date(s.Y(),6),r=Date.UTC(s.Y(),6);return e-t!==n-r?1:0},O:function(){var e=r.getTimezoneOffset(),t=Math.abs(e);return(e>0?"-":"+")+a(Math.floor(t/60)*100+t%60,4)},P:function(){var e=s.O();return e.substr(0,3)+":"+e.substr(3,2)},T:function(){return"UTC"},Z:function(){return-r.getTimezoneOffset()*60},c:function(){return"Y-m-d\\TH:i:sP".replace(o,u)},r:function(){return"D, d M Y H:i:s O".replace(o,u)},U:function(){return r/1e3|0}};this.date=function(e,t){n=this;r=t===undefined?new Date:t instanceof Date?new Date(t):new Date(t*1e3);return e.replace(o,u)};return this.date(e,t)},
		time: function(){return Math.floor((new Date).getTime()/1e3)},
		
		
		/** Customized for Itvina's Library */
		
		//	Ham dung format du lieu so, dua tren ham number_format.
		//	+ Chuyen dau phan cach phan ngan: "," -> "."
		//	+ Chuyen dan phan cach phan thap phan: ".", -> "."
		MAX_DECIMALS: 4,
		vnNumberFormat: function(value, escape, decimals) {
			if (value) {
				var escapedValue = ((false === escape || undefined === escape) 
					? value : this.escapeVnNumberFormat(value, true)).toString()
				;
				//  Trim '0' phia sau.
				escapedValue = (new Number(escapedValue)).toString();
				//  Format chieu dai so thap phan.
				var escapedValueDecimals = (!!(escapedValue.lastIndexOf('.') + 1) * 1) * escapedValue.split('.').pop().length;
				decimals = isNaN(decimals) ? this.MAX_DECIMALS : decimals;				 
				decimals = (decimals > escapedValueDecimals) ? escapedValueDecimals : decimals;
				value = this.number_format(escapedValue, decimals, ',', '.');	
			}
			return (new String((null === value || undefined === value) ? "" : value)).toString();
		},
		//	Ham dung escape dau cua gia tri tra ve tu "vnNumberFormat".
		escapeVnNumberFormat: function(value, float) {
			value = value.toString().replace(/\./g, '');
			if (false !== float) {
				value = value.replace(/,(\d*)$/, '.$1').replace(/,/g, '').replace(/^\.$/, '');
			}
			return value;
		},
		
		/**
		 * Tinh gia tri co VAT tu gia tri chua VAT
		 * @author Mr.Khanh 14.12.2015
 		 * @param Number amount So tien
 		 * @param Number vat %vat
 		 * @return Number
		 */
		hasVAT: function(amount, vat){
			return amount + (amount * (vat / 100));
		},
		/**
		 * Tinh gia tri chua VAT tu gia tri co VAT
		 * @author Mr.Khanh 14.12.2015
 		 * @param Number amount So tien
 		 * @param Number vat %vat
 		 * @return Number
		 */
		noVAT: function(amount, vat){
			return amount /  (1 + (vat / 100));
		}
	};
})(jQuery);
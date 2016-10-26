String.prototype.hashCode = function() {
	var hash = 0, i, chr, len;
	
	if ( this.length === 0 ) {
		return hash;
	}

	for ( i = 0, len = this.length; i < len; i++ ) {
		chr = this.charCodeAt( i );
		hash = ( ( hash << 5 ) - hash ) + chr;
		hash |= 0;
	}

	return hash;
};

var hbSync = {

	state: {}, 

	checksum: 0,

	init: function() {
		hbSync.hostRequest();

		hbSync.timer = setInterval( function() {
			hbSync.hostRequest();
		}, 500 );
	},

	terminate: function() {
		clearInterval( hbSync.timer );
	},

	hostRequest: function( action ) {
		var url = 'http://homebase.dev/wp-json/homebase/v1/get';
		var http = new XMLHttpRequest();
		
		http.open( 'GET', url, true );
		http.setRequestHeader( 'Content-type', 'application/x-www-form-urlencoded' );
		
		http.onreadystatechange = function() {
			if ( 4 === http.readyState && 200 === http.status ) {
				var oldChecksum = hbSync.checksum;
				var newChecksum = http.responseText.hashCode();

				if ( oldChecksum !== newChecksum ) {
					hbSync.checksum = newChecksum;
					hbSync.state = JSON.parse( http.responseText );

					for ( var prop in hbSync.state ) {
						if ( hbSync.state.hasOwnProperty( prop ) ) {
							var i = prop;
							var g = prop[0];
							var v = hbSync.state[prop];
							
							if ( 'undefined' !== typeof window.app.refs ) {	
								if ( v ) {
									window.app.refs[g].refs[i].toggleOn();
								} else {
									window.app.refs[g].refs[i].toggleOff();
								}
							}
						}
					}
				}
			}
		}

		http.send();
	},

};

hbSync.init();
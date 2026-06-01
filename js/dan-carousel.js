( function () {
	'use strict';

	var PAGE_SIZE  = 3;
	var SLIDE_MS   = 220;
	var carousels  = {};

	/* ---- navigation state ---- */
	function updateNav( id ) {
		var c = carousels[ id ];
		if ( ! c ) return;
		var maxStart = c.items.length - PAGE_SIZE;
		if ( c.prevBtn ) c.prevBtn.disabled = ( c.start <= 0 );
		if ( c.nextBtn ) c.nextBtn.disabled = ( c.start >= maxStart );
	}

	/* ---- show items[start … start+3) with directional slide ---- */
	function showWindow( id, start, direction ) {
		var c = carousels[ id ];
		if ( ! c || c.busy ) return;
		c.busy = true;

		var track    = c.track;
		var exitDir  = direction === 'next' ? '-24px' : '24px';
		var enterDir = direction === 'next' ? '24px'  : '-24px';
		var t        = 'opacity ' + SLIDE_MS + 'ms ease, transform ' + SLIDE_MS + 'ms ease';

		/* slide + fade out */
		track.style.transition = t;
		track.style.opacity    = '0';
		track.style.transform  = 'translateX(' + exitDir + ')';

		setTimeout( function () {
			/* swap visible items */
			for ( var i = 0; i < c.items.length; i++ ) {
				c.items[ i ].style.display =
					( i >= start && i < start + PAGE_SIZE ) ? '' : 'none';
			}
			c.start = start;
			updateNav( id );

			/* snap to enter-side with no transition */
			track.style.transition = 'none';
			track.style.transform  = 'translateX(' + enterDir + ')';

			/* force reflow so the browser registers the snap */
			track.offsetHeight; // eslint-disable-line no-unused-expressions

			/* slide + fade in */
			track.style.transition = t;
			track.style.opacity    = '1';
			track.style.transform  = 'translateX(0)';

			setTimeout( function () { c.busy = false; }, SLIDE_MS );
		}, SLIDE_MS );
	}

	/* ---- initialise ---- */
	document.addEventListener( 'DOMContentLoaded', function () {

		/* collect tracks referenced by buttons */
		document.querySelectorAll( '[data-carousel-prev], [data-carousel-next]' ).forEach( function ( btn ) {
			var id = btn.dataset.carouselPrev || btn.dataset.carouselNext;
			if ( ! id ) return;

			if ( ! carousels[ id ] ) {
				var track = document.getElementById( id );
				if ( ! track ) return;
				carousels[ id ] = {
					track   : track,
					items   : Array.prototype.slice.call( track.children ),
					start   : 0,
					prevBtn : null,
					nextBtn : null,
					busy    : false,
				};
			}

			if ( btn.hasAttribute( 'data-carousel-prev' ) ) carousels[ id ].prevBtn = btn;
			if ( btn.hasAttribute( 'data-carousel-next' ) ) carousels[ id ].nextBtn = btn;
		} );

		/* show first PAGE_SIZE items in each carousel */
		Object.keys( carousels ).forEach( function ( id ) {
			var c = carousels[ id ];
			for ( var i = 0; i < c.items.length; i++ ) {
				c.items[ i ].style.display = i < PAGE_SIZE ? '' : 'none';
			}
			updateNav( id );
		} );

		/* button click handlers */
		document.querySelectorAll( '[data-carousel-prev], [data-carousel-next]' ).forEach( function ( btn ) {
			var id     = btn.dataset.carouselPrev || btn.dataset.carouselNext;
			var isNext = btn.hasAttribute( 'data-carousel-next' );

			btn.addEventListener( 'click', function () {
				var c = carousels[ id ];
				if ( ! c || c.busy ) return;

				var maxStart = c.items.length - PAGE_SIZE;
				var next     = isNext
					? Math.min( c.start + 1, maxStart )
					: Math.max( c.start - 1, 0 );

				if ( next === c.start ) return;
				showWindow( id, next, isNext ? 'next' : 'prev' );
			} );
		} );
	} );
} )();

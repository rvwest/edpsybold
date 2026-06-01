( function () {
	'use strict';

	var PAGE_SIZE = 3;
	var carousels = {};

	/* ---- read computed column-gap in px before we alter the element ---- */
	function readGap( track ) {
		var colGap = parseFloat( window.getComputedStyle( track ).columnGap );
		return isNaN( colGap ) ? 24 : colGap;
	}

	/* ---- (re)calculate card widths and translate to current start ---- */
	function measure( id ) {
		var c        = carousels[ id ];
		var wrapW    = c.wrap.offsetWidth;
		c.cardWidth  = ( wrapW - c.gap * ( PAGE_SIZE - 1 ) ) / PAGE_SIZE;

		/* track must be exactly wide enough to hold every card side-by-side */
		c.track.style.width = ( c.items.length * c.cardWidth + ( c.items.length - 1 ) * c.gap ) + 'px';

		c.items.forEach( function ( item ) {
			item.style.width     = c.cardWidth + 'px';
			item.style.flexShrink = '0';
			item.style.minWidth  = '0';
		} );

		/* snap to current position without animation */
		translate( id, c.start, false );
	}

	/* ---- move the track ---- */
	function translate( id, start, animate ) {
		var c = carousels[ id ];
		var x = -( start * ( c.cardWidth + c.gap ) );
		c.track.style.transition = animate
			? 'transform 0.42s cubic-bezier(0.25, 0.46, 0.45, 0.94)'
			: 'none';
		c.track.style.transform  = 'translateX(' + x + 'px)';
	}

	/* ---- update disabled state on prev/next buttons ---- */
	function updateNav( id ) {
		var c        = carousels[ id ];
		var maxStart = c.items.length - PAGE_SIZE;
		if ( c.prevBtn ) c.prevBtn.disabled = ( c.start <= 0 );
		if ( c.nextBtn ) c.nextBtn.disabled = ( c.start >= maxStart );
	}

	/* ---- slide to a new start index ---- */
	function slide( id, start ) {
		var c   = carousels[ id ];
		c.start = start;
		translate( id, start, true );
		updateNav( id );
	}

	/* ---- setup ---- */
	function init( id ) {
		var track = document.getElementById( id );
		if ( ! track ) return;

		/* read gap while track is still a grid */
		var gap = readGap( track );

		/* wrap track in an overflow:hidden clipping div */
		var wrap = document.createElement( 'div' );
		wrap.className = 'dan-carousel-wrap';
		track.parentNode.insertBefore( wrap, track );
		wrap.appendChild( track );

		/* switch from grid to flex, keep the same gap */
		track.style.display    = 'flex';
		track.style.flexWrap   = 'nowrap';
		track.style.gap        = gap + 'px';
		track.style.maxWidth   = 'none';

		carousels[ id ] = {
			track    : track,
			wrap     : wrap,
			items    : Array.prototype.slice.call( track.children ),
			start    : 0,
			gap      : gap,
			cardWidth: 0,
			prevBtn  : null,
			nextBtn  : null,
		};

		measure( id );
	}

	/* ---- boot ---- */
	document.addEventListener( 'DOMContentLoaded', function () {

		/* discover carousel IDs from buttons */
		document.querySelectorAll( '[data-carousel-prev], [data-carousel-next]' ).forEach( function ( btn ) {
			var id = btn.dataset.carouselPrev || btn.dataset.carouselNext;
			if ( ! id ) return;
			if ( ! carousels[ id ] ) init( id );

			var c = carousels[ id ];
			if ( ! c ) return;
			if ( btn.hasAttribute( 'data-carousel-prev' ) ) c.prevBtn = btn;
			if ( btn.hasAttribute( 'data-carousel-next' ) ) c.nextBtn = btn;
		} );

		/* set initial disabled states */
		Object.keys( carousels ).forEach( updateNav );

		/* wire up button clicks */
		document.querySelectorAll( '[data-carousel-prev], [data-carousel-next]' ).forEach( function ( btn ) {
			var id     = btn.dataset.carouselPrev || btn.dataset.carouselNext;
			var isNext = btn.hasAttribute( 'data-carousel-next' );

			btn.addEventListener( 'click', function () {
				var c = carousels[ id ];
				if ( ! c ) return;
				var maxStart = c.items.length - PAGE_SIZE;
				var next     = isNext
					? Math.min( c.start + 1, maxStart )
					: Math.max( c.start - 1, 0 );
				if ( next !== c.start ) slide( id, next );
			} );
		} );

		/* recalculate card sizes on window resize */
		var resizeTimer;
		window.addEventListener( 'resize', function () {
			clearTimeout( resizeTimer );
			resizeTimer = setTimeout( function () {
				Object.keys( carousels ).forEach( measure );
			}, 150 );
		} );
	} );
} )();

( function () {
	'use strict';

	var BREAK_VERT = 501;  /* below → vertical, 3 cards stacked */
	var BREAK_WIDE = 769;  /* below → horizontal, 2 cards */
	var carousels  = {};

	function isVertical() { return window.innerWidth < BREAK_VERT; }

	function pageSize() {
		/* vertical and wide-desktop both show 3; mid-range shows 2 */
		return window.innerWidth < BREAK_WIDE ? ( isVertical() ? 3 : 2 ) : 3;
	}

	/* ---- read computed column-gap in px while track is still a grid ---- */
	function readGap( track ) {
		var g = parseFloat( window.getComputedStyle( track ).columnGap );
		return isNaN( g ) ? 24 : g;
	}

	/* ===== HORIZONTAL MEASURE ===== */
	function measureH( id ) {
		var c  = carousels[ id ];
		var ps = c.ps;

		/* clear vertical-mode overrides */
		c.track.style.flexDirection = 'row';
		c.track.style.height        = '';
		c.wrap.style.height         = '';
		c.items.forEach( function ( item ) {
			item.style.height     = '';
			item.style.boxSizing  = '';
		} );

		var wrapW   = c.wrap.offsetWidth;
		c.cardWidth = ( wrapW - c.gap * ( ps - 1 ) ) / ps;
		c.cardHeight = 0; /* unused in this mode */

		c.track.style.width = ( c.items.length * c.cardWidth + ( c.items.length - 1 ) * c.gap ) + 'px';

		c.items.forEach( function ( item ) {
			item.style.width      = c.cardWidth + 'px';
			item.style.flexShrink = '0';
			item.style.minWidth   = '0';
		} );
	}

	/* ===== VERTICAL MEASURE ===== */
	function measureV( id ) {
		var c  = carousels[ id ];
		var ps = c.ps;

		/* clear horizontal-mode overrides */
		c.track.style.flexDirection = 'column';
		c.track.style.width         = '100%';
		c.items.forEach( function ( item ) {
			item.style.width      = '';
			item.style.flexShrink = '';
			item.style.minWidth   = '';
			item.style.height     = ''; /* clear first so we can measure natural height */
			item.style.boxSizing  = '';
		} );

		/* find the tallest card so all can be uniform */
		var maxH = 0;
		c.items.forEach( function ( item ) {
			var h = item.offsetHeight;
			if ( h > maxH ) maxH = h;
		} );
		c.cardHeight = maxH;
		c.cardWidth  = 0; /* unused in this mode */

		/* lock every card to the same height */
		c.items.forEach( function ( item ) {
			item.style.height    = maxH + 'px';
			item.style.boxSizing = 'border-box';
		} );

		c.track.style.height = ( c.items.length * maxH + ( c.items.length - 1 ) * c.gap ) + 'px';
		c.wrap.style.height  = ( ps * maxH + ( ps - 1 ) * c.gap ) + 'px';
	}

	/* ---- dispatch to the right measure function, clamp start ---- */
	function measure( id ) {
		var c    = carousels[ id ];
		c.ps     = pageSize();
		c.vert   = isVertical();

		if ( c.vert ) {
			measureV( id );
		} else {
			measureH( id );
		}

		var maxStart = c.items.length - c.ps;
		if ( c.start > maxStart ) c.start = Math.max( maxStart, 0 );

		translate( id, c.start, false );
		updateNav( id );
	}

	/* ---- translate the track (X or Y depending on mode) ---- */
	function translate( id, start, animate ) {
		var c    = carousels[ id ];
		var unit = c.vert ? c.cardHeight : c.cardWidth;
		var val  = -( start * ( unit + c.gap ) );
		var axis = c.vert ? 'translateY' : 'translateX';

		c.track.style.transition = animate
			? 'transform 0.42s cubic-bezier(0.25, 0.46, 0.45, 0.94)'
			: 'none';
		c.track.style.transform  = axis + '(' + val + 'px)';
	}

	/* ---- update button disabled state, nav visibility, arrow icons ---- */
	function updateNav( id ) {
		var c        = carousels[ id ];
		var maxStart = c.items.length - c.ps;

		/* hide nav entirely if all cards fit without scrolling */
		if ( c.nav ) c.nav.style.display = maxStart > 0 ? '' : 'none';

		if ( c.prevBtn ) c.prevBtn.disabled = ( c.start <= 0 );
		if ( c.nextBtn ) c.nextBtn.disabled = ( c.start >= maxStart );

		/* swap arrow icons to match orientation */
		var prevIcon = c.prevBtn && c.prevBtn.querySelector( 'i' );
		var nextIcon = c.nextBtn && c.nextBtn.querySelector( 'i' );
		if ( prevIcon ) prevIcon.className = c.vert ? 'far fa-arrow-up'   : 'far fa-arrow-left';
		if ( nextIcon ) nextIcon.className = c.vert ? 'far fa-arrow-down' : 'far fa-arrow-right';
	}

	/* ---- slide to a new start index ---- */
	function slide( id, start ) {
		var c   = carousels[ id ];
		c.start = start;
		translate( id, start, true );
		updateNav( id );
	}

	/* ---- one-time setup per carousel track ---- */
	function init( id ) {
		var track = document.getElementById( id );
		if ( ! track ) return;

		var gap = readGap( track );

		/* wrap track in overflow:hidden clipping div */
		var wrap = document.createElement( 'div' );
		wrap.className = 'dan-carousel-wrap';
		track.parentNode.insertBefore( wrap, track );
		wrap.appendChild( track );

		/* switch from grid to flex; gap stays as-is from CSS */
		track.style.display  = 'flex';
		track.style.flexWrap = 'nowrap';
		track.style.maxWidth = 'none';

		carousels[ id ] = {
			track    : track,
			wrap     : wrap,
			items    : Array.prototype.slice.call( track.children ),
			start    : 0,
			gap      : gap,
			cardWidth : 0,
			cardHeight: 0,
			ps       : pageSize(),
			vert     : isVertical(),
			nav      : null,
			prevBtn  : null,
			nextBtn  : null,
		};

		measure( id );
	}

	/* ---- boot ---- */
	document.addEventListener( 'DOMContentLoaded', function () {

		document.querySelectorAll( '[data-carousel-prev], [data-carousel-next]' ).forEach( function ( btn ) {
			var id = btn.dataset.carouselPrev || btn.dataset.carouselNext;
			if ( ! id ) return;
			if ( ! carousels[ id ] ) init( id );

			var c = carousels[ id ];
			if ( ! c ) return;

			if ( btn.hasAttribute( 'data-carousel-prev' ) ) {
				c.prevBtn = btn;
				c.nav     = btn.parentElement;
			}
			if ( btn.hasAttribute( 'data-carousel-next' ) ) {
				c.nextBtn = btn;
				if ( ! c.nav ) c.nav = btn.parentElement;
			}
		} );

		Object.keys( carousels ).forEach( updateNav );

		document.querySelectorAll( '[data-carousel-prev], [data-carousel-next]' ).forEach( function ( btn ) {
			var id     = btn.dataset.carouselPrev || btn.dataset.carouselNext;
			var isNext = btn.hasAttribute( 'data-carousel-next' );

			btn.addEventListener( 'click', function () {
				var c = carousels[ id ];
				if ( ! c ) return;
				var maxStart = c.items.length - c.ps;
				var next     = isNext
					? Math.min( c.start + c.ps, maxStart )
					: Math.max( c.start - c.ps, 0 );
				if ( next !== c.start ) slide( id, next );
			} );
		} );

		var resizeTimer;
		window.addEventListener( 'resize', function () {
			clearTimeout( resizeTimer );
			resizeTimer = setTimeout( function () {
				Object.keys( carousels ).forEach( measure );
			}, 150 );
		} );
	} );
} )();

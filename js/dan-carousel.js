( function () {
	'use strict';

	var BREAKPOINT = 769; /* px — below this shows 2 cards */
	var carousels  = {};

	function pageSize() {
		return window.innerWidth < BREAKPOINT ? 2 : 3;
	}

	/* ---- read computed column-gap in px before we alter the element ---- */
	function readGap( track ) {
		var colGap = parseFloat( window.getComputedStyle( track ).columnGap );
		return isNaN( colGap ) ? 24 : colGap;
	}

	/* ---- (re)calculate card widths, clamp start, snap to position ---- */
	function measure( id ) {
		var c    = carousels[ id ];
		var ps   = pageSize();
		c.ps     = ps;

		var wrapW   = c.wrap.offsetWidth;
		c.cardWidth = ( wrapW - c.gap * ( ps - 1 ) ) / ps;

		/* track wide enough to hold every card side-by-side */
		c.track.style.width = ( c.items.length * c.cardWidth + ( c.items.length - 1 ) * c.gap ) + 'px';

		c.items.forEach( function ( item ) {
			item.style.width      = c.cardWidth + 'px';
			item.style.flexShrink = '0';
			item.style.minWidth   = '0';
		} );

		/* clamp start so we don't show empty space after a resize */
		var maxStart = c.items.length - ps;
		if ( c.start > maxStart ) c.start = Math.max( maxStart, 0 );

		/* snap without animation, then update button state */
		translate( id, c.start, false );
		updateNav( id );
	}

	/* ---- move the track ---- */
	function translate( id, start, animate ) {
		var c = carousels[ id ];
		var x = -( start * ( c.cardWidth + c.gap ) );
		c.track.style.transition = animate
			? 'transform 0.42s cubic-bezier(0.25, 0.46, 0.45, 0.94)'
			: 'none';
		c.track.style.transform = 'translateX(' + x + 'px)';
	}

	/* ---- show/hide nav and update disabled state ---- */
	function updateNav( id ) {
		var c        = carousels[ id ];
		var maxStart = c.items.length - c.ps;

		/* hide the whole nav container when all cards already fit */
		if ( c.nav ) c.nav.style.display = maxStart > 0 ? '' : 'none';

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

	/* ---- one-time setup per carousel ---- */
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

		/* switch from grid to flex, preserve gap */
		track.style.display  = 'flex';
		track.style.flexWrap = 'nowrap';
		track.style.gap      = gap + 'px';
		track.style.maxWidth = 'none';

		carousels[ id ] = {
			track    : track,
			wrap     : wrap,
			items    : Array.prototype.slice.call( track.children ),
			start    : 0,
			gap      : gap,
			cardWidth: 0,
			ps       : pageSize(),
			nav      : null,
			prevBtn  : null,
			nextBtn  : null,
		};

		measure( id );
	}

	/* ---- boot ---- */
	document.addEventListener( 'DOMContentLoaded', function () {

		/* discover carousels from buttons; store button + nav references */
		document.querySelectorAll( '[data-carousel-prev], [data-carousel-next]' ).forEach( function ( btn ) {
			var id = btn.dataset.carouselPrev || btn.dataset.carouselNext;
			if ( ! id ) return;
			if ( ! carousels[ id ] ) init( id );

			var c = carousels[ id ];
			if ( ! c ) return;

			if ( btn.hasAttribute( 'data-carousel-prev' ) ) {
				c.prevBtn = btn;
				c.nav     = btn.parentElement; /* nav wrapper contains both buttons */
			}
			if ( btn.hasAttribute( 'data-carousel-next' ) ) {
				c.nextBtn = btn;
				if ( ! c.nav ) c.nav = btn.parentElement;
			}
		} );

		/* apply initial nav state */
		Object.keys( carousels ).forEach( updateNav );

		/* wire up button clicks */
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

		/* recalculate on resize (page size may change at breakpoint) */
		var resizeTimer;
		window.addEventListener( 'resize', function () {
			clearTimeout( resizeTimer );
			resizeTimer = setTimeout( function () {
				Object.keys( carousels ).forEach( measure );
			}, 150 );
		} );
	} );
} )();

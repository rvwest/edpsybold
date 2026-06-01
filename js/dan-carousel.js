( function () {
	'use strict';

	var BREAK_MID  = 501;   /* below → show-more; above → horizontal carousel */
	var BREAK_WIDE = 769;   /* below → 2-card carousel; above → 3-card carousel */
	var SHOW_N     = 3;     /* cards always visible in show-more mode */

	var instances = {};     /* keyed by carousel track ID */

	/* ================================================================
	   SHARED HELPERS
	   ================================================================ */

	function readGap( track ) {
		var g = parseFloat( window.getComputedStyle( track ).columnGap );
		return isNaN( g ) ? 24 : g;
	}

	function getMode() {
		return window.innerWidth < BREAK_MID ? 'showmore' : 'carousel';
	}

	function carouselPageSize() {
		return window.innerWidth < BREAK_WIDE ? 2 : 3;
	}

	/* ================================================================
	   HORIZONTAL CAROUSEL
	   ================================================================ */

	function carouselTranslate( c, animate ) {
		var x = -( c.start * ( c.cardWidth + c.gap ) );
		c.track.style.transition = animate
			? 'transform 0.42s cubic-bezier(0.25, 0.46, 0.45, 0.94)'
			: 'none';
		c.track.style.transform = 'translateX(' + x + 'px)';
	}

	function carouselUpdateNav( inst ) {
		var c        = inst.carousel;
		var maxStart = c.items.length - c.ps;

		if ( inst.nav ) inst.nav.style.display = maxStart > 0 ? '' : 'none';
		if ( inst.prevBtn ) inst.prevBtn.disabled = ( c.start <= 0 );
		if ( inst.nextBtn ) inst.nextBtn.disabled = ( c.start >= maxStart );

		/* ensure icons are left/right arrows */
		var pi = inst.prevBtn && inst.prevBtn.querySelector( 'i' );
		var ni = inst.nextBtn && inst.nextBtn.querySelector( 'i' );
		if ( pi ) pi.className = 'far fa-arrow-left';
		if ( ni ) ni.className = 'far fa-arrow-right';
	}

	function carouselMeasure( inst ) {
		var c    = inst.carousel;
		c.ps     = carouselPageSize();

		var wrapW   = c.wrap.offsetWidth;
		c.cardWidth = ( wrapW - c.gap * ( c.ps - 1 ) ) / c.ps;

		c.track.style.width = ( c.items.length * c.cardWidth + ( c.items.length - 1 ) * c.gap ) + 'px';
		c.items.forEach( function ( item ) {
			item.style.width      = c.cardWidth + 'px';
			item.style.flexShrink = '0';
			item.style.minWidth   = '0';
		} );

		var maxStart = c.items.length - c.ps;
		if ( c.start > maxStart ) c.start = Math.max( maxStart, 0 );

		carouselTranslate( c, false );
		carouselUpdateNav( inst );
	}

	function setupCarousel( id, inst ) {
		var track = document.getElementById( id );
		if ( ! track ) return;

		var gap = readGap( track );

		/* wrap in overflow:hidden clipping div */
		var wrap = document.createElement( 'div' );
		wrap.className = 'dan-carousel-wrap';
		track.parentNode.insertBefore( wrap, track );
		wrap.appendChild( track );

		track.style.display      = 'flex';
		track.style.flexWrap     = 'nowrap';
		track.style.flexDirection = 'row';
		track.style.gap          = gap + 'px';
		track.style.maxWidth     = 'none';

		inst.carousel = {
			track    : track,
			wrap     : wrap,
			items    : Array.prototype.slice.call( track.children ),
			start    : 0,
			gap      : gap,
			cardWidth: 0,
			ps       : carouselPageSize(),
		};
		inst.mode = 'carousel';

		carouselMeasure( inst );

		/* wire click handlers once */
		if ( ! inst.prevWired ) {
			inst.prevBtn && inst.prevBtn.addEventListener( 'click', function () {
				var c = inst.carousel;
				if ( ! c ) return;
				var next = Math.max( c.start - c.ps, 0 );
				if ( next !== c.start ) { c.start = next; carouselTranslate( c, true ); carouselUpdateNav( inst ); }
			} );
			inst.prevWired = true;
		}
		if ( ! inst.nextWired ) {
			inst.nextBtn && inst.nextBtn.addEventListener( 'click', function () {
				var c = inst.carousel;
				if ( ! c ) return;
				var maxStart = c.items.length - c.ps;
				var next     = Math.min( c.start + c.ps, maxStart );
				if ( next !== c.start ) { c.start = next; carouselTranslate( c, true ); carouselUpdateNav( inst ); }
			} );
			inst.nextWired = true;
		}
	}

	function teardownCarousel( inst ) {
		if ( ! inst.carousel ) return;
		var c     = inst.carousel;
		var track = c.track;
		var wrap  = c.wrap;

		/* unwrap the track */
		if ( wrap && wrap.parentNode ) {
			wrap.parentNode.insertBefore( track, wrap );
			wrap.parentNode.removeChild( wrap );
		}

		/* clear all inline styles set by the carousel */
		track.style.display       = '';
		track.style.flexWrap      = '';
		track.style.flexDirection = '';
		track.style.gap           = '';
		track.style.maxWidth      = '';
		track.style.width         = '';
		track.style.transform     = '';
		track.style.transition    = '';

		c.items.forEach( function ( item ) {
			item.style.width      = '';
			item.style.flexShrink = '';
			item.style.minWidth   = '';
		} );

		inst.carousel = null;
	}

	/* ================================================================
	   SHOW MORE / SHOW FEWER
	   ================================================================ */

	function setupShowMore( id, inst ) {
		var track = document.getElementById( id );
		if ( ! track ) return;

		/* hide nav arrows — not needed in this mode */
		if ( inst.nav ) inst.nav.style.display = 'none';

		/* stack cards in a single column */
		track.style.display       = 'flex';
		track.style.flexDirection = 'column';

		var items = Array.prototype.slice.call( track.children );

		/* show first SHOW_N, hide the rest */
		items.forEach( function ( item, i ) {
			item.style.display = i < SHOW_N ? '' : 'none';
		} );

		/* only add toggle if there are cards to reveal */
		var toggle = null;
		if ( items.length > SHOW_N ) {
			toggle = document.createElement( 'button' );
			toggle.className   = 'dan-show-more-btn';
			toggle.textContent = 'Show more';
			toggle.setAttribute( 'aria-expanded', 'false' );

			var expanded = false;
			toggle.addEventListener( 'click', function () {
				expanded = ! expanded;
				items.forEach( function ( item, i ) {
					if ( i >= SHOW_N ) item.style.display = expanded ? '' : 'none';
				} );
				toggle.textContent = expanded ? 'Show fewer' : 'Show more';
				toggle.setAttribute( 'aria-expanded', String( expanded ) );
			} );

			/* insert directly after the track element */
			track.parentNode.insertBefore( toggle, track.nextSibling );
		}

		inst.showMore = { track: track, items: items, toggle: toggle };
		inst.mode     = 'showmore';
	}

	function teardownShowMore( inst ) {
		if ( ! inst.showMore ) return;
		var sm = inst.showMore;

		if ( sm.toggle && sm.toggle.parentNode ) {
			sm.toggle.parentNode.removeChild( sm.toggle );
		}

		sm.items.forEach( function ( item ) { item.style.display = ''; } );

		sm.track.style.display       = '';
		sm.track.style.flexDirection = '';

		/* restore nav for carousel mode */
		if ( inst.nav ) inst.nav.style.display = '';

		inst.showMore = null;
	}

	/* ================================================================
	   INIT & RESIZE
	   ================================================================ */

	function initOrUpdate( id ) {
		var inst = instances[ id ];
		var mode = getMode();

		if ( inst.mode === mode ) {
			if ( mode === 'carousel' ) carouselMeasure( inst );
			return;
		}

		if ( inst.mode === 'carousel' )  teardownCarousel( inst );
		if ( inst.mode === 'showmore' )  teardownShowMore( inst );

		if ( mode === 'carousel' ) setupCarousel( id, inst );
		else                       setupShowMore( id, inst );
	}

	document.addEventListener( 'DOMContentLoaded', function () {

		/* collect instances from nav buttons */
		document.querySelectorAll( '[data-carousel-prev], [data-carousel-next]' ).forEach( function ( btn ) {
			var id = btn.dataset.carouselPrev || btn.dataset.carouselNext;
			if ( ! id ) return;

			if ( ! instances[ id ] ) {
				instances[ id ] = {
					mode: null, carousel: null, showMore: null,
					nav: null, prevBtn: null, nextBtn: null,
					prevWired: false, nextWired: false,
				};
			}

			var inst = instances[ id ];
			if ( btn.hasAttribute( 'data-carousel-prev' ) ) { inst.prevBtn = btn; inst.nav = btn.parentElement; }
			if ( btn.hasAttribute( 'data-carousel-next' ) ) { inst.nextBtn = btn; if ( ! inst.nav ) inst.nav = btn.parentElement; }
		} );

		Object.keys( instances ).forEach( function ( id ) {
			var mode = getMode();
			if ( mode === 'carousel' ) setupCarousel( id, instances[ id ] );
			else                       setupShowMore( id, instances[ id ] );
		} );

		var resizeTimer;
		window.addEventListener( 'resize', function () {
			clearTimeout( resizeTimer );
			resizeTimer = setTimeout( function () {
				Object.keys( instances ).forEach( initOrUpdate );
			}, 150 );
		} );
	} );
} )();

( function () {
	'use strict';

	var PAGE_SIZE = 3;
	var carousels = {};

	function showPage( id, page ) {
		var c = carousels[ id ];
		if ( ! c ) return;

		var items = c.items;
		var start = page * PAGE_SIZE;

		for ( var i = 0; i < items.length; i++ ) {
			items[ i ].style.display = ( i >= start && i < start + PAGE_SIZE ) ? '' : 'none';
		}

		c.page = page;
		updateNav( id );
	}

	function updateNav( id ) {
		var c = carousels[ id ];
		if ( ! c ) return;

		var pages = Math.ceil( c.items.length / PAGE_SIZE );

		if ( c.prevBtn ) c.prevBtn.disabled = ( c.page === 0 );
		if ( c.nextBtn ) c.nextBtn.disabled = ( c.page >= pages - 1 );
	}

	document.addEventListener( 'DOMContentLoaded', function () {
		/* Collect all carousel tracks referenced by any nav button */
		document.querySelectorAll( '[data-carousel-prev], [data-carousel-next]' ).forEach( function ( btn ) {
			var id = btn.dataset.carouselPrev || btn.dataset.carouselNext;
			if ( ! id ) return;

			if ( ! carousels[ id ] ) {
				var track = document.getElementById( id );
				if ( ! track ) return;

				carousels[ id ] = {
					track   : track,
					items   : Array.prototype.slice.call( track.children ),
					page    : 0,
					prevBtn : null,
					nextBtn : null,
				};
			}

			if ( btn.dataset.carouselPrev ) carousels[ id ].prevBtn = btn;
			if ( btn.dataset.carouselNext ) carousels[ id ].nextBtn = btn;
		} );

		/* Initialise every discovered carousel */
		Object.keys( carousels ).forEach( function ( id ) {
			showPage( id, 0 );
		} );

		/* Wire up button clicks */
		document.querySelectorAll( '[data-carousel-prev], [data-carousel-next]' ).forEach( function ( btn ) {
			var id     = btn.dataset.carouselPrev || btn.dataset.carouselNext;
			var isNext = !! btn.dataset.carouselNext;

			btn.addEventListener( 'click', function () {
				var c = carousels[ id ];
				if ( ! c ) return;

				var pages = Math.ceil( c.items.length / PAGE_SIZE );
				var next  = isNext
					? Math.min( c.page + 1, pages - 1 )
					: Math.max( c.page - 1, 0 );

				showPage( id, next );
			} );
		} );
	} );
} )();

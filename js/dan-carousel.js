( function () {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function () {
		var PAGE_SIZE = 3;

		document.querySelectorAll( '[data-carousel-next], [data-carousel-prev]' ).forEach( function ( btn ) {
			var id     = btn.dataset.carouselNext || btn.dataset.carouselPrev;
			var isNext = 'carouselNext' in btn.dataset;
			var track  = document.getElementById( id );
			if ( ! track ) return;

			initCarousel( track );

			btn.addEventListener( 'click', function () {
				var page     = parseInt( track.dataset.carouselPage, 10 ) || 0;
				var total    = track.querySelectorAll( ':scope > *' ).length;
				var pages    = Math.ceil( total / PAGE_SIZE );
				var nextPage = isNext
					? Math.min( page + 1, pages - 1 )
					: Math.max( page - 1, 0 );

				showPage( track, nextPage );
				updateNavState( track, id );
			} );
		} );

		function initCarousel( track ) {
			if ( track.dataset.carouselInit ) return;
			track.dataset.carouselInit = '1';
			showPage( track, 0 );
			updateNavState( track, track.id );
		}

		function showPage( track, page ) {
			var items = track.querySelectorAll( ':scope > *' );
			var start = page * PAGE_SIZE;
			items.forEach( function ( item, i ) {
				item.hidden = ( i < start || i >= start + PAGE_SIZE );
			} );
			track.dataset.carouselPage = page;
		}

		function updateNavState( track, id ) {
			var page  = parseInt( track.dataset.carouselPage, 10 ) || 0;
			var total = track.querySelectorAll( ':scope > *' ).length;
			var pages = Math.ceil( total / PAGE_SIZE );

			var prevBtn = document.querySelector( '[data-carousel-prev="' + id + '"]' );
			var nextBtn = document.querySelector( '[data-carousel-next="' + id + '"]' );

			if ( prevBtn ) prevBtn.disabled = ( page === 0 );
			if ( nextBtn ) nextBtn.disabled = ( page >= pages - 1 );
		}
	} );
} )();

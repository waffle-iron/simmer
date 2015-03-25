jQuery( document ).ready( function( $ ) {
	
	$( '.simmer-recipe-print' ).click( function( e ) {
		
		e.preventDefault();
		
		$( this ).parents( '.simmer-recipe' ).printThis( {
			printContainer: false
		} );
		
	} );
	
} );

var simmerShortcodeModal;

( function( $ ) {
	
	var inputs = {};

	simmerShortcodeModal = {
		
		init: function() {
			
			inputs.wrap     = $( '.simmer-shortcode-modal-wrap' );
			inputs.backdrop = $( '.simmer-shortcode-modal-background' );
			inputs.select   = $( '.simmer-shortcode-modal-content select' );
			inputs.submit   = $( '.simmer-shortcode-modal-wrap .simmer-submit-shortcode button' );
			inputs.close    = $( '.simmer-shortcode-modal-wrap .simmer-shortcode-modal-close' );
			inputs.cancel   = $( '.simmer-shortcode-modal-wrap .cancel' );
			
			// Enable Select2 for the dropdown.
			inputs.select.select2();
			
			inputs.trigger = $( '#simmer-add-recipe' );
			
			$( inputs.trigger ).click( function( event ) {
				
				event.preventDefault();
				
				simmerShortcodeModal.open();
				
			} );
			
			inputs.submit.click( function( event ) {
				
				event.preventDefault();
				
				simmerShortcodeModal.submit();
				
			} );
			
			inputs.close.add( inputs.backdrop ).add( inputs.cancel ).click( function( event ) {
				event.preventDefault();
				simmerShortcodeModal.close();
			} );
		},

		open: function() {
			
			$( document.body ).addClass( 'modal-open' );

			inputs.wrap.show();
			inputs.backdrop.show();
			
			$( document ).trigger( 'simmer-shortcode-modal-open', inputs.wrap );
		},

		close: function() {
			
			inputs.backdrop.hide();
			inputs.wrap.hide();
			
			inputs.text.val( '' );
			
			$( document.body ).removeClass( 'modal-open' );
			
			$( document ).trigger( 'simmer-shortcode-modal-close', inputs.wrap );
		},
		
		submit: function() {
			
			
		}
	};
	
	$( document ).ready( simmerShortcodeModal.init );
	
})( jQuery );

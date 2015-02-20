var simmerBulkModal;

( function( $ ) {
	
	var inputs = {};

	simmerBulkModal = {
		
		init: function() {
			
			inputs.wrap     = $( '.simmer-bulk-modal-wrap' );
			inputs.backdrop = $( '.simmer-bulk-modal-background' );
			inputs.text     = $( '.simmer-bulk-modal-content textarea' );
			inputs.nonce    = $( '#simmer_process_bulk_nonce' );
			inputs.submit   = $( '.simmer-bulk-modal-wrap .simmer-submit-bulk button' );
			inputs.close    = $( '.simmer-bulk-modal-wrap .simmer-bulk-modal-close' );
			inputs.cancel   = $( '.simmer-bulk-modal-wrap .cancel' );
			
			inputs.trigger = $( '.simmer-list-table .simmer-actions .simmer-bulk-add-link a' );
			inputs.type    = inputs.trigger.data( 'type' );
			
			$( inputs.trigger ).click( function( event ) {
				
				event.preventDefault();
				
				simmerBulkModal.open();
				
			} );
			
			inputs.submit.click( function( event ) {
				
				event.preventDefault();
				
				simmerBulkModal.submit();
				
			} );
			
			inputs.close.add( inputs.backdrop ).add( inputs.cancel ).click( function( event ) {
				event.preventDefault();
				simmerBulkModal.close();
			} );
		},

		open: function() {
			
			$( document.body ).addClass( 'modal-open' );

			inputs.wrap.show();
			inputs.backdrop.show();
			
			if ( 'ingredients' == inputs.type ) {
				var titleText  = simmer_bulk_add_vars.ingredients_title;
				var buttonText = simmer_bulk_add_vars.ingredients_button;
			} else if ( 'instructions' == inputs.type ) {
				var titleText  = simmer_bulk_add_vars.instructions_title;
				var buttonText = simmer_bulk_add_vars.instructions_button;
			}
			
			inputs.wrap.find( '.simmer-bulk-modal-title' ).text( titleText );
			inputs.submit.text( buttonText );
			
			$( document ).trigger( 'simmer-bulk-modal-open', inputs.wrap );
		},

		close: function() {
			
			inputs.backdrop.hide();
			inputs.wrap.hide();
			
			$( document ).trigger( 'simmer-bulk-modal-close', inputs.wrap );
		},
		
		submit: function() {
			
			$.ajax( {
				url: simmer_bulk_add_vars.ajax_url,
				dataType: 'json',
				type: 'post',
				data: {
					action: 'simmer_process_bulk',
					type: inputs.type,
					text: inputs.text.val(),
					nonce: inputs.nonce.val()
				},
				success: function( response ) {
					
					console.log( response );
				}
			} );
		}
	};

	$( document ).ready( simmerBulkModal.init );
	
})( jQuery );

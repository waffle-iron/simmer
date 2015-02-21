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
				simmerBulkModal.close();
				
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
			
			if ( 'ingredient' == inputs.type ) {
				var titleText  = simmer_bulk_add_vars.ingredients_title;
				var buttonText = simmer_bulk_add_vars.ingredients_button;
			} else if ( 'instruction' == inputs.type ) {
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
					
					if ( ! response.error ) {
						
						$.each( response,  function( index, item ) {
							simmerBulkModal.addRow( inputs.type, item );
							console.log( item );
						} );
					}
				}
			} );
		},
		
		addRow: function( type, item ) {
			
			row = $( 'tr.simmer-' + type ).last();
			
			clone = row.clone();
			
			var count = row.parent().find( 'tr' ).length;
			
			clone.find( '.simmer-amt input' ).val( item.amount );
			clone.find( '.simmer-unit select' ).val( item.unit );
			clone.find( '.simmer-desc input', '.simmer-desc textarea' ).val( item.description );
			
			clone.removeClass( 'simmer-row-hidden' );
			
			clone.find( 'input, select, textarea' ).each( function() {
				
				name = $( this ).attr( 'name' );
	
				name = name.replace( /\[(\d+)\]/, '[' + parseInt( count ) + ']');
	
				$( this ).attr( 'name', name ).attr( 'id', name );
				
			} );
			
			clone.find( '.simmer-sort input' ).attr( 'value', parseInt( count ) );
			
			clone.insertAfter( row );
		}
	};

	$( document ).ready( simmerBulkModal.init );
	
})( jQuery );

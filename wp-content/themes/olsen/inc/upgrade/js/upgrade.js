jQuery( function ( $ ) {
	'use strict';

	function olsen_data_upgrade_get_status() {
		$.ajax( {
			type: 'post',
			url: olsen_data_upgrade.ajax_url,
			data: {
				action: 'olsen_data_upgrade_get_status',
			},
			dataType: 'json',
			success: function ( response ) {
				var $notice = $( '#olsen-data-upgrade' );
				if ( response.data.is_upgrading ) {
					$notice.find( '.secondary' ).text( response.data.message );
					setTimeout( function () {
						olsen_data_upgrade_get_status();
					}, parseInt( olsen_data_upgrade.update_interval ) );
				} else {
					$notice.find( '.primary' ).text( olsen_data_upgrade.text_done );
					$notice.find( '.secondary' ).remove();
					$notice.removeClass( 'notice-warning' ).addClass( 'notice-info' );
				}
			}
		} );

	}

	olsen_data_upgrade_get_status();

} );

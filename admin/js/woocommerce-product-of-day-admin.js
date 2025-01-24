(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

$( document ).ready( function() {
        var POTD_Admin = {
            init: function() {
                this.pre_load_products();
                this.tiptip_toottip();
            },
            pre_load_products: function() {
            // var courses = $( '#ld_retakequiz_course' ).select2( 'val' );

                   $('#wn_product_of_day_selected_product').select2({
                    // minimumInputLength: 2,
                    // multiple: true,
                    allowClear: true,
                    width: 'auto',
                    placeholder: myPOTDAdminAjax.select_option,
                    //     width: 'element'
                    ajax: {
                      url: myPOTDAdminAjax.ajax_url,
                      dataType: 'json',
                      delay: 250, // delay in ms while typing when to perform a AJAX search
                      data: function (params) {
                        var query = {
                          search: params.term,
                          page: params.page || 1,
                          action: 'potd_ajax_load_products',
                        };

                        // console.log(groups);

                        return query;
                      },
                      processResults: function (data, params) {
                        params.page = params.page || 1;
                        var per_page_count = 10;
                        return {
                          results: data.data,
                          pagination: {
                            more: (params.page * per_page_count) < data.total_count
                          }
                        };
                      }
                    }
                });

            },
            tiptip_toottip: function() {
			$('.feedback-help-tip').tipTip( {
                    'attribute': 'data-tip',
                    'fadeIn': 50,
                    'fadeOut': 50,
                    'delay': 200,
                    'keepAlive': true
                } );
			}

        };

        POTD_Admin.init(); 
});

$('.fa_toogle').click(function(){
$('.fa_toogle').next('.description').fadeToggle();
});

})( jQuery );


const wpBaseURL = window.wpApiSettings;
console.log(wpBaseURL);
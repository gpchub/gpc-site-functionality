jQuery( document ).ready(
	function ( $ ) {

        /*---------- Color picker ---------- */

		$('.gpc-field-color').each(function(){
			$(this).wpColorPicker();
		});

        /*---------- Date picker ---------- */
        $('.gpc-field-datepicker').each(function(){
			$(this).datepicker( {
                'dateFormat': 'dd/mm/yy'
            } );
		});

        /*---------- Image uploader ---------- */

		var file_frame;

		jQuery.fn.uploadMediaFile = function (button, preview_media) {
			var button_id  = button.attr( 'id' );
			var field_id   = button_id.replace( '_button', '' );
			var preview_id = button_id.replace( '_button', '_preview' );

			// If the media frame already exists, reopen it.
			if (file_frame) {
				file_frame.open();
				return;
			}

			// Create the media frame.
			file_frame = wp.media.frames.file_frame = wp.media(
				{
					title: jQuery( this ).data( 'uploader_title' ),
					button: {
						text: jQuery( this ).data( 'uploader_button_text' ),
					},
					multiple: false
				}
			);

			// When an image is selected, run a callback.
			file_frame.on(
				'select',
				function () {
					attachment = file_frame.state().get( 'selection' ).first().toJSON();
					jQuery( "#" + field_id ).val( attachment.id );
					if (preview_media) {
						jQuery( "#" + preview_id ).attr( 'src', attachment.sizes.thumbnail.url ).show();
					}
					file_frame = false;
				}
			);

			// Finally, open the modal.
			file_frame.open();
		}

		jQuery( '.image_upload_button' ).click(
			function () {
				jQuery.fn.uploadMediaFile( jQuery( this ), true );
			}
		);

		jQuery( '.image_delete_button' ).click(
			function () {
				jQuery( this ).closest( '.gpc-field-image' ).find( '.image_data_field' ).val( '' );
				jQuery( this ).closest( '.gpc-field-image' ).find( '.image_preview' ).attr('src', '').hide();
				return false;
			}
		);

        /*---------- Gallery ---------- */
        $('.gpc-field-gallery').each(function() {
            const $this = $(this);
            const $selected = $this.find('.gpc-field-gallery-selected');

            //upload button event
            $this.on('click', '.gpc-field-gallery-upload-button', function(event) {
                // prevent default link click event
                event.preventDefault();

                const button = $(this);

                // we are going to use <input type="hidden"> to store image IDs, comma separated
                const hiddenField = button.prev();
                const selectedValueString = hiddenField.val();
                let selectedValues = [];
                if (selectedValueString.length > 0) {
                    if ( selectedValueString.indexOf(',') !== -1 ) {
                        selectedValues = selectedValueString.split(',');
                    } else {
                        selectedValues = [selectedValueString];
                    }
                }

                const customUploader = wp.media({
                    title: 'Insert images',
                    library: {
                        type: 'image'
                    },
                    button: {
                        text: 'Use these images'
                    },
                    multiple: true
                }).on( 'select', function() {

                    // get selected images and rearrange the array
                    let selectedImages = customUploader.state().get( 'selection' ).map( item => {
                        item.toJSON();
                        return item;
                    } )

                    selectedImages.map( image => {
                        // add every selected image to the <ul> list
                        $selected.append( '<li class="gpc-field-gallery__item attachment" data-id="' + image.id + '"><div class="gpc-field-gallery__preview attachment-preview"><div class="thumbnail"><img src="' + image.attributes.url + '" /></div></div><button type="button" class="button-link attachment-close media-modal-icon gpc-field-gallery__remove"><span class="screen-reader-text">Xóa bỏ</span></button>' );
                        // and to hidden field
                        selectedValues.push( image.id )
                    } );

                    // refresh sortable
                    $selected.sortable( 'refresh' );
                    // add the IDs to the hidden field value
                    hiddenField.val( selectedValues.join() );

                }).open();
            });

            // remove image event
            $this.on( 'click', '.gpc-field-gallery__remove', function( event ){

                event.preventDefault();

                const button = $(this)
                const imageId = button.parent().data( 'id' )
                const container = button.parent().parent()
                const hiddenField = container.next();
                const selectedValueString = hiddenField.val();
                let selectedValues = [];
                if (selectedValueString.length > 0) {
                    if ( selectedValueString.indexOf(',') !== -1 ) {
                        selectedValues = selectedValueString.split(',').map( Number );
                    } else {
                        selectedValues = [parseInt(selectedValueString)];
                    }
                }
                const i = selectedValues.indexOf( imageId );

                button.parent().remove();

                // remove certain array element
                if( i != -1 ) {
                    selectedValues.splice(i, 1);
                }

                // add the IDs to the hidden field value
                hiddenField.val( selectedValues.join() );

                // refresh sortable
                container.sortable( 'refresh' );

            });

            // reordering the images with drag and drop
            $selected.sortable({
                items: 'li',
                cursor: '-webkit-grabbing', // mouse cursor
                scrollSensitivity: 40,
                /*
                You can set your custom CSS styles while this element is dragging */
                start:function(event,ui){
                    ui.item.css({'box-shadow':'inset 0 0 2px 3px #fff, inset 0 0 0 7px #4f94d4'});
                },

                stop: function( event, ui ){
                    ui.item.removeAttr( 'style' );

                    let sort = new Array() // array of image IDs
                    const container = $(this) // .gpc-field-gallery

                    // each time after dragging we resort our array
                    container.find( 'li' ).each( function( index ){
                        sort.push( $(this).attr( 'data-id' ) );
                    });
                    // add the array value to the hidden input field
                    container.next().val( sort.join() );
                    // console.log(sort);
                }
            });
        });

        /*---------- Autocomplete ---------- */
        var autocomplete_cache = {};

        $('.gpc-field-autocomplete').each(function() {
            const $this = $(this);
            const $input = $this.find('.gpc-field-autocomplete-input');
            const $selected = $this.find('.gpc-field-autocomplete-selected');
            const search_type = $this.attr('data-type');
            let post_type = '';
            let taxonomy = '';
            let action = 'gpc_field_search_post';

            if ( search_type == 'term') {
                taxonomy = $this.attr('data-taxonomy');
                action = 'gpc_field_search_term';
            } else {
                post_type = $this.attr('data-post-type');
            }

            $input.autocomplete({
                source: function( request, response ) {
                    var term = request.term;
                    if ( term in autocomplete_cache ) {
                        response( autocomplete_cache[ term ] );
                        return;
                    }

                    $.ajax( {
                        url: ajaxurl ,
                        dataType: 'json',
                        delay: 250,
                        data: {
                            q: term, // search query
                            action: action, // AJAX action for admin-ajax.php
                            taxonomy: taxonomy,
                            post_type: post_type,
                        },
                        success: function( data ) {
                            autocomplete_cache[ term ] = data;
                            response( data );
                        }
                    } );
                },
                minLength: 2,
                select: function( event, ui ) {
                    $selected.append('<li data-id="' + ui.item.id + '" class="gpc-field-autocomplete-selected__item ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span> ' +  ui.item.label + ' <a href="#" class="gpc-field-autocomplete-selected__remove"><span class="dashicons dashicons-remove"></span></a></li>');

                    $selected.show();
                    let sort = new Array();
                    // each time after dragging we resort our array
                    $selected.find( 'li' ).each( function( index ){
                        sort.push( $(this).attr( 'data-id' ) );
                    });

                    // add the array value to the hidden input field
                    $selected.next().val( sort.join() );
                    $selected.sortable( 'refresh' );
                    $input.val('');
                    return false;
                }
            });

            $selected.sortable({
                items: 'li',
                cursor: '-webkit-grabbing', // mouse cursor
                scrollSensitivity: 40,
                /*
                You can set your custom CSS styles while this element is dragging */
                start:function(event,ui){
                    ui.item.css({'box-shadow':'-1px 1px 9px -1px rgba(79,148,212,1)'});
                },

                stop: function( event, ui ){
                    ui.item.removeAttr( 'style' );

                    let sort = new Array() // array of image IDs
                    const container = $(this) // .gpc-field-gallery

                    // each time after dragging we resort our array
                    container.find( 'li' ).each( function( index ){
                        sort.push( $(this).attr( 'data-id' ) );
                    });
                    // add the array value to the hidden input field
                    container.next().val( sort.join() );
                    // console.log(sort);
                }
            });

            $this.on('click', '.gpc-field-autocomplete-selected__remove', function() {
                const $_this = $(this);
                $_this.closest('.gpc-field-autocomplete-selected__item').remove();

                let sort = new Array();
                $items = $selected.find( 'li' );
                if ( $items.length > 0) {
                    // each time after dragging we resort our array
                    $selected.find( 'li' ).each( function( index ){
                        sort.push( $(this).attr( 'data-id' ) );
                    });

                    // add the array value to the hidden input field

                    $selected.sortable('refresh');
                } else {
                    $selected.hide();
                }

                $selected.next().val( sort.join() );

            });
        });
	}
);

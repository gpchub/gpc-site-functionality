jQuery( function( $ ){

	let numberOfTags = 0;
	let newNumberOfTags = 0;

	// when there are some terms are already created
	if( ! $( '#the-list' ).children( 'tr' ).first().hasClass( 'no-items' ) ) {
		numberOfTags = $( '#the-list' ).children( 'tr' ).length;
	}

	// after a term has been added via AJAX
	$(document).ajaxComplete( function( event, xhr, settings ){

		newNumberOfTags = $( '#the-list' ).children('tr').length;
		if( parseInt( newNumberOfTags ) > parseInt( numberOfTags ) ) {
			// refresh the actual number of tags variable
			numberOfTags = newNumberOfTags;

            const $form = $('#addtag');
			$form[0].reset();

            //reset images
            $form.find('.image_preview').attr('src', '').hide();
            $form.find('.gpc-field-image__value').val('');

            //reset gallery
            $form.find('.gpc-field-gallery-selected').empty();
            $form.find('.gpc-field-gallery__value').val('');

            //reset autocomplet results
            $form.find('.gpc-field-autocomplete-selected').empty().hide();
            $form.find('.gpc-field-autocomplete__value').val('');

		}
	});
});
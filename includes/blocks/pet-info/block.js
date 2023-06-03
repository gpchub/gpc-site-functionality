( function ( blocks, i18n, element, blockEditor ) {
	var el = element.createElement;
	var __ = i18n.__;
	var useBlockProps = blockEditor.useBlockProps;

	var blockStyle = {
		backgroundColor: '#e7e7e7',
		padding: '15px',
	};

	blocks.registerBlockType( 'gpc/pet-info', {
		edit: function () {
			return el(
				'p',
				useBlockProps( { style: blockStyle } ),
				'[Thông tin thú cưng]'
			);
		},
		save: function () {
			return null;
		},
	} );
} )(
	window.wp.blocks,
	window.wp.i18n,
	window.wp.element,
	window.wp.blockEditor
);
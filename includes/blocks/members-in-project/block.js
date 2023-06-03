( function ( blocks, i18n, element, blockEditor ) {
	var el = element.createElement;
	var __ = i18n.__;
	var useBlockProps = blockEditor.useBlockProps;

	var blockStyle = {
		backgroundColor: '#e7e7e7',
		padding: '15px',
	};

	blocks.registerBlockType( 'gpc/members-in-project', {
		edit: function () {
			return el(
				'p',
				useBlockProps( { style: blockStyle } ),
				'[Thành viên dự án]'
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
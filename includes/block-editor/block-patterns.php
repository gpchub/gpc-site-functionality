<?php

namespace GpcSiteFunctionality\Block_Editor;

use GpcSiteFunctionality\Trait\Singleton;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Block_Patterns
{
    use Singleton;

    private $pattern_category = 'gpc-patterns';

    public function __construct()
    {
        add_action( 'init', [ $this, 'register_block_pattern_category' ] );
        add_action( 'init', [ $this, 'register_block_patterns' ] );
    }

    public function register_block_pattern_category()
    {
        register_block_pattern_category( $this->pattern_category, array(
            'label' => __( 'My Patterns', 'gpc-site-functionality' )
        ) );
    }

    public function register_block_patterns()
    {
        $this->register_pattern_single_du_an();
        $this->register_pattern_single_pet();
    }

    private function register_pattern_single_du_an()
    {
        register_block_pattern(
            'gpc-theme/single-du-an',
            array(
                'title'       => __( 'Trang chi tiết dự án', 'gpc-site-functionality' ),
                'categories'  => array( $this->pattern_category ),
                'content'     => "<!-- wp:kadence/rowlayout {\"uniqueID\":\"_38fc7f-b8\",\"colLayout\":\"equal\",\"kbVersion\":2} -->\r\n<!-- wp:kadence/column {\"borderWidth\":[\"\",\"\",\"\",\"\"],\"uniqueID\":\"_3a5f91-52\",\"borderStyle\":[{\"top\":[\"\",\"\",\"\"],\"right\":[\"\",\"\",\"\"],\"bottom\":[\"\",\"\",\"\"],\"left\":[\"\",\"\",\"\"],\"unit\":\"px\"}]} -->\r\n<div class=\"wp-block-kadence-column kadence-column_3a5f91-52\"><div class=\"kt-inside-inner-col\"><!-- wp:embed {\"url\":\"https://youtu.be/fG1smV0HHK0\",\"type\":\"video\",\"providerNameSlug\":\"youtube\",\"responsive\":true,\"className\":\"wp-embed-aspect-16-9 wp-has-aspect-ratio\"} -->\r\n<figure class=\"wp-block-embed is-type-video is-provider-youtube wp-block-embed-youtube wp-embed-aspect-16-9 wp-has-aspect-ratio\"><div class=\"wp-block-embed__wrapper\">\r\nhttps://youtu.be/fG1smV0HHK0\r\n</div></figure>\r\n<!-- /wp:embed --></div></div>\r\n<!-- /wp:kadence/column -->\r\n\r\n<!-- wp:kadence/column {\"id\":2,\"borderWidth\":[\"\",\"\",\"\",\"\"],\"uniqueID\":\"_bbd1b6-aa\",\"borderStyle\":[{\"top\":[\"\",\"\",\"\"],\"right\":[\"\",\"\",\"\"],\"bottom\":[\"\",\"\",\"\"],\"left\":[\"\",\"\",\"\"],\"unit\":\"px\"}]} -->\r\n<div class=\"wp-block-kadence-column kadence-column_bbd1b6-aa\"><div class=\"kt-inside-inner-col\"><!-- wp:heading -->\r\n<h2 class=\"wp-block-heading\">Cumque aut quaerat vel</h2>\r\n<!-- /wp:heading -->\r\n\r\n<!-- wp:paragraph -->\r\n<p><strong>Thông tin 1:</strong> Khu phức hợp (TTTM – Văn phòng)</p>\r\n<!-- /wp:paragraph -->\r\n\r\n<!-- wp:paragraph -->\r\n<p><strong>Thông tin 2:</strong> Công trình đã thực hiện</p>\r\n<!-- /wp:paragraph -->\r\n\r\n<!-- wp:paragraph -->\r\n<p><strong>Thông tin 3:</strong> Khu vực Miền Nam</p>\r\n<!-- /wp:paragraph -->\r\n\r\n<!-- wp:gpc/members-in-project /--></div></div>\r\n<!-- /wp:kadence/column -->\r\n<!-- /wp:kadence/rowlayout -->",
            )
        );
    }

    private function register_pattern_single_pet()
    {
        register_block_pattern(
            'gpc-theme/single-pet',
            array(
                'title'       => __( 'Trang chi tiết thú cưng', 'gpc-site-functionality' ),
                'categories'  => array(  $this->pattern_category ),
                'content'     => "<!-- wp:kadence/rowlayout {\"uniqueID\":\"_a1cbbb-21\",\"colLayout\":\"equal\",\"kbVersion\":2} -->\r\n<!-- wp:kadence/column {\"borderWidth\":[\"\",\"\",\"\",\"\"],\"uniqueID\":\"_3fdf50-8f\",\"borderStyle\":[{\"top\":[\"\",\"\",\"\"],\"right\":[\"\",\"\",\"\"],\"bottom\":[\"\",\"\",\"\"],\"left\":[\"\",\"\",\"\"],\"unit\":\"px\"}]} -->\r\n<div class=\"wp-block-kadence-column kadence-column_3fdf50-8f\"><div class=\"kt-inside-inner-col\"><!-- wp:kadence/advancedgallery {\"uniqueID\":\"_362f59-ea\",\"ids\":[2520,2541],\"type\":\"slider\",\"linkTo\":\"media\",\"lightbox\":\"magnific\",\"lightboxCaption\":false,\"imagesDynamic\":[{\"id\":2520,\"link\":\"\",\"alt\":\"\",\"url\":\"https://picsum.photos/id/13/600/400\",\"customLink\":\"\",\"linkTarget\":\"\",\"linkSponsored\":\"\",\"thumbUrl\":\"https://picsum.photos/id/13/600/400\",\"lightUrl\":\"https://picsum.photos/id/13/600/400\",\"width\":600,\"height\":400},{\"id\":2541,\"link\":\"\",\"alt\":\"\",\"url\":\"https://picsum.photos/id/13/600/400\",\"customLink\":\"\",\"linkTarget\":\"\",\"linkSponsored\":\"\",\"thumbUrl\":\"https://picsum.photos/id/13/600/400\",\"lightUrl\":\"https://picsum.photos/id/13/600/400\",\"width\":600,\"height\":400}],\"kbVersion\":2} /--></div></div>\r\n<!-- /wp:kadence/column -->\r\n\r\n<!-- wp:kadence/column {\"id\":2,\"borderWidth\":[\"\",\"\",\"\",\"\"],\"uniqueID\":\"_4ee22c-66\",\"borderStyle\":[{\"top\":[\"\",\"\",\"\"],\"right\":[\"\",\"\",\"\"],\"bottom\":[\"\",\"\",\"\"],\"left\":[\"\",\"\",\"\"],\"unit\":\"px\"}]} -->\r\n<div class=\"wp-block-kadence-column kadence-column_4ee22c-66\"><div class=\"kt-inside-inner-col\"><!-- wp:heading -->\r\n<h2 class=\"wp-block-heading\">Bella</h2>\r\n<!-- /wp:heading -->\r\n\r\n<!-- wp:kadence/advancedheading {\"uniqueID\":\"_75b110-2c\",\"color\":\"palette1\",\"markBorder\":\"\",\"markBorderStyles\":[{\"top\":[null,\"\",\"\"],\"right\":[null,\"\",\"\"],\"bottom\":[null,\"\",\"\"],\"left\":[null,\"\",\"\"],\"unit\":\"px\"}],\"tabletMarkBorderStyles\":[{\"top\":[null,\"\",\"\"],\"right\":[null,\"\",\"\"],\"bottom\":[null,\"\",\"\"],\"left\":[null,\"\",\"\"],\"unit\":\"px\"}],\"mobileMarkBorderStyles\":[{\"top\":[null,\"\",\"\"],\"right\":[null,\"\",\"\"],\"bottom\":[null,\"\",\"\"],\"left\":[null,\"\",\"\"],\"unit\":\"px\"}],\"colorClass\":\"theme-palette1\",\"htmlTag\":\"p\",\"fontSize\":[\"md\",\"\",\"\"]} -->\r\n<p class=\"kt-adv-heading_75b110-2c wp-block-kadence-advancedheading has-theme-palette-1-color has-text-color\" data-kb-block=\"kb-adv-heading_75b110-2c\"><strong>FEMALE – 2 YEARS OLD</strong></p>\r\n<!-- /wp:kadence/advancedheading -->\r\n\r\n<!-- wp:gpc/pet-info /--></div></div>\r\n<!-- /wp:kadence/column -->\r\n<!-- /wp:kadence/rowlayout -->",
            )
        );
    }
}
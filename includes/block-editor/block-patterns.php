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
                'content'     => "<!-- wp:kadence/rowlayout {\"uniqueID\":\"_38fc7f-b8\",\"colLayout\":\"equal\",\"kbVersion\":2} -->\r\n<!-- wp:kadence/column {\"borderWidth\":[\"\",\"\",\"\",\"\"],\"uniqueID\":\"_3a5f91-52\",\"borderStyle\":[{\"top\":[\"\",\"\",\"\"],\"right\":[\"\",\"\",\"\"],\"bottom\":[\"\",\"\",\"\"],\"left\":[\"\",\"\",\"\"],\"unit\":\"px\"}]} -->\r\n<div class=\"wp-block-kadence-column kadence-column_3a5f91-52\"><div class=\"kt-inside-inner-col\"><!-- wp:kadence/advancedgallery {\"uniqueID\":\"_32f3c5-df\",\"ids\":[2530,2497],\"type\":\"slider\",\"linkTo\":\"media\",\"lightbox\":\"magnific\",\"lightboxCaption\":false,\"imagesDynamic\":[{\"id\":2530,\"link\":\"\",\"alt\":\"\",\"caption\":{\"raw\":\"\",\"rendered\":\"\"},\"url\":\"https://picsum.photos/id/13/600/400\",\"customLink\":\"\",\"linkTarget\":\"\",\"linkSponsored\":\"\",\"thumbUrl\":\"https://picsum.photos/id/13/600/400\",\"lightUrl\":\"https://picsum.photos/id/13/600/400\",\"width\":1024,\"height\":682},{\"id\":2497,\"link\":\"\",\"alt\":\"\",\"caption\":{\"raw\":\"\",\"rendered\":\"\"},\"url\":\"https://picsum.photos/id/13/600/400\",\"customLink\":\"\",\"linkTarget\":\"\",\"linkSponsored\":\"\",\"thumbUrl\":\"https://picsum.photos/id/13/600/400\",\"lightUrl\":\"https://picsum.photos/id/13/600/400\",\"width\":1024,\"height\":683}],\"kbVersion\":2} /--></div></div>\r\n<!-- /wp:kadence/column -->\r\n\r\n<!-- wp:kadence/column {\"id\":2,\"borderWidth\":[\"\",\"\",\"\",\"\"],\"uniqueID\":\"_bbd1b6-aa\",\"borderStyle\":[{\"top\":[\"\",\"\",\"\"],\"right\":[\"\",\"\",\"\"],\"bottom\":[\"\",\"\",\"\"],\"left\":[\"\",\"\",\"\"],\"unit\":\"px\"}]} -->\r\n<div class=\"wp-block-kadence-column kadence-column_bbd1b6-aa\"><div class=\"kt-inside-inner-col\"><!-- wp:heading -->\r\n<h2 class=\"wp-block-heading\">Cumque aut quaerat vel</h2>\r\n<!-- /wp:heading -->\r\n\r\n<!-- wp:paragraph -->\r\n<p><strong>Thông tin 1:</strong> Khu phức hợp (TTTM – Văn phòng)</p>\r\n<!-- /wp:paragraph -->\r\n\r\n<!-- wp:paragraph -->\r\n<p><strong>Thông tin 2:</strong> Công trình đã thực hiện</p>\r\n<!-- /wp:paragraph -->\r\n\r\n<!-- wp:paragraph -->\r\n<p><strong>Thông tin 3:</strong> Khu vực Miền Nam</p>\r\n<!-- /wp:paragraph --></div></div>\r\n<!-- /wp:kadence/column -->\r\n<!-- /wp:kadence/rowlayout -->\r\n\r\n<!-- wp:heading {\"level\":3} -->\r\n<h3 class=\"wp-block-heading\">Tổng quan dự án</h3>\r\n<!-- /wp:heading -->",
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
                'content'     => "<!-- wp:kadence/rowlayout {\"uniqueID\":\"_a1cbbb-21\",\"colLayout\":\"equal\",\"kbVersion\":2} -->\r\n<!-- wp:kadence/column {\"borderWidth\":[\"\",\"\",\"\",\"\"],\"uniqueID\":\"_3fdf50-8f\",\"borderStyle\":[{\"top\":[\"\",\"\",\"\"],\"right\":[\"\",\"\",\"\"],\"bottom\":[\"\",\"\",\"\"],\"left\":[\"\",\"\",\"\"],\"unit\":\"px\"}]} -->\r\n<div class=\"wp-block-kadence-column kadence-column_3fdf50-8f\"><div class=\"kt-inside-inner-col\"><!-- wp:kadence/advancedgallery {\"uniqueID\":\"_362f59-ea\",\"ids\":[2530,2497],\"type\":\"slider\",\"linkTo\":\"media\",\"lightbox\":\"magnific\",\"lightboxCaption\":false,\"imagesDynamic\":[{\"id\":2530,\"link\":\"\",\"alt\":\"\",\"caption\":{\"raw\":\"\",\"rendered\":\"\"},\"url\":\"https://picsum.photos/id/13/600/400\",\"customLink\":\"\",\"linkTarget\":\"\",\"linkSponsored\":\"\",\"thumbUrl\":\"https://picsum.photos/id/13/600/400\",\"lightUrl\":\"https://picsum.photos/id/13/600/400\",\"width\":1024,\"height\":682},{\"id\":2497,\"link\":\"\",\"alt\":\"\",\"caption\":{\"raw\":\"\",\"rendered\":\"\"},\"url\":\"https://picsum.photos/id/13/600/400\",\"customLink\":\"\",\"linkTarget\":\"\",\"linkSponsored\":\"\",\"thumbUrl\":\"https://picsum.photos/id/13/600/400\",\"lightUrl\":\"https://picsum.photos/id/13/600/400\",\"width\":1024,\"height\":683}],\"kbVersion\":2} /--></div></div>\r\n<!-- /wp:kadence/column -->\r\n\r\n<!-- wp:kadence/column {\"id\":2,\"borderWidth\":[\"\",\"\",\"\",\"\"],\"uniqueID\":\"_4ee22c-66\",\"borderStyle\":[{\"top\":[\"\",\"\",\"\"],\"right\":[\"\",\"\",\"\"],\"bottom\":[\"\",\"\",\"\"],\"left\":[\"\",\"\",\"\"],\"unit\":\"px\"}]} -->\r\n<div class=\"wp-block-kadence-column kadence-column_4ee22c-66\"><div class=\"kt-inside-inner-col\"><!-- wp:heading -->\r\n<h2 class=\"wp-block-heading\">Bella</h2>\r\n<!-- /wp:heading -->\r\n\r\n<!-- wp:kadence/advancedheading {\"uniqueID\":\"_75b110-2c\",\"color\":\"palette1\",\"markBorder\":\"\",\"markBorderStyles\":[{\"top\":[null,\"\",\"\"],\"right\":[null,\"\",\"\"],\"bottom\":[null,\"\",\"\"],\"left\":[null,\"\",\"\"],\"unit\":\"px\"}],\"tabletMarkBorderStyles\":[{\"top\":[null,\"\",\"\"],\"right\":[null,\"\",\"\"],\"bottom\":[null,\"\",\"\"],\"left\":[null,\"\",\"\"],\"unit\":\"px\"}],\"mobileMarkBorderStyles\":[{\"top\":[null,\"\",\"\"],\"right\":[null,\"\",\"\"],\"bottom\":[null,\"\",\"\"],\"left\":[null,\"\",\"\"],\"unit\":\"px\"}],\"colorClass\":\"theme-palette1\",\"htmlTag\":\"p\",\"fontSize\":[\"md\",\"\",\"\"]} -->\r\n<p class=\"kt-adv-heading_75b110-2c wp-block-kadence-advancedheading has-theme-palette-1-color has-text-color\" data-kb-block=\"kb-adv-heading_75b110-2c\"><strong>FEMALE – 2 YEARS OLD</strong></p>\r\n<!-- /wp:kadence/advancedheading -->\r\n\r\n<!-- wp:paragraph -->\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>\r\n<!-- /wp:paragraph -->\r\n\r\n<!-- wp:kadence/iconlist {\"uniqueID\":\"_1f06cc-06\",\"listMargin\":[\"0\",\"0\",\"0\",\"0\"]} -->\r\n<div class=\"wp-block-kadence-iconlist kt-svg-icon-list-items kt-svg-icon-list-items_1f06cc-06 kt-svg-icon-list-columns-1 alignnone\"><ul class=\"kt-svg-icon-list\"><!-- wp:kadence/listitem {\"uniqueID\":\"_392de1-92\",\"size\":20,\"text\":\"Friendly to other animals\",\"color\":\"#0d9b3f\"} -->\r\n<li class=\"wp-block-kadence-listitem kt-svg-icon-list-item-wrap kt-svg-icon-list-item-_392de1-92\"><span data-name=\"USE_PARENT_DEFAULT_ICON\" data-class=\"kt-svg-icon-list-single\" class=\"kadence-dynamic-icon\"></span><span class=\"kt-svg-icon-list-text\">Friendly to other animals</span></li>\r\n<!-- /wp:kadence/listitem --></ul></div>\r\n<!-- /wp:kadence/iconlist -->\r\n\r\n<!-- wp:kadence/iconlist {\"uniqueID\":\"_989764-eb\"} -->\r\n<div class=\"wp-block-kadence-iconlist kt-svg-icon-list-items kt-svg-icon-list-items_989764-eb kt-svg-icon-list-columns-1 alignnone\"><ul class=\"kt-svg-icon-list\"><!-- wp:kadence/listitem {\"uniqueID\":\"_cbe4f0-fe\",\"icon\":\"icon-clear\",\"size\":20,\"text\":\"Not Friendly to kids\",\"color\":\"#cf0c0c\"} -->\r\n<li class=\"wp-block-kadence-listitem kt-svg-icon-list-item-wrap kt-svg-icon-list-item-_cbe4f0-fe\"><span data-name=\"icon-clear\" data-class=\"kt-svg-icon-list-single\" class=\"kadence-dynamic-icon\"></span><span class=\"kt-svg-icon-list-text\">Not Friendly to kids</span></li>\r\n<!-- /wp:kadence/listitem --></ul></div>\r\n<!-- /wp:kadence/iconlist --></div></div>\r\n<!-- /wp:kadence/column -->\r\n<!-- /wp:kadence/rowlayout -->\r\n\r\n<!-- wp:heading {\"level\":3} -->\r\n<h3 class=\"wp-block-heading\">Giới thiệu thú cưng</h3>\r\n<!-- /wp:heading -->",
            )
        );
    }
}
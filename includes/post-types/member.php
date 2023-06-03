<?php

namespace GpcSiteFunctionality\Post_Types;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use GpcSiteFunctionality\Blocks\Gpc_Members;
use GpcSiteFunctionality\Lib\Post_Type_Helper;
use GpcSiteFunctionality\Lib\Taxonomy_Helper;
use GpcSiteFunctionality\Trait\Singleton;
use MB_Relationships_API;

class Member
{
    use Singleton;

    public function __construct()
    {
        add_action( 'init', array( $this, 'register_post_type' ) );
        add_action( 'mb_relationships_init', [ $this, 'add_relationships' ] );
        add_shortcode( 'gpc_members_in_project', [ $this, 'render_member_list' ] );
        add_shortcode( 'gpc_projects_of_member', [ $this, 'render_project_list' ] );

        $this->register_blocks();
    }

    public function register_post_type()
    {
        Post_Type_Helper::register('gpc_member', 'Member', '', [
            'rewrite' => array( 'slug' => 'member' ),
        ]);
        Taxonomy_Helper::regiter('gpc_member_cat', ['gpc_member'], 'Danh mục member', '', [
            'rewrite' => array( 'slug' => 'danh-muc-member' ),
        ]);
    }

    /**
     * Code mẫu thêm liên kết với custom post type khác
     * Yêu cầu plugin:
     * + Meta Box: https://wordpress.org/plugins/meta-box/
     * + MB Relationships: https://wordpress.org/plugins/mb-relationships/
     * Document: https://docs.metabox.io/extensions/mb-relationships/
     */
    public function add_relationships()
    {
        MB_Relationships_API::register( [
            'id'   => 'projects_to_members',
            'from' => 'gpc_project',
            'to'   => 'gpc_member',
            'label_from' => 'Members',
            'label_to' => 'Dự án',
        ] );
    }

    public function register_blocks()
    {
        new Gpc_Members();
    }

    public function render_member_list( $atts )
    {
        global $post;
        if ( $post->post_type !== 'gpc_project' ) {
            return;
        }

		$atts = shortcode_atts(
			[
				'limit' => 10
			],
			$atts
		);

        $connected = new \WP_Query( [
            'relationship' => [
                'id'   => 'projects_to_members',
                'from' => $post->ID, // You can pass object ID or full object
            ],
            'limit' => $atts['limit'],
            'nopaging'     => true,
        ] );

        ob_start();
        ?>
        <div class="project-members">
        <?php

		while ( $connected->have_posts() ) :
            $connected->the_post();
            $post_id = get_the_ID();
            $member_cats = get_the_terms($post_id, 'gpc_member_cat');
            ?>
            <div class="project-members__item">
                <a href="<?php the_permalink(); ?>">
                    <?php echo get_the_post_thumbnail( $post_id, 'thumbnail' ); ;?>
                    <h5 class="project-members__name"><?php the_title(); ?></h5>
                    <div class="project-members__cats">
                        <?php if ( !empty( $member_cats ) ) :
                            $member_cats_string = join(', ', wp_list_pluck($member_cats, 'name'));
                            echo $member_cats_string;
                        endif; ?>
                    </div>
                </a>
            </div>
            <?php
        endwhile;

        wp_reset_postdata();

        ?>
        </div>
        <?php

        $html = ob_get_clean();

        return $html;

    }

    public function render_project_list( $atts )
    {
        global $post;
        if ( $post->post_type !== 'gpc_member' ) {
            return;
        }

        $atts = shortcode_atts(
			[
				'limit' => 10
			],
			$atts
		);

        $connected = new \WP_Query( [
            'relationship' => [
                'id'   => 'projects_to_members',
                'to' => $post->ID, // You can pass object ID or full object
            ],
            'limit' => $atts['limit'],
            'nopaging'     => true,
        ] );

        ob_start();

        if ($connected->have_posts()) :
        ?>
            <h2 class="member-projects__heading">Dự án tham gia</h2>
            <div class="member-projects content-wrap grid-cols gpc_project-archive grid-sm-col-2 grid-lg-col-4 item-image-style-above is-style-post-grid-portfolio">
            <?php
            while ( $connected->have_posts() ) :
                $connected->the_post();
                ?>
                <article <?php post_class( 'entry content-bg loop-entry member-projects__item' ); ?>>
                    <a class="post-thumbnail kadence-thumbnail-ratio-2-3" href="<?php the_permalink(); ?>">
                        <div class="post-thumbnail-inner">
                        <?php
                            the_post_thumbnail(
                                'medium_large',
                                array(
                                    'alt' => the_title_attribute(
                                        array(
                                            'echo' => false,
                                        )
                                    ),
                                )
                            );
                            ?>
                        </div>
                    </a>
                    <div class="entry-content-wrap">
                        <header class="entry-header">
                            <h3 class="entry-title">
                                <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
                            </h3>
                        </header>
                    </div>
                </article>
            <?php endwhile; ?>
            </div>
        <?php endif;

        wp_reset_postdata();
        ?>
        </div>
        <?php

        $html = ob_get_clean();

        return $html;
    }
}
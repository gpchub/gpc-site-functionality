<?php

/**
 * Class post type base, chỉ dùng với theme Kadence
 * - Thêm related post cho custom post type
 *
 * Các theme khác nên tạo class post type base riêng cho từng theme
 * vì mỗi theme có cách code khác nhau.
 */

namespace GpcSiteFunctionality\Post_Types;

use GpcSiteFunctionality\Trait\Singleton;
use function Kadence\kadence;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Gpc_Kadence_Post_Type
{
    use Singleton;

    protected $related_options = [];

    public function __construct()
    {
        $default_related_options = [
            'enabled' => false,
            'post_type' => 'post',
            'heading' => esc_html__( 'Similar Posts', 'kadence' ),
            // số cột hiển thị trên slider
            'cols' => array(
                'xxl' => 3,
                'xl'  => 3,
                'md'  => 3,
                'sm'  => 2,
                'xs'  => 2,
                'ss'  => 1,
            ),
            'count' => 6,
            'related_by' => []
        ];

        $this->related_options = array_merge( $default_related_options, $this->get_related_options() );
        add_action( 'kadence_after_main_content', [ $this, 'add_related_posts' ]);
    }

    public function get_related_options() {
        return [];
    }

    public function add_related_posts()
    {
        if ( !$this->related_options['enabled'] ) {
            return;
        }

        global $post;

        if ( !is_singular() || $post->post_type !== $this->related_options['post_type'] ) {
            return;
        }

        $args = $this->get_related_posts_args( $post );
        $cols = $this->related_options['cols'];

        $columns_class = apply_filters( 'kadence_related_posts_columns_class', ( 2 === $cols['xxl'] ? 'grid-sm-col-2 grid-lg-col-2' : 'grid-sm-col-2 grid-lg-col-3' ) );

        $bpc = new \WP_Query( $args );

        if ( $bpc ) :
            kadence()->print_styles( 'kadence-related-posts' );
            kadence()->print_styles( 'kad-splide' );
            wp_enqueue_script( 'kadence-slide-init' );

            $num = $bpc->post_count;

            if ( $num > 0 ) {
                ?>
                <div class="entry-related alignfull entry-related-style-wide">
                    <div class="entry-related-inner content-container site-container">
                        <div class="entry-related-inner-content alignwide">
                            <?php echo wp_kses_post( apply_filters( 'kadence_single_post_similar_posts_title', '<h2 class="entry-related-title">' . $this->related_options['heading'] . '</h2>' ) ); ?>
                            <div class="entry-related-carousel kadence-slide-init splide" data-columns-xxl="<?php echo esc_attr( $cols['xxl'] ); ?>" data-columns-xl="<?php echo esc_attr( $cols['xl'] ); ?>" data-columns-md="<?php echo esc_attr( $cols['md'] ); ?>" data-columns-sm="<?php echo esc_attr( $cols['sm'] ); ?>" data-columns-xs="<?php echo esc_attr( $cols['xs'] ); ?>" data-columns-ss="<?php echo esc_attr( $cols['ss'] ); ?>" data-slider-anim-speed="400" data-slider-scroll="1" data-slider-dots="true" data-slider-arrows="true" data-slider-hover-pause="false" data-slider-auto="<?php echo esc_attr( apply_filters( 'kadence_single_post_similar_posts_carousel_autoplay', false ) ? 'true' : 'false' ); ?>" data-slider-speed="7000" data-slider-gutter="40" data-slider-loop="true" data-slider-next-label="<?php echo esc_attr__( 'Next', 'kadence' ); ?>" data-slider-slide-label="<?php echo esc_attr__( 'Posts', 'kadence' ); ?>" data-slider-prev-label="<?php echo esc_attr__( 'Previous', 'kadence' ); ?>">
                                <div class="splide__track">
                                    <div class="splide__list grid-cols <?php echo esc_attr( $columns_class ); ?>">
                                        <?php
                                        while ( $bpc->have_posts() ) :
                                            $bpc->the_post();
                                            echo '<div class="carousel-item splide__slide">';
                                            get_template_part( 'template-parts/content/entry', get_post_type() );
                                            echo '</div>';
                                        endwhile;
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- .entry-author -->
                <?php
            }
        endif;
        wp_reset_postdata();

    }

    private function get_related_posts_args( $post )
    {
		$related_args = array(
			'post_type'              => $post->post_type,
			'posts_per_page'         => $this->related_options['count'],
			'no_found_rows'          => true,
			'post_status'            => 'publish',
			'post__not_in'           => array( $post->ID ),
		);

        $related_by = $this->related_options['related_by'];
        if ( !empty($related_by) ) {
            $related_args['tax_query'] = [
                'relation' => 'OR',
            ];

            foreach ( $related_by as $tax ) {
                $terms = get_the_terms( $post, $tax );
                if ( !empty( $terms  ) ) {
                    $term_list = wp_list_pluck( $terms, 'slug' );
                    $related_args[] = [
                        'taxonomy' => $tax,
                        'field'    => 'slug',
                        'terms'    => $term_list,
                    ];
                }
            }
        }

        return $related_args;
    }
}
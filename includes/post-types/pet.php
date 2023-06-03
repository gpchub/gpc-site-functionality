<?php

namespace GpcSiteFunctionality\Post_Types;

if (!defined('ABSPATH')) {
    exit;
}

use GpcSiteFunctionality\Blocks\Gpc_Pet_Info;
use GpcSiteFunctionality\Lib\Post_Type_Helper;
use GpcSiteFunctionality\Lib\Taxonomy_Helper;
use GpcSiteFunctionality\Trait\Singleton;

class Pet extends Gpc_Kadence_Post_Type
{
    use Singleton;

    public function __construct()
    {
        add_action('init', array($this, 'register_post_type'));

        add_shortcode('gpc_pet_info', [$this, 'render_pet_info']);

        $this->register_blocks();

        parent::__construct();
    }

    public function get_related_options()
    {
        return [
            'enabled' => true,
            'post_type' => 'gpc_pet',
            'heading' => 'Xem thêm thú cưng khác',
            'cols' => array(
                'xxl' => 3,
                'xl'  => 3,
                'md'  => 3,
                'sm'  => 2,
                'xs'  => 2,
                'ss'  => 1,
            ),
            'count' => 3,
            'related_by' => ['gpc_pet_cat']
        ];
    }

    public function register_post_type()
    {
        Post_Type_Helper::register('gpc_pet', 'Thú cưng', '', [
            'rewrite' => array('slug' => 'thu-cung'),
        ]);
        Taxonomy_Helper::regiter('gpc_pet_cat', ['gpc_pet'], 'Danh mục thú cưng', '', [
            'rewrite' => array('slug' => 'danh-muc-thu-cung'),
        ]);
    }

    public function register_blocks()
    {
        new Gpc_Pet_Info();
    }

    public function render_pet_info()
    {
        global $post;
        if ( $post->post_type !== 'gpc_pet' ) {
            return;
        }

        $pet_info = get_post_meta($post->ID, 'gpc_pet_info', true);

        ob_start();
        ?>
        <div class="pet-info">
            <svg aria-hidden="true" style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <defs>
                    <symbol id="icon-cheveron-right" viewBox="0 0 20 20">
                        <path d="M12.95 10.707l0.707-0.707-5.657-5.657-1.414 1.414 4.242 4.243-4.242 4.243 1.414 1.414 4.95-4.95z"></path>
                    </symbol>
                </defs>
            </svg>
            <?php if (isset($pet_info['pet_gender'])) : /*---------- Giới tính ---------- */ ?>
                <div class="pet-info__item">
                    <span class="pet-info__item-title">
                        <?php echo $this->get_pet_info_icon(); ?> Giới tính:
                    </span>
                    <span class="pet-info__item-value"><?php echo $pet_info['pet_gender']; ?></span>
                </div>
            <?php endif; ?>

            <?php if (isset($pet_info['pet_age'])) : /*---------- Tuổi ---------- */ ?>
                <div class="pet-info__item">
                    <span class="pet-info__item-title">
                        <?php echo $this->get_pet_info_icon(); ?> Tuổi:
                    </span>
                    <span class="pet-info__item-value"><?php echo $pet_info['pet_age']; ?></span>
                </div>
            <?php endif; ?>

            <?php if (isset($pet_info['pet_breed'])) : /*---------- Giống ---------- */ ?>
                <div class="pet-info__item">
                    <span class="pet-info__item-title">
                        <?php echo $this->get_pet_info_icon(); ?> Giống:
                    </span>
                    <span class="pet-info__item-value"><?php echo $pet_info['pet_breed']; ?></span>
                </div>
            <?php endif; ?>

            <?php if (isset($pet_info['pet_color'])) : /*---------- Màu lông ---------- */ ?>
                <div class="pet-info__item">
                    <span class="pet-info__item-title">
                        <?php echo $this->get_pet_info_icon(); ?> Màu lông:
                    </span>
                    <span class="pet-info__item-value"><?php echo $pet_info['pet_color']; ?></span>
                </div>
            <?php endif; ?>

            <?php if (isset($pet_info['pet_vaccined'])) : /*---------- Tiêm vaccine ---------- */ ?>
                <div class="pet-info__item">
                    <span class="pet-info__item-title">
                        <?php echo $this->get_pet_info_icon(); ?> Tiêm vaccine:
                    </span>
                    <span class="pet-info__item-value"><?php echo $pet_info['pet_vaccined'] ? 'Đã tiêm vaccine' : 'Chưa tiêm vaccine'; ?></span>
                </div>
            <?php endif; ?>

            <?php if (isset($pet_info['pet_triet_san'])) : /*---------- Triệt sản ---------- */ ?>
                <div class="pet-info__item">
                    <span class="pet-info__item-title">
                        <?php echo $this->get_pet_info_icon(); ?> Triệt sản:
                    </span>
                    <span class="pet-info__item-value"><?php echo $pet_info['pet_triet_san'] ? 'Đã triệt sản' : 'Chưa triệt sản'; ?></span>
                </div>
            <?php endif; ?>

        </div>

        <div class="pet-adoption">
            <a class="button button-adoption modal-trigger" href="#pu-dang-ky-nhan-nuoi-pet">Đăng ký nhận nuôi</a>
        </div>

        <?php echo do_shortcode("[gpc_share_icons]"); ?>

        <?php

        $html = ob_get_clean();

        return $html;
    }

    private function get_pet_info_icon()
    {
        return '<svg class="icon icon-cheveron-right"><use xlink:href="#icon-cheveron-right"></use></svg>';
    }


}

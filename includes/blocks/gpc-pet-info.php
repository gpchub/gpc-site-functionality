<?php

namespace GpcSiteFunctionality\Blocks;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Gpc_Pet_Info
{
    public function __construct()
    {
        add_action( 'init', [$this, 'register_block'] );
    }

    public function register_block()
    {
        register_block_type( __DIR__ . '/pet-info', array(
            'render_callback' => [ $this, 'render_block' ],
        ) );
    }

    public function render_block()
    {
        return do_shortcode('[gpc_pet_info]');
    }
}
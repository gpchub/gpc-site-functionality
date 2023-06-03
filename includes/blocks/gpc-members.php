<?php

namespace GpcSiteFunctionality\Blocks;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Gpc_Members
{
    public function __construct()
    {
        add_action( 'init', [$this, 'register_block'] );
    }

    public function register_block()
    {
        register_block_type( __DIR__ . '/members-in-project', array(
            'render_callback' => [ $this, 'render_members_in_project' ],
        ) );

        register_block_type( __DIR__ . '/projects-of-member', array(
            'render_callback' => [ $this, 'render_projects_of_member' ],
        ) );
    }

    public function render_members_in_project()
    {
        return do_shortcode('[gpc_members_in_project]');
    }

    public function render_projects_of_member()
    {
        return do_shortcode('[gpc_projects_of_member]');
    }
}
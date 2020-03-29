<?php

/*
Widget Name: (TEST) Static Block
Description: Add Static block content
Author: OrionThemes
Author URI: http://orionthemes.com
*/
class orion_static_block_w extends SiteOrigin_Widget {

	function __construct() {
		parent::__construct(
			'orion_static_block_w',
			esc_html__('(TEST) Static blocks', 'test'),
			array(
				'description' => esc_html__('Add Static block content.', 'test'),
				'panels_groups' => array('test'),
				'panels_icon' => 'orion dashicons dashicons-admin-page',
			),
			array(

			),
			array(
			    'title' => array(
			        'type' => 'text',
			        'label' => esc_html__('Widget Title', 'test'),
			    ),						
				'static_block' => array(
					'type' => 'select',
					'label' => esc_html__( 'Choose a static block', 'test' ),
					'description' => esc_html__( 'Select a static block.', 'test' ),
					'default' => 'all',
					'options' => orion_get_static_blocks()	
				),			 
			),		    				
			plugin_dir_path(__FILE__)
		);
	}

    function get_template_name($instance) {
         return 'orion_static_block_w-template';
    }
	function get_template_dir($instance) {
	    return 'tpl';
	}
    function get_style_name($instance) {
        return '';
    }
}

siteorigin_widget_register('orion_static_block_w', __FILE__, 'orion_static_block_w');
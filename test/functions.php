<?php

/* Load theme styles*/
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );
function enqueue_parent_styles() {
   wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}

/* display banner area */
add_action( 'vantage_before_page_wrapper', 'test_subheader_template', 10 );
function test_subheader_template() {
    global $post;
    $test_static_block_meta_box = get_post_meta($post->ID, 'test_static_block_meta_box', true);

    if(isset($test_static_block_meta_box) && $test_static_block_meta_box != '' && function_exists( 'siteorigin_panels_render')) {
        echo '<div class="staticblock-wrap">';
            echo siteorigin_panels_render($test_static_block_meta_box);
        echo '</div>';
    }
}

/* Add widget folder to Page builder*/
add_filter('siteorigin_widgets_widget_folders', 'test_theme_add_so_widgets');
function test_theme_add_so_widgets($folders){
    $folders[] = get_stylesheet_directory() . '/testwidgets/';
    return $folders;
}

/* Register static block post type */
add_action( 'init', 'test_register_static_blocks_post_type', 0 );
function test_register_static_blocks_post_type() {
      $labels = array(
        'name'                  => esc_html__( 'Static Blocks', 'Post Type General Name', 'test' ),
        'singular_name'         => esc_html__( 'Static Block', 'Post Type Singular Name', 'test' ),
        'menu_name'             => esc_html__( 'Static Blocks', 'test' ),
        'name_admin_bar'        => esc_html__( 'Static Blocks', 'test' ),
        'archives'              => esc_html__( 'Item Archives', 'test' ),
        'attributes'            => esc_html__( 'Item Attributes', 'test' ),
        'parent_item_colon'     => esc_html__( 'Parent Item:', 'test' ),
        'all_items'             => esc_html__( 'All Items', 'test' ),
        'add_new_item'          => esc_html__( 'Add New Item', 'test' ),
        'add_new'               => esc_html__( 'Add New', 'test' ),
        'new_item'              => esc_html__( 'New Item', 'test' ),
        'edit_item'             => esc_html__( 'Edit Item', 'test' ),
        'update_item'           => esc_html__( 'Update Item', 'test' ),
        'view_item'             => esc_html__( 'View Item', 'test' ),
        'view_items'            => esc_html__( 'View Items', 'test' ),
        'search_items'          => esc_html__( 'Search Item', 'test' ),
        'not_found'             => esc_html__( 'Not found', 'test' ),
        'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'test' ),
        'featured_image'        => esc_html__( 'Featured Image', 'test' ),
        'set_featured_image'    => esc_html__( 'Set featured image', 'test' ),
        'remove_featured_image' => esc_html__( 'Remove featured image', 'test' ),
        'use_featured_image'    => esc_html__( 'Use as featured image', 'test' ),
        'insert_into_item'      => esc_html__( 'Insert into item', 'test' ),
        'uploaded_to_this_item' => esc_html__( 'Uploaded to this item', 'test' ),
        'items_list'            => esc_html__( 'Items list', 'test' ),
        'items_list_navigation' => esc_html__( 'Items list navigation', 'test' ),
        'filter_items_list'     => esc_html__( 'Filter items list', 'test' ),
      );

      $args = array(
        'label'                 => esc_html__( 'Static Block', 'test' ),
        'description'           => esc_html__( 'Content blocks, which can be loaded anywhere.', 'test' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor' ),
        'hierarchical'          => true,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 20,
        'menu_icon'             => 'dashicons-admin-page',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => false,
        'can_export'            => true,
        'has_archive'           => true,    
        'exclude_from_search'   => true,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
      );
    register_post_type( 'static_blocks', $args );
}

function orion_get_static_blocks() {
    $block_args = array(
        'posts_per_page'   => -1,
        'offset'           => 0,
        'category'         => '',
        'category_name'    => '',
        'orderby'          => 'date',
        'order'            => 'DESC',
        'exclude'          => '',
        'meta_key'         => '',
        'meta_value'       => '',
        'post_type'        => 'static_blocks',
        'post_mime_type'   => '',
        'post_parent'      => '',
        'author'       => '',
        'author_name'      => '',
        'post_status'      => 'publish',
        'suppress_filters' => false 
    );
    $posts_array = get_posts( $block_args ); 

    $static_blocks = array( 'none' => 'None');
    foreach ($posts_array as $block) {
        $id = $block->ID;
        $name = $block->post_title;
        $static_blocks[$id] = $name;
    }
    return $static_blocks;
}



/* post meta */
add_action( 'add_meta_boxes', 'test_custom_meta_box' );
function test_custom_meta_box($post){
    global $post;
    add_meta_box('so_meta_box', 'Display Static block in Banner area', 'test_static_block_meta_box', $post->post_type, 'normal' , 'high');
}

add_action('save_post', 'so_save_metabox');
function so_save_metabox(){ 
    global $post;
    if(isset($_POST["test_static_block"])){
        $meta_element_class = $_POST['test_static_block'];
        update_post_meta($post->ID, 'test_static_block_meta_box', $meta_element_class);
    }
}

function test_static_block_meta_box($post){
$orion_get_static_blocks = orion_get_static_blocks();

    $meta_element_class = get_post_meta($post->ID, 'test_static_block_meta_box', true);?>   
    <select name="test_static_block" id="test_static_block">
    <?php foreach ($orion_get_static_blocks as $value => $label) :?>
        <option value="<?php echo esc_attr($value);?>" <?php selected( $meta_element_class, esc_attr($value) ); ?>><?php echo esc_attr($label);?></option>
    <?php endforeach;?>
    </select>
    <?php
}
?>
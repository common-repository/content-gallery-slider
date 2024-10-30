<?php
/*
Plugin Name: Content Gallery Slider
Plugin URL: http://beautiful-module.com/demo/content-gallery-slider/
Description: A simple Responsive Content Gallery Slider
Version: 1.0
Author: Module Express
Author URI: http://beautiful-module.com
Contributors: Module Express
*/
/*
 * Register CPT sp_content.gallery
 *
 */
if(!class_exists('Content_Gallery_Slider')) {
	class Content_Gallery_Slider {

		function __construct() {
		    if(!function_exists('add_shortcode')) {
		            return;
		    }
			add_action ( 'init' , array( $this , 'fcgs_responsive_gallery_setup_post_types' ));

			/* Include style and script */
			add_action ( 'wp_enqueue_scripts' , array( $this , 'fcgs_register_style_script' ));
			
			/* Register Taxonomy */
			add_action ( 'init' , array( $this , 'fcgs_responsive_gallery_taxonomies' ));
			add_action ( 'add_meta_boxes' , array( $this , 'fcgs_rsris_add_meta_box_gallery' ));
			add_action ( 'save_post' , array( $this , 'fcgs_rsris_save_meta_box_data_gallery' ));
			register_activation_hook( __FILE__, 'fcgs_responsive_gallery_rewrite_flush' );


			// Manage Category Shortcode Columns
			add_filter ( 'manage_responsive_fcgs_slider-category_custom_column' , array( $this , 'fcgs_responsive_gallery_category_columns' ), 10, 3);
			add_filter ( 'manage_edit-responsive_fcgs_slider-category_columns' , array( $this , 'fcgs_responsive_gallery_category_manage_columns' ));
			require_once( 'fcgs_gallery_admin_settings_center.php' );
		    add_shortcode ( 'sp_content.gallery' , array( $this , 'fcgs_responsivegallery_shortcode' ));
		}


		function fcgs_responsive_gallery_setup_post_types() {

			$responsive_gallery_labels =  apply_filters( 'sp_fcgs_labels', array(
				'name'                => 'Content Gallery Slider',
				'singular_name'       => 'Content Gallery Slider',
				'add_new'             => __('Add New', 'sp_fcgs'),
				'add_new_item'        => __('Add New Image', 'sp_fcgs'),
				'edit_item'           => __('Edit Image', 'sp_fcgs'),
				'new_item'            => __('New Image', 'sp_fcgs'),
				'all_items'           => __('All Images', 'sp_fcgs'),
				'view_item'           => __('View Image', 'sp_fcgs'),
				'search_items'        => __('Search Image', 'sp_fcgs'),
				'not_found'           => __('No Image found', 'sp_fcgs'),
				'not_found_in_trash'  => __('No Image found in Trash', 'sp_fcgs'),
				'parent_item_colon'   => '',
				'menu_name'           => __('Content Gallery Slider', 'sp_fcgs'),
				'exclude_from_search' => true
			) );


			$responsiveslider_args = array(
				'labels' 			=> $responsive_gallery_labels,
				'public' 			=> true,
				'publicly_queryable'		=> true,
				'show_ui' 			=> true,
				'show_in_menu' 		=> true,
				'query_var' 		=> true,
				'capability_type' 	=> 'post',
				'has_archive' 		=> true,
				'hierarchical' 		=> false,
				'menu_icon'   => 'dashicons-format-gallery',
				'supports' => array('title','editor','thumbnail')
				
			);
			register_post_type( 'sp_fcgs', apply_filters( 'sp_faq_post_type_args', $responsiveslider_args ) );

		}
		
		function fcgs_register_style_script() {
		    wp_enqueue_style( 'fcgs_responsiveimgslider',  plugin_dir_url( __FILE__ ). 'css/responsiveimgslider.css' );
			/*   REGISTER ALL CSS FOR SITE */
						
			wp_enqueue_style( 'fcgs_swiper',  plugin_dir_url( __FILE__ ). 'css/swiper.css' );
			wp_enqueue_style( 'fcgs_content-gallery-slider',  plugin_dir_url( __FILE__ ). 'css/content-gallery-slider.css' );
			

			/*   REGISTER ALL JS FOR SITE */	
			wp_enqueue_script( 'fcgs_swiper', plugin_dir_url( __FILE__ ) . 'js/swiper.js', array( 'jquery' ));
		}
		
		
		function fcgs_responsive_gallery_taxonomies() {
		    $labels = array(
		        'name'              => _x( 'Category', 'taxonomy general name' ),
		        'singular_name'     => _x( 'Category', 'taxonomy singular name' ),
		        'search_items'      => __( 'Search Category' ),
		        'all_items'         => __( 'All Category' ),
		        'parent_item'       => __( 'Parent Category' ),
		        'parent_item_colon' => __( 'Parent Category:' ),
		        'edit_item'         => __( 'Edit Category' ),
		        'update_item'       => __( 'Update Category' ),
		        'add_new_item'      => __( 'Add New Category' ),
		        'new_item_name'     => __( 'New Category Name' ),
		        'menu_name'         => __( 'Gallery Category' ),
		    );

		    $args = array(
		        'hierarchical'      => true,
		        'labels'            => $labels,
		        'show_ui'           => true,
		        'show_admin_column' => true,
		        'query_var'         => true,
		        'rewrite'           => array( 'slug' => 'responsive_fcgs_slider-category' ),
		    );

		    register_taxonomy( 'responsive_fcgs_slider-category', array( 'sp_fcgs' ), $args );
		}

		function fcgs_responsive_gallery_rewrite_flush() {  
				fcgs_responsive_gallery_setup_post_types();
		    flush_rewrite_rules();
		}


		function fcgs_responsive_gallery_category_manage_columns($theme_columns) {
		    $new_columns = array(
		            'cb' => '<input type="checkbox" />',
		            'name' => __('Name'),
		            'gallery_fcgs_shortcode' => __( 'Gallery Category Shortcode', 'fcgs_slick_slider' ),
		            'slug' => __('Slug'),
		            'posts' => __('Posts')
					);

		    return $new_columns;
		}

		function fcgs_responsive_gallery_category_columns($out, $column_name, $theme_id) {
		    $theme = get_term($theme_id, 'responsive_fcgs_slider-category');

		    switch ($column_name) {      
		        case 'title':
		            echo get_the_title();
		        break;
		        case 'gallery_fcgs_shortcode':
					echo '[sp_content.gallery cat_id="' . $theme_id. '"]';			  	  

		        break;
		        default:
		            break;
		    }
		    return $out;   

		}

		/* Custom meta box for slider link */
		function fcgs_rsris_add_meta_box_gallery() {
			add_meta_box('custom-metabox',__( 'LINK URL', 'link_textdomain' ),array( $this , 'fcgs_rsris_gallery_box_callback' ),'sp_fcgs');			
		}
		
		function fcgs_rsris_gallery_box_callback( $post ) {
			wp_nonce_field( 'fcgs_rsris_save_meta_box_data_gallery', 'rsris_meta_box_nonce' );
			$value = get_post_meta( $post->ID, 'rsris_fcgs_link', true );
			echo '<input type="url" id="rsris_fcgs_link" name="rsris_fcgs_link" value="' . esc_attr( $value ) . '" size="80" /><br />';
			echo 'ie http://www.google.com';
		}
		
		function fcgs_truncate($string, $length = 100, $append = "&hellip;")
		{
			$string = trim($string);
			if (strlen($string) > $length)
			{
				$string = wordwrap($string, $length);
				$string = explode("\n", $string, 2);
				$string = $string[0] . $append;
			}

			return $string;
		}
			
		function fcgs_rsris_save_meta_box_data_gallery( $post_id ) {
			if ( ! isset( $_POST['rsris_meta_box_nonce'] ) ) {
				return;
			}
			if ( ! wp_verify_nonce( $_POST['rsris_meta_box_nonce'], 'fcgs_rsris_save_meta_box_data_gallery' ) ) {
				return;
			}
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}
			if ( isset( $_POST['post_type'] ) && 'sp_fcgs' == $_POST['post_type'] ) {

				if ( ! current_user_can( 'edit_page', $post_id ) ) {
					return;
				}
			} else {

				if ( ! current_user_can( 'edit_post', $post_id ) ) {
					return;
				}
			}
			if ( ! isset( $_POST['rsris_fcgs_link'] ) ) {
				return;
			}
			$link_data = sanitize_text_field( $_POST['rsris_fcgs_link'] );
			update_post_meta( $post_id, 'rsris_fcgs_link', $link_data );
		}
		
		/*
		 * Add [sp_content.gallery] shortcode
		 *
		 */
		function fcgs_responsivegallery_shortcode( $atts, $content = null ) {
			
			extract(shortcode_atts(array(
				"limit"  => '',
				"cat_id" => '',
				"autoplay_interval" => '',
				"rows" => '',
				"columns" => '',
				"space" => '',
				"width" => ''
			), $atts));
			
			if( $limit ) { 
				$posts_per_page = $limit; 
			} else {
				$posts_per_page = '-1';
			}
			if( $cat_id ) { 
				$cat = $cat_id; 
			} else {
				$cat = '';
			}
			
			if( $space ) { 
				$space_between_items = $space; 
			} else {
				$space_between_items = '20';
			}	 	
			
			if( $autoplay_interval ) { 
				$autoplay_intervalslider = $autoplay_interval; 
			} else {
				$autoplay_intervalslider = '4000';
			}
			
			if( $rows ) { 
				$rows_slider = $rows; 
			} else {
				$rows_slider = '4000';
			}

			if( $columns ) { 
				$columns_slider = $columns; 
			} else {
				$columns_slider = '4000';
			}			

			if( $width ) { 
				$width_slider = $width . "px"; 
			} else {
				$width_slider = '100%';
			}
			
			ob_start();
			// Create the Query
			$post_type 		= 'sp_fcgs';
			$orderby 		= 'post_date';
			$order 			= 'DESC';
						
			 $args = array ( 
		            'post_type'      => $post_type, 
		            'orderby'        => $orderby, 
		            'order'          => $order,
		            'posts_per_page' => $posts_per_page,  
		           
		            );
			if($cat != ""){
		            	$args['tax_query'] = array( array( 'taxonomy' => 'responsive_fcgs_slider-category', 'field' => 'id', 'terms' => $cat) );
		            }        
		      $query = new WP_Query($args);

			$post_count = $query->post_count;
			$i = 1;

			if( $post_count > 0) :
			?>
			<div style="width:<?php echo $width_slider; ?>;">
				<div class="fcgs-gallery-container">
					
					<div class="swiper-button-next"></div>
					<div class="swiper-button-prev"></div>
					  <div class="swiper-container">
						  <div class="swiper-wrapper">
							  <?php								
								  while ($query->have_posts()) : $query->the_post();
									  include('designs/template.php');
									
								  $i++;
								  endwhile;									
							  ?>
						  </div>

					  </div>
				</div>	
			</div>	
			<?php
				endif;
				// Reset query to prevent conflicts
				wp_reset_query();
			?>							
			<script type="text/javascript">
				jQuery(document).ready(function ($) {
					var swiper = new Swiper('.fcgs-gallery-container .swiper-container', {
						pagination: '.swiper-pagination',
						nextButton: '.swiper-button-next',
						prevButton: '.swiper-button-prev',
						slidesPerView: <?php echo $rows_slider; ?>,
						slidesPerColumn: <?php echo $columns_slider; ?>,
						paginationClickable: false,
						autoplay: <?php echo $autoplay_intervalslider; ?>,
						spaceBetween: <?php echo $space_between_items; ?>,
						autoplayDisableOnInteraction: false,
						slidesPerGroup:1

					});
	
				});

			</script>
			<?php
			return ob_get_clean();
		}		
	}
}
	
function fcgs_master_gallery_images_load() {
        global $mfpd;
        $mfpd = new Content_Gallery_Slider();
}
add_action( 'plugins_loaded', 'fcgs_master_gallery_images_load' );
?>
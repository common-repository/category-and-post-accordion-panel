<?php 
/** 
 * Abstract class  has been designed to use common functions.
 * This is file is responsible to add custom logic needed by all templates and classes.  
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly   
if ( ! class_exists( 'categoryPostAccordionPanelLib' ) ) { 
	abstract class categoryPostAccordionPanelLib extends WP_Widget {
		
	   /**
		* Default values can be stored
		*
		* @access    public
		* @since     1.0
		*
		* @var       array
		*/
		public $_config = array();

		/**
		 * PHP5 constructor method.
		 *
		 * Run the following methods when this class is loaded.
		 * 
		 * @access    public
		 * @since     1.0
		 *
		 * @return    void
		 */ 
		public function __construct() {  
		
			/**
			 * Default values configuration 
			 */
			$this->_config = array(
				'widget_title'=>apcp_widget_title,
				'number_of_post_display'=>apcp_number_of_post_display, 
				'title_text_color'=>apcp_title_text_color,
				'category_tab_text_color'=>apcp_category_tab_text_color,
				'category_tab_background_color'=>apcp_category_tab_background_color,
				'header_text_color'=>apcp_header_text_color,
				'header_background_color'=>apcp_header_background_color,
				'display_title_over_image'=>apcp_display_title_over_image, 
				'hide_widget_title'=>apcp_hide_widget_title,
				'hide_post_title'=>apcp_hide_post_title,
				'template'=>apcp_template, 
				'vcode'=>$this->getUCode(), 
				'category_id'=>apcp_category,
				'security_key'=>apcp_security_key,
				'tp_widget_width'=>apcp_widget_width
			); 
			
			/**
			 * Load text domain
			 */
			add_action( 'plugins_loaded', array( $this, 'postaccordionpanel_text_domain' ) );
			 	
			parent::__construct( 'postaccordionpanel', __( 'Category and Post Accordion Panel', 'postaccordionpanel' ) ); 
			
			/**
			 * Widget initialization for accordion panel for category and posts
			 */
			add_action( 'widgets_init', array( &$this, 'initCategoryPostAccordionPanel' ) ); 
			
			/**
			 * Load the CSS/JS scripts
			 */
			add_action( 'init',  array( $this, 'postaccordionpanel_scripts' ) );
			
			add_action( 'admin_enqueue_scripts', array( $this, 'apcp_admin_enqueue' ) ); 
			
		}
		
		
 	   /**
		* Register and load JS/CSS for admin widget configuration 
		*
		* @access  private
		* @since   1.0
		*
		* @return  bool|void It returns false if not valid page or display HTML for JS/CSS
		*/  
		public function apcp_admin_enqueue() {

			if ( ! $this->validate_page() )
				return FALSE;
			
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_style( 'admin-postaccordionpanel.css', APCP_MEDIA."css/admin-postaccordionpanel.css" );
			wp_enqueue_script( 'admin-postaccordionpanel.js', APCP_MEDIA."js/admin-postaccordionpanel.js" ); 
			
		}

		
	   /**
		* Validate widget or shortcode post type page
		*
		* @access  private
		* @since   1.0
		*
		* @return  bool It returns true if page is post.php or widget otherwise returns false
		*/ 
		private function validate_page() {

			if ( ( isset( $_GET['post_type'] )  && $_GET['post_type'] == 'apcp_accordion' ) || strpos($_SERVER["REQUEST_URI"],"widgets.php") > 0  || strpos($_SERVER["REQUEST_URI"],"post.php" ) > 0 || strpos($_SERVER["REQUEST_URI"], "postaccordionpanel_settings" ) > 0  )
				return TRUE;
		
		} 		
		
		/**
		 * Load the CSS/JS scripts
		 *
		 * @return  void
		 *
		 * @access  public
		 * @since   1.0
		 */
		function postaccordionpanel_scripts() {

			$dependencies = array( 'jquery' );
			 
			/**
			 * Include Category and Post Accordion Panel JS/CSS 
			 */
			wp_enqueue_style( 'postaccordionpanel', APCP_MEDIA."css/postaccordionpanel.css" );
			 
			wp_enqueue_script( 'postaccordionpanel', APCP_MEDIA."js/postaccordionpanel.js", $dependencies  );
			
			/**
			 * Define global javascript variable
			 */
			wp_localize_script( 'postaccordionpanel', 'postaccordionpanel', array(
				'apcp_ajax_url' => admin_url( 'admin-ajax.php' ),
				'apcp_security'  =>  wp_create_nonce(apcp_security_key),
				'apcp_plugin_url' => plugins_url( '/', __FILE__ ),
			));
		}	
		
		/**
		 * Loads the text domain
		 *
		 * @access  private
		 * @since   1.0
		 *
		 * @return  void
		 */
		public function postaccordionpanel_text_domain() {

		  /**
		   * Load text domain
		   */
		   load_plugin_textdomain( 'postaccordionpanel', false, APCP_Plugin_DIR . '/languages' );
			
		}
		 
		/**
		 * Load and register widget settings
		 *
		 * @access  private
		 * @since   1.0
		 *
		 * @return  void
		 */ 
		public function initCategoryPostAccordionPanel() { 
			
		  /**
		   * Widget registration
		   */ 
			register_widget( 'categoryPostAccordionPanelWidget_Admin' );
			
		}     
		 
		/**
		 * Get post image by given image attachment id
		 *
 		 * @access  public
		 * @since   1.0
		 *
		 * @param   int   $img  Image attachment ID
		 * @return  string  Returns image html from post attachment
		 */
		 public function getPostImage( $img ) {
		 
			$image_link = wp_get_attachment_url( $img ); 
			if( $image_link ) {
				$image_title = esc_attr( get_the_title( $img ) );  
				return wp_get_attachment_image( $img , array(180,180), 0, $attr = array(
									'title'	=> $image_title,
									'alt'	=> $image_title
								) );
			}else{
				return "<img src='".APCP_MEDIA."images/no-img.png' />";
			}
			
		 }
		 
		/**
		 * Get all the categories
		 *
		 * @access  public
		 * @since   1.0
		 *
		 * @return  object It contains all the categories for shop
		 */
		public function getCategories($category_ids = "") {
		
			global $wpdb;
			
			/**
			 * Fetch all the categories from database
			 */
			$_id_filter = "";
			
			if( trim( $category_ids ) != "" && trim( $category_ids ) != "0" ) {
					$category_ids = explode(",", $category_ids);
					$__ids = "";
					$ol = 0;
					foreach( $category_ids as $__val ) {
						if($ol==0)
							$__ids .= intval($__val);
						else
							$__ids .= ", ".intval($__val);
						
						$ol++;	
					}
					$_id_filter =  " where wtt.term_id in ( ".$__ids." ) " ;
			}
			
			return $wpdb->get_results( "SELECT wtt.term_taxonomy_id as id, wt.name as category FROM `{$wpdb->prefix}terms` as wt INNER JOIN {$wpdb->prefix}term_taxonomy as wtt on wtt.term_id = wt.term_id and wtt.taxonomy = 'category' ".$_id_filter );
		
		}
		 
		/**
		 * Get Unique Block ID
		 *
		 * @access  public
		 * @since   1.0
		 *
		 * @return  string 
		 */
		public function getUCode() { 
			
			return 'uid_'.md5( "TABULARPANE32@#RPSDD@SQSITARAM@A$".time() );
		
		} 
		
		/**
		 * Get Category and Post Accordion Panel Template
		 *
		 * @access  public
		 * @since   1.0
		 *
		 * @param   string $file Template file name
		 * @return  string Returns template file path
		 */
		public function getCategoryPostAccordionPanelTemplate( $file ) {
			
			if( locate_template( $file ) != "" ){
				return locate_template( $file );
			}else{
				return plugin_dir_path( dirname( __FILE__ ) ) . 'templates/' . $file ;
			} 
				
	   }
   }
}
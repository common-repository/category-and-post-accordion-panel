<?php 
/*
  Plugin Name: Category and Post Accordion Panel
  Description: Category and Post Accordion Panel
  Author: ikhodal team
  Plugin URI: http://www.ikhodal.com/wp-category-and-post-accordion-panel/
  Author URI: http://www.ikhodal.com/wp-category-and-post-accordion-panel/
  Version: 2.0
  License: GNU General Public License v2.0
  License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/ 
  
  
//////////////////////////////////////////////////////
// Defines the constants for use within the plugin. //
////////////////////////////////////////////////////// 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly  
/**
* Widget/Block Title
*/
define( 'apcp_widget_title', __( 'Category & Post View', 'postaccordionpanel') );
 
/**
* Default category selection for fist post load in widget
*/
define( 'apcp_category', '0' );

/**
* Number of posts per next loading result
*/
define( 'apcp_number_of_post_display', '2' ); 
 
/**
* Category tab text color 
*/
define( 'apcp_category_tab_text_color', '#000' );

/**
* Post title text color
*/
define( 'apcp_title_text_color', '#000' );

/**
* Category tab background color
*/
define( 'apcp_category_tab_background_color', '#f7f7f7' );

/**
* Widget/block header text color
*/
define( 'apcp_header_text_color', '#fff' );

/**
* Widget/block header text background color
*/
define( 'apcp_header_background_color', '#00bc65' );

/**
* Display post title and text over post image
*/
define( 'apcp_display_title_over_image', 'no' );

/**
* Widget/block width
*/
define( 'apcp_widget_width', '100%' );  

/**
* Hide/Show widget title
*/
define( 'apcp_hide_widget_title', 'no' ); 

/**
* Template for widget/block
*/
define( 'apcp_template', 'pane_style_1' ); 

/**
* Hide/Show post title
*/
define( 'apcp_hide_post_title', 'no' );  

/**
* Security key for block id
*/
define( 'apcp_security_key', 'APCP_#s@R$@ASI#TA(!@@21M3' );
 
/**
*  Assets for accordion panel for category and posts
*/
$apcp_plugins_url = plugins_url( "/assets/", __FILE__ );

define( 'APCP_MEDIA', $apcp_plugins_url ); 

/**
*  Plugin DIR
*/
$apcp_plugin_DIR = plugin_basename(dirname(__FILE__));

define( 'APCP_Plugin_DIR', $apcp_plugin_DIR ); 
 
/**
 * Include abstract class for common methods
 */
require_once 'include/abstract.php';


///////////////////////////////////////////////////////
// Include files for widget and shortcode management //
///////////////////////////////////////////////////////

/**
 * Admin panel widget configuration
 */ 
require_once 'include/admin.php';
 
/**
 * Load Category and Post Accordion Panel on frontent pages
 */
require_once 'include/postaccordionpanel.php';  
 
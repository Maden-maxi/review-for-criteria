<?php
/**
 * Review for criteria.
 *
 * @package   Review_For_Criteria_Metaboxes
 * @author    Your Company
 * @license   GPL-2.0+
 * @link      http://yourcompany.com
 * @copyright 2018 Your Company
 */

/**
 *-----------------------------------------
 * Do not delete this line
 * Added for security reasons: http://codex.wordpress.org/Theme_Development#Template_Files
 *-----------------------------------------
 */
defined('ABSPATH') or die("Direct access to the script does not allowed");
/*-----------------------------------------*/

/**
 * Register Metaboxes for custom post types
 */
new Review_For_Criteria_Metaboxes;
class Review_For_Criteria_Metaboxes
{

	/**
	 * Entries custom post type slug
	 *
	 * @since 0.0.0
	 *
	 * @var string
	 */

	private $entries_slug = 'entries';

	public $entries_meta_prefix = 'entry_';
    public $entries_meta = array(
    	'address' => array(
    		'label' => 'Address',
		    'icon'  => 'building',
		    'type'  => 'text'
	    ),
	    'website' => array(
		    'label' => 'Website',
		    'icon'  => 'paperclip',
		    'type'  => 'url'
	    ),
	    'hours'   => array(
		    'label' => 'Hours',
		    'icon'  => 'clock',
		    'type'  => 'text'
	    )
    );
	/**
	 * Reviews custom post type slug
	 *
	 * @since 0.0.0
	 *
	 * @var string
	 */

	private $reviews_slug = 'reviews';

	/**
	 * Review_For_Criteria_Metaboxes constructor.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_metabox' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}

	public function add_metabox() {
		add_meta_box(
			'box_additional_info',
			__('Additional info', RFC_PLUGIN_DOMAIN),
			array( $this, 'render_metabox' ),
			$this->entries_slug,
			'advanced',
			'high'
		);
	}


	public function render_metabox( $post ) {
		wp_nonce_field( 'box_additional_info', 'box_additional_info_nonce' );
		require_once RFC_PLUGIN_PATH . 'includes/admin/views/metaboxes/additional-info.php';
	}

	/**
	 * Save data in save post action
	 *
	 * @param $post_id
	 * @return mixed
	 */
	public function save( $post_id ) {
		if ( ! isset( $_POST['box_additional_info_nonce'] ) )
			return $post_id;
		$nonce = $_POST['box_additional_info_nonce'];
		if ( ! wp_verify_nonce( $nonce, 'box_additional_info' ) )
			return $post_id;
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;
		foreach ( $this->entries_meta as $key => $field )
			$this->save_field($post_id , $this->entries_meta_prefix . $key);
	}
	/**
	 * Save field value
	 *
	 * @param $post_id int
	 * @param $name string
	 */
	public function save_field( $post_id, $name ){
		$data =  $_POST[$name] ;
		update_post_meta( $post_id, '_' . $name, $data );
	}


}
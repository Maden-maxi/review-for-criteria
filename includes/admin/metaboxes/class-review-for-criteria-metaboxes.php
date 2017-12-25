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
	private $reviews_meta_prefix = 'review_';
	private $reviews_meta_storage = array(
		'storage_label' => array(
			'label' => 'Storage',
			'icon'  => 'building',
			'type'  => 'text'
		),
		'storage_value' => array(
			'label' => '',
			'icon' => '',
			'type' => 'hidden'
		),
	);
	private $reviews_meta_tabs = array(
		'facilities' => array(
			'label' => 'Facilities'
		),
		'locations' => array(
			'label' => 'Locations'
		),
		'price' => array(
			'label' => 'Price'
		),
		'transportation' => array(
			'label' => 'Transportation'
		),
	);
	private $criteria;
	private $criteria_prefix = 'criteria_';
	private $criteria_overall = 'overall';
	/**
	 * Review_For_Criteria_Metaboxes constructor.
	 */
	public function __construct() {
		$this->criteria = get_option('review_for_criteria_options') ? json_decode(get_option('review_for_criteria_options')) : [];
		add_action( 'add_meta_boxes', array( $this, 'add_metabox' ) );
		add_action( 'save_post', array( $this, 'save_storage' ) );
		add_action( 'save_post', array( $this, 'save_review' ) );
		add_action( 'admin_enqueue_scripts', array($this, 'assets_admin') );
		add_action( 'wp_enqueue_scripts', array($this, 'assets_public') );

	}

	public function assets_admin($slug) {
		$post_type = get_post_type();

		if ($slug === 'post.php' || $slug === 'post-new.php') {

			if ($post_type === 'entries') {
				wp_enqueue_style(RFC_PLUGIN_DOMAIN . '-star-rating', RFC_PLUGIN_URL . '.assets/star-rating.css');
			}

			if ($post_type === 'reviews') {
				wp_enqueue_style(
					RFC_PLUGIN_DOMAIN . '-reviews',
					RFC_PLUGIN_URL . 'includes/admin/assets/css/admin-review.css'
				);

				wp_enqueue_style(RFC_PLUGIN_DOMAIN . '-star-rating', RFC_PLUGIN_URL . '.assets/star-rating.css');

				wp_enqueue_script(
					RFC_PLUGIN_DOMAIN .'-reviews',
					RFC_PLUGIN_URL . 'includes/admin/assets/js/admin-review.js',
					array('jquery', 'jquery-ui-autocomplete', 'jquery-ui-tabs'),
					'0.0.0',
					true
				);
				wp_localize_script(RFC_PLUGIN_DOMAIN .'-reviews', 'rfc_reviews', array(
					'ajaxurl' => admin_url('admin-ajax.php'),
					'security' => wp_create_nonce('reviews')
				));
			}

		}

	}
	public function assets_public() {
		wp_enqueue_style(RFC_PLUGIN_DOMAIN . '-star-rating', RFC_PLUGIN_URL . '.assets/star-rating.css');
	}

	public function add_metabox() {
		add_meta_box(
			'box_additional_info',
			__('Additional info', RFC_PLUGIN_DOMAIN),
			array( $this, 'render_entry_metabox' ),
			$this->entries_slug,
			'advanced',
			'high'
		);

		add_meta_box(
			'box_review_criteria',
			__( 'Review criteria', RFC_PLUGIN_DOMAIN ),
			array( $this, 'render_review_metabox' ),
			$this->reviews_slug,
			'advanced',
			'high'
		);
	}


	public function render_entry_metabox( $post ) {
		wp_nonce_field( 'box_additional_info', 'box_additional_info_nonce' );
		require_once RFC_PLUGIN_PATH . 'includes/admin/views/metaboxes/additional-info.php';
	}
	public function render_review_metabox( $post ) {
		wp_nonce_field( 'box_review_criteria', 'box_review_criteria_nonce' );
		require_once RFC_PLUGIN_PATH . 'includes/admin/views/metaboxes/review-criteria.php';
	}

	/**
	 * Save data in save post action
	 *
	 * @param $post_id
	 * @return mixed
	 */
	public function save_storage( $post_id ) {
		// entry
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
	public function save_review( $post_id ) {
		// review
		if ( ! isset( $_POST['box_review_criteria_nonce'] ) )
			return $post_id;
		$nonce = $_POST['box_review_criteria_nonce'];
		if ( ! wp_verify_nonce( $nonce, 'box_review_criteria' ) )
			return $post_id;
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;
		foreach ( $this->reviews_meta_storage as $key => $field )
			$this->save_field($post_id , $this->reviews_meta_prefix . $key);
		foreach ( $this->reviews_meta_tabs as $key => $field )
			$this->save_field($post_id , $this->reviews_meta_prefix . $key);
		foreach ( $this->criteria as $field ) {
			$key = $this->criteria_prefix . str_replace(' ', '_', trim( strtolower($field->criteria) ));
			$this->save_field($post_id , $key);
		}

		$this->save_field($post_id , $this->criteria_prefix . $this->criteria_overall);
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
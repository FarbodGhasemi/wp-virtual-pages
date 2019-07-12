<?php 

/**
 * Plugin Name: Wordpress Virtual Pages
 * Description: Creates Virtual Pages that don't show up in the Pages menu inside the Dashboard
 * Version: 1.0
 * Author: Farbod Ghasemi<farbod.ghasemi762@hotmail.com>
 *	
 */

if ( !class_exists( 'VirtualPage' ) ) {
	class VirtualPage {

		/**
		 * @var String
		 *
		 * The slug of the virtual page
		 */
		public $slug;

		/**
		 * @var String
		 *
		 * Path to the template file of the virtual page
		 */
		public $template;

		/**
		 * @var Array
		 *
		 * Array of the Scripts and Styles to Enqueue into the Virtual Page
		 */
		public $scripts;
		
		/**
		 * Sets the Class Variables
		 * @param string $slug 
		 * @param string $templateFile 
		 * @param array $scriptsArr 
		 * @return void
		 */
		public function __construct( $slug, $templateFile, $scriptsArr = [] ) {
			$this->slug = $slug;
			$this->template = $templateFile;
			$this->scripts = $scriptsArr;
		}

		/**
		 * Add the virutal Page into the Wordpress registered urls
		 * @return void
		 */
		private function set_action() {
			add_action( 'init', function() {
				
				$url = $_SERVER['REQUEST_URI'];
				$slug = $this->slug;
				$pattern = "/^.*\/($slug){1}?(\?(.*)|\/(.*))?$/";
				preg_match($pattern, $url, $matches);
				if (isset($matches[1]) && $matches[1] == $slug ) {
					global $wp_query;
					
					set_query_var( 'page_name', $slug );
					$wp_query->is_page = true;
					
					$this->enqueue_scripts();
					
					$load = locate_template($this->template, true);
					if ($load) {
						exit(); 
					}
				}
			});
		}

		/**
		 * Enqueue the Scripts and Styles into the virtual Page
		 * @return type
		 */
		private function enqueue_scripts() {
			foreach ($this->scripts as $handle => $data) {
				wp_enqueue_script($handle, $data['url'], $data['dependencies']);
				if( isset( $data['localize'] ) && !empty( $data['localize'] ) ) {
					wp_localize_script( 
						$handle, 
						$data['localize']['name'],
						$data['localize']['data'] 
					);
				}
			}
		}

		/**
		 * Initialize the Virtual Page
		 */
		public function init() {
			$this->set_action();
		}
	}
}
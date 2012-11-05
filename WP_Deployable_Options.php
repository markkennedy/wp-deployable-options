<?php
class WP_Deployable_Options {
	public function __construct() {
	}

	public function init() {
		if(defined('WP_DEPLOYABLE_OPTIONS_JSON') && self::has_not_already_initialized()) {
			$json = json_decode(WP_DEPLOYABLE_OPTIONS_JSON);
			$this->add_filters_for_options($json);
		}
		self::$has_initialized = true;
	}

	private function add_filters_for_options($json) {
		foreach($json as $section) {
			foreach ($section as $option_name => $value) {
				$filter = 'pre_option_' . $option_name;
				$callback = function() use($value) { return $value; };
				add_filter($filter, $callback);
			}
		}
	}

	private static $has_initialized;

	private static function has_not_already_initialized() {
		return !self::$has_initialized;
	}
}
<?php
class Olsen_Data_Upgrade_Log {
	private $option_name;
	private $debug = false;

	public $default_message = '';
	public $current_message = '';

	public function __construct( $option_name, $default_message = '', $debug = false ) {
		$this->option_name     = $option_name;
		$this->debug           = (bool) $debug;
		$this->default_message = $default_message;
		$this->current_message = get_option( $this->option_name );
	}

	public function get() {
		return $this->current_message;
	}

	public function set( $message ) {
		if ( $this->current_message !== $message ) {
			$this->current_message = $message;
			update_option( $this->option_name, wp_kses_post( $this->current_message ) );
		}
	}

	public function reset() {
		$this->set( $this->default_message );
	}

	public function debug( $message ) {
		if ( $this->debug && defined( 'WP_DEBUG' ) && true === (bool) WP_DEBUG ) {
			error_log( $message );
		}
	}

	public function clear() {
		if ( $this->current_message ) {
			$this->current_message = '';
			delete_option( $this->option_name );
		}
	}
}

<?php
class Olsen_Data_Upgrade_Background_Process extends Olsen_WP_Background_Process {
	/**
	 * Prefix
	 *
	 * (default value: 'wp')
	 *
	 * @var string
	 * @access protected
	 */
	protected $prefix = 'olsen';

	/**
	 * @var string
	 */
	protected $action = 'theme_upgrade_process';

	/**
	 * @var Olsen_Data_Upgrade
	 */
	protected $parent;

	/**
	 * @var string
	 */
	protected $db_version;

	public function __construct( Olsen_Data_Upgrade $parent ) {
		parent::__construct();

		$this->parent = $parent;
	}

	/**
	 * Task
	 *
	 * Override this method to perform any actions required on each
	 * queue item. Return the modified item for further processing
	 * in the next pass through. Or, return false to remove the
	 * item from the queue.
	 *
	 * @param mixed $item Queue item to iterate over
	 *
	 * @return mixed
	 */
	protected function task( $item ) {
		$callback     = $item['callback'];
		$this_version = $item['this_version'];
		$next_version = $item['next_version'];

		$this->parent->log->debug( sprintf( 'Olsen_Upgrade - Data upgrade task received. Callback: %s Version: %s Next Version: %s', $callback, $this_version, $next_version ) );

		$repeat = false;

		if ( is_callable( $callback ) ) {
			$callback_result  = call_user_func( $callback, $this->parent->log, $this_version, $next_version );
			$this->db_version = $next_version;

			if ( $callback_result ) {
				$repeat = true;
			}
		}

		$repeat_text = $repeat ? 'true' : 'false';
		$this->parent->log->debug( sprintf( 'Olsen_Upgrade - Done processing task. Will repeat: %s Callback: %s Version: %s Next Version: %s',
			$repeat ? 'true' : 'false',
			$callback,
			$this_version,
			$next_version
		) );

		if ( $repeat ) {
			return $item;
		}

		return false;
	}

	/**
	 * Complete
	 *
	 * Override if applicable, but ensure that the below actions are
	 * performed, or, call parent::complete().
	 */
	protected function complete() {
		parent::complete();

		$this->parent->set_db_version( $this->db_version );
		$this->parent->set_is_upgrading( false );
	}

	public function is_queue_empty() {
		return parent::is_queue_empty();
	}
}

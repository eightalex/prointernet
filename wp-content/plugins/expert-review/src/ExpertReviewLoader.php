<?php

namespace Wpshop\ExpertReview;

use Wpshop\ExpertReview\Settings\ExpertOptions;

class ExpertReviewLoader {

	public function init() {
		$this->setup_ajax();

		do_action( __METHOD__, $this );
	}

	/**
	 * @return void
	 */
	protected function setup_ajax() {
		if ( is_admin() ) {
			add_action( 'wp_ajax_expert_review_load_experts', [ $this, '_load_experts' ] );
			add_action( 'wp_ajax_expert_review_load_users', [ $this, '_load_users' ] );
		}
	}

	/**
	 * @return void
	 */
	public function _load_experts() {
		if ( ! wp_verify_nonce( $_REQUEST['nonce'], 'wpshop-nonce' ) ) {
			wp_send_json_error( [ 'message' => 'Forbidden' ] );
		}

		$options = new ExpertOptions();
		if ( $options->experts ) {
			wp_send_json_success( [ 'items' => json_decode( $options->experts, true ) ] );
		}
		wp_send_json_success( [ 'items' => [] ] );
	}

	/**
	 * @return void
	 */
	public function _load_users() {
		if ( ! wp_verify_nonce( $_REQUEST['nonce'], 'wpshop-nonce' ) ) {
			wp_send_json_error( [ 'message' => 'Forbidden' ] );
		}

		$result = [];
		/** @var \WP_User $user */
		foreach ( $users = get_users() as $user ) {
			$result[] = [
				'id'   => $user->ID,
				'name' => $user->display_name,
			];
		}

		wp_send_json_success( [ 'items' => $result ] );
	}
}

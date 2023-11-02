<?php

namespace Wpshop\ExpertReview;

use Wpshop\ExpertReview\Settings\ExpertOptions;

class Shortcodes {

	/**
	 * @var Plugin
	 */
	protected $plugin;

	/**
	 * Shortcodes constructor.
	 *
	 * @param Plugin $plugin
	 */
	public function __construct( Plugin $plugin ) {
		$this->plugin = $plugin;
	}

	/**
	 * @return void
	 */
	public function init() {
		if ( $this->plugin->verify() ) {
			add_shortcode( 'expert_review', [ $this, '_expert_review' ] );
		}

		do_action( __METHOD__, $this );
	}

	/**
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	public function _expert_review( $atts, $content = '' ) {
		$atts = shortcode_atts( [
			'color'                     => '',
			'expert_type'               => 'self',
			'expert_id'                 => 0,
			'expert_avatar'             => '',
			'expert_name'               => '',
			'expert_description'        => '',
			'expert_text'               => '',
			'expert_show_button'        => 1, // задать вопрос
			'expert_title'              => '',
			'expert_show_title'         => 0,
			'qa_data'                   => '',
			'qa_title'                  => 'Питання експерту',      // todo перевод
			'qa_show_title'             => 1,
			'qa_type'                   => 'popup',
			'score_data'                => '',
			'score_summary_text'        => '',
			'score_max'                 => 5,                       // todo перенести в настройки
			'score_summary_average'     => 1,
			'pluses_minuses_title'      => __( 'Плюси & Мінуси', Plugin::TEXT_DOMAIN ),  // todo перевод
			'pluses_minuses_show_title' => 1,
			'pluses'                    => '',
			'minuses'                   => '',
		], $atts, 'expert_review' );

		$out = '';

		$expert_name        = '';
		$expert_description = '';
		$expert_avatar      = '';

		switch ( $atts['expert_type'] ) {
			case 'self':
				break;
			case 'user_id':
				if ( $user = get_userdata( $atts['expert_id'] ) ) {
					$atts['expert_name']   = $user->display_name;
					$atts['expert_avatar'] = get_avatar_url( $user->ID );
					if ( ! $atts['expert_description'] ) {
						$atts['expert_description'] = $user->user_description;
					}
				}
				break;
			case 'expert_id':
				$options = new ExpertOptions();
				if ( $item = $options->get_by_id( $atts['expert_id'] ) ) {
					$atts['expert_avatar'] = $item['avatar'];
					$atts['expert_name']   = $item['name'];
					if ( ! $atts['expert_description'] ) {
						$atts['expert_description'] = $item['description'];
					}
				}
				break;
			default:
				break;
		}


		/**
		 * Expert
		 */
		if (
			! empty( $atts['expert_name'] ) ||
			! empty( $atts['expert_text'] ) ||
			! empty( $atts['expert_id'] ) ||
			! empty( $atts['expert_user_id'] ) ) {

			// todo user id, expert id check

			if ( ! empty( $atts['expert_name'] ) ) {
				$expert_name = $atts['expert_name'];
			}
			if ( ! empty( $atts['expert_description'] ) ) {
				$expert_description = html_entity_decode( $atts['expert_description'] );
			}
			if ( ! empty( $atts['expert_avatar'] ) ) {
				$expert_avatar = '<img src="' . $atts['expert_avatar'] . '" alt="' . $expert_name . '">';
			}

			$out .= '<div class="expert-review-expert">';

			if ( ! empty( $atts['expert_title'] ) && $atts['expert_show_title'] == 1 ) {
				$out .= '<div class="expert-review-expert-header">' . html_entity_decode( $atts['expert_title'] ) . '</div>';
			}

			$out .= '  <div class="expert-review-expert-bio">';
			$out .= '    <div class="expert-review-expert-bio__avatar">';
			if ( ! empty( $expert_avatar ) ) {
				$out .= $expert_avatar;
			}
			$out .= '    </div>';
			$out .= '    <div class="expert-review-expert-bio__body">';
			$out .= '      <div class="expert-review-expert-bio-name">' . $expert_name . '</div>';
			$out .= '      <div class="expert-review-expert-bio-description">' . $expert_description . '</div>';
			$out .= '    </div>';
			$out .= '    <div class="expert-review-expert-bio__button">';

			$button_settings = esc_attr( json_encode( [
				'type'       => $atts['qa_type'],
				'expertType' => $atts['expert_type'],
				'expertId'   => $atts['expert_id'],
			] ) );
			$out             .= '      <span class="expert-review-button js-expert-review-button" data-settings="' . $button_settings . '">Задати питання</span>';
			$out             .= '    </div>';
			$out             .= '  </div>';

			if ( ! empty( $atts['expert_text'] ) ) {
				$out .= '  <div class="expert-review-expert-text">';
				$out .= '  ' . html_entity_decode( $atts['expert_text'] );
				$out .= '  </div>';
			}

			$out .= '</div>';
		}


		/**
		 * Questions and Answers
		 */
		if ( ! empty( $atts['qa_data'] ) ) {
			$out .= '<div class="expert-review-qa">';

			if ( ! empty( $atts['qa_title'] ) && $atts['qa_show_title'] == 1 ) {
				$out .= '<div class="expert-review-qa-header">' . html_entity_decode( $atts['qa_title'] ) . '</div>';
			}

			$qas             = [];
			$prepare_qa_data = explode( ';;', $atts['qa_data'] );

			foreach ( $prepare_qa_data as $prepare_qa_line ) {
				if ( strpos( $prepare_qa_line, '::' ) ) {
					$prepare_qa = explode( '::', $prepare_qa_line );

					$qas[] = [
						'q' => html_entity_decode( $prepare_qa[0] ),
						'a' => html_entity_decode( ( ! empty( $prepare_qa[1] ) ) ? $prepare_qa[1] : '' ),
					];
				}
			}

			foreach ( $qas as $qa ) {
				$out .= '<div class="expert-review-qa-container">';
				$out .= '  <div class="expert-review-qa__question">' . $qa['q'] . '</div>';
				$out .= '  <div class="expert-review-qa__answer">';
				$out .= '    <div class="expert-review-qa__avatar">' . $expert_avatar . '</div>';
				$out .= '    <div class="expert-review-qa__text">' . $qa['a'] . '</div>';
				$out .= '  </div>';
				$out .= '</div>';
			}

			$out .= '</div><!--.expert-review-qa-->';
		}


		/**
		 * Score
		 */
		if ( ! empty( $atts['score_data'] ) ) {

			$score_data = [];
			$score_avg  = 0;

			$prepare_data = explode( ';;', $atts['score_data'] );
			foreach ( $prepare_data as $prepare_line ) {
				if ( strpos( $prepare_line, '::' ) ) {
					$prepare_score = explode( '::', $prepare_line );
					if ( ! empty( $prepare_score[1] ) ) {
						$prepare_score[1] = str_replace( ',', '.', $prepare_score[1] );
						$score_data[]     = [
							'name'  => html_entity_decode( trim( $prepare_score[0] ) ),
							'score' => (float) $prepare_score[1],
						];
						$score_avg        += (float) $prepare_score[1];
					}
				}
			}

			if ( ! empty( $score_data ) ) {
				$score_avg = round( $score_avg / count( $score_data ), 1 );

				$out .= '<div class="expert-review-score">';
				foreach ( $score_data as $score_item ) {

					$score_percent = ceil( ( $score_item['score'] * 100 ) / $atts['score_max'] );

					$out .= '<div class="expert-review-score-line">';
					$out .= '  <div class="expert-review-score-line__name">' . $score_item['name'] . '</div>';
					$out .= '  <div class="expert-review-score-line__progress"><div class="expert-review-score-line__progress-container"><div class="expert-review-score-line__progress-fill" style="width: ' . $score_percent . '%;"></div></div></div>';
					$out .= '  <div class="expert-review-score-line__score">' . $score_item['score'] . '</div>';
					$out .= '</div>';
				}
				if ( ! empty( $atts['score_summary_text'] ) || ( $atts['score_summary_average'] == 1 && count( $score_data ) > 1 ) ) {
					$out .= '<div class="expert-review-score-summary">';
					$out .= '  <div class="expert-review-score-summary__label">Результат</div>'; // todo перевод
					$out .= '  <div class="expert-review-score-summary__content">';

					if ( $atts['score_summary_average'] == 1 ) {
						$out .= '    <div class="expert-review-score-summary__average">' . $score_avg . '</div>';
					}

					if ( ! empty( $atts['score_summary_text'] ) ) {
						$out .= '    <div class="expert-review-score-summary__text">' . html_entity_decode( $atts['score_summary_text'] ) . '</div>';
					}

					$out .= '  </div>';
					$out .= '</div>';
				}
				$out .= '</div>';
			}
		}


		/**
		 * Pluses and minuses
		 */
		$pluses  = [];
		$minuses = [];
		if ( ! empty( $atts['pluses'] ) ) {
			$prepare_pluses = explode( ';;', $atts['pluses'] );
			foreach ( $prepare_pluses as $prepare_plus ) {
				$prepare_plus = trim( $prepare_plus );
				if ( ! empty( $prepare_plus ) ) {
					$pluses[] = html_entity_decode( $prepare_plus );
				}
			}
		}
		if ( ! empty( $atts['minuses'] ) ) {
			$prepare_minuses = explode( ';;', $atts['minuses'] );
			foreach ( $prepare_minuses as $prepare_minus ) {
				$prepare_minus = trim( $prepare_minus );
				if ( ! empty( $prepare_minus ) ) {
					$minuses[] = html_entity_decode( $prepare_minus );
				}
			}
		}
		if ( ! empty( $pluses ) || ! empty( $minuses ) ) {
			$out .= '<div class="expert-review-pluses-minuses">';

			if ( ! empty( $atts['pluses_minuses_title'] ) && $atts['pluses_minuses_show_title'] == 1 ) {
				$out .= '<div class="expert-review-pluses-minuses-header">' . html_entity_decode( $atts['pluses_minuses_title'] ) . '</div>';
			}

			if ( ! empty( $pluses ) ) {
				$out .= '<div class="expert-review-pluses">';
				foreach ( $pluses as $plus ) {
					$out .= '<div class="expert-review-plus">' . $plus . '</div>';
				}
				$out .= '</div>';
			}

			if ( ! empty( $minuses ) ) {
				$out .= '<div class="expert-review-minuses">';
				foreach ( $minuses as $minus ) {
					$out .= '<div class="expert-review-minus">' . $minus . '</div>';
				}
				$out .= '</div>';
			}

			$out .= '</div>';
		}

		$classes = [];
		if ( ! empty( $atts['color'] ) ) {
			$classes[] = 'expert-review--color-' . $atts['color'];
		}
		$classes = ' ' . implode( ',', $classes );

		$out = '<div class="expert-review' . $classes . '">' . $out . '</div>';

		return $out;
	}
}

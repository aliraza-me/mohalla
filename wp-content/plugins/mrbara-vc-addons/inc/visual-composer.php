<?php
/**
 * Custom functions for Visual Composer
 *
 * @package    mrbara
 * @subpackage Visual Composer
 */

if ( ! function_exists( 'is_plugin_active' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

/**
 * Class fos_VC
 *
 * @since 1.0.0
 */
class MrBara_VC {
	/**
	 * List of available icons
	 *
	 * @var array
	 */
	public $icons;

	/**
	 * Construction
	 */
	function __construct() {
		// Stop if VC is not installed
		if ( ! is_plugin_active( 'js_composer/js_composer.php' ) ) {
			return false;
		}

		$this->icons = self::get_icons();

		if ( function_exists( 'vc_add_shortcode_param' ) ) {

			vc_add_shortcode_param( 'icon', array(
				$this,
				'icon_param',
			), MRBARA_ADDONS_URL . '/assets/js/vc/icon-field.js' );

		} elseif ( function_exists( 'add_shortcode_param' ) ) {

			add_shortcode_param( 'icon', array(
				$this,
				'icon_param',
			), MRBARA_ADDONS_URL . '/assets/js/vc/icon-field.js' );

		} else {
			return false;
		}

		add_action( 'init', array( $this, 'map_shortcodes' ), 20 );
	}

	/**
	 * Define icon classes
	 *
	 * @since  1.0.0
	 *
	 * @return array
	 */
	public static function get_icons() {
		$icons_ionicons     = array(
			'ion-alert',
			'ion-alert-circled',
			'ion-android-add',
			'ion-android-add-circle',
			'ion-android-alarm-clock',
			'ion-android-alert',
			'ion-android-apps',
			'ion-android-archive',
			'ion-android-arrow-back',
			'ion-android-arrow-down',
			'ion-android-arrow-dropdown',
			'ion-android-arrow-dropdown-circle',
			'ion-android-arrow-dropleft',
			'ion-android-arrow-dropleft-circle',
			'ion-android-arrow-dropright',
			'ion-android-arrow-dropright-circle',
			'ion-android-arrow-dropup',
			'ion-android-arrow-dropup-circle',
			'ion-android-arrow-forward',
			'ion-android-arrow-up',
			'ion-android-attach',
			'ion-android-bar',
			'ion-android-bicycle',
			'ion-android-boat',
			'ion-android-bookmark',
			'ion-android-bulb',
			'ion-android-bus',
			'ion-android-calendar',
			'ion-android-call',
			'ion-android-camera',
			'ion-android-cancel',
			'ion-android-car',
			'ion-android-cart',
			'ion-android-chat',
			'ion-android-checkbox',
			'ion-android-checkbox-blank',
			'ion-android-checkbox-outline',
			'ion-android-checkbox-outline-blank',
			'ion-android-checkmark-circle',
			'ion-android-clipboard',
			'ion-android-close',
			'ion-android-cloud',
			'ion-android-cloud-circle',
			'ion-android-cloud-done',
			'ion-android-cloud-outline',
			'ion-android-color-palette',
			'ion-android-compass',
			'ion-android-contact',
			'ion-android-contacts',
			'ion-android-contract',
			'ion-android-create',
			'ion-android-delete',
			'ion-android-desktop',
			'ion-android-document',
			'ion-android-done',
			'ion-android-done-all',
			'ion-android-download',
			'ion-android-drafts',
			'ion-android-exit',
			'ion-android-expand',
			'ion-android-favorite',
			'ion-android-favorite-outline',
			'ion-android-film',
			'ion-android-folder',
			'ion-android-folder-open',
			'ion-android-funnel',
			'ion-android-globe',
			'ion-android-hand',
			'ion-android-hangout',
			'ion-android-happy',
			'ion-android-home',
			'ion-android-image',
			'ion-android-laptop',
			'ion-android-list',
			'ion-android-locate',
			'ion-android-lock',
			'ion-android-mail',
			'ion-android-map',
			'ion-android-menu',
			'ion-android-microphone',
			'ion-android-microphone-off',
			'ion-android-more-horizontal',
			'ion-android-more-vertical',
			'ion-android-navigate',
			'ion-android-notifications',
			'ion-android-notifications-none',
			'ion-android-notifications-off',
			'ion-android-open',
			'ion-android-options',
			'ion-android-people',
			'ion-android-person',
			'ion-android-person-add',
			'ion-android-phone-landscape',
			'ion-android-phone-portrait',
			'ion-android-pin',
			'ion-android-plane',
			'ion-android-playstore',
			'ion-android-print',
			'ion-android-radio-button-off',
			'ion-android-radio-button-on',
			'ion-android-refresh',
			'ion-android-remove',
			'ion-android-remove-circle',
			'ion-android-restaurant',
			'ion-android-sad',
			'ion-android-search',
			'ion-android-send',
			'ion-android-settings',
			'ion-android-share',
			'ion-android-share-alt',
			'ion-android-star',
			'ion-android-star-half',
			'ion-android-star-outline',
			'ion-android-stopwatch',
			'ion-android-subway',
			'ion-android-sunny',
			'ion-android-sync',
			'ion-android-textsms',
			'ion-android-time',
			'ion-android-train',
			'ion-android-unlock',
			'ion-android-upload',
			'ion-android-volume-down',
			'ion-android-volume-mute',
			'ion-android-volume-off',
			'ion-android-volume-up',
			'ion-android-walk',
			'ion-android-warning',
			'ion-android-watch',
			'ion-android-wifi',
			'ion-aperture',
			'ion-archive',
			'ion-arrow-down-a',
			'ion-arrow-down-b',
			'ion-arrow-down-c',
			'ion-arrow-expand',
			'ion-arrow-graph-down-left',
			'ion-arrow-graph-down-right',
			'ion-arrow-graph-up-left',
			'ion-arrow-graph-up-right',
			'ion-arrow-left-a',
			'ion-arrow-left-b',
			'ion-arrow-left-c',
			'ion-arrow-move',
			'ion-arrow-resize',
			'ion-arrow-return-left',
			'ion-arrow-return-right',
			'ion-arrow-right-a',
			'ion-arrow-right-b',
			'ion-arrow-right-c',
			'ion-arrow-shrink',
			'ion-arrow-swap',
			'ion-arrow-up-a',
			'ion-arrow-up-b',
			'ion-arrow-up-c',
			'ion-asterisk',
			'ion-at',
			'ion-backspace',
			'ion-backspace-outline',
			'ion-bag',
			'ion-battery-charging',
			'ion-battery-empty',
			'ion-battery-full',
			'ion-battery-half',
			'ion-battery-low',
			'ion-beaker',
			'ion-beer',
			'ion-bluetooth',
			'ion-bonfire',
			'ion-bookmark',
			'ion-bowtie',
			'ion-briefcase',
			'ion-bug',
			'ion-calculator',
			'ion-calendar',
			'ion-camera',
			'ion-card',
			'ion-cash',
			'ion-chatbox',
			'ion-chatbox-working',
			'ion-chatboxes',
			'ion-chatbubble',
			'ion-chatbubble-working',
			'ion-chatbubbles',
			'ion-checkmark',
			'ion-checkmark-circled',
			'ion-checkmark-round',
			'ion-chevron-down',
			'ion-chevron-left',
			'ion-chevron-right',
			'ion-chevron-up',
			'ion-clipboard',
			'ion-clock',
			'ion-close',
			'ion-close-circled',
			'ion-close-round',
			'ion-closed-captioning',
			'ion-cloud',
			'ion-code',
			'ion-code-download',
			'ion-code-working',
			'ion-coffee',
			'ion-compass',
			'ion-compose',
			'ion-connection-bars',
			'ion-contrast',
			'ion-crop',
			'ion-cube',
			'ion-disc',
			'ion-document',
			'ion-document-text',
			'ion-drag',
			'ion-earth',
			'ion-easel',
			'ion-edit',
			'ion-egg',
			'ion-eject',
			'ion-email',
			'ion-email-unread',
			'ion-erlenmeyer-flask',
			'ion-erlenmeyer-flask-bubbles',
			'ion-eye',
			'ion-eye-disabled',
			'ion-female',
			'ion-filing',
			'ion-film-marker',
			'ion-fireball',
			'ion-flag',
			'ion-flame',
			'ion-flash',
			'ion-flash-off',
			'ion-folder',
			'ion-fork',
			'ion-fork-repo',
			'ion-forward',
			'ion-funnel',
			'ion-gear-a',
			'ion-gear-b',
			'ion-grid',
			'ion-hammer',
			'ion-happy',
			'ion-happy-outline',
			'ion-headphone',
			'ion-heart',
			'ion-heart-broken',
			'ion-help',
			'ion-help-buoy',
			'ion-help-circled',
			'ion-home',
			'ion-icecream',
			'ion-image',
			'ion-images',
			'ion-information',
			'ion-information-circled',
			'ion-ionic',
			'ion-ios-alarm',
			'ion-ios-alarm-outline',
			'ion-ios-albums',
			'ion-ios-albums-outline',
			'ion-ios-americanfootball',
			'ion-ios-americanfootball-outline',
			'ion-ios-analytics',
			'ion-ios-analytics-outline',
			'ion-ios-arrow-back',
			'ion-ios-arrow-down',
			'ion-ios-arrow-forward',
			'ion-ios-arrow-left',
			'ion-ios-arrow-right',
			'ion-ios-arrow-thin-down',
			'ion-ios-arrow-thin-left',
			'ion-ios-arrow-thin-right',
			'ion-ios-arrow-thin-up',
			'ion-ios-arrow-up',
			'ion-ios-at',
			'ion-ios-at-outline',
			'ion-ios-barcode',
			'ion-ios-barcode-outline',
			'ion-ios-baseball',
			'ion-ios-baseball-outline',
			'ion-ios-basketball',
			'ion-ios-basketball-outline',
			'ion-ios-bell',
			'ion-ios-bell-outline',
			'ion-ios-body',
			'ion-ios-body-outline',
			'ion-ios-bolt',
			'ion-ios-bolt-outline',
			'ion-ios-book',
			'ion-ios-book-outline',
			'ion-ios-bookmarks',
			'ion-ios-bookmarks-outline',
			'ion-ios-box',
			'ion-ios-box-outline',
			'ion-ios-briefcase',
			'ion-ios-briefcase-outline',
			'ion-ios-browsers',
			'ion-ios-browsers-outline',
			'ion-ios-calculator',
			'ion-ios-calculator-outline',
			'ion-ios-calendar',
			'ion-ios-calendar-outline',
			'ion-ios-camera',
			'ion-ios-camera-outline',
			'ion-ios-cart',
			'ion-ios-cart-outline',
			'ion-ios-chatboxes',
			'ion-ios-chatboxes-outline',
			'ion-ios-chatbubble',
			'ion-ios-chatbubble-outline',
			'ion-ios-checkmark',
			'ion-ios-checkmark-empty',
			'ion-ios-checkmark-outline',
			'ion-ios-circle-filled',
			'ion-ios-circle-outline',
			'ion-ios-clock',
			'ion-ios-clock-outline',
			'ion-ios-close',
			'ion-ios-close-empty',
			'ion-ios-close-outline',
			'ion-ios-cloud',
			'ion-ios-cloud-download',
			'ion-ios-cloud-download-outline',
			'ion-ios-cloud-outline',
			'ion-ios-cloud-upload',
			'ion-ios-cloud-upload-outline',
			'ion-ios-cloudy',
			'ion-ios-cloudy-night',
			'ion-ios-cloudy-night-outline',
			'ion-ios-cloudy-outline',
			'ion-ios-cog',
			'ion-ios-cog-outline',
			'ion-ios-color-filter',
			'ion-ios-color-filter-outline',
			'ion-ios-color-wand',
			'ion-ios-color-wand-outline',
			'ion-ios-compose',
			'ion-ios-compose-outline',
			'ion-ios-contact',
			'ion-ios-contact-outline',
			'ion-ios-copy',
			'ion-ios-copy-outline',
			'ion-ios-crop',
			'ion-ios-crop-strong',
			'ion-ios-download',
			'ion-ios-download-outline',
			'ion-ios-drag',
			'ion-ios-email',
			'ion-ios-email-outline',
			'ion-ios-eye',
			'ion-ios-eye-outline',
			'ion-ios-fastforward',
			'ion-ios-fastforward-outline',
			'ion-ios-filing',
			'ion-ios-filing-outline',
			'ion-ios-film',
			'ion-ios-film-outline',
			'ion-ios-flag',
			'ion-ios-flag-outline',
			'ion-ios-flame',
			'ion-ios-flame-outline',
			'ion-ios-flask',
			'ion-ios-flask-outline',
			'ion-ios-flower',
			'ion-ios-flower-outline',
			'ion-ios-folder',
			'ion-ios-folder-outline',
			'ion-ios-football',
			'ion-ios-football-outline',
			'ion-ios-game-controller-a',
			'ion-ios-game-controller-a-outline',
			'ion-ios-game-controller-b',
			'ion-ios-game-controller-b-outline',
			'ion-ios-gear',
			'ion-ios-gear-outline',
			'ion-ios-glasses',
			'ion-ios-glasses-outline',
			'ion-ios-grid-view',
			'ion-ios-grid-view-outline',
			'ion-ios-heart',
			'ion-ios-heart-outline',
			'ion-ios-help',
			'ion-ios-help-empty',
			'ion-ios-help-outline',
			'ion-ios-home',
			'ion-ios-home-outline',
			'ion-ios-infinite',
			'ion-ios-infinite-outline',
			'ion-ios-information',
			'ion-ios-information-empty',
			'ion-ios-information-outline',
			'ion-ios-ionic-outline',
			'ion-ios-keypad',
			'ion-ios-keypad-outline',
			'ion-ios-lightbulb',
			'ion-ios-lightbulb-outline',
			'ion-ios-list',
			'ion-ios-list-outline',
			'ion-ios-location',
			'ion-ios-location-outline',
			'ion-ios-locked',
			'ion-ios-locked-outline',
			'ion-ios-loop',
			'ion-ios-loop-strong',
			'ion-ios-medical',
			'ion-ios-medical-outline',
			'ion-ios-medkit',
			'ion-ios-medkit-outline',
			'ion-ios-mic',
			'ion-ios-mic-off',
			'ion-ios-mic-outline',
			'ion-ios-minus',
			'ion-ios-minus-empty',
			'ion-ios-minus-outline',
			'ion-ios-monitor',
			'ion-ios-monitor-outline',
			'ion-ios-moon',
			'ion-ios-moon-outline',
			'ion-ios-more',
			'ion-ios-more-outline',
			'ion-ios-musical-note',
			'ion-ios-musical-notes',
			'ion-ios-navigate',
			'ion-ios-navigate-outline',
			'ion-ios-nutrition',
			'ion-ios-nutrition-outline',
			'ion-ios-paper',
			'ion-ios-paper-outline',
			'ion-ios-paperplane',
			'ion-ios-paperplane-outline',
			'ion-ios-partlysunny',
			'ion-ios-partlysunny-outline',
			'ion-ios-pause',
			'ion-ios-pause-outline',
			'ion-ios-paw',
			'ion-ios-paw-outline',
			'ion-ios-people',
			'ion-ios-people-outline',
			'ion-ios-person',
			'ion-ios-person-outline',
			'ion-ios-personadd',
			'ion-ios-personadd-outline',
			'ion-ios-photos',
			'ion-ios-photos-outline',
			'ion-ios-pie',
			'ion-ios-pie-outline',
			'ion-ios-pint',
			'ion-ios-pint-outline',
			'ion-ios-play',
			'ion-ios-play-outline',
			'ion-ios-plus',
			'ion-ios-plus-empty',
			'ion-ios-plus-outline',
			'ion-ios-pricetag',
			'ion-ios-pricetag-outline',
			'ion-ios-pricetags',
			'ion-ios-pricetags-outline',
			'ion-ios-printer',
			'ion-ios-printer-outline',
			'ion-ios-pulse',
			'ion-ios-pulse-strong',
			'ion-ios-rainy',
			'ion-ios-rainy-outline',
			'ion-ios-recording',
			'ion-ios-recording-outline',
			'ion-ios-redo',
			'ion-ios-redo-outline',
			'ion-ios-refresh',
			'ion-ios-refresh-empty',
			'ion-ios-refresh-outline',
			'ion-ios-reload',
			'ion-ios-reverse-camera',
			'ion-ios-reverse-camera-outline',
			'ion-ios-rewind',
			'ion-ios-rewind-outline',
			'ion-ios-rose',
			'ion-ios-rose-outline',
			'ion-ios-search',
			'ion-ios-search-strong',
			'ion-ios-settings',
			'ion-ios-settings-strong',
			'ion-ios-shuffle',
			'ion-ios-shuffle-strong',
			'ion-ios-skipbackward',
			'ion-ios-skipbackward-outline',
			'ion-ios-skipforward',
			'ion-ios-skipforward-outline',
			'ion-ios-snowy',
			'ion-ios-speedometer',
			'ion-ios-speedometer-outline',
			'ion-ios-star',
			'ion-ios-star-half',
			'ion-ios-star-outline',
			'ion-ios-stopwatch',
			'ion-ios-stopwatch-outline',
			'ion-ios-sunny',
			'ion-ios-sunny-outline',
			'ion-ios-telephone',
			'ion-ios-telephone-outline',
			'ion-ios-tennisball',
			'ion-ios-tennisball-outline',
			'ion-ios-thunderstorm',
			'ion-ios-thunderstorm-outline',
			'ion-ios-time',
			'ion-ios-time-outline',
			'ion-ios-timer',
			'ion-ios-timer-outline',
			'ion-ios-toggle',
			'ion-ios-toggle-outline',
			'ion-ios-trash',
			'ion-ios-trash-outline',
			'ion-ios-undo',
			'ion-ios-undo-outline',
			'ion-ios-unlocked',
			'ion-ios-unlocked-outline',
			'ion-ios-upload',
			'ion-ios-upload-outline',
			'ion-ios-videocam',
			'ion-ios-videocam-outline',
			'ion-ios-volume-high',
			'ion-ios-volume-low',
			'ion-ios-wineglass',
			'ion-ios-wineglass-outline',
			'ion-ios-world',
			'ion-ios-world-outline',
			'ion-ipad',
			'ion-iphone',
			'ion-ipod',
			'ion-jet',
			'ion-key',
			'ion-knife',
			'ion-laptop',
			'ion-leaf',
			'ion-levels',
			'ion-lightbulb',
			'ion-link',
			'ion-load-a',
			'ion-load-b',
			'ion-load-c',
			'ion-load-d',
			'ion-location',
			'ion-lock-combination',
			'ion-locked',
			'ion-log-in',
			'ion-log-out',
			'ion-loop',
			'ion-magnet',
			'ion-male',
			'ion-man',
			'ion-map',
			'ion-medkit',
			'ion-merge',
			'ion-mic-a',
			'ion-mic-b',
			'ion-mic-c',
			'ion-minus',
			'ion-minus-circled',
			'ion-minus-round',
			'ion-model-s',
			'ion-monitor',
			'ion-more',
			'ion-mouse',
			'ion-music-note',
			'ion-navicon',
			'ion-navicon-round',
			'ion-navigate',
			'ion-network',
			'ion-no-smoking',
			'ion-nuclear',
			'ion-outlet',
			'ion-paintbrush',
			'ion-paintbucket',
			'ion-paper-airplane',
			'ion-paperclip',
			'ion-pause',
			'ion-person',
			'ion-person-add',
			'ion-person-stalker',
			'ion-pie-graph',
			'ion-pin',
			'ion-pinpoint',
			'ion-pizza',
			'ion-plane',
			'ion-planet',
			'ion-play',
			'ion-playstation',
			'ion-plus',
			'ion-plus-circled',
			'ion-plus-round',
			'ion-podium',
			'ion-pound',
			'ion-power',
			'ion-pricetag',
			'ion-pricetags',
			'ion-printer',
			'ion-pull-request',
			'ion-qr-scanner',
			'ion-quote',
			'ion-radio-waves',
			'ion-record',
			'ion-refresh',
			'ion-reply',
			'ion-reply-all',
			'ion-ribbon-a',
			'ion-ribbon-b',
			'ion-sad',
			'ion-sad-outline',
			'ion-scissors',
			'ion-search',
			'ion-settings',
			'ion-share',
			'ion-shuffle',
			'ion-skip-backward',
			'ion-skip-forward',
			'ion-social-android',
			'ion-social-android-outline',
			'ion-social-angular',
			'ion-social-angular-outline',
			'ion-social-apple',
			'ion-social-apple-outline',
			'ion-social-bitcoin',
			'ion-social-bitcoin-outline',
			'ion-social-buffer',
			'ion-social-buffer-outline',
			'ion-social-chrome',
			'ion-social-chrome-outline',
			'ion-social-codepen',
			'ion-social-codepen-outline',
			'ion-social-css3',
			'ion-social-css3-outline',
			'ion-social-designernews',
			'ion-social-designernews-outline',
			'ion-social-dribbble',
			'ion-social-dribbble-outline',
			'ion-social-dropbox',
			'ion-social-dropbox-outline',
			'ion-social-euro',
			'ion-social-euro-outline',
			'ion-social-facebook',
			'ion-social-facebook-outline',
			'ion-social-foursquare',
			'ion-social-foursquare-outline',
			'ion-social-freebsd-devil',
			'ion-social-github',
			'ion-social-github-outline',
			'ion-social-google',
			'ion-social-google-outline',
			'ion-social-googleplus',
			'ion-social-googleplus-outline',
			'ion-social-hackernews',
			'ion-social-hackernews-outline',
			'ion-social-html5',
			'ion-social-html5-outline',
			'ion-social-instagram',
			'ion-social-instagram-outline',
			'ion-social-javascript',
			'ion-social-javascript-outline',
			'ion-social-linkedin',
			'ion-social-linkedin-outline',
			'ion-social-markdown',
			'ion-social-nodejs',
			'ion-social-octocat',
			'ion-social-pinterest',
			'ion-social-pinterest-outline',
			'ion-social-python',
			'ion-social-reddit',
			'ion-social-reddit-outline',
			'ion-social-rss',
			'ion-social-rss-outline',
			'ion-social-sass',
			'ion-social-skype',
			'ion-social-skype-outline',
			'ion-social-snapchat',
			'ion-social-snapchat-outline',
			'ion-social-tumblr',
			'ion-social-tumblr-outline',
			'ion-social-tux',
			'ion-social-twitch',
			'ion-social-twitch-outline',
			'ion-social-twitter',
			'ion-social-twitter-outline',
			'ion-social-usd',
			'ion-social-usd-outline',
			'ion-social-vimeo',
			'ion-social-vimeo-outline',
			'ion-social-whatsapp',
			'ion-social-whatsapp-outline',
			'ion-social-windows',
			'ion-social-windows-outline',
			'ion-social-wordpress',
			'ion-social-wordpress-outline',
			'ion-social-yahoo',
			'ion-social-yahoo-outline',
			'ion-social-yen',
			'ion-social-yen-outline',
			'ion-social-youtube',
			'ion-social-youtube-outline',
			'ion-soup-can',
			'ion-soup-can-outline',
			'ion-speakerphone',
			'ion-speedometer',
			'ion-spoon',
			'ion-star',
			'ion-stats-bars',
			'ion-steam',
			'ion-stop',
			'ion-thermometer',
			'ion-thumbsdown',
			'ion-thumbsup',
			'ion-toggle',
			'ion-toggle-filled',
			'ion-transgender',
			'ion-trash-a',
			'ion-trash-b',
			'ion-trophy',
			'ion-tshirt',
			'ion-tshirt-outline',
			'ion-umbrella',
			'ion-university',
			'ion-unlocked',
			'ion-upload',
			'ion-usb',
			'ion-videocamera',
			'ion-volume-high',
			'ion-volume-low',
			'ion-volume-medium',
			'ion-volume-mute',
			'ion-wand',
			'ion-waterdrop',
			'ion-wifi',
			'ion-wineglass',
			'ion-woman',
			'ion-wrench',
			'ion-xbox',
		);
		$icons_eleganticons = array(
			'arrow_up',
			'arrow_down',
			'arrow_left',
			'arrow_right',
			'arrow_left-up',
			'arrow_right-up',
			'arrow_right-down',
			'arrow_left-down',
			'arrow-up-down',
			'arrow_up-down_alt',
			'arrow_left-right_alt',
			'arrow_left-right',
			'arrow_expand_alt2',
			'arrow_expand_alt',
			'arrow_condense',
			'arrow_expand',
			'arrow_move',
			'arrow_carrot-up',
			'arrow_carrot-down',
			'arrow_carrot-left',
			'arrow_carrot-right',
			'arrow_carrot-2up',
			'arrow_carrot-2down',
			'arrow_carrot-2left',
			'arrow_carrot-2right',
			'arrow_carrot-up_alt2',
			'arrow_carrot-down_alt2',
			'arrow_carrot-left_alt2',
			'arrow_carrot-right_alt2',
			'arrow_carrot-2up_alt2',
			'arrow_carrot-2down_alt2',
			'arrow_carrot-2left_alt2',
			'arrow_carrot-2right_alt2',
			'arrow_triangle-up',
			'arrow_triangle-down',
			'arrow_triangle-left',
			'arrow_triangle-right',
			'arrow_triangle-up_alt2',
			'arrow_triangle-down_alt2',
			'arrow_triangle-left_alt2',
			'arrow_triangle-right_alt2',
			'arrow_back',
			'icon_minus-06',
			'icon_plus',
			'icon_close',
			'icon_check',
			'icon_minus_alt2',
			'icon_plus_alt2',
			'icon_close_alt2',
			'icon_check_alt2',
			'icon_zoom-out_alt',
			'icon_zoom-in_alt',
			'icon_search',
			'icon_box-empty',
			'icon_box-selected',
			'icon_minus-box',
			'icon_plus-box',
			'icon_box-checked',
			'icon_circle-empty',
			'icon_circle-slelected',
			'icon_stop_alt2',
			'icon_stop',
			'icon_pause_alt2',
			'icon_pause',
			'icon_menu',
			'icon_menu-square_alt2',
			'icon_menu-circle_alt2',
			'icon_ul',
			'icon_ol',
			'icon_adjust-horiz',
			'icon_adjust-vert',
			'icon_document_alt',
			'icon_documents_alt',
			'icon_pencil',
			'icon_pencil-edit_alt',
			'icon_pencil-edit',
			'icon_folder-alt',
			'icon_folder-open_alt',
			'icon_folder-add_alt',
			'icon_info_alt',
			'icon_error-oct_alt',
			'icon_error-circle_alt',
			'icon_error-triangle_alt',
			'icon_question_alt2',
			'icon_question',
			'icon_comment_alt',
			'icon_chat_alt',
			'icon_vol-mute_alt',
			'icon_volume-low_alt',
			'icon_volume-high_alt',
			'icon_quotations',
			'icon_quotations_alt2',
			'icon_clock_alt',
			'icon_lock_alt',
			'icon_lock-open_alt',
			'icon_key_alt',
			'icon_cloud_alt',
			'icon_cloud-upload_alt',
			'icon_cloud-download_alt',
			'icon_image',
			'icon_images',
			'icon_lightbulb_alt',
			'icon_gift_alt',
			'icon_house_alt',
			'icon_genius',
			'icon_mobile',
			'icon_tablet',
			'icon_laptop',
			'icon_desktop',
			'icon_camera_alt',
			'icon_mail_alt',
			'icon_cone_alt',
			'icon_ribbon_alt',
			'icon_bag_alt',
			'icon_creditcard',
			'icon_cart_alt',
			'icon_paperclip',
			'icon_tag_alt',
			'icon_tags_alt',
			'icon_trash_alt',
			'icon_cursor_alt',
			'icon_mic_alt',
			'icon_compass_alt',
			'icon_pin_alt',
			'icon_pushpin_alt',
			'icon_map_alt',
			'icon_drawer_alt',
			'icon_toolbox_alt',
			'icon_book_alt',
			'icon_calendar',
			'icon_film',
			'icon_table',
			'icon_contacts_alt',
			'icon_headphones',
			'icon_lifesaver',
			'icon_piechart',
			'icon_refresh',
			'icon_link_alt',
			'icon_link',
			'icon_loading',
			'icon_blocked',
			'icon_archive_alt',
			'icon_heart_alt',
			'icon_star_alt',
			'icon_star-half_alt',
			'icon_star',
			'icon_star-half',
			'icon_tools',
			'icon_tool',
			'icon_cog',
			'icon_cogs',
			'arrow_up_alt',
			'arrow_down_alt',
			'arrow_left_alt',
			'arrow_right_alt',
			'arrow_left-up_alt',
			'arrow_right-up_alt',
			'arrow_right-down_alt',
			'arrow_left-down_alt',
			'arrow_condense_alt',
			'arrow_expand_alt3',
			'arrow_carrot_up_alt',
			'arrow_carrot-down_alt',
			'arrow_carrot-left_alt',
			'arrow_carrot-right_alt',
			'arrow_carrot-2up_alt',
			'arrow_carrot-2dwnn_alt',
			'arrow_carrot-2left_alt',
			'arrow_carrot-2right_alt',
			'arrow_triangle-up_alt',
			'arrow_triangle-down_alt',
			'arrow_triangle-left_alt',
			'arrow_triangle-right_alt',
			'icon_minus_alt',
			'icon_plus_alt',
			'icon_close_alt',
			'icon_check_alt',
			'icon_zoom-out',
			'icon_zoom-in',
			'icon_stop_alt',
			'icon_menu-square_alt',
			'icon_menu-circle_alt',
			'icon_document',
			'icon_documents',
			'icon_pencil_alt',
			'icon_folder',
			'icon_folder-open',
			'icon_folder-add',
			'icon_folder_upload',
			'icon_folder_download',
			'icon_info',
			'icon_error-circle',
			'icon_error-oct',
			'icon_error-triangle',
			'icon_question_alt',
			'icon_comment',
			'icon_chat',
			'icon_vol-mute',
			'icon_volume-low',
			'icon_volume-high',
			'icon_quotations_alt',
			'icon_clock',
			'icon_lock',
			'icon_lock-open',
			'icon_key',
			'icon_cloud',
			'icon_cloud-upload',
			'icon_cloud-download',
			'icon_lightbulb',
			'icon_gift',
			'icon_house',
			'icon_camera',
			'icon_mail',
			'icon_cone',
			'icon_ribbon',
			'icon_bag',
			'icon_cart',
			'icon_tag',
			'icon_tags',
			'icon_trash',
			'icon_cursor',
			'icon_mic',
			'icon_compass',
			'icon_pin',
			'icon_pushpin',
			'icon_map',
			'icon_drawer',
			'icon_toolbox',
			'icon_book',
			'icon_contacts',
			'icon_archive',
			'icon_heart',
			'icon_profile',
			'icon_group',
			'icon_grid-2x2',
			'icon_grid-3x3',
			'icon_music',
			'icon_pause_alt',
			'icon_phone',
			'icon_upload',
			'icon_download',
			'social_facebook',
			'social_twitter',
			'social_pinterest',
			'social_googleplus',
			'social_tumblr',
			'social_tumbleupon',
			'social_wordpress',
			'social_instagram',
			'social_dribbble',
			'social_vimeo',
			'social_linkedin',
			'social_rss',
			'social_deviantart',
			'social_share',
			'social_myspace',
			'social_skype',
			'social_youtube',
			'social_picassa',
			'social_googledrive',
			'social_flickr',
			'social_blogger',
			'social_spotify',
			'social_delicious',
			'social_facebook_circle',
			'social_twitter_circle',
			'social_pinterest_circle',
			'social_googleplus_circle',
			'social_tumblr_circle',
			'social_stumbleupon_circle',
			'social_wordpress_circle',
			'social_instagram_circle',
			'social_dribbble_circle',
			'social_vimeo_circle',
			'social_linkedin_circle',
			'social_rss_circle',
			'social_deviantart_circle',
			'social_share_circle',
			'social_myspace_circle',
			'social_skype_circle',
			'social_youtube_circle',
			'social_picassa_circle',
			'social_googledrive_alt2',
			'social_flickr_circle',
			'social_blogger_circle',
			'social_spotify_circle',
			'social_delicious_circle',
			'social_facebook_square',
			'social_twitter_square',
			'social_pinterest_square',
			'social_googleplus_square',
			'social_tumblr_square',
			'social_stumbleupon_square',
			'social_wordpress_square',
			'social_instagram_square',
			'social_dribbble_square',
			'social_vimeo_square',
			'social_linkedin_square',
			'social_rss_square',
			'social_deviantart_square',
			'social_share_square',
			'social_myspace_square',
			'social_skype_square',
			'social_youtube_square',
			'social_picassa_square',
			'social_googledrive_square',
			'social_flickr_square',
			'social_blogger_square',
			'social_spotify_square',
			'social_delicious_square',
			'icon_printer',
			'icon_calulator',
			'icon_building',
			'icon_floppy',
			'icon_drive',
			'icon_search-2',
			'icon_id',
			'icon_id-2',
			'icon_puzzle',
			'icon_like',
			'icon_dislike',
			'icon_mug',
			'icon_currency',
			'icon_wallet',
			'icon_pens',
			'icon_easel',
			'icon_flowchart',
			'icon_datareport',
			'icon_briefcase',
			'icon_shield',
			'icon_percent',
			'icon_globe',
			'icon_globe-2',
			'icon_target',
			'icon_hourglass',
			'icon_balance',
			'icon_rook',
			'icon_printer-alt',
			'icon_calculator_alt',
			'icon_building_alt',
			'icon_floppy_alt',
			'icon_drive_alt',
			'icon_search_alt',
			'icon_id_alt',
			'icon_id-2_alt',
			'icon_puzzle_alt',
			'icon_like_alt',
			'icon_dislike_alt',
			'icon_mug_alt',
			'icon_currency_alt',
			'icon_wallet_alt',
			'icon_pens_alt',
			'icon_easel_alt',
			'icon_flowchart_alt',
			'icon_datareport_alt',
			'icon_briefcase_alt',
			'icon_shield_alt',
			'icon_percent_alt',
			'icon_globe_alt',
			'icon_clipboard',
		);
		$icons_linearicons  = array(
			'iconlin-home',
			'iconlin-home2',
			'iconlin-home3',
			'iconlin-home4',
			'iconlin-home5',
			'iconlin-home6',
			'iconlin-bathtub',
			'iconlin-toothbrush',
			'iconlin-bed',
			'iconlin-couch',
			'iconlin-chair',
			'iconlin-city',
			'iconlin-apartment',
			'iconlin-pencil',
			'iconlin-pencil2',
			'iconlin-pen',
			'iconlin-pencil3',
			'iconlin-eraser',
			'iconlin-pencil4',
			'iconlin-pencil5',
			'iconlin-feather',
			'iconlin-feather2',
			'iconlin-feather3',
			'iconlin-pen2',
			'iconlin-pen-add',
			'iconlin-pen-remove',
			'iconlin-vector',
			'iconlin-pen3',
			'iconlin-blog',
			'iconlin-brush',
			'iconlin-brush2',
			'iconlin-spray',
			'iconlin-paint-roller',
			'iconlin-stamp',
			'iconlin-tape',
			'iconlin-desk-tape',
			'iconlin-texture',
			'iconlin-eye-dropper',
			'iconlin-palette',
			'iconlin-color-sampler',
			'iconlin-bucket',
			'iconlin-gradient',
			'iconlin-gradient2',
			'iconlin-magic-wand',
			'iconlin-magnet',
			'iconlin-pencil-ruler',
			'iconlin-pencil-ruler2',
			'iconlin-compass',
			'iconlin-aim',
			'iconlin-gun',
			'iconlin-bottle',
			'iconlin-drop',
			'iconlin-drop-crossed',
			'iconlin-drop2',
			'iconlin-snow',
			'iconlin-snow2',
			'iconlin-fire',
			'iconlin-lighter',
			'iconlin-knife',
			'iconlin-dagger',
			'iconlin-tissue',
			'iconlin-toilet-paper',
			'iconlin-poop',
			'iconlin-umbrella',
			'iconlin-umbrella2',
			'iconlin-rain',
			'iconlin-tornado',
			'iconlin-wind',
			'iconlin-fan',
			'iconlin-contrast',
			'iconlin-sun-small',
			'iconlin-sun',
			'iconlin-sun2',
			'iconlin-moon',
			'iconlin-cloud',
			'iconlin-cloud-upload',
			'iconlin-cloud-download',
			'iconlin-cloud-rain',
			'iconlin-cloud-hailstones',
			'iconlin-cloud-snow',
			'iconlin-cloud-windy',
			'iconlin-sun-wind',
			'iconlin-cloud-fog',
			'iconlin-cloud-sun',
			'iconlin-cloud-lightning',
			'iconlin-cloud-sync',
			'iconlin-cloud-lock',
			'iconlin-cloud-gear',
			'iconlin-cloud-alert',
			'iconlin-cloud-check',
			'iconlin-cloud-cross',
			'iconlin-cloud-crossed',
			'iconlin-cloud-database',
			'iconlin-database',
			'iconlin-database-add',
			'iconlin-database-remove',
			'iconlin-database-lock',
			'iconlin-database-refresh',
			'iconlin-database-check',
			'iconlin-database-history',
			'iconlin-database-upload',
			'iconlin-database-download',
			'iconlin-server',
			'iconlin-shield',
			'iconlin-shield-check',
			'iconlin-shield-alert',
			'iconlin-shield-cross',
			'iconlin-lock',
			'iconlin-rotation-lock',
			'iconlin-unlock',
			'iconlin-key',
			'iconlin-key-hole',
			'iconlin-toggle-off',
			'iconlin-toggle-on',
			'iconlin-cog',
			'iconlin-cog2',
			'iconlin-wrench',
			'iconlin-screwdriver',
			'iconlin-hammer-wrench',
			'iconlin-hammer',
			'iconlin-saw',
			'iconlin-axe',
			'iconlin-axe2',
			'iconlin-shovel',
			'iconlin-pickaxe',
			'iconlin-factory',
			'iconlin-factory2',
			'iconlin-recycle',
			'iconlin-trash',
			'iconlin-trash2',
			'iconlin-trash3',
			'iconlin-broom',
			'iconlin-game',
			'iconlin-gamepad',
			'iconlin-joystick',
			'iconlin-dice',
			'iconlin-spades',
			'iconlin-diamonds',
			'iconlin-clubs',
			'iconlin-hearts',
			'iconlin-heart',
			'iconlin-star',
			'iconlin-star-half',
			'iconlin-star-empty',
			'iconlin-flag',
			'iconlin-flag2',
			'iconlin-flag3',
			'iconlin-mailbox-full',
			'iconlin-mailbox-empty',
			'iconlin-at-sign',
			'iconlin-envelope',
			'iconlin-envelope-open',
			'iconlin-paperclip',
			'iconlin-paper-plane',
			'iconlin-reply',
			'iconlin-reply-all',
			'iconlin-inbox',
			'iconlin-inbox2',
			'iconlin-outbox',
			'iconlin-box',
			'iconlin-archive',
			'iconlin-archive2',
			'iconlin-drawers',
			'iconlin-drawers2',
			'iconlin-drawers3',
			'iconlin-eye',
			'iconlin-eye-crossed',
			'iconlin-eye-plus',
			'iconlin-eye-minus',
			'iconlin-binoculars',
			'iconlin-binoculars2',
			'iconlin-hdd',
			'iconlin-hdd-down',
			'iconlin-hdd-up',
			'iconlin-floppy-disk',
			'iconlin-disc',
			'iconlin-tape2',
			'iconlin-printer',
			'iconlin-shredder',
			'iconlin-file-empty',
			'iconlin-file-add',
			'iconlin-file-check',
			'iconlin-file-lock',
			'iconlin-files',
			'iconlin-copy',
			'iconlin-compare',
			'iconlin-folder',
			'iconlin-folder-search',
			'iconlin-folder-plus',
			'iconlin-folder-minus',
			'iconlin-folder-download',
			'iconlin-folder-upload',
			'iconlin-folder-star',
			'iconlin-folder-heart',
			'iconlin-folder-user',
			'iconlin-folder-shared',
			'iconlin-folder-music',
			'iconlin-folder-picture',
			'iconlin-folder-film',
			'iconlin-scissors',
			'iconlin-paste',
			'iconlin-clipboard-empty',
			'iconlin-clipboard-pencil',
			'iconlin-clipboard-text',
			'iconlin-clipboard-check',
			'iconlin-clipboard-down',
			'iconlin-clipboard-left',
			'iconlin-clipboard-alert',
			'iconlin-clipboard-user',
			'iconlin-register',
			'iconlin-enter',
			'iconlin-exit',
			'iconlin-papers',
			'iconlin-news',
			'iconlin-reading',
			'iconlin-typewriter',
			'iconlin-document',
			'iconlin-document2',
			'iconlin-graduation-hat',
			'iconlin-license',
			'iconlin-license2',
			'iconlin-medal-empty',
			'iconlin-medal-first',
			'iconlin-medal-second',
			'iconlin-medal-third',
			'iconlin-podium',
			'iconlin-trophy',
			'iconlin-trophy2',
			'iconlin-music-note',
			'iconlin-music-note2',
			'iconlin-music-note3',
			'iconlin-playlist',
			'iconlin-playlist-add',
			'iconlin-guitar',
			'iconlin-trumpet',
			'iconlin-album',
			'iconlin-shuffle',
			'iconlin-repeat-one',
			'iconlin-repeat',
			'iconlin-headphones',
			'iconlin-headset',
			'iconlin-loudspeaker',
			'iconlin-equalizer',
			'iconlin-theater',
			'iconlin-3d-glasses',
			'iconlin-ticket',
			'iconlin-presentation',
			'iconlin-play',
			'iconlin-film-play',
			'iconlin-clapboard-play',
			'iconlin-media',
			'iconlin-film',
			'iconlin-film2',
			'iconlin-surveillance',
			'iconlin-surveillance2',
			'iconlin-camera',
			'iconlin-camera-crossed',
			'iconlin-camera-play',
			'iconlin-time-lapse',
			'iconlin-record',
			'iconlin-camera2',
			'iconlin-camera-flip',
			'iconlin-panorama',
			'iconlin-time-lapse2',
			'iconlin-shutter',
			'iconlin-shutter2',
			'iconlin-face-detection',
			'iconlin-flare',
			'iconlin-convex',
			'iconlin-concave',
			'iconlin-picture',
			'iconlin-picture2',
			'iconlin-picture3',
			'iconlin-pictures',
			'iconlin-book',
			'iconlin-audio-book',
			'iconlin-book2',
			'iconlin-bookmark',
			'iconlin-bookmark2',
			'iconlin-label',
			'iconlin-library',
			'iconlin-library2',
			'iconlin-contacts',
			'iconlin-profile',
			'iconlin-portrait',
			'iconlin-portrait2',
			'iconlin-user',
			'iconlin-user-plus',
			'iconlin-user-minus',
			'iconlin-user-lock',
			'iconlin-users',
			'iconlin-users2',
			'iconlin-users-plus',
			'iconlin-users-minus',
			'iconlin-group-work',
			'iconlin-woman',
			'iconlin-man',
			'iconlin-baby',
			'iconlin-baby2',
			'iconlin-baby3',
			'iconlin-baby-bottle',
			'iconlin-walk',
			'iconlin-hand-waving',
			'iconlin-jump',
			'iconlin-run',
			'iconlin-woman2',
			'iconlin-man2',
			'iconlin-man-woman',
			'iconlin-height',
			'iconlin-weight',
			'iconlin-scale',
			'iconlin-button',
			'iconlin-bow-tie',
			'iconlin-tie',
			'iconlin-socks',
			'iconlin-shoe',
			'iconlin-shoes',
			'iconlin-hat',
			'iconlin-pants',
			'iconlin-shorts',
			'iconlin-flip-flops',
			'iconlin-shirt',
			'iconlin-hanger',
			'iconlin-laundry',
			'iconlin-store',
			'iconlin-haircut',
			'iconlin-store-24',
			'iconlin-barcode',
			'iconlin-barcode2',
			'iconlin-barcode3',
			'iconlin-cashier',
			'iconlin-bag',
			'iconlin-bag2',
			'iconlin-cart',
			'iconlin-cart-empty',
			'iconlin-cart-full',
			'iconlin-cart-plus',
			'iconlin-cart-plus2',
			'iconlin-cart-add',
			'iconlin-cart-remove',
			'iconlin-cart-exchange',
			'iconlin-tag',
			'iconlin-tags',
			'iconlin-receipt',
			'iconlin-wallet',
			'iconlin-credit-card',
			'iconlin-cash-dollar',
			'iconlin-cash-euro',
			'iconlin-cash-pound',
			'iconlin-cash-yen',
			'iconlin-bag-dollar',
			'iconlin-bag-euro',
			'iconlin-bag-pound',
			'iconlin-bag-yen',
			'iconlin-coin-dollar',
			'iconlin-coin-euro',
			'iconlin-coin-pound',
			'iconlin-coin-yen',
			'iconlin-calculator',
			'iconlin-calculator2',
			'iconlin-abacus',
			'iconlin-vault',
			'iconlin-telephone',
			'iconlin-phone-lock',
			'iconlin-phone-wave',
			'iconlin-phone-pause',
			'iconlin-phone-outgoing',
			'iconlin-phone-incoming',
			'iconlin-phone-in-out',
			'iconlin-phone-error',
			'iconlin-phone-sip',
			'iconlin-phone-plus',
			'iconlin-phone-minus',
			'iconlin-voicemail',
			'iconlin-dial',
			'iconlin-telephone2',
			'iconlin-pushpin',
			'iconlin-pushpin2',
			'iconlin-map-marker',
			'iconlin-map-marker-user',
			'iconlin-map-marker-down',
			'iconlin-map-marker-check',
			'iconlin-map-marker-crossed',
			'iconlin-radar',
			'iconlin-compass2',
			'iconlin-map',
			'iconlin-map2',
			'iconlin-location',
			'iconlin-road-sign',
			'iconlin-calendar-empty',
			'iconlin-calendar-check',
			'iconlin-calendar-cross',
			'iconlin-calendar-31',
			'iconlin-calendar-full',
			'iconlin-calendar-insert',
			'iconlin-calendar-text',
			'iconlin-calendar-user',
			'iconlin-mouse',
			'iconlin-mouse-left',
			'iconlin-mouse-right',
			'iconlin-mouse-both',
			'iconlin-keyboard',
			'iconlin-keyboard-up',
			'iconlin-keyboard-down',
			'iconlin-delete',
			'iconlin-spell-check',
			'iconlin-escape',
			'iconlin-enter2',
			'iconlin-screen',
			'iconlin-aspect-ratio',
			'iconlin-signal',
			'iconlin-signal-lock',
			'iconlin-signal-80',
			'iconlin-signal-60',
			'iconlin-signal-40',
			'iconlin-signal-20',
			'iconlin-signal-0',
			'iconlin-signal-blocked',
			'iconlin-sim',
			'iconlin-flash-memory',
			'iconlin-usb-drive',
			'iconlin-phone',
			'iconlin-smartphone',
			'iconlin-smartphone-notification',
			'iconlin-smartphone-vibration',
			'iconlin-smartphone-embed',
			'iconlin-smartphone-waves',
			'iconlin-tablet',
			'iconlin-tablet2',
			'iconlin-laptop',
			'iconlin-laptop-phone',
			'iconlin-desktop',
			'iconlin-launch',
			'iconlin-new-tab',
			'iconlin-window',
			'iconlin-cable',
			'iconlin-cable2',
			'iconlin-tv',
			'iconlin-radio',
			'iconlin-remote-control',
			'iconlin-power-switch',
			'iconlin-power',
			'iconlin-power-crossed',
			'iconlin-flash-auto',
			'iconlin-lamp',
			'iconlin-flashlight',
			'iconlin-lampshade',
			'iconlin-cord',
			'iconlin-outlet',
			'iconlin-battery-power',
			'iconlin-battery-empty',
			'iconlin-battery-alert',
			'iconlin-battery-error',
			'iconlin-battery-low1',
			'iconlin-battery-low2',
			'iconlin-battery-low3',
			'iconlin-battery-mid1',
			'iconlin-battery-mid2',
			'iconlin-battery-mid3',
			'iconlin-battery-full',
			'iconlin-battery-charging',
			'iconlin-battery-charging2',
			'iconlin-battery-charging3',
			'iconlin-battery-charging4',
			'iconlin-battery-charging5',
			'iconlin-battery-charging6',
			'iconlin-battery-charging7',
			'iconlin-chip',
			'iconlin-chip-x64',
			'iconlin-chip-x86',
			'iconlin-bubble',
			'iconlin-bubbles',
			'iconlin-bubble-dots',
			'iconlin-bubble-alert',
			'iconlin-bubble-question',
			'iconlin-bubble-text',
			'iconlin-bubble-pencil',
			'iconlin-bubble-picture',
			'iconlin-bubble-video',
			'iconlin-bubble-user',
			'iconlin-bubble-quote',
			'iconlin-bubble-heart',
			'iconlin-bubble-emoticon',
			'iconlin-bubble-attachment',
			'iconlin-phone-bubble',
			'iconlin-quote-open',
			'iconlin-quote-close',
			'iconlin-dna',
			'iconlin-heart-pulse',
			'iconlin-pulse',
			'iconlin-syringe',
			'iconlin-pills',
			'iconlin-first-aid',
			'iconlin-lifebuoy',
			'iconlin-bandage',
			'iconlin-bandages',
			'iconlin-thermometer',
			'iconlin-microscope',
			'iconlin-brain',
			'iconlin-beaker',
			'iconlin-skull',
			'iconlin-bone',
			'iconlin-construction',
			'iconlin-construction-cone',
			'iconlin-pie-chart',
			'iconlin-pie-chart2',
			'iconlin-graph',
			'iconlin-chart-growth',
			'iconlin-chart-bars',
			'iconlin-chart-settings',
			'iconlin-cake',
			'iconlin-gift',
			'iconlin-balloon',
			'iconlin-rank',
			'iconlin-rank2',
			'iconlin-rank3',
			'iconlin-crown',
			'iconlin-lotus',
			'iconlin-diamond',
			'iconlin-diamond2',
			'iconlin-diamond3',
			'iconlin-diamond4',
			'iconlin-linearicons',
			'iconlin-teacup',
			'iconlin-teapot',
			'iconlin-glass',
			'iconlin-bottle2',
			'iconlin-glass-cocktail',
			'iconlin-glass2',
			'iconlin-dinner',
			'iconlin-dinner2',
			'iconlin-chef',
			'iconlin-scale2',
			'iconlin-egg',
			'iconlin-egg2',
			'iconlin-eggs',
			'iconlin-platter',
			'iconlin-steak',
			'iconlin-hamburger',
			'iconlin-hotdog',
			'iconlin-pizza',
			'iconlin-sausage',
			'iconlin-chicken',
			'iconlin-fish',
			'iconlin-carrot',
			'iconlin-cheese',
			'iconlin-bread',
			'iconlin-ice-cream',
			'iconlin-ice-cream2',
			'iconlin-candy',
			'iconlin-lollipop',
			'iconlin-coffee-bean',
			'iconlin-coffee-cup',
			'iconlin-cherry',
			'iconlin-grapes',
			'iconlin-citrus',
			'iconlin-apple',
			'iconlin-leaf',
			'iconlin-landscape',
			'iconlin-pine-tree',
			'iconlin-tree',
			'iconlin-cactus',
			'iconlin-paw',
			'iconlin-footprint',
			'iconlin-speed-slow',
			'iconlin-speed-medium',
			'iconlin-speed-fast',
			'iconlin-rocket',
			'iconlin-hammer2',
			'iconlin-balance',
			'iconlin-briefcase',
			'iconlin-luggage-weight',
			'iconlin-dolly',
			'iconlin-plane',
			'iconlin-plane-crossed',
			'iconlin-helicopter',
			'iconlin-traffic-lights',
			'iconlin-siren',
			'iconlin-road',
			'iconlin-engine',
			'iconlin-oil-pressure',
			'iconlin-coolant-temperature',
			'iconlin-car-battery',
			'iconlin-gas',
			'iconlin-gallon',
			'iconlin-transmission',
			'iconlin-car',
			'iconlin-car-wash',
			'iconlin-car-wash2',
			'iconlin-bus',
			'iconlin-bus2',
			'iconlin-car2',
			'iconlin-parking',
			'iconlin-car-lock',
			'iconlin-taxi',
			'iconlin-car-siren',
			'iconlin-car-wash3',
			'iconlin-car-wash4',
			'iconlin-ambulance',
			'iconlin-truck',
			'iconlin-trailer',
			'iconlin-scale-truck',
			'iconlin-train',
			'iconlin-ship',
			'iconlin-ship2',
			'iconlin-anchor',
			'iconlin-boat',
			'iconlin-bicycle',
			'iconlin-bicycle2',
			'iconlin-dumbbell',
			'iconlin-bench-press',
			'iconlin-swim',
			'iconlin-football',
			'iconlin-baseball-bat',
			'iconlin-baseball',
			'iconlin-tennis',
			'iconlin-tennis2',
			'iconlin-ping-pong',
			'iconlin-hockey',
			'iconlin-8ball',
			'iconlin-bowling',
			'iconlin-bowling-pins',
			'iconlin-golf',
			'iconlin-golf2',
			'iconlin-archery',
			'iconlin-slingshot',
			'iconlin-soccer',
			'iconlin-basketball',
			'iconlin-cube',
			'iconlin-3d-rotate',
			'iconlin-puzzle',
			'iconlin-glasses',
			'iconlin-glasses2',
			'iconlin-accessibility',
			'iconlin-wheelchair',
			'iconlin-wall',
			'iconlin-fence',
			'iconlin-wall2',
			'iconlin-icons',
			'iconlin-resize-handle',
			'iconlin-icons2',
			'iconlin-select',
			'iconlin-select2',
			'iconlin-site-map',
			'iconlin-earth',
			'iconlin-earth-lock',
			'iconlin-network',
			'iconlin-network-lock',
			'iconlin-planet',
			'iconlin-happy',
			'iconlin-smile',
			'iconlin-grin',
			'iconlin-tongue',
			'iconlin-sad',
			'iconlin-wink',
			'iconlin-dream',
			'iconlin-shocked',
			'iconlin-shocked2',
			'iconlin-tongue2',
			'iconlin-neutral',
			'iconlin-happy-grin',
			'iconlin-cool',
			'iconlin-mad',
			'iconlin-grin-evil',
			'iconlin-evil',
			'iconlin-wow',
			'iconlin-annoyed',
			'iconlin-wondering',
			'iconlin-confused',
			'iconlin-zipped',
			'iconlin-grumpy',
			'iconlin-mustache',
			'iconlin-tombstone-hipster',
			'iconlin-tombstone',
			'iconlin-ghost',
			'iconlin-ghost-hipster',
			'iconlin-halloween',
			'iconlin-christmas',
			'iconlin-easter-egg',
			'iconlin-mustache2',
			'iconlin-mustache-glasses',
			'iconlin-pipe',
			'iconlin-alarm',
			'iconlin-alarm-add',
			'iconlin-alarm-snooze',
			'iconlin-alarm-ringing',
			'iconlin-bullhorn',
			'iconlin-hearing',
			'iconlin-volume-high',
			'iconlin-volume-medium',
			'iconlin-volume-low',
			'iconlin-volume',
			'iconlin-mute',
			'iconlin-lan',
			'iconlin-lan2',
			'iconlin-wifi',
			'iconlin-wifi-lock',
			'iconlin-wifi-blocked',
			'iconlin-wifi-mid',
			'iconlin-wifi-low',
			'iconlin-wifi-low2',
			'iconlin-wifi-alert',
			'iconlin-wifi-alert-mid',
			'iconlin-wifi-alert-low',
			'iconlin-wifi-alert-low2',
			'iconlin-stream',
			'iconlin-stream-check',
			'iconlin-stream-error',
			'iconlin-stream-alert',
			'iconlin-communication',
			'iconlin-communication-crossed',
			'iconlin-broadcast',
			'iconlin-antenna',
			'iconlin-satellite',
			'iconlin-satellite2',
			'iconlin-mic',
			'iconlin-mic-mute',
			'iconlin-mic2',
			'iconlin-spotlights',
			'iconlin-hourglass',
			'iconlin-loading',
			'iconlin-loading2',
			'iconlin-loading3',
			'iconlin-refresh',
			'iconlin-refresh2',
			'iconlin-undo',
			'iconlin-redo',
			'iconlin-jump2',
			'iconlin-undo2',
			'iconlin-redo2',
			'iconlin-sync',
			'iconlin-repeat-one2',
			'iconlin-sync-crossed',
			'iconlin-sync2',
			'iconlin-repeat-one3',
			'iconlin-sync-crossed2',
			'iconlin-return',
			'iconlin-return2',
			'iconlin-refund',
			'iconlin-history',
			'iconlin-history2',
			'iconlin-self-timer',
			'iconlin-clock',
			'iconlin-clock2',
			'iconlin-clock3',
			'iconlin-watch',
			'iconlin-alarm2',
			'iconlin-alarm-add2',
			'iconlin-alarm-remove',
			'iconlin-alarm-check',
			'iconlin-alarm-error',
			'iconlin-timer',
			'iconlin-timer-crossed',
			'iconlin-timer2',
			'iconlin-timer-crossed2',
			'iconlin-download',
			'iconlin-upload',
			'iconlin-download2',
			'iconlin-upload2',
			'iconlin-enter-up',
			'iconlin-enter-down',
			'iconlin-enter-left',
			'iconlin-enter-right',
			'iconlin-exit-up',
			'iconlin-exit-down',
			'iconlin-exit-left',
			'iconlin-exit-right',
			'iconlin-enter-up2',
			'iconlin-enter-down2',
			'iconlin-enter-vertical',
			'iconlin-enter-left2',
			'iconlin-enter-right2',
			'iconlin-enter-horizontal',
			'iconlin-exit-up2',
			'iconlin-exit-down2',
			'iconlin-exit-left2',
			'iconlin-exit-right2',
			'iconlin-cli',
			'iconlin-bug',
			'iconlin-code',
			'iconlin-file-code',
			'iconlin-file-image',
			'iconlin-file-zip',
			'iconlin-file-audio',
			'iconlin-file-video',
			'iconlin-file-preview',
			'iconlin-file-charts',
			'iconlin-file-stats',
			'iconlin-file-spreadsheet',
			'iconlin-link',
			'iconlin-unlink',
			'iconlin-link2',
			'iconlin-unlink2',
			'iconlin-thumbs-up',
			'iconlin-thumbs-down',
			'iconlin-thumbs-up2',
			'iconlin-thumbs-down2',
			'iconlin-thumbs-up3',
			'iconlin-thumbs-down3',
			'iconlin-share',
			'iconlin-share2',
			'iconlin-share3',
			'iconlin-magnifier',
			'iconlin-file-search',
			'iconlin-find-replace',
			'iconlin-zoom-in',
			'iconlin-zoom-out',
			'iconlin-loupe',
			'iconlin-loupe-zoom-in',
			'iconlin-loupe-zoom-out',
			'iconlin-cross',
			'iconlin-menu',
			'iconlin-list',
			'iconlin-list2',
			'iconlin-list3',
			'iconlin-menu2',
			'iconlin-list4',
			'iconlin-menu3',
			'iconlin-exclamation',
			'iconlin-question',
			'iconlin-check',
			'iconlin-cross2',
			'iconlin-plus',
			'iconlin-minus',
			'iconlin-percent',
			'iconlin-chevron-up',
			'iconlin-chevron-down',
			'iconlin-chevron-left',
			'iconlin-chevron-right',
			'iconlin-chevrons-expand-vertical',
			'iconlin-chevrons-expand-horizontal',
			'iconlin-chevrons-contract-vertical',
			'iconlin-chevrons-contract-horizontal',
			'iconlin-arrow-up',
			'iconlin-arrow-down',
			'iconlin-arrow-left',
			'iconlin-arrow-right',
			'iconlin-arrow-up-right',
			'iconlin-arrows-merge',
			'iconlin-arrows-split',
			'iconlin-arrow-divert',
			'iconlin-arrow-return',
			'iconlin-expand',
			'iconlin-contract',
			'iconlin-expand2',
			'iconlin-contract2',
			'iconlin-move',
			'iconlin-tab',
			'iconlin-arrow-wave',
			'iconlin-expand3',
			'iconlin-expand4',
			'iconlin-contract3',
			'iconlin-notification',
			'iconlin-warning',
			'iconlin-notification-circle',
			'iconlin-question-circle',
			'iconlin-menu-circle',
			'iconlin-checkmark-circle',
			'iconlin-cross-circle',
			'iconlin-plus-circle',
			'iconlin-circle-minus',
			'iconlin-percent-circle',
			'iconlin-arrow-up-circle',
			'iconlin-arrow-down-circle',
			'iconlin-arrow-left-circle',
			'iconlin-arrow-right-circle',
			'iconlin-chevron-up-circle',
			'iconlin-chevron-down-circle',
			'iconlin-chevron-left-circle',
			'iconlin-chevron-right-circle',
			'iconlin-backward-circle',
			'iconlin-first-circle',
			'iconlin-previous-circle',
			'iconlin-stop-circle',
			'iconlin-play-circle',
			'iconlin-pause-circle',
			'iconlin-next-circle',
			'iconlin-last-circle',
			'iconlin-forward-circle',
			'iconlin-eject-circle',
			'iconlin-crop',
			'iconlin-frame-expand',
			'iconlin-frame-contract',
			'iconlin-focus',
			'iconlin-transform',
			'iconlin-grid',
			'iconlin-grid-crossed',
			'iconlin-layers',
			'iconlin-layers-crossed',
			'iconlin-toggle',
			'iconlin-rulers',
			'iconlin-ruler',
			'iconlin-funnel',
			'iconlin-flip-horizontal',
			'iconlin-flip-vertical',
			'iconlin-flip-horizontal2',
			'iconlin-flip-vertical2',
			'iconlin-angle',
			'iconlin-angle2',
			'iconlin-subtract',
			'iconlin-combine',
			'iconlin-intersect',
			'iconlin-exclude',
			'iconlin-align-center-vertical',
			'iconlin-align-right',
			'iconlin-align-bottom',
			'iconlin-align-left',
			'iconlin-align-center-horizontal',
			'iconlin-align-top',
			'iconlin-square',
			'iconlin-plus-square',
			'iconlin-minus-square',
			'iconlin-percent-square',
			'iconlin-arrow-up-square',
			'iconlin-arrow-down-square',
			'iconlin-arrow-left-square',
			'iconlin-arrow-right-square',
			'iconlin-chevron-up-square',
			'iconlin-chevron-down-square',
			'iconlin-chevron-left-square',
			'iconlin-chevron-right-square',
			'iconlin-check-square',
			'iconlin-cross-square',
			'iconlin-menu-square',
			'iconlin-prohibited',
			'iconlin-circle',
			'iconlin-radio-button',
			'iconlin-ligature',
			'iconlin-text-format',
			'iconlin-text-format-remove',
			'iconlin-text-size',
			'iconlin-bold',
			'iconlin-italic',
			'iconlin-underline',
			'iconlin-strikethrough',
			'iconlin-highlight',
			'iconlin-text-align-left',
			'iconlin-text-align-center',
			'iconlin-text-align-right',
			'iconlin-text-align-justify',
			'iconlin-line-spacing',
			'iconlin-indent-increase',
			'iconlin-indent-decrease',
			'iconlin-text-wrap',
			'iconlin-pilcrow',
			'iconlin-direction-ltr',
			'iconlin-direction-rtl',
			'iconlin-page-break',
			'iconlin-page-break2',
			'iconlin-sort-alpha-asc',
			'iconlin-sort-alpha-desc',
			'iconlin-sort-numeric-asc',
			'iconlin-sort-numeric-desc',
			'iconlin-sort-amount-asc',
			'iconlin-sort-amount-desc',
			'iconlin-sort-time-asc',
			'iconlin-sort-time-desc',
			'iconlin-sigma',
			'iconlin-pencil-line',
			'iconlin-hand',
			'iconlin-pointer-up',
			'iconlin-pointer-right',
			'iconlin-pointer-down',
			'iconlin-pointer-left',
			'iconlin-finger-tap',
			'iconlin-fingers-tap',
			'iconlin-reminder',
			'iconlin-fingers-crossed',
			'iconlin-fingers-victory',
			'iconlin-gesture-zoom',
			'iconlin-gesture-pinch',
			'iconlin-fingers-scroll-horizontal',
			'iconlin-fingers-scroll-vertical',
			'iconlin-fingers-scroll-left',
			'iconlin-fingers-scroll-right',
			'iconlin-hand2',
			'iconlin-pointer-up2',
			'iconlin-pointer-right2',
			'iconlin-pointer-down2',
			'iconlin-pointer-left2',
			'iconlin-finger-tap2',
			'iconlin-fingers-tap2',
			'iconlin-reminder2',
			'iconlin-gesture-zoom2',
			'iconlin-gesture-pinch2',
			'iconlin-fingers-scroll-horizontal2',
			'iconlin-fingers-scroll-vertical2',
			'iconlin-fingers-scroll-left2',
			'iconlin-fingers-scroll-right2',
			'iconlin-fingers-scroll-vertical3',
			'iconlin-border-style',
			'iconlin-border-all',
			'iconlin-border-outer',
			'iconlin-border-inner',
			'iconlin-border-top',
			'iconlin-border-horizontal',
			'iconlin-border-bottom',
			'iconlin-border-left',
			'iconlin-border-vertical',
			'iconlin-border-right',
			'iconlin-border-none',
			'iconlin-ellipsis',
			'iconlin-uni21',
			'iconlin-uni22',
			'iconlin-uni23',
			'iconlin-uni24',
			'iconlin-uni25',
			'iconlin-uni26',
			'iconlin-uni27',
			'iconlin-uni28',
			'iconlin-uni29',
			'iconlin-uni2a',
			'iconlin-uni2b',
			'iconlin-uni2c',
			'iconlin-uni2d',
			'iconlin-uni2e',
			'iconlin-uni2f',
			'iconlin-uni30',
			'iconlin-uni31',
			'iconlin-uni32',
			'iconlin-uni33',
			'iconlin-uni34',
			'iconlin-uni35',
			'iconlin-uni36',
			'iconlin-uni37',
			'iconlin-uni38',
			'iconlin-uni39',
			'iconlin-uni3a',
			'iconlin-uni3b',
			'iconlin-uni3c',
			'iconlin-uni3d',
			'iconlin-uni3e',
			'iconlin-uni3f',
			'iconlin-uni40',
			'iconlin-uni41',
			'iconlin-uni42',
			'iconlin-uni43',
			'iconlin-uni44',
			'iconlin-uni45',
			'iconlin-uni46',
			'iconlin-uni47',
			'iconlin-uni48',
			'iconlin-uni49',
			'iconlin-uni4a',
			'iconlin-uni4b',
			'iconlin-uni4c',
			'iconlin-uni4d',
			'iconlin-uni4e',
			'iconlin-uni4f',
			'iconlin-uni50',
			'iconlin-uni51',
			'iconlin-uni52',
			'iconlin-uni53',
			'iconlin-uni54',
			'iconlin-uni55',
			'iconlin-uni56',
			'iconlin-uni57',
			'iconlin-uni58',
			'iconlin-uni59',
			'iconlin-uni5a',
			'iconlin-uni5b',
			'iconlin-uni5c',
			'iconlin-uni5d',
			'iconlin-uni5e',
			'iconlin-uni5f',
			'iconlin-uni60',
			'iconlin-uni61',
			'iconlin-uni62',
			'iconlin-uni63',
			'iconlin-uni64',
			'iconlin-uni65',
			'iconlin-uni66',
			'iconlin-uni67',
			'iconlin-uni68',
			'iconlin-uni69',
			'iconlin-uni6a',
			'iconlin-uni6b',
			'iconlin-uni6c',
			'iconlin-uni6d',
			'iconlin-uni6e',
			'iconlin-uni6f',
			'iconlin-uni70',
			'iconlin-uni71',
			'iconlin-uni72',
			'iconlin-uni73',
			'iconlin-uni74',
			'iconlin-uni75',
			'iconlin-uni76',
			'iconlin-uni77',
			'iconlin-uni78',
			'iconlin-uni79',
			'iconlin-uni7a',
			'iconlin-uni7b',
			'iconlin-uni7c',
			'iconlin-uni7d',
			'iconlin-uni7e',
			'iconlin-copyright',

		);

		$icons = array_merge( $icons_ionicons, $icons_eleganticons, $icons_linearicons );

		return apply_filters( 'mrbara_theme_icons', $icons );
	}

	/**
	 * Add new params or add new shortcode to VC
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	function map_shortcodes() {

		// get form id of mailchimp
		$forms    = get_posts( 'post_type=mc4wp-form&number=-1' );
		$form_ids = array(
			esc_html( 'Select a form', 'mrbara' ) => '0',
		);
		foreach ( $forms as $form ) {
			$form_ids[ $form->post_title ] = $form->ID;
		}

		vc_remove_param( 'vc_row', 'parallax_image' );
		vc_remove_param( 'vc_row', 'parallax' );
		vc_remove_param( 'vc_row', 'parallax_speed_bg' );

		$attributes = array(
			array(
				'type'        => 'checkbox',
				'heading'     => esc_html__( 'Enable Parallax effect', 'mrbara' ),
				'param_name'  => 'enable_parallax',
				'group'       => esc_html__( 'Design Options', 'mrbara' ),
				'value'       => array( esc_html__( 'Enable', 'mrbara' ) => 'yes' ),
				'description' => esc_html__( 'Enable this option if you want to have parallax effect on this row. When you enable this option, please set background repeat option as "Theme defaults" to make it works.', 'mrbara' ),
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Overlay', 'mrbara' ),
				'param_name'  => 'overlay',
				'group'       => esc_html__( 'Design Options', 'mrbara' ),
				'value'       => '',
				'description' => esc_html__( 'Select an overlay color for this row', 'mrbara' ),
			),
		);

		vc_add_params( 'vc_row', $attributes );

		$dd_attributes = array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Style', 'mrbara' ),
				'param_name' => 'style',
				'value'      => array(
					esc_html__( 'Style 1', 'mrbara' ) => '1',
					esc_html__( 'Style 2', 'mrbara' ) => '2',
					esc_html__( 'Style 3', 'mrbara' ) => '3',
				),
			),
		);

		vc_add_params( 'vc_wp_custommenu', $dd_attributes );


		// Add instagram shortcode
		vc_map(
			array(
				'name'     => esc_html__( 'Instagram Photos', 'mrbara' ),
				'base'     => 'mrbara_instagram',
				'class'    => '',
				'category' => esc_html__( 'Content', 'mrbara' ),
				'params'   => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'User Name', 'mrbara' ),
						'param_name'  => 'user_id',
						'description' => esc_html__( 'Username of account you want to get feed', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Numbers', 'mrbara' ),
						'param_name'  => 'numbers',
						'value'       => 6,
						'description' => esc_html__( 'Enter number of photos you want to show.', 'mrbara' ),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Image GrayScale', 'mrbara' ),
						'param_name'  => 'image_grayscale',
						'description' => esc_html__( 'Check this option to Converts the image to grayscale', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Slider autoplay', 'mrbara' ),
						'param_name'  => 'autoplay',
						'value'       => '0',
						'description' => esc_html__( 'Duration of animation between slides (in ms). Enter the value is 0 or empty if you want the slider is not autoplay', 'mrbara' ),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Hide Pagination', 'mrbara' ),
						'param_name'  => 'pagination',
						'value'       => array( esc_html__( 'Yes', 'mrbara' ) => 'false' ),
						'description' => esc_html__( 'If "YES" pagination control will be removed.', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'class_name',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'mrbara' ),
					),
				),
			)
		);


		// Add section title shortcode
		vc_map(
			array(
				'name'     => esc_html__( 'Section Title', 'mrbara' ),
				'base'     => 'mrbara_section_title',
				'class'    => '',
				'category' => esc_html__( 'MrBara', 'mrbara' ),
				'params'   => array(
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Style', 'mrbara' ),
						'param_name' => 'style',
						'value'      => array(
							esc_html__( 'Style 1', 'mrbara' ) => '1',
							esc_html__( 'Style 2', 'mrbara' ) => '2',
							esc_html__( 'Style 3', 'mrbara' ) => '3',
							esc_html__( 'Style 4', 'mrbara' ) => '4',
						),
					),

					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Subtitle', 'mrbara' ),
						'param_name'  => 'subtitle',
						'value'       => '',
						'description' => esc_html__( 'Enter the subtitle here', 'mrbara' ),
						'dependency'  => array(
							'element' => 'style',
							'value'   => array( '1', '3' ),
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Subtitle', 'mrbara' ),
						'param_name'  => 'subtitle_2',
						'value'       => esc_html__( 'Subtitle text|extra', 'mrbara' ),
						'description' => esc_html__( 'The subtitle with a special text separated by | symbol.', 'mrbara' ),
						'dependency'  => array(
							'element' => 'style',
							'value'   => array( '2' ),
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Title', 'mrbara' ),
						'param_name'  => 'title',
						'value'       => '',
						'description' => esc_html__( 'Enter the title content', 'mrbara' ),
					),

					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Font Size', 'mrbara' ),
						'param_name' => 'title_font_size',
						'group'      => esc_html__( 'Title Options', 'mrbara' ),
						'value'      => '',

						'description' => esc_html__( 'Enter font size in pixels (Example: 16px)', 'mrbara' ),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Line Height', 'mrbara' ),
						'param_name' => 'title_line_height',
						'group'      => esc_html__( 'Title Options', 'mrbara' ),
						'value'      => '',
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Letter Spacing', 'mrbara' ),
						'param_name'  => 'title_letter_spacing',
						'group'       => esc_html__( 'Title Options', 'mrbara' ),
						'value'       => '',
						'description' => esc_html__( 'Enter letter spacing in pixels (Example: 1px)', 'mrbara' ),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Font Family', 'mrbara' ),
						'param_name' => 'title_font_family',
						'group'      => esc_html__( 'Title Options', 'mrbara' ),
						'value'      => $this->get_font_family(),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Font Style', 'mrbara' ),
						'param_name' => 'title_font_style',
						'group'      => esc_html__( 'Title Options', 'mrbara' ),
						'value'      => array(
							esc_html__( '400 Normal', 'mrbara' )   => '',
							esc_html__( '600 SemiBold', 'mrbara' ) => '600',
							esc_html__( '300 Light', 'mrbara' )    => '300',
							esc_html__( '700 Bold', 'mrbara' )     => '700',
						),
					),

					array(
						'type'        => 'textarea_html',
						'heading'     => esc_html__( 'Description', 'mrbara' ),
						'param_name'  => 'content',
						'value'       => '',
						'description' => esc_html__( 'Enter the title content', 'mrbara' ),
					),
					array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Light Skin', 'mrbara' ),
						'param_name' => 'light_skin',
						'value'      => '',
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Text Align', 'mrbara' ),
						'param_name' => 'text_align',
						'value'      => array(
							esc_html__( 'Left ', 'mrbara' )   => 'text-left',
							esc_html__( 'Right ', 'mrbara' )  => 'text-right',
							esc_html__( 'Center ', 'mrbara' ) => 'text-center',
						),
						'dependency' => array(
							'element' => 'style',
							'value'   => array( '1', '2', '3' ),
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file . ', 'mrbara' ),
					),
				),
			)
		);


		// Add section title shortcode
		vc_map(
			array(
				'name'        => esc_html__( 'Section Title Vertical', 'mrbara' ),
				'base'        => 'mrbara_section_title_ver',
				'class'       => '',
				'description' => esc_html__( 'Displays a vertical section title', 'mrbara' ),
				'category'    => esc_html__( 'MrBara', 'mrbara' ),
				'params'      => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Title', 'mrbara' ),
						'param_name'  => 'content',
						'value'       => '',
						'description' => esc_html__( 'Enter the title content', 'mrbara' ),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Title Alignment', 'mrbara' ),
						'param_name' => 'align',
						'value'      => array(
							esc_html__( 'Left', 'mrbara' )  => '',
							esc_html__( 'Right', 'mrbara' ) => 'align-right',
						),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Number', 'mrbara' ),
						'param_name' => 'number',
						'value'      => '',
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Margin Top', 'mrbara' ),
						'param_name' => 'top',
						'value'      => '',
					),
					array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'White Text', 'mrbara' ),
						'param_name' => 'white_text',
						'value'      => array( esc_html__( 'Yes', 'mrbara' ) => 'true' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file . ', 'mrbara' ),
					),
				),
			)
		);


		// Add section heading shortcode
		vc_map(
			array(
				'name'     => esc_html__( 'MrBara Single Image', 'mrbara' ),
				'base'     => 'mrbara_single_image',
				'class'    => '',
				'category' => esc_html__( 'MrBara', 'mrbara' ),
				'params'   => array(
					array(
						'type'        => 'attach_image',
						'heading'     => esc_html__( 'Image', 'mrbara' ),
						'param_name'  => 'image',
						'value'       => '',
						'description' => esc_html__( 'Select an image from media library', 'mrbara' ),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Alignment', 'mrbara' ),
						'param_name' => 'align',
						'value'      => array(
							esc_html__( 'Left', 'mrbara' )   => '',
							esc_html__( 'Right', 'mrbara' )  => 'text-right',
							esc_html__( 'Center', 'mrbara' ) => 'text-center',
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file . ', 'mrbara' ),
					),
				),
			)
		);

		// About Us
		vc_map(
			array(
				'name'     => esc_html__( 'About', 'mrbara' ),
				'base'     => 'mrbara_about',
				'category' => esc_html__( 'MrBara', 'mrbara' ),
				'params'   => array(
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Skin', 'mrbara' ),
						'param_name' => 'skin',
						'group'      => esc_html__( 'General', 'mrbara' ),
						'value'      => array(
							esc_html__( 'Light', 'mrbara' ) => '',
							esc_html__( 'Gray', 'mrbara' )  => 'gray',
						),

					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Title', 'mrbara' ),
						'description' => esc_html__( 'Enter the title here!', 'mrbara' ),
						'param_name'  => 'title',
						'group'       => esc_html__( 'General', 'mrbara' ),
						'value'       => '',
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Font Size', 'mrbara' ),
						'param_name' => 'title_font_size',
						'group'      => esc_html__( 'Title Options', 'mrbara' ),
						'value'      => '',
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Font Family', 'mrbara' ),
						'param_name' => 'title_font_family',
						'group'      => esc_html__( 'Title Options', 'mrbara' ),
						'value'      => $this->get_font_family(),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Font Style', 'mrbara' ),
						'param_name' => 'title_font_style',
						'group'      => esc_html__( 'Title Options', 'mrbara' ),
						'value'      => array(
							esc_html__( '400 Normal', 'mrbara' )   => '',
							esc_html__( '600 SemiBold', 'mrbara' ) => '600',
							esc_html__( '300 Light', 'mrbara' )    => '300',
							esc_html__( '700 Bold', 'mrbara' )     => '700',
						),

					),
					array(
						'type'        => 'textarea',
						'heading'     => esc_html__( 'Desc', 'mrbara' ),
						'param_name'  => 'desc',
						'group'       => esc_html__( 'General', 'mrbara' ),
						'value'       => '',
						'description' => esc_html__( 'Enter the description', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Name', 'mrbara' ),
						'description' => esc_html__( 'Enter your name!', 'mrbara' ),
						'param_name'  => 'name',
						'group'       => esc_html__( 'General', 'mrbara' ),
						'value'       => '',
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Job', 'mrbara' ),
						'group'       => esc_html__( 'General', 'mrbara' ),
						'description' => esc_html__( 'Enter your job!', 'mrbara' ),
						'param_name'  => 'job',
						'value'       => '',
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Video file URL', 'mrbara' ),
						'group'       => esc_html__( 'Video', 'mrbara' ),
						'description' => esc_html__( 'Only allow mp4, webm, ogv files', 'mrbara' ),
						'param_name'  => 'video',
						'value'       => '',
					),
					array(
						'type'       => 'attach_image',
						'group'      => esc_html__( 'Video', 'mrbara' ),
						'heading'    => esc_html__( 'Poster Image', 'mrbara' ),
						'param_name' => 'image',
					),
					array(
						'type'       => 'colorpicker',
						'heading'    => esc_html__( 'Background Color Overlay', 'mrbara' ),
						'param_name' => 'bg_color_overlay',
						'group'      => esc_html__( 'Video', 'mrbara' ),
						'value'      => '',
					),
					array(
						'type'        => 'textarea_html',
						'heading'     => esc_html__( 'Title Video', 'mrbara' ),
						'param_name'  => 'content',
						'group'       => esc_html__( 'Video', 'mrbara' ),
						'value'       => '',
						'description' => esc_html__( 'Enter the titile of video', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'group'       => esc_html__( 'Video', 'mrbara' ),
						'heading'     => esc_html__( 'Height', 'mrbara' ),
						'param_name'  => 'height',
						'value'       => '',
						'description' => esc_html__( 'Specify height of video banner. Enter height in pixels (Example: 400px)', 'mrbara' ),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Mute', 'mrbara' ),
						'group'       => esc_html__( 'Video', 'mrbara' ),
						'param_name'  => 'mute',
						'value'       => array( esc_html__( 'Yes', 'mrbara' ) => 'true' ),
						'description' => esc_html__( 'Mute this video by default', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'group'       => esc_html__( 'General', 'mrbara' ),
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file . ', 'mrbara' ),
					),
				),
			)
		);

		// Add shortcode About 2
		vc_map(
			array(
				'name'     => esc_html__( 'About 2', 'mrbara' ),
				'base'     => 'mrbara_about_2',
				'class'    => '',
				'category' => esc_html__( 'MrBara', 'mrbara' ),
				'params'   => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Sub Title', 'mrbara' ),
						'param_name'  => 'subtitle',
						'value'       => '',
						'description' => esc_html__( 'Enter the subtitle content', 'mrbara' ),
					),
					array(
						'type'        => 'textarea',
						'heading'     => esc_html__( 'Title', 'mrbara' ),
						'param_name'  => 'content',
						'value'       => '',
						'description' => esc_html__( 'Enter the title content', 'mrbara' ),
					),
					array(
						'type'        => 'textarea',
						'heading'     => esc_html__( 'Description', 'mrbara' ),
						'param_name'  => 'desc',
						'value'       => '',
						'description' => esc_html__( 'Enter a short description for section', 'mrbara' ),
					),
					array(
						'type'       => 'attach_image',
						'heading'    => esc_html__( 'About Image', 'mrbara' ),
						'param_name' => 'image',
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file . ', 'mrbara' ),
					),
				),
			)
		);

		// Add shortcode About 3
		vc_map(
			array(
				'name'     => esc_html__( 'About 3', 'mrbara' ),
				'base'     => 'mrbara_about_3',
				'class'    => '',
				'category' => esc_html__( 'MrBara', 'mrbara' ),
				'params'   => array(
					array(
						'type'        => 'textarea_html',
						'heading'     => esc_html__( 'Title', 'mrbara' ),
						'param_name'  => 'content',
						'value'       => '',
						'description' => esc_html__( 'Enter the title content', 'mrbara' ),
					),
					array(
						'type'        => 'textarea',
						'heading'     => esc_html__( 'Description', 'mrbara' ),
						'param_name'  => 'desc',
						'value'       => '',
						'description' => esc_html__( 'Enter a short description for section', 'mrbara' ),
					),
					array(
						'type'       => 'attach_image',
						'heading'    => esc_html__( 'About Image', 'mrbara' ),
						'param_name' => 'image',
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file . ', 'mrbara' ),
					),
				),
			)
		);

		// Add shortcode About 4
		vc_map(
			array(
				'name'     => esc_html__( 'About 4', 'mrbara' ),
				'base'     => 'mrbara_about_4',
				'class'    => '',
				'category' => esc_html__( 'MrBara', 'mrbara' ),
				'params'   => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Sub Title', 'mrbara' ),
						'param_name'  => 'subtitle',
						'value'       => '',
						'description' => esc_html__( 'Enter the subtitle content', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Title', 'mrbara' ),
						'param_name'  => 'title',
						'value'       => '',
						'description' => esc_html__( 'Enter the title content', 'mrbara' ),
					),
					array(
						'type'        => 'textarea_html',
						'heading'     => esc_html__( 'Description', 'mrbara' ),
						'param_name'  => 'content',
						'value'       => '',
						'description' => esc_html__( 'Enter a description for section', 'mrbara' ),
					),
					array(
						'type'       => 'attach_image',
						'heading'    => esc_html__( 'About Image', 'mrbara' ),
						'param_name' => 'image',
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file . ', 'mrbara' ),
					),
				),
			)
		);

		// Add shortcode mrbara heading
		vc_map(
			array(
				'name'     => esc_html__( 'MrBara Heading', 'mrbara' ),
				'base'     => 'mrbara_heading',
				'class'    => '',
				'category' => esc_html__( 'MrBara', 'mrbara' ),
				'params'   => array(
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Style', 'mrbara' ),
						'param_name' => 'style',
						'value'      => array(
							esc_html__( 'Style 1', 'mrbara' ) => '1',
							esc_html__( 'Style 2', 'mrbara' ) => '2',
							esc_html__( 'Style 3', 'mrbara' ) => '3',
							esc_html__( 'Style 4', 'mrbara' ) => '4',
							esc_html__( 'Style 5', 'mrbara' ) => '5',
							esc_html__( 'Style 6', 'mrbara' ) => '6',
						),

					),
					array(
						'type'       => 'textarea',
						'heading'    => esc_html__( 'Text', 'mrbara' ),
						'param_name' => 'content',
						'value'      => '',
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Font Size', 'mrbara' ),
						'param_name'  => 'font_size',
						'value'       => '',
						'description' => esc_html__( 'Enter font size in pixels (Example: 16px)', 'mrbara' ),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Line Height', 'mrbara' ),
						'param_name' => 'line_height',
						'value'      => '',
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Letter Spacing', 'mrbara' ),
						'param_name'  => 'letter_spacing',
						'value'       => '',
						'description' => esc_html__( 'Enter letter spacing in pixels (Example: 1px)', 'mrbara' ),
					),
					array(
						'type'       => 'colorpicker',
						'heading'    => esc_html__( 'Color', 'mrbara' ),
						'param_name' => 'color',
						'value'      => '',

					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Font Family', 'mrbara' ),
						'param_name' => 'font_family',
						'value'      => $this->get_font_family(),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Font Style', 'mrbara' ),
						'param_name' => 'font_style',
						'value'      => array(
							esc_html__( '400 Normal', 'mrbara' )   => '',
							esc_html__( '600 SemiBold', 'mrbara' ) => '600',
							esc_html__( '300 Light', 'mrbara' )    => '300',
							esc_html__( '700 Bold', 'mrbara' )     => '700',
						),

					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Text Align', 'mrbara' ),
						'param_name' => 'align',
						'value'      => array(
							esc_html__( 'Left', 'mrbara' )   => 'text-left',
							esc_html__( 'Center', 'mrbara' ) => 'text-center',
							esc_html__( 'Right', 'mrbara' )  => 'text-right',
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file . ', 'mrbara' ),
					),
					array(
						'type'       => 'css_editor',
						'heading'    => esc_html__( 'CSS', 'mrbara' ),
						'param_name' => 'css',
						'group'      => esc_html__( 'Design options', 'mrbara' ),
					),
				),
			)
		);

		// Link
		vc_map(
			array(
				'name'     => esc_html__( 'MrBara Link', 'mrbara' ),
				'base'     => 'mrbara_link',
				'category' => esc_html__( 'MrBara', 'mrbara' ),
				'params'   => array(
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Style', 'mrbara' ),
						'param_name' => 'style',
						'value'      => array(
							esc_html__( 'Style 1', 'mrbara' ) => '1',
							esc_html__( 'Style 2', 'mrbara' ) => '2',
						),

					),
					array(
						'type'        => 'textarea',
						'heading'     => esc_html__( 'Text', 'mrbara' ),
						'param_name'  => 'content',
						'admin_label' => true,
						'value'       => esc_html__( 'Text on the link', 'mrbara' ),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Text Align', 'mrbara' ),
						'param_name' => 'align',
						'value'      => array(
							esc_html__( 'Left', 'mrbara' )   => '',
							esc_html__( 'Right', 'mrbara' )  => 'text-right',
							esc_html__( 'Center', 'mrbara' ) => 'text-center',
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Font Size', 'mrbara' ),
						'param_name'  => 'font_size',
						'value'       => '',
						'description' => esc_html__( 'Enter font size in pixels (Example: 16px)', 'mrbara' ),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Line Height', 'mrbara' ),
						'param_name' => 'line_height',
						'value'      => '',
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Font Family', 'mrbara' ),
						'param_name' => 'font_family',
						'value'      => $this->get_font_family(),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Font Weight', 'mrbara' ),
						'param_name' => 'font_style',
						'value'      => array(
							esc_html__( '400 Normal', 'mrbara' )   => '',
							esc_html__( '600 SemiBold', 'mrbara' ) => '600',
							esc_html__( '300 Light', 'mrbara' )    => '300',
							esc_html__( '700 Bold', 'mrbara' )     => '700',
						),
					),
					array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Italic', 'mrbara' ),
						'param_name' => 'italic',
						'value'      => '',
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Color', 'mrbara' ),
						'param_name' => 'link_color',
						'value'      => array(
							esc_html__( 'Primary Color', 'mrbara' ) => 'primary',
							esc_html__( 'Dark', 'mrbara' )          => 'dark',
							esc_html__( 'Gray', 'mrbara' )          => 'gray',
							esc_html__( 'Light', 'mrbara' )         => 'light',
						),

					),
					array(
						'type'        => 'vc_link',
						'heading'     => esc_html__( 'URL (link)', 'mrbara' ),
						'param_name'  => 'link',
						'value'       => '',
						'description' => esc_html__( 'Add URL link', 'mrbara' ),
					),
					array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Show Icon', 'mrbara' ),
						'param_name' => 'link_icon',
						'value'      => '',
					),

					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'mrbara' ),
					),
				),
			)
		);

		// Add Counter shortcode
		vc_map(
			array(
				'name'     => esc_html__( 'Counter', 'mrbara' ),
				'base'     => 'mrbara_counter',
				'class'    => '',
				'category' => esc_html__( 'MrBara', 'mrbara' ),
				'params'   => array(

					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Style', 'mrbara' ),
						'param_name' => 'style',
						'value'      => array(
							esc_html__( 'Style 1', 'mrbara' ) => 'style1',
							esc_html__( 'Style 2', 'mrbara' ) => 'style2',
						),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Number', 'mrbara' ),
						'param_name' => 'number',
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Step', 'mrbara' ),
						'param_name' => 'step',
						'value'      => '5',
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Title', 'mrbara' ),
						'param_name' => 'title',
					),
					array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Bold Text Number', 'mrbara' ),
						'param_name' => 'bold',
						'value'      => '',
						'dependency' => array(
							'element' => 'style',
							'value'   => array( 'style2' ),
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file . ', 'mrbara' ),
					),
				),
			)
		);


		// Add counter 2 shortcode
		vc_map(
			array(
				'name'     => esc_html__( 'Countdown', 'mrbara' ),
				'base'     => 'mrbara_countdown',
				'class'    => '',
				'category' => esc_html__( 'MrBara', 'mrbara' ),
				'params'   => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Date', 'mrbara' ),
						'param_name'  => 'date',
						'value'       => '',
						'description' => esc_html__( 'Enter the date by format: YYYY/MM/DD', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file . ', 'mrbara' ),
					),
				),
			)
		);

		// Add Call to Comming soon shortcode
		vc_map(
			array(
				'name'     => esc_html__( 'Countdown 2', 'mrbara' ),
				'base'     => 'mrbara_coming_soon',
				'class'    => '',
				'category' => esc_html__( 'MrBara', 'mrbara' ),
				'params'   => array(
					array(
						'type'       => 'textarea_html',
						'heading'    => esc_html__( 'Title', 'mrbara' ),
						'param_name' => 'content',
						'value'      => '',
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Date', 'mrbara' ),
						'param_name'  => 'date',
						'value'       => '',
						'description' => esc_html__( 'Enter the date by format: YYYY/MM/DD', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file . ', 'mrbara' ),
					),
				),
			)
		);

		// Add team shortcode
		vc_map(
			array(
				'name'     => esc_html__( 'Team', 'mrbara' ),
				'base'     => 'mrbara_team',
				'class'    => '',
				'category' => esc_html__( 'MrBara', 'mrbara' ),
				'params'   => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Total members', 'mrbara' ),
						'param_name'  => 'total',
						'value'       => '3',
						'description' => esc_html__( 'Set numbers of members to show . ', 'mrbara' ),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Columns', 'mrbara' ),
						'param_name' => 'columns',
						'value'      => array(
							esc_html__( '3 Columns', 'mrbara' ) => '3',
							esc_html__( '4 Columns', 'mrbara' ) => '4',
							esc_html__( '6 Columns', 'mrbara' ) => '6',
						),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Category', 'mrbara' ),
						'param_name'  => 'category',
						'value'       => $this->get_categories( 'team_group' ),
						'description' => esc_html__( 'Select a category or all categories.', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file . ', 'mrbara' ),
					),
				),
			)
		);


		// Add images carousel shortcode
		vc_map(
			array(
				'name'     => esc_html__( 'Images Carousel', 'mrbara' ),
				'base'     => 'mrbara_image_carousel',
				'class'    => '',
				'category' => esc_html__( 'MrBara', 'mrbara' ),
				'params'   => array(
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Style', 'mrbara' ),
						'param_name' => 'style',
						'value'      => array(
							esc_html__( 'Style 1', 'mrbara' ) => '1',
							esc_html__( 'Style 2', 'mrbara' ) => '2',
						),
					),
					array(
						'type'        => 'attach_images',
						'heading'     => esc_html__( 'Images', 'mrbara' ),
						'param_name'  => 'images',
						'value'       => '',
						'description' => esc_html__( 'Select images from media library', 'mrbara' ),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Columns', 'mrbara' ),
						'param_name' => 'number',
						'value'      => '6',
						'dependency' => array(
							'element' => 'style',
							'value'   => array( '1' ),
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Image size', 'mrbara' ),
						'param_name'  => 'image_size',
						'description' => esc_html__( 'Enter image size . Example: thumbnail, medium, large, full . Leave empty to use "thumbnail" size . ', 'mrbara' ),
					),
					array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Image Opacity', 'mrbara' ),
						'param_name' => 'image_opacity',
						'value'      => '',
						'dependency' => array(
							'element' => 'style',
							'value'   => array( '1' ),
						),
					),
					array(
						'type'        => 'exploded_textarea_safe',
						'heading'     => esc_html__( 'Custom links', 'mrbara' ),
						'param_name'  => 'custom_links',
						'description' => esc_html__( 'Enter links for each slide here. Divide links with linebreaks (Enter).', 'mrbara' ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Custom link target', 'mrbara' ),
						'param_name'  => 'custom_links_target',
						'value'       => array(
							esc_html__( 'Same window', 'mrbara' ) => '_self',
							esc_html__( 'New window', 'mrbara' )  => '_blank',
						),
						'description' => esc_html__( 'Select where to open custom links.', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Slider autoplay', 'mrbara' ),
						'param_name'  => 'autoplay',
						'value'       => '0',
						'description' => esc_html__( 'Duration of animation between slides (in ms). Enter the value is 0 or empty if you want the slider is not autoplay', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file . ', 'mrbara' ),
					),
				),
			)
		);

		// Add images carousel  2 shortcode
		vc_map(
			array(
				'name'     => esc_html__( 'Products Images Carousel', 'mrbara' ),
				'base'     => 'mrbara_products_images_carousel',
				'class'    => '',
				'category' => esc_html__( 'MrBara', 'mrbara' ),
				'params'   => array(
					array(
						'type'        => 'autocomplete',
						'heading'     => esc_html__( 'Products', 'mrbara' ),
						'param_name'  => 'ids',
						'settings'    => array(
							'multiple' => true,
							'sortable' => true,
							'values'   => $this->get_products(),
						),
						'save_always' => true,
						'description' => esc_html__( 'Enter a products', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Slider autoplay', 'mrbara' ),
						'param_name'  => 'autoplay',
						'value'       => '0',
						'description' => esc_html__( 'Duration of animation between slides (in ms). Enter the value is 0 or empty if you want the slider is not autoplay', 'mrbara' ),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Hide Navigation', 'mrbara' ),
						'param_name'  => 'navigation',
						'value'       => array( esc_html__( 'Yes', 'mrbara' ) => 'false' ),
						'description' => esc_html__( 'If "YES" prev/next control will be removed.', 'mrbara' ),
						'dependency'  => array(
							'element' => 'style',
							'value'   => array( 'style1' ),
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file . ', 'mrbara' ),
					),
				),
			)
		);

		// Add icon box shortcode
		vc_map(
			array(
				'name'              => esc_html__( 'Icon Box 1', 'mrbara' ),
				'base'              => 'mrbara_icon_box_1',
				'class'             => '',
				'category'          => esc_html__( 'MrBara', 'mrbara' ),
				'admin_enqueue_css' => MRBARA_ADDONS_URL . '/assets/css/vc/icon-field.css',
				'params'            => array(
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Style', 'mrbara' ),
						'param_name' => 'style',
						'value'      => array(
							esc_html__( 'Style 1', 'mrbara' ) => '1',
							esc_html__( 'Style 2', 'mrbara' ) => '2',
							esc_html__( 'Style 3', 'mrbara' ) => '3',
							esc_html__( 'Style 4', 'mrbara' ) => '4',
							esc_html__( 'Style 5', 'mrbara' ) => '5',
						),
					),
					array(
						'type'       => 'icon',
						'heading'    => esc_html__( 'Icon', 'mrbara' ),
						'param_name' => 'icon',
						'value'      => '',
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Icon Color', 'mrbara' ),
						'param_name' => 'icon_color',
						'value'      => array(
							esc_html__( 'Primary Color', 'mrbara' ) => '',
							esc_html__( 'Dark', 'mrbara' )          => 'dark',
							esc_html__( 'Gray', 'mrbara' )          => 'gray',
						),
						'dependency' => array(
							'element' => 'style',
							'value'   => array( '2', '5' ),
						),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Icon Opacity', 'mrbara' ),
						'description' => esc_html__( 'Check this to show icon has opacity', 'mrbara' ),
						'param_name'  => 'icon_opacity',
						'value'       => '',
						'dependency'  => array(
							'element' => 'style',
							'value'   => array( '1' ),
						),
					),
					array(
						'type'        => 'textarea_html',
						'heading'     => esc_html__( 'Title', 'mrbara' ),
						'param_name'  => 'content',
						'value'       => '',
						'description' => esc_html__( 'Enter the content of this box', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'SubTitle', 'mrbara' ),
						'param_name'  => 'subtitle',
						'value'       => '',
						'description' => esc_html__( 'Enter the subtitle content', 'mrbara' ),
						'dependency'  => array(
							'element' => 'style',
							'value'   => array( '2', '3', '4', '5' ),
						),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Text alignment', 'mrbara' ),
						'param_name' => 'text_align',
						'value'      => array(
							esc_html__( 'Center', 'mrbara' ) => 'center',
							esc_html__( 'Left', 'mrbara' )   => 'left',
						),
					),
					array(
						'type'       => 'vc_link',
						'heading'    => esc_html__( 'Link', 'mrbara' ),
						'param_name' => 'link',
						'value'      => '',
					),
					array(
						'type'       => 'css_editor',
						'heading'    => esc_html__( 'CSS', 'mrbara' ),
						'param_name' => 'css',
						'group'      => esc_html__( 'Design options', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file . ', 'mrbara' ),
					),
				),
			)
		);

		// Add icon box shortcode
		vc_map(
			array(
				'name'              => esc_html__( 'Icon Box 2', 'mrbara' ),
				'base'              => 'mrbara_icon_box_2',
				'class'             => '',
				'category'          => esc_html__( 'MrBara', 'mrbara' ),
				'admin_enqueue_css' => MRBARA_ADDONS_URL . '/assets/css/vc/icon-field.css',
				'params'            => array(
					array(
						'type'       => 'icon',
						'heading'    => esc_html__( 'Icon', 'mrbara' ),
						'param_name' => 'icon',
						'value'      => '',
					),
					array(
						'type'        => 'colorpicker',
						'heading'     => esc_html__( 'Icon Color', 'mrbara' ),
						'param_name'  => 'icon_color',
						'value'       => '',
						'description' => esc_html__( 'Select an color for this icon', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Title', 'mrbara' ),
						'description' => esc_html__( 'Enter the title here!', 'mrbara' ),
						'param_name'  => 'title',
						'value'       => '',
					),
					array(
						'type'        => 'textarea_html',
						'heading'     => esc_html__( 'Content', 'mrbara' ),
						'param_name'  => 'content',
						'value'       => '',
						'description' => esc_html__( 'Enter the content of this box', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file . ', 'mrbara' ),
					),
				),
			)
		);

		// Add icon list shortcode
		vc_map(
			array(
				'name'              => esc_html__( 'Icon List', 'mrbara' ),
				'base'              => 'mrbara_icon_list',
				'class'             => '',
				'category'          => esc_html__( 'MrBara', 'mrbara' ),
				'admin_enqueue_css' => MRBARA_ADDONS_URL . '/assets/css/vc/icon-field.css',
				'params'            => array(
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Style', 'mrbara' ),
						'param_name' => 'style',
						'value'      => array(
							esc_html__( 'Style 1', 'mrbara' ) => 'style1',
							esc_html__( 'Style 2', 'mrbara' ) => 'style2',
							esc_html__( 'Style 3', 'mrbara' ) => 'style3',
							esc_html__( 'Style 4', 'mrbara' ) => 'style4',
						),

					),
					array(
						'type'       => 'icon',
						'heading'    => esc_html__( 'Icon', 'mrbara' ),
						'param_name' => 'icon',
						'value'      => '',
					),
					array(
						'type'        => 'textarea_html',
						'heading'     => esc_html__( 'Content', 'mrbara' ),
						'param_name'  => 'content',
						'value'       => '',
						'description' => esc_html__( 'Enter the content of this icon', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file . ', 'mrbara' ),
					),
				),
			)
		);

		// Divider
		vc_map(
			array(
				'name'     => esc_html__( 'Divider', 'mrbara' ),
				'base'     => 'mrbara_divider',
				'category' => esc_html__( 'MrBara', 'mrbara' ),
				'params'   => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Title', 'mrbara' ),
						'param_name'  => 'title',
						'value'       => '',
						'admin_label' => true,
						'description' => esc_html__( 'Enter the title of this box.', 'mrbara' ),
					),
					array(
						'type'        => 'textarea_html',
						'heading'     => esc_html__( 'Content', 'mrbara' ),
						'param_name'  => 'content',
						'value'       => '',
						'description' => esc_html__( 'Enter the content of this box.', 'mrbara' ),
					),
					array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Light Skin', 'mrbara' ),
						'param_name' => 'light_skin',
						'value'      => '',
					),
					array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Box shadow', 'mrbara' ),
						'param_name' => 'box_shadow',
						'value'      => '',
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'mrbara' ),
					),
				),
			)
		);

		// Add Facts Box shortcode
		vc_map(
			array(
				'name'              => esc_html__( 'Facts Box', 'mrbara' ),
				'base'              => 'mrbara_facts_box',
				'class'             => '',
				'category'          => esc_html__( 'MrBara', 'mrbara' ),
				'admin_enqueue_css' => MRBARA_ADDONS_URL . '/assets/css/vc/icon-field.css',
				'params'            => array(
					array(
						'type'       => 'icon',
						'heading'    => esc_html__( 'Icon', 'mrbara' ),
						'param_name' => 'icon',
						'value'      => '',
					),
					array(
						'type'        => 'colorpicker',
						'heading'     => esc_html__( 'Icon Color', 'mrbara' ),
						'param_name'  => 'icon_color',
						'value'       => '',
						'description' => esc_html__( 'Select an color for this icon', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Number', 'mrbara' ),
						'description' => esc_html__( 'Enter the number here!', 'mrbara' ),
						'param_name'  => 'number',
						'value'       => '',
					),
					array(
						'type'        => 'textarea_html',
						'heading'     => esc_html__( 'Content', 'mrbara' ),
						'param_name'  => 'content',
						'value'       => '',
						'description' => esc_html__( 'Enter the content of this box', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file . ', 'mrbara' ),
					),
				),
			)
		);

		// get form id of mailchimp
		$contact_forms    = get_posts( 'post_type=wpcf7_contact_form&number=-1' );
		$contact_form_ids = array();
		foreach ( $contact_forms as $form ) {
			$contact_form_ids[ $form->post_title ] = $form->ID;
		}

		// Add Contact Form 7 shortcode
		vc_map(
			array(
				'name'     => esc_html__( 'MrBara Contact Form 7', 'mrbara' ),
				'base'     => 'mrbara_contact_form',
				'class'    => '',
				'category' => esc_html__( 'MrBara', 'mrbara' ),
				'params'   => array(
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Contact Form', 'mrbara' ),
						'param_name' => 'form',
						'value'      => $contact_form_ids,
					),
					array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Dark Skin', 'mrbara' ),
						'param_name' => 'dark_skin',
						'value'      => '',
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'mrbara' ),
					),
				),
			)
		);

		// Add Featured box shortcode
		vc_map(
			array(
				'name'     => esc_html__( 'Feature Box', 'mrbara' ),
				'base'     => 'mrbara_feature_box',
				'class'    => '',
				'category' => esc_html__( 'MrBara', 'mrbara' ),
				'params'   => array(
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Style', 'mrbara' ),
						'param_name' => 'style',
						'value'      => array(
							esc_html__( 'Style 1', 'mrbara' ) => '1',
							esc_html__( 'Style 2', 'mrbara' ) => '2',
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Title', 'mrbara' ),
						'param_name'  => 'title',
						'value'       => '',
						'description' => esc_html__( 'Enter the title content', 'mrbara' ),
						'dependency'  => array(
							'element' => 'style',
							'value'   => array( '2' ),
						),
					),
					array(
						'type'        => 'textarea',
						'heading'     => esc_html__( 'Title', 'mrbara' ),
						'param_name'  => 'content',
						'value'       => '',
						'description' => esc_html__( 'Enter the title content', 'mrbara' ),
						'dependency'  => array(
							'element' => 'style',
							'value'   => array( '1' ),
						),
					),
					array(
						'type'       => 'colorpicker',
						'heading'    => esc_html__( 'Title Color', 'mrbara' ),
						'param_name' => 'title_color',
						'value'      => '',
					),
					array(
						'type'        => 'textarea',
						'heading'     => esc_html__( 'Description', 'mrbara' ),
						'param_name'  => 'desc',
						'value'       => '',
						'description' => esc_html__( 'Enter a short description for section', 'mrbara' ),
					),
					array(
						'type'       => 'colorpicker',
						'heading'    => esc_html__( 'Description Color', 'mrbara' ),
						'param_name' => 'desc_color',
						'value'      => '',
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file . ', 'mrbara' ),
					),
				),
			)
		);

		// Add Featured box shortcode
		vc_map(
			array(
				'name'     => esc_html__( 'Info Box', 'mrbara' ),
				'base'     => 'mrbara_info_box',
				'class'    => '',
				'category' => esc_html__( 'MrBara', 'mrbara' ),
				'params'   => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Title', 'mrbara' ),
						'param_name'  => 'title',
						'value'       => '',
						'description' => esc_html__( 'Enter the title in this format "abc|xyz" to break line', 'mrbara' ),
					),
					array(
						'type'        => 'textarea_html',
						'heading'     => esc_html__( 'Description', 'mrbara' ),
						'param_name'  => 'content',
						'value'       => '',
						'description' => esc_html__( 'Enter a short description', 'mrbara' ),
					),

					array(
						'type'        => 'vc_link',
						'heading'     => esc_html__( 'URL (link)', 'mrbara' ),
						'param_name'  => 'link',
						'value'       => '',
						'description' => esc_html__( 'Add link to button', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file . ', 'mrbara' ),
					),
				),
			)
		);

		// Video Banner
		vc_map(
			array(
				'name'     => esc_html__( 'Video Banner', 'mrbara' ),
				'base'     => 'mrbara_video',
				'category' => esc_html__( 'MrBara', 'mrbara' ),
				'params'   => array(
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Style', 'mrbara' ),
						'param_name' => 'style',
						'value'      => array(
							esc_html__( 'Style 1', 'mrbara' ) => 'style1',
							esc_html__( 'Style 2', 'mrbara' ) => 'style2',
							esc_html__( 'Style 3', 'mrbara' ) => 'style3',
							esc_html__( 'Style 4', 'mrbara' ) => 'style4',
							esc_html__( 'Style 5', 'mrbara' ) => 'style5',
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Video file URL', 'mrbara' ),
						'description' => esc_html__( 'Only allow mp4, webm, ogv files', 'mrbara' ),
						'param_name'  => 'video',
						'value'       => '',
					),
					array(
						'type'       => 'attach_image',
						'heading'    => esc_html__( 'Poster Image', 'mrbara' ),
						'param_name' => 'image',
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Height', 'mrbara' ),
						'param_name'  => 'height',
						'value'       => '',
						'description' => esc_html__( 'Specify height of video banner. Enter height in pixels (Example: 160px)', 'mrbara' ),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Mute', 'mrbara' ),
						'param_name'  => 'mute',
						'value'       => array( esc_html__( 'Yes', 'mrbara' ) => 'true' ),
						'description' => esc_html__( 'Mute this video by default', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Video title', 'mrbara' ),
						'description' => esc_html__( 'Enter the title of video', 'mrbara' ),
						'param_name'  => 'title',
						'value'       => '',
						'dependency'  => array(
							'element' => 'style',
							'value'   => array( 'style2' ),
						),
					),

					array(
						'type'        => 'textarea_html',
						'heading'     => esc_html__( 'Description', 'mrbara' ),
						'param_name'  => 'content',
						'value'       => '',
						'description' => esc_html__( 'Enter the description', 'mrbara' ),
						'dependency'  => array(
							'element' => 'style',
							'value'   => array( 'style2', 'style4' ),
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file . ', 'mrbara' ),
					),
				),
			)
		);

		// Add products shortcode
		vc_map(
			array(
				'name'     => esc_html__( 'Products Carousel', 'mrbara' ),
				'base'     => 'mrbara_products_carousel',
				'class'    => '',
				'category' => esc_html__( 'MrBara', 'mrbara' ),
				'params'   => array(
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Style', 'mrbara' ),
						'param_name' => 'style',
						'value'      => array(
							esc_html__( 'Style 1', 'mrbara' ) => '1',
							esc_html__( 'Style 2', 'mrbara' ) => '2',
						),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Title', 'mrbara' ),
						'param_name' => 'title',
						'value'      => '',
						'dependency' => array(
							'element' => 'style',
							'value'   => array( '2' ),
						),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Products', 'mrbara' ),
						'param_name' => 'products',
						'value'      => array(
							esc_html__( 'Recent', 'mrbara' )       => 'recent',
							esc_html__( 'Featured', 'mrbara' )     => 'featured',
							esc_html__( 'Best Selling', 'mrbara' ) => 'best_selling',
							esc_html__( 'Top Rated', 'mrbara' )    => 'top_rated',
							esc_html__( 'On Sale', 'mrbara' )      => 'sale',
						),
					),
					array(
						'type'        => 'autocomplete',
						'heading'     => esc_html__( 'Product Categories', 'mrbara' ),
						'param_name'  => 'categories',
						'settings'    => array(
							'multiple' => true,
							'sortable' => true,
							'values'   => $this->get_product_categories(),
						),
						'save_always' => true,
						'description' => esc_html__( 'Enter product categories', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Products per view', 'mrbara' ),
						'param_name'  => 'per_page',
						'value'       => '12',
						'description' => esc_html__( 'Set numbers of products you want to display at the same time.', 'mrbara' ),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Number of columns', 'mrbara' ),
						'param_name' => 'number',
						'value'      => array(
							esc_html__( '4 Columns', 'mrbara' ) => '4',
							esc_html__( '3 Columns', 'mrbara' ) => '3',
							esc_html__( '5 Columns', 'mrbara' ) => '5',
						),
						'dependency' => array(
							'element' => 'style',
							'value'   => array( '1' ),
						),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Order By', 'mrbara' ),
						'param_name'  => 'orderby',
						'value'       => array(
							''                                   => '',
							esc_html__( 'Date', 'mrbara' )       => 'date',
							esc_html__( 'Title', 'mrbara' )      => 'title',
							esc_html__( 'Menu Order', 'mrbara' ) => 'menu_order',
							esc_html__( 'Random', 'mrbara' )     => 'rand',
						),
						'dependency'  => array(
							'element' => 'products',
							'value'   => array( 'top_rated', 'sale', 'featured' ),
						),
						'description' => esc_html__( 'Select to order products. Leave empty to use the default order by of theme.', 'mrbara' ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Order', 'mrbara' ),
						'param_name'  => 'order',
						'value'       => array(
							''                                    => '',
							esc_html__( 'Ascending ', 'mrbara' )  => 'asc',
							esc_html__( 'Descending ', 'mrbara' ) => 'desc',
						),
						'dependency'  => array(
							'element' => 'products',
							'value'   => array( 'top_rated', 'sale', 'featured' ),
						),
						'description' => esc_html__( 'Select to sort products. Leave empty to use the default sort of theme', 'mrbara' ),
					),
					array(
						'type'       => 'vc_link',
						'heading'    => esc_html__( 'View More Link', 'mrbara' ),
						'param_name' => 'link',
						'dependency' => array(
							'element' => 'style',
							'value'   => array( '1' ),
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Slider autoplay', 'mrbara' ),
						'param_name'  => 'autoplay',
						'value'       => '0',
						'description' => esc_html__( 'Duration of animation between slides (in ms). Enter the value is 0 or empty if you want the slider is not autoplay', 'mrbara' ),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Paginated Type', 'mrbara' ),
						'param_name' => 'paginated',
						'value'      => array(
							esc_html__( 'None ', 'mrbara' )       => '',
							esc_html__( 'Navigation ', 'mrbara' ) => 'navi',
							esc_html__( 'Pagination ', 'mrbara' ) => 'pagi',
						),
						'dependency' => array(
							'element' => 'style',
							'value'   => array( '1' ),
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'mrbara' ),
					),
				),
			)
		);

		// Add products shortcode
		vc_map(
			array(
				'name'     => esc_html__( 'Products Carousel 2', 'mrbara' ),
				'base'     => 'mrbara_products_carousel_2',
				'class'    => '',
				'category' => esc_html__( 'MrBara', 'mrbara' ),
				'params'   => array(
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Style', 'mrbara' ),
						'param_name' => 'style',
						'value'      => array(
							esc_html__( 'Style 1', 'mrbara' ) => '1',
							esc_html__( 'Style 2', 'mrbara' ) => '2',
							esc_html__( 'Style 3', 'mrbara' ) => '3',
						),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Show Categories', 'mrbara' ),
						'param_name'  => 'cats_filter',
						'value'       => array( esc_html__( 'Yes', 'mrbara' ) => 1 ),
						'description' => esc_html__( 'Check to this option to show categories.', 'mrbara' ),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Products', 'mrbara' ),
						'param_name' => 'products',
						'value'      => array(
							esc_html__( 'Recent', 'mrbara' )       => 'recent',
							esc_html__( 'Featured', 'mrbara' )     => 'featured',
							esc_html__( 'Best Selling', 'mrbara' ) => 'best_selling',
							esc_html__( 'Top Rated', 'mrbara' )    => 'top_rated',
							esc_html__( 'On Sale', 'mrbara' )      => 'sale',
						),
					),
					array(
						'type'        => 'autocomplete',
						'heading'     => esc_html__( 'Product Categories', 'mrbara' ),
						'param_name'  => 'categories',
						'settings'    => array(
							'multiple' => true,
							'sortable' => false,
							'values'   => $this->get_product_categories(),
						),
						'save_always' => true,
						'description' => esc_html__( 'Enter product categories', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Products per view', 'mrbara' ),
						'param_name'  => 'per_page',
						'value'       => '12',
						'description' => esc_html__( 'Set numbers of products you want to display at the same time.', 'mrbara' ),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Number of columns', 'mrbara' ),
						'param_name' => 'number',
						'value'      => array(
							esc_html__( '4 Columns', 'mrbara' ) => '4',
							esc_html__( '3 Columns', 'mrbara' ) => '3',
							esc_html__( '5 Columns', 'mrbara' ) => '5',
						),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Order By', 'mrbara' ),
						'param_name'  => 'orderby',
						'value'       => array(
							''                                   => '',
							esc_html__( 'Date', 'mrbara' )       => 'date',
							esc_html__( 'Title', 'mrbara' )      => 'title',
							esc_html__( 'Menu Order', 'mrbara' ) => 'menu_order',
							esc_html__( 'Random', 'mrbara' )     => 'rand',
						),
						'dependency'  => array(
							'element' => 'products',
							'value'   => array( 'top_rated', 'sale', 'featured' ),
						),
						'description' => esc_html__( 'Select to order products. Leave empty to use the default order by of theme.', 'mrbara' ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Order', 'mrbara' ),
						'param_name'  => 'order',
						'value'       => array(
							''                                    => '',
							esc_html__( 'Ascending ', 'mrbara' )  => 'asc',
							esc_html__( 'Descending ', 'mrbara' ) => 'desc',
						),
						'dependency'  => array(
							'element' => 'products',
							'value'   => array( 'top_rated', 'sale', 'featured' ),
						),
						'description' => esc_html__( 'Select to sort products. Leave empty to use the default sort of theme', 'mrbara' ),
					),
					array(
						'type'       => 'vc_link',
						'heading'    => esc_html__( 'View More Link', 'mrbara' ),
						'param_name' => 'link',
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Slider autoplay', 'mrbara' ),
						'param_name'  => 'autoplay',
						'value'       => '0',
						'description' => esc_html__( 'Duration of animation between slides (in ms). Enter the value is 0 or empty if you want the slider is not autoplay', 'mrbara' ),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Hide Navigation', 'mrbara' ),
						'param_name'  => 'navigation',
						'value'       => array( esc_html__( 'Yes', 'mrbara' ) => 'false' ),
						'description' => esc_html__( 'If "YES" prev/next control will be removed.', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'mrbara' ),
					),
				),
			)
		);

		// Add products shortcode
		vc_map(
			array(
				'name'     => esc_html__( 'MrBara Products', 'mrbara' ),
				'base'     => 'mrbara_products',
				'class'    => '',
				'category' => esc_html__( 'MrBara', 'mrbara' ),
				'params'   => array(
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Layout', 'mrbara' ),
						'param_name' => 'layout',
						'value'      => array(
							esc_html__( 'Grid', 'mrbara' ) => '',
							esc_html__( 'List', 'mrbara' ) => 'list',
						),
					),
					array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Show Categories', 'mrbara' ),
						'param_name' => 'cats_filter',
						'dependency' => array(
							'element' => 'layout',
							'value'   => array( '' ),
						),
						'value'      => array( esc_html__( 'Yes', 'mrbara' ) => 1 ),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Products', 'mrbara' ),
						'param_name' => 'products',
						'value'      => array(
							esc_html__( 'Recent', 'mrbara' )       => 'recent',
							esc_html__( 'Featured', 'mrbara' )     => 'featured',
							esc_html__( 'Best Selling', 'mrbara' ) => 'best_selling',
							esc_html__( 'Top Rated', 'mrbara' )    => 'top_rated',
							esc_html__( 'On Sale', 'mrbara' )      => 'sale',
						),
					),
					array(
						'type'        => 'autocomplete',
						'heading'     => esc_html__( 'Product Categories', 'mrbara' ),
						'param_name'  => 'categories',
						'settings'    => array(
							'multiple' => true,
							'sortable' => false,
							'values'   => $this->get_product_categories(),
						),
						'save_always' => true,
						'description' => esc_html__( 'Enter product categories', 'mrbara' ),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Number of columns', 'mrbara' ),
						'param_name' => 'columns',
						'value'      => array(
							esc_html__( '4 Columns', 'mrbara' ) => '4',
							esc_html__( '3 Columns', 'mrbara' ) => '3',
							esc_html__( '2 Columns', 'mrbara' ) => '2',
						),
						'dependency' => array(
							'element' => 'layout',
							'value'   => array( '' ),
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Products per view', 'mrbara' ),
						'param_name'  => 'per_page',
						'value'       => '8',
						'description' => esc_html__( 'Set numbers of products you want to display at the same time.', 'mrbara' ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Order By', 'mrbara' ),
						'param_name'  => 'orderby',
						'value'       => array(
							''                                   => '',
							esc_html__( 'Date', 'mrbara' )       => 'date',
							esc_html__( 'Title', 'mrbara' )      => 'title',
							esc_html__( 'Menu Order', 'mrbara' ) => 'menu_order',
							esc_html__( 'Random', 'mrbara' )     => 'rand',
						),
						'dependency'  => array(
							'element' => 'products',
							'value'   => array( 'top_rated', 'sale', 'featured' ),
						),
						'description' => esc_html__( 'Select to order products. Leave empty to use the default order by of theme.', 'mrbara' ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Order', 'mrbara' ),
						'param_name'  => 'order',
						'value'       => array(
							''                                    => '',
							esc_html__( 'Ascending ', 'mrbara' )  => 'asc',
							esc_html__( 'Descending ', 'mrbara' ) => 'desc',
						),
						'dependency'  => array(
							'element' => 'products',
							'value'   => array( 'top_rated', 'sale', 'featured' ),
						),
						'description' => esc_html__( 'Select to sort products. Leave empty to use the default sort of theme', 'mrbara' ),
					),
					array(
						'type'       => 'vc_link',
						'heading'    => esc_html__( 'View More Link', 'mrbara' ),
						'param_name' => 'link',
						'dependency' => array(
							'element' => 'layout',
							'value'   => array( '' ),
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'mrbara' ),
					),
				),
			)
		);

		// Add hot deal shortcode
		vc_map(
			array(
				'name'     => esc_html__( 'Hot Deal Product', 'mrbara' ),
				'base'     => 'mrbara_hot_deal_product',
				'class'    => '',
				'category' => esc_html__( 'Content', 'mrbara' ),
				'params'   => array(
					array(
						'type'        => 'autocomplete',
						'heading'     => esc_html__( 'Product', 'mrbara' ),
						'param_name'  => 'product',
						'settings'    => array(
							'multiple' => true,
							'sortable' => true,
							'values'   => $this->get_products_onsale(),
						),
						'save_always' => true,
						'description' => esc_html__( 'Enter a product', 'mrbara' ),
					),
					array(
						'type'       => 'checkbox',
						'holder'     => 'div',
						'heading'    => esc_html__( 'Border', 'mrbara' ),
						'param_name' => 'border',
						'value'      => '',
					),
					array(
						'type'        => 'textfield',
						'holder'      => 'div',
						'heading'     => esc_html__( 'Height(px)', 'mrbara' ),
						'param_name'  => 'height',
						'value'       => '',
						'description' => esc_html__( 'Specify height of this element or leave it empty to use the default height. Enter height in pixels (Example: 800px)', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'holder'      => 'div',
						'heading'     => esc_html__( 'Slider autoplay', 'mrbara' ),
						'param_name'  => 'autoplay',
						'value'       => '0',
						'description' => esc_html__( 'Duration of animation between slides (in ms). Enter the value is 0 or empty if you want the slider is not autoplay', 'mrbara' ),
					),
					array(
						'type'        => 'checkbox',
						'holder'      => 'div',
						'heading'     => esc_html__( 'Hide navigation', 'mrbara' ),
						'param_name'  => 'navigation',
						'value'       => array( esc_html__( 'Yes', 'mrbara' ) => 'false' ),
						'description' => esc_html__( 'If "YES" prev / next control will be removed . ', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'holder'      => 'div',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'class_name',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'mrbara' ),
					),
				),
			)
		);


		// Add product carousel shortcode
		vc_map(
			array(
				'name'     => esc_html__( 'Products Tabs', 'mrbara' ),
				'base'     => 'mrbara_products_tabs',
				'class'    => '',
				'category' => esc_html__( 'MrBara', 'mrbara' ),
				'params'   => array(
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Style', 'mrbara' ),
						'param_name' => 'style',
						'value'      => array(
							esc_html__( 'Style 1', 'mrbara' ) => '1',
							esc_html__( 'Style 2', 'mrbara' ) => '2',
							esc_html__( 'Style 3', 'mrbara' ) => '3',
							esc_html__( 'Style 4', 'mrbara' ) => '4',
							esc_html__( 'Style 5', 'mrbara' ) => '5',
						),
					),
					array(
						'type'        => 'autocomplete',
						'heading'     => esc_html__( 'Product Categories', 'mrbara' ),
						'param_name'  => 'categories',
						'settings'    => array(
							'multiple' => true,
							'sortable' => false,
							'values'   => $this->get_product_categories(),
						),
						'save_always' => true,
						'description' => esc_html__( 'Enter product categories', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Total Products', 'mrbara' ),
						'param_name'  => 'per_page',
						'value'       => '12',
						'description' => esc_html__( 'Set numbers of products to show.', 'mrbara' ),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Number of columns', 'mrbara' ),
						'param_name' => 'columns',
						'value'      => array(
							esc_html__( '4 Columns', 'mrbara' ) => '4',
							esc_html__( '3 Columns', 'mrbara' ) => '3',
							esc_html__( '2 Columns', 'mrbara' ) => '2',
						),
					),
					array(
						'type'       => 'vc_link',
						'heading'    => esc_html__( 'View More Link', 'mrbara' ),
						'param_name' => 'link',
						'dependency' => array(
							'element' => 'style',
							'value'   => array( '3', '4', '1', '2' ),
						),
					),
					array(
						'type'        => 'textfield',
						'holder'      => 'div',
						'heading'     => esc_html__( 'Slider autoplay', 'mrbara' ),
						'param_name'  => 'autoplay',
						'value'       => '0',
						'dependency'  => array(
							'element' => 'style',
							'value'   => array( '3', '4', '5' ),
						),
						'description' => esc_html__( 'Duration of animation between slides (in ms). Enter the value is 0 or empty if you want the slider is not autoplay', 'mrbara' ),
					),
					array(
						'type'        => 'checkbox',
						'holder'      => 'div',
						'heading'     => esc_html__( 'Hide navigation', 'mrbara' ),
						'param_name'  => 'navigation',
						'dependency'  => array(
							'element' => 'style',
							'value'   => array( '3', '5' ),
						),
						'value'       => array( esc_html__( 'Yes', 'mrbara' ) => 'false' ),
						'description' => esc_html__( 'If "YES" prev / next control will be removed . ', 'mrbara' ),
					),
					array(
						'type'        => 'checkbox',
						'holder'      => 'div',
						'heading'     => esc_html__( 'Hide Pagigation', 'mrbara' ),
						'param_name'  => 'pagigation',
						'dependency'  => array(
							'element' => 'style',
							'value'   => array( '4' ),
						),
						'value'       => array( esc_html__( 'Yes', 'mrbara' ) => 'false' ),
						'description' => esc_html__( 'If "YES" prev / next control will be removed . ', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'mrbara' ),
					),
					array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Hide Featured Tab', 'mrbara' ),
						'group'      => esc_html__( 'Featured Tab', 'mrbara' ),
						'param_name' => 'hide_featured',
						'value'      => array( esc_html__( 'Yes', 'mrbara' ) => 'false' ),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Title', 'mrbara' ),
						'group'      => esc_html__( 'Featured Tab', 'mrbara' ),
						'param_name' => 'featured_title',
						'value'      => esc_html__( 'Featured', 'mrbara' ),
					),
					array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Hide New Tab', 'mrbara' ),
						'group'      => esc_html__( 'New Tab', 'mrbara' ),
						'param_name' => 'hide_new',
						'value'      => array( esc_html__( 'Yes', 'mrbara' ) => 'false' ),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Title', 'mrbara' ),
						'group'      => esc_html__( 'New Tab', 'mrbara' ),
						'param_name' => 'new_title',
						'value'      => esc_html__( 'New Products', 'mrbara' ),
					),
					array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Hide Best Seller Tab', 'mrbara' ),
						'group'      => esc_html__( 'Best Seller Tab', 'mrbara' ),
						'param_name' => 'hide_best_seller',
						'value'      => array( esc_html__( 'Yes', 'mrbara' ) => 'false' ),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Title', 'mrbara' ),
						'group'      => esc_html__( 'Best Seller Tab', 'mrbara' ),
						'param_name' => 'best_seller_title',
						'value'      => esc_html__( 'Best Seller', 'mrbara' ),
					),
					array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Hide Sale Tab', 'mrbara' ),
						'group'      => esc_html__( 'Sale Tab', 'mrbara' ),
						'param_name' => 'hide_sale',
						'value'      => array( esc_html__( 'Yes', 'mrbara' ) => 'false' ),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Title', 'mrbara' ),
						'group'      => esc_html__( 'Sale Tab', 'mrbara' ),
						'param_name' => 'sale_title',
						'value'      => esc_html__( 'Hot Sale', 'mrbara' ),
					),
				),
			)
		);

		// Add product carousel shortcode
		vc_map(
			array(
				'name'     => esc_html__( 'Products Tabs 2', 'mrbara' ),
				'base'     => 'mrbara_products_tabs_2',
				'class'    => '',
				'category' => esc_html__( 'MrBara', 'mrbara' ),
				'params'   => array(
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Style', 'mrbara' ),
						'param_name' => 'style',
						'value'      => array(
							esc_html__( 'Style 1', 'mrbara' ) => '1',
							esc_html__( 'Style 2', 'mrbara' ) => '2',
						),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Products', 'mrbara' ),
						'param_name' => 'products',
						'value'      => array(
							esc_html__( 'Recent', 'mrbara' )       => 'recent',
							esc_html__( 'Featured', 'mrbara' )     => 'featured',
							esc_html__( 'Best Selling', 'mrbara' ) => 'best_selling',
							esc_html__( 'Top Rated', 'mrbara' )    => 'top_rated',
							esc_html__( 'On Sale', 'mrbara' )      => 'sale',
						),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Title', 'mrbara' ),
						'param_name' => 'title',
						'value'      => '',
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Products per view', 'mrbara' ),
						'param_name'  => 'views',
						'value'       => array(
							esc_html__( '6 Items', 'mrbara' ) => '6',
							esc_html__( '4 Items', 'mrbara' ) => '4',
							esc_html__( '3 Items', 'mrbara' ) => '3',
							esc_html__( '8 Items', 'mrbara' ) => '8',
						),
						'description' => esc_html__( 'Set numbers of products you want to display at the same time.', 'mrbara' ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Order By', 'mrbara' ),
						'param_name'  => 'orderby',
						'value'       => array(
							''                                   => '',
							esc_html__( 'Date', 'mrbara' )       => 'date',
							esc_html__( 'Title', 'mrbara' )      => 'title',
							esc_html__( 'Menu Order', 'mrbara' ) => 'menu_order',
							esc_html__( 'Random', 'mrbara' )     => 'rand',
						),
						'dependency'  => array(
							'element' => 'products',
							'value'   => array( 'top_rated', 'sale', 'featured' ),
						),
						'description' => esc_html__( 'Select to order products. Leave empty to use the default order by of theme.', 'mrbara' ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Order', 'mrbara' ),
						'param_name'  => 'order',
						'value'       => array(
							''                                    => '',
							esc_html__( 'Ascending ', 'mrbara' )  => 'asc',
							esc_html__( 'Descending ', 'mrbara' ) => 'desc',
						),
						'dependency'  => array(
							'element' => 'products',
							'value'   => array( 'top_rated', 'sale', 'featured' ),
						),
						'description' => esc_html__( 'Select to sort products. Leave empty to use the default sort of theme', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Slider autoplay', 'mrbara' ),
						'param_name'  => 'autoplay',
						'value'       => '0',
						'description' => esc_html__( 'Duration of animation between slides (in ms). Enter the value is 0 or empty if you want the slider is not autoplay', 'mrbara' ),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Hide Pagination', 'mrbara' ),
						'param_name'  => 'pagination',
						'value'       => array( esc_html__( 'Yes', 'mrbara' ) => 'false' ),
						'description' => esc_html__( 'If "YES" pagination control will be removed.', 'mrbara' ),
					),
					array(
						'type'       => 'vc_link',
						'heading'    => esc_html__( 'Link', 'mrbara' ),
						'param_name' => 'link',
						'value'      => '',
						'dependency' => array(
							'element' => 'style',
							'value'   => array( '2' ),
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'mrbara' ),
					),
					array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Hide Top Products  Tab', 'mrbara' ),
						'group'      => esc_html__( 'Top Products Tab', 'mrbara' ),
						'param_name' => 'hide_top',
						'value'      => array( esc_html__( 'Yes', 'mrbara' ) => 'false' ),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Title', 'mrbara' ),
						'group'      => esc_html__( 'Top Products Tab', 'mrbara' ),
						'param_name' => 'top_title',
						'value'      => esc_html__( 'Top 10', 'mrbara' ),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Number Top Products', 'mrbara' ),
						'group'      => esc_html__( 'Top Products Tab', 'mrbara' ),
						'param_name' => 'top_number',
						'value'      => '10',
					),
					array(
						'type'        => 'autocomplete',
						'heading'     => esc_html__( 'Product Categories', 'mrbara' ),
						'group'       => esc_html__( 'Categories Tab', 'mrbara' ),
						'param_name'  => 'categories',
						'settings'    => array(
							'multiple' => true,
							'sortable' => false,
							'values'   => $this->get_product_categories(),
						),
						'save_always' => true,
						'description' => esc_html__( 'Select a category or all categories.', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Total Products', 'mrbara' ),
						'group'       => esc_html__( 'Categories Tab', 'mrbara' ),
						'param_name'  => 'per_page',
						'value'       => '12',
						'description' => esc_html__( 'Set numbers of products to show.', 'mrbara' ),
					),

				),
			)
		);

		// Add hot deal shortcode
		vc_map(
			array(
				'name'     => esc_html__( 'Products Picks', 'mrbara' ),
				'base'     => 'mrbara_products_picks',
				'class'    => '',
				'category' => esc_html__( 'Content', 'mrbara' ),
				'params'   => array(
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Style', 'mrbara' ),
						'param_name' => 'style',
						'value'      => array(
							esc_html__( 'Style 1 ', 'mrbara' ) => '1',
							esc_html__( 'Style 2 ', 'mrbara' ) => '2',
						),
					),
					array(
						'type'        => 'autocomplete',
						'heading'     => esc_html__( 'Products', 'mrbara' ),
						'param_name'  => 'ids',
						'settings'    => array(
							'multiple' => true,
							'sortable' => true,
							'values'   => $this->get_products(),
						),
						'save_always' => true,
						'description' => esc_html__( 'Enter a products', 'mrbara' ),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Number of columns', 'mrbara' ),
						'param_name' => 'columns',
						'value'      => array(
							esc_html__( '5 Columns', 'mrbara' ) => '5',
							esc_html__( '4 Columns', 'mrbara' ) => '4',
							esc_html__( '3 Columns', 'mrbara' ) => '3',
							esc_html__( '2 Columns', 'mrbara' ) => '2',
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Slider autoplay', 'mrbara' ),
						'param_name'  => 'autoplay',
						'value'       => '0',
						'description' => esc_html__( 'Duration of animation between slides (in ms). Enter the value is 0 or empty if you want the slider is not autoplay', 'mrbara' ),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Paginated Type', 'mrbara' ),
						'param_name' => 'paginated',
						'value'      => array(
							esc_html__( 'None ', 'mrbara' )       => '',
							esc_html__( 'Navigation ', 'mrbara' ) => 'navi',
							esc_html__( 'Pagination ', 'mrbara' ) => 'pagi',
						),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Navigation Type', 'mrbara' ),
						'param_name' => 'navigation',
						'value'      => array(
							esc_html__( 'Style 1 ', 'mrbara' ) => '1',
							esc_html__( 'Style 2 ', 'mrbara' ) => '2',
							esc_html__( 'Style 3 ', 'mrbara' ) => '3',
						),
						'dependency' => array(
							'element' => 'paginated',
							'value'   => array( 'navi' ),
						),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Pagination Type', 'mrbara' ),
						'param_name' => 'pagination',
						'value'      => array(
							esc_html__( 'Style 1 ', 'mrbara' ) => '1',
							esc_html__( 'Style 2 ', 'mrbara' ) => '2',
						),
						'dependency' => array(
							'element' => 'paginated',
							'value'   => array( 'pagi' ),
						),
					),
					array(
						'type'       => 'vc_link',
						'heading'    => esc_html__( 'Link', 'mrbara' ),
						'param_name' => 'link',
						'value'      => '',
					),
					array(
						'type'        => 'textfield',
						'holder'      => 'div',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'mrbara' ),
					),
				),
			)
		);


		// Add product categories box
		vc_map(
			array(
				'name'     => esc_html__( 'Product Category Box', 'mrbara' ),
				'base'     => 'mrbara_product_category_box',
				'class'    => '',
				'category' => esc_html__( 'MrBara', 'mrbara' ),
				'params'   => array(
					array(
						'type'        => 'autocomplete',
						'heading'     => esc_html__( 'Product Category', 'mrbara' ),
						'param_name'  => 'cat_slug',
						'settings'    => array(
							'multiple' => false,
							'sortable' => true,
							'values'   => $this->get_product_categories(),
						),
						'save_always' => true,
						'description' => esc_html__( 'Enter a product category', 'mrbara' ),
					),
					array(
						'type'       => 'icon',
						'heading'    => esc_html__( 'Category Icon', 'mrbara' ),
						'param_name' => 'cat_icon',
						'value'      => '',
					),
					array(
						'type'        => 'colorpicker',
						'heading'     => esc_html__( 'Category Color', 'mrbara' ),
						'param_name'  => 'cat_color',
						'description' => esc_html__( 'Select a category color', 'mrbara' ),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Hide In Left Side Menu', 'mrbara' ),
						'param_name'  => 'cat_left_side',
						'value'       => array( esc_html__( 'Yes', 'mrbara' ) => 'false' ),
						'description' => esc_html__( 'Check this option to hide this category in the left side menu.', 'mrbara' ),
					),
					array(
						'type'        => 'autocomplete',
						'heading'     => esc_html__( 'Product SubCategories', 'mrbara' ),
						'param_name'  => 'subcat_slug',
						'settings'    => array(
							'multiple' => true,
							'sortable' => true,
							'values'   => $this->get_product_categories(),
						),
						'save_always' => true,
						'description' => esc_html__( 'Enter product subcategories', 'mrbara' ),
					),
					array(
						'type'       => 'vc_link',
						'heading'    => esc_html__( 'Link', 'mrbara' ),
						'param_name' => 'link',
					),
					array(
						'type'        => 'attach_images',
						'heading'     => esc_html__( 'Images', 'mrbara' ),
						'group'       => esc_html__( 'Images Slider', 'mrbara' ),
						'param_name'  => 'images',
						'description' => esc_html__( 'Select images from media library', 'mrbara' ),
					),
					array(
						'type'        => 'exploded_textarea_safe',
						'heading'     => esc_html__( 'Custom links', 'mrbara' ),
						'group'       => esc_html__( 'Images Slider', 'mrbara' ),
						'param_name'  => 'custom_links',
						'description' => esc_html__( 'Enter links for each slide here. Divide links with linebreaks (Enter).', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Slider autoplay', 'mrbara' ),
						'group'       => esc_html__( 'Images Slider', 'mrbara' ),
						'param_name'  => 'autoplay',
						'value'       => '0',
						'description' => esc_html__( 'Duration of animation between slides (in ms). Enter the value is 0 or empty if you want the slider is not autoplay', 'mrbara' ),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Hide Pagination', 'mrbara' ),
						'group'       => esc_html__( 'Images Slider', 'mrbara' ),
						'param_name'  => 'pagination',
						'value'       => array( esc_html__( 'Yes', 'mrbara' ) => 'false' ),
						'description' => esc_html__( 'If "YES" pagination control will be removed.', 'mrbara' ),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Products', 'mrbara' ),
						'group'      => esc_html__( 'Products', 'mrbara' ),
						'param_name' => 'products',
						'value'      => array(
							esc_html__( 'Recent', 'mrbara' )       => 'recent',
							esc_html__( 'Featured', 'mrbara' )     => 'featured',
							esc_html__( 'Best Selling', 'mrbara' ) => 'best_selling',
							esc_html__( 'Top Rated', 'mrbara' )    => 'top_rated',
							esc_html__( 'On Sale', 'mrbara' )      => 'sale',
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Products per view', 'mrbara' ),
						'group'       => esc_html__( 'Products', 'mrbara' ),
						'value'       => '6',
						'param_name'  => 'per_page',
						'description' => esc_html__( 'Enter numbers of products you want to display at the same time.', 'mrbara' ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Order By', 'mrbara' ),
						'group'       => esc_html__( 'Products', 'mrbara' ),
						'param_name'  => 'orderby',
						'value'       => array(
							''                                   => '',
							esc_html__( 'Date', 'mrbara' )       => 'date',
							esc_html__( 'Title', 'mrbara' )      => 'title',
							esc_html__( 'Menu Order', 'mrbara' ) => 'menu_order',
							esc_html__( 'Random', 'mrbara' )     => 'rand',
						),
						'dependency'  => array(
							'element' => 'products',
							'value'   => array( 'top_rated', 'sale', 'featured' ),
						),
						'description' => esc_html__( 'Select to order products. Leave empty to use the default order by of theme.', 'mrbara' ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Order', 'mrbara' ),
						'group'       => esc_html__( 'Products', 'mrbara' ),
						'param_name'  => 'order',
						'value'       => array(
							''                                    => '',
							esc_html__( 'Ascending ', 'mrbara' )  => 'asc',
							esc_html__( 'Descending ', 'mrbara' ) => 'desc',
						),
						'dependency'  => array(
							'element' => 'products',
							'value'   => array( 'top_rated', 'sale', 'featured' ),
						),
						'description' => esc_html__( 'Select to sort products. Leave empty to use the default sort of theme', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file . ', 'mrbara' ),
					),
				),
			)
		);

		// Add product categories box
		vc_map(
			array(
				'name'     => esc_html__( 'Product Category Box 2', 'mrbara' ),
				'base'     => 'mrbara_product_category_box_2',
				'class'    => '',
				'category' => esc_html__( 'MrBara', 'mrbara' ),
				'params'   => array(
					array(
						'type'        => 'autocomplete',
						'heading'     => esc_html__( 'Product Category', 'mrbara' ),
						'param_name'  => 'cat_slug',
						'settings'    => array(
							'multiple' => false,
							'sortable' => true,
							'values'   => $this->get_product_categories(),
						),
						'save_always' => true,
						'description' => esc_html__( 'Enter a product category', 'mrbara' ),
					),
					array(
						'type'       => 'icon',
						'heading'    => esc_html__( 'Category Icon', 'mrbara' ),
						'param_name' => 'cat_icon',
						'value'      => '',
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Hide In Left Side Menu', 'mrbara' ),
						'param_name'  => 'cat_left_side',
						'value'       => array( esc_html__( 'Yes', 'mrbara' ) => 'false' ),
						'description' => esc_html__( 'Check this option to hide this category in the left side menu.', 'mrbara' ),
					),
					array(
						'type'        => 'colorpicker',
						'heading'     => esc_html__( 'Category Color', 'mrbara' ),
						'param_name'  => 'cat_color',
						'description' => esc_html__( 'Select a category color', 'mrbara' ),
					),

					array(
						'type'        => 'attach_images',
						'heading'     => esc_html__( 'Banners Slider', 'mrbara' ),
						'param_name'  => 'banner',
						'description' => esc_html__( 'Select images from media library', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Slider autoplay', 'mrbara' ),
						'param_name'  => 'autoplay',
						'value'       => '0',
						'description' => esc_html__( 'Duration of animation between slides (in ms). Enter the value is 0 or empty if you want the slider is not autoplay', 'mrbara' ),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Hide Pagination', 'mrbara' ),
						'param_name'  => 'pagination',
						'value'       => array( esc_html__( 'Yes', 'mrbara' ) => 'false' ),
						'description' => esc_html__( 'If "YES" pagination control will be removed.', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file . ', 'mrbara' ),
					),
				),
			)
		);


		// Add products ads
		vc_map(
			array(
				'name'     => esc_html__( 'Banner and Products', 'mrbara' ),
				'base'     => 'mrbara_products_ads',
				'class'    => '',
				'category' => esc_html__( 'MrBara', 'mrbara' ),
				'params'   => array(
					array(
						'type'       => 'vc_link',
						'heading'    => esc_html__( 'View More Link', 'mrbara' ),
						'param_name' => 'link',
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'mrbara' ),
					),
					array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Hide Ads', 'mrbara' ),
						'param_name' => 'hide_ads',
						'group'      => esc_html__( 'Ads Options', 'mrbara' ),
						'value'      => array( esc_html__( 'Yes', 'mrbara' ) => 'true' ),
					),
					array(
						'type'        => 'attach_image',
						'heading'     => esc_html__( 'Background Image', 'mrbara' ),
						'param_name'  => 'ads_image',
						'group'       => esc_html__( 'Ads Options', 'mrbara' ),
						'description' => esc_html__( 'Select categories to get products', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Background Image Size', 'mrbara' ),
						'param_name'  => 'ads_image_size',
						'group'       => esc_html__( 'Ads Options', 'mrbara' ),
						'value'       => '',
						'description' => esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 570x440 (Width x Height)).', 'mrbara' ),
					),
					array(
						'type'        => 'textarea',
						'heading'     => esc_html__( 'SubTitle', 'mrbara' ),
						'param_name'  => 'content',
						'group'       => esc_html__( 'Ads Options', 'mrbara' ),
						'value'       => '',
						'description' => esc_html__( 'Enter the subtitle', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Title', 'mrbara' ),
						'param_name'  => 'ads_title',
						'group'       => esc_html__( 'Ads Options', 'mrbara' ),
						'value'       => '',
						'description' => esc_html__( 'Enter the title', 'mrbara' ),
					),
					array(
						'type'       => 'vc_link',
						'group'      => esc_html__( 'Ads Options', 'mrbara' ),
						'heading'    => esc_html__( 'View Now Link', 'mrbara' ),
						'param_name' => 'ads_link',
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Products', 'mrbara' ),
						'param_name' => 'products',
						'group'      => esc_html__( 'Products Options', 'mrbara' ),
						'value'      => array(
							esc_html__( 'Recent', 'mrbara' )       => 'recent',
							esc_html__( 'Featured', 'mrbara' )     => 'featured',
							esc_html__( 'Best Selling', 'mrbara' ) => 'best_selling',
							esc_html__( 'Top Rated', 'mrbara' )    => 'top_rated',
							esc_html__( 'On Sale', 'mrbara' )      => 'sale',
						),
					),
					array(
						'type'        => 'autocomplete',
						'heading'     => esc_html__( 'Product Categories', 'mrbara' ),
						'group'       => esc_html__( 'Products Options', 'mrbara' ),
						'param_name'  => 'categories',
						'settings'    => array(
							'multiple' => true,
							'sortable' => true,
							'values'   => $this->get_product_categories(),
						),
						'save_always' => true,
						'description' => esc_html__( 'Select categories to get products', 'mrbara' ),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Number of columns', 'mrbara' ),
						'param_name' => 'columns',
						'value'      => array(
							esc_html__( '4 Columns', 'mrbara' ) => '4',
							esc_html__( '3 Columns', 'mrbara' ) => '3',
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Products per view', 'mrbara' ),
						'param_name'  => 'per_page',
						'value'       => '6',
						'group'       => esc_html__( 'Products Options', 'mrbara' ),
						'description' => esc_html__( 'Set numbers of products you want to display at the same time.', 'mrbara' ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Order By', 'mrbara' ),
						'param_name'  => 'orderby',
						'value'       => array(
							''                                   => '',
							esc_html__( 'Date', 'mrbara' )       => 'date',
							esc_html__( 'Title', 'mrbara' )      => 'title',
							esc_html__( 'Menu Order', 'mrbara' ) => 'menu_order',
							esc_html__( 'Random', 'mrbara' )     => 'rand',
						),
						'dependency'  => array(
							'element' => 'products',
							'value'   => array( 'top_rated', 'sale', 'featured' ),
						),
						'group'       => esc_html__( 'Products Options', 'mrbara' ),
						'description' => esc_html__( 'Select to order products. Leave empty to use the default order by of theme.', 'mrbara' ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Order', 'mrbara' ),
						'param_name'  => 'order',
						'value'       => array(
							''                                    => '',
							esc_html__( 'Ascending ', 'mrbara' )  => 'asc',
							esc_html__( 'Descending ', 'mrbara' ) => 'desc',
						),
						'dependency'  => array(
							'element' => 'products',
							'value'   => array( 'top_rated', 'sale', 'featured' ),
						),
						'group'       => esc_html__( 'Products Options', 'mrbara' ),
						'description' => esc_html__( 'Select to sort products. Leave empty to use the default sort of theme', 'mrbara' ),
					),
				),
			)
		);

		vc_map(
			array(
				'name'            => esc_html__( 'MrBara Sliders', 'mrbara' ),
				'base'            => 'mrbara_sliders',
				'as_parent'       => array( 'only' => 'mrbara_slider' ),
				'category'        => esc_html__( 'MrBara', 'mrbara' ),
				'content_element' => true,
				'params'          => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Active Slide', 'mrbara' ),
						'param_name'  => 'active_slide',
						'value'       => '0',
						'description' => esc_html__( 'Enter active section slide', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Slider autoplay', 'mrbara' ),
						'param_name'  => 'autoplay',
						'value'       => '0',
						'description' => esc_html__( 'Duration of animation between slides (in ms). Enter the value is 0 or empty if you want the slider is not autoplay', 'mrbara' ),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Hide Navigation', 'mrbara' ),
						'param_name'  => 'navigation',
						'value'       => array( esc_html__( 'Yes', 'mrbara' ) => 'false' ),
						'description' => esc_html__( 'If "YES" prev/next control will be removed.', 'mrbara' ),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Hide ScrollBar', 'mrbara' ),
						'param_name'  => 'scrollbar',
						'value'       => array( esc_html__( 'Yes', 'mrbara' ) => 'false' ),
						'description' => esc_html__( 'If "YES" ScrollBar control will be removed.', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'mrbara' ),
					),
				),
				'js_view'         => 'VcColumnView',
			)
		);
		vc_map(
			array(
				'name'            => esc_html__( 'MrBara Slider', 'mrbara' ),
				'base'            => 'mrbara_slider',
				'content_element' => true,
				'as_child'        => array( 'only' => 'mrbara_sliders' ),
				'params'          => array(
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Style', 'mrbara' ),
						'param_name' => 'style',
						'value'      => array(
							esc_html__( 'Style 1', 'mrbara' ) => '1',
							esc_html__( 'Style 2', 'mrbara' ) => '2',
							esc_html__( 'Style 3', 'mrbara' ) => '3',
						),
					),
					array(
						'type'        => 'attach_image',
						'heading'     => esc_html__( 'Background Image', 'mrbara' ),
						'param_name'  => 'bg_image',
						'value'       => '',
						'description' => esc_html__( 'Select an image from media library', 'mrbara' ),
					),
					array(
						'type'       => 'textarea',
						'heading'    => esc_html__( 'SubTitle', 'mrbara' ),
						'param_name' => 'subtitle',
						'value'      => '',
						'dependency' => array(
							'element' => 'style',
							'value'   => array( '2', '3' ),
						),
					),
					array(
						'type'       => 'textarea',
						'heading'    => esc_html__( 'Title', 'mrbara' ),
						'param_name' => 'content',
						'value'      => '',
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Desc', 'mrbara' ),
						'param_name' => 'desc',
						'value'      => '',
						'dependency' => array(
							'element' => 'style',
							'value'   => array( '1', '2' ),
						),
					),
					array(
						'type'       => 'textarea',
						'heading'    => esc_html__( 'Category', 'mrbara' ),
						'param_name' => 'category',
						'value'      => '',
						'dependency' => array(
							'element' => 'style',
							'value'   => array( '1' ),
						),
					),
					array(
						'type'       => 'vc_link',
						'heading'    => esc_html__( 'Link', 'mrbara' ),
						'param_name' => 'link',
						'value'      => '',
					),
					array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Assign the link to the slider', 'mrbara' ),
						'param_name' => 'link_image',
						'value'      => '',
					),
				),
			)
		);

		// Sliders and Banners
		vc_map(
			array(
				'name'            => esc_html__( 'Sliders and Banners', 'mrbara' ),
				'base'            => 'mrbara_sliders_banners',
				'as_parent'       => array( 'only' => 'mrbara_banner_grid, mrbara_revslider' ),
				'category'        => esc_html__( 'MrBara', 'mrbara' ),
				'content_element' => true,
				'params'          => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'mrbara' ),
					),
				),
				'js_view'         => 'VcColumnView',
			)
		);
		vc_map(
			array(
				'name'            => esc_html__( 'Banner', 'mrbara' ),
				'base'            => 'mrbara_banner_grid',
				'as_child'        => array( 'only' => 'mrbara_sliders_banners', 'mrbara_info_banners' ),
				'content_element' => true,
				'params'          => array(
					array(
						'type'        => 'attach_image',
						'heading'     => esc_html__( 'Image', 'mrbara' ),
						'param_name'  => 'image',
						'value'       => '',
						'description' => esc_html__( 'Select an image from media library', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Image Size', 'mrbara' ),
						'param_name'  => 'image_size',
						'value'       => '',
						'description' => esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 970x534 (Width x Height)).', 'mrbara' ),
					),
					array(
						'type'        => 'colorpicker',
						'heading'     => esc_html__( 'Background Color', 'mrbara' ),
						'param_name'  => 'bg_color',
						'value'       => '',
						'description' => esc_html__( 'Select an background color for this element', 'mrbara' ),
					),
					array(
						'type'       => 'textarea',
						'heading'    => esc_html__( 'Title', 'mrbara' ),
						'param_name' => 'content',
						'value'      => '',
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Description', 'mrbara' ),
						'param_name' => 'desc',
						'value'      => '',
					),

					array(
						'type'       => 'vc_link',
						'heading'    => esc_html__( 'Link', 'mrbara' ),
						'param_name' => 'link',
						'value'      => '',
					),
					array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Show link when hover on banner', 'mrbara' ),
						'param_name' => 'link_hover',
						'value'      => '',
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Dark Skin', 'mrbara' ),
						'param_name'  => 'dark_skin',
						'value'       => '',
						'description' => esc_html__( 'Check this option to show bright text on dark skin.', 'mrbara' ),
					),
				),
			)
		);

		vc_map(
			array(
				'name'            => esc_html__( 'Revolution Slider', 'mrbara' ),
				'base'            => 'mrbara_revslider',
				'content_element' => true,
				'as_child'        => array( 'only' => 'mrbara_sliders_banners' ),
				'params'          => array(
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Revolution Slider', 'mrbara' ),
						'param_name'  => 'alias',
						'value'       => $this->rev_sliders(),
						'description' => esc_html__( 'Select your Revolution Slider.', 'mrbara' ),
					),
				),
			)
		);

		// Banners and Info
		vc_map(
			array(
				'name'            => esc_html__( 'Info Banners Masonry', 'mrbara' ),
				'base'            => 'mrbara_info_banners',
				'as_parent'       => array( 'only' => 'mrbara_banner_grid, mrbara_info_newsletter, mrbara_info_section_title' ),
				'category'        => esc_html__( 'MrBara', 'mrbara' ),
				'content_element' => true,
				'params'          => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Title', 'mrbara' ),
						'param_name'  => 'title',
						'value'       => '',
						'description' => esc_html__( 'Enter the title content', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Description', 'mrbara' ),
						'param_name'  => 'desc',
						'value'       => '',
						'description' => esc_html__( 'Enter the title content', 'mrbara' ),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Style', 'mrbara' ),
						'param_name' => 'style',
						'value'      => array(
							esc_html__( 'Style 1', 'mrbara' ) => '',
							esc_html__( 'Style 2', 'mrbara' ) => '2',
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'mrbara' ),
					),
				),
				'js_view'         => 'VcColumnView',
			)
		);

		vc_map(
			array(
				'name'     => esc_html__( 'Section Title', 'mrbara' ),
				'base'     => 'mrbara_info_section_title',
				'as_child' => array( 'only' => 'mrbara_info_banners' ),
				'class'    => '',
				'category' => esc_html__( 'MrBara', 'mrbara' ),
				'params'   => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Title', 'mrbara' ),
						'param_name'  => 'title',
						'value'       => '',
						'description' => esc_html__( 'Enter the title content', 'mrbara' ),
					),
					array(
						'type'        => 'colorpicker',
						'heading'     => esc_html__( 'Background Color', 'mrbara' ),
						'param_name'  => 'bg_color',
						'value'       => '',
						'description' => esc_html__( 'Select an background color for this element', 'mrbara' ),
					),
					array(
						'type'        => 'textarea_html',
						'heading'     => esc_html__( 'Description', 'mrbara' ),
						'param_name'  => 'content',
						'value'       => '',
						'description' => esc_html__( 'Enter the title content', 'mrbara' ),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Dark Skin', 'mrbara' ),
						'param_name'  => 'dark_skin',
						'value'       => '',
						'description' => esc_html__( 'Check this option to show bright text on dark skin.', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file . ', 'mrbara' ),
					),
				),
			)
		);

		// Add newsletter shortcode
		vc_map(
			array(
				'name'     => esc_html__( 'Newsletter', 'mrbara' ),
				'base'     => 'mrbara_info_newsletter',
				'as_child' => array( 'only' => 'mrbara_info_banners' ),
				'class'    => '',
				'category' => esc_html__( 'MrBara', 'mrbara' ),
				'params'   => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Title', 'mrbara' ),
						'param_name'  => 'title',
						'value'       => esc_html__( 'Get|10%|Discount', 'mrbara' ),
						'description' => esc_html__( 'Enter the title in this format "A|B|C and the B element is primary color."', 'mrbara' ),
					),
					array(
						'type'        => 'colorpicker',
						'heading'     => esc_html__( 'Background Color', 'mrbara' ),
						'param_name'  => 'bg_color',
						'value'       => '',
						'description' => esc_html__( 'Select an background color for this element', 'mrbara' ),
					),
					array(
						'type'       => 'textarea_html',
						'heading'    => esc_html__( 'Description', 'mrbara' ),
						'param_name' => 'content',
						'value'      => '',
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Dark Skin', 'mrbara' ),
						'param_name'  => 'dark_skin',
						'value'       => '',
						'description' => esc_html__( 'Check this option to show bright text on dark skin.', 'mrbara' ),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Mailchimp Form', 'mrbara' ),
						'param_name' => 'form',
						'value'      => $form_ids,
					),
				),
			)
		);


		// Add contact shortcode
		vc_map(
			array(
				'name'     => esc_html__( 'MrBara Google Maps', 'mrbara' ),
				'base'     => 'mrbara_gmaps',
				'class'    => '',
				'category' => esc_html__( 'MrBara', 'mrbara' ),
				'params'   => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Api Key', 'mrbara' ),
						'param_name'  => 'api_key',
						'value'       => '',
						'description' => sprintf( __( 'Please go to <a href="%s">Google Maps APIs</a> to get a key', 'mrbara' ), esc_url( 'https://developers.google.com/maps/documentation/javascript/get-api-key#get-an-api-key' ) ),
					),
					array(
						'type'        => 'attach_image',
						'heading'     => esc_html__( 'Marker', 'mrbara' ),
						'param_name'  => 'marker',
						'value'       => '',
						'description' => esc_html__( 'Select an image from media library', 'mrbara' ),
					),
					array(
						'type'       => 'textarea',
						'heading'    => esc_html__( 'Address', 'mrbara' ),
						'param_name' => 'address',
						'value'      => '',
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Width(px)', 'mrbara' ),
						'param_name'  => 'width',
						'value'       => '',
						'description' => esc_html__( 'Enter number of the width', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Height(px)', 'mrbara' ),
						'param_name'  => 'height',
						'value'       => '450',
						'description' => esc_html__( 'Enter number of the height', 'mrbara' ),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Zoom', 'mrbara' ),
						'param_name' => 'zoom',
						'value'      => '13',
					),
					array(
						'type'       => 'textarea_html',
						'heading'    => esc_html__( 'Content', 'mrbara' ),
						'param_name' => 'content',
						'value'      => '',
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'mrbara' ),
					),
				),
			)
		);


		// Add posts carousel shortcode
		vc_map(
			array(
				'name'     => esc_html__( 'MrBara Posts', 'mrbara' ),
				'base'     => 'mrbara_posts',
				'class'    => '',
				'category' => esc_html__( 'MrBara', 'mrbara' ),
				'params'   => array(
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Style', 'mrbara' ),
						'param_name' => 'style',
						'value'      => array(
							esc_html__( 'Style 1', 'mrbara' ) => '1',
							esc_html__( 'Style 2', 'mrbara' ) => '2',
							esc_html__( 'Style 3', 'mrbara' ) => '3',
							esc_html__( 'Style 4', 'mrbara' ) => '4',
						),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Total Posts', 'mrbara' ),
						'param_name' => 'total',
						'value'      => '3',
					),
					array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Show Excerpt', 'mrbara' ),
						'param_name' => 'show_excerpt',
						'value'      => '',
						'dependency' => array(
							'element' => 'style',
							'value'   => array( '4', '2' ),
						),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Excerpt Length', 'mrbara' ),
						'param_name' => 'excerpt_length',
						'value'      => '30',
						'dependency' => array(
							'element' => 'style',
							'value'   => array( '4', '2' ),
						),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Category', 'mrbara' ),
						'param_name'  => 'category',
						'value'       => $this->get_categories(),
						'description' => esc_html__( 'Select a category or all categories.', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'mrbara' ),
					),
				),
			)
		);

		vc_map(
			array(
				'name'     => esc_html__( 'Posts Carousel', 'mrbara' ),
				'base'     => 'mrbara_posts_carousel',
				'class'    => '',
				'category' => esc_html__( 'MrBara', 'mrbara' ),
				'params'   => array(
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Title', 'mrbara' ),
						'param_name' => 'title',
						'value'      => '',
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Total Posts', 'mrbara' ),
						'param_name' => 'total',
						'value'      => '13',
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Posts per view', 'mrbara' ),
						'param_name'  => 'views',
						'value'       => 2,
						'description' => esc_html__( 'Set numbers of posts you want to display at the same time.', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Image Size', 'mrbara' ),
						'param_name'  => 'image_size',
						'value'       => '',
						'description' => esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 80x64 (Width x Height)).', 'mrbara' ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Category', 'mrbara' ),
						'param_name'  => 'category',
						'value'       => $this->get_categories(),
						'description' => esc_html__( 'Select a category or all categories.', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Slider autoplay', 'mrbara' ),
						'param_name'  => 'autoplay',
						'value'       => '0',
						'description' => esc_html__( 'Duration of animation between slides (in ms). Enter the value is 0 or empty if you want the slider is not autoplay', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'mrbara' ),
					),
				),
			)
		);


		// Vertical line
		vc_map(
			array(
				'name'                    => esc_html__( 'Vertical Line', 'mrbara' ),
				'description'             => esc_html__( 'A vertical line', 'mrbara' ),
				'base'                    => 'mrbara_vertical_line',
				'category'                => esc_html__( 'MrBara', 'mrbara' ),
				'show_settings_on_create' => false,
				'params'                  => array(
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'offset',
						'value'       => array(
							esc_html__( 'Top', 'mrbara' )    => 'top',
							esc_html__( 'Bottom', 'mrbara' ) => 'bottom',
						),
						'description' => esc_html__( 'Select offset direction', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'mrbara' ),
					),
				),
			)
		);

		// Add pricing shortcode
		vc_map(
			array(
				'name'     => esc_html__( 'Pricing Table', 'mrbara' ),
				'base'     => 'mrbara_pricing',
				'class'    => '',
				'category' => esc_html__( 'MrBara', 'mrbara' ),
				'params'   => array(
					array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Featured', 'mrbara' ),
						'param_name' => 'featured',
						'value'      => '',
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Title', 'mrbara' ),
						'param_name' => 'title',
						'value'      => '',
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Price', 'mrbara' ),
						'param_name' => 'price',
						'value'      => '',
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Time Duration', 'mrbara' ),
						'param_name' => 'time_duration',
						'value'      => '',
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Description', 'mrbara' ),
						'param_name' => 'desc',
						'value'      => '',
					),
					array(
						'type'        => 'textarea_html',
						'heading'     => esc_html__( 'Content', 'mrbara' ),
						'param_name'  => 'content',
						'value'       => '',
						'description' => esc_html__( 'Enter a short description', 'mrbara' ),
					),
					array(
						'type'       => 'vc_link',
						'heading'    => esc_html__( 'Button', 'mrbara' ),
						'param_name' => 'link',
						'value'      => '',
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file . ', 'mrbara' ),
					),
				),
			)
		);

		// Add pricing shortcode
		vc_map(
			array(
				'name'     => esc_html__( 'Product Detail', 'mrbara' ),
				'base'     => 'mrbara_product_detail',
				'class'    => '',
				'category' => esc_html__( 'MrBara', 'mrbara' ),
				'params'   => array(
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Title', 'mrbara' ),
						'param_name' => 'title',
						'value'      => '',
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Price', 'mrbara' ),
						'param_name' => 'price',
						'value'      => '',
					),
					array(
						'type'        => 'textarea_html',
						'heading'     => esc_html__( 'Description', 'mrbara' ),
						'param_name'  => 'content',
						'value'       => '',
						'description' => esc_html__( 'Enter a short description', 'mrbara' ),
					),
					array(
						'type'       => 'vc_link',
						'heading'    => esc_html__( 'Button', 'mrbara' ),
						'param_name' => 'link',
						'value'      => '',
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Show Quick View', 'mrbara' ),
						'param_name'  => 'quick_view',
						'value'       => '',
						'description' => esc_html__( 'If you check this option, you need to select button URL is a URL of product.', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file . ', 'mrbara' ),
					),
				),
			)
		);


		// Add Progress Bar shortcode
		vc_map(
			array(
				'name'     => esc_html__( 'MrBara Progressbar Circle ', 'mrbara' ),
				'base'     => 'mrbara_progressbar_circle',
				'class'    => '',
				'category' => esc_html__( 'MrBara', 'mrbara' ),
				'params'   => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Label', 'mrbara' ),
						'param_name'  => 'title',
						'value'       => '',
						'description' => esc_html__( 'Enter text used as title of bar.', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Value', 'mrbara' ),
						'param_name'  => 'value',
						'value'       => '',
						'description' => esc_html__( 'Enter value of bar.', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Units', 'mrbara' ),
						'param_name'  => 'units',
						'value'       => '',
						'description' => esc_html__( 'Enter measurement units (Example: %, px, points, etc. Note: graph value and units will be appended to graph title).', 'mrbara' ),
					),
					array(
						'type'        => 'colorpicker',
						'heading'     => esc_html__( 'Color', 'mrbara' ),
						'param_name'  => 'color',
						'value'       => '',
						'description' => esc_html__( 'Select single bar background color.', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file . ', 'mrbara' ),
					),
				),
			)
		);

		// Add pricing shortcode
		vc_map(
			array(
				'name'              => esc_html__( 'MrBara Pie Chart ', 'mrbara' ),
				'base'              => 'mrbara_pie_chart',
				'class'             => '',
				'category'          => esc_html__( 'MrBara', 'mrbara' ),
				'admin_enqueue_css' => MRBARA_ADDONS_URL . '/assets/css/vc/icon-field.css',
				'params'            => array(
					array(
						'type'       => 'icon',
						'heading'    => esc_html__( 'Icon', 'mrbara' ),
						'param_name' => 'icon',
						'value'      => '',
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Label', 'mrbara' ),
						'param_name'  => 'title',
						'value'       => '',
						'description' => esc_html__( 'Enter text used as title of bar.', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Value', 'mrbara' ),
						'param_name'  => 'value',
						'value'       => '',
						'description' => esc_html__( 'Enter value of bar.', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Units', 'mrbara' ),
						'param_name'  => 'units',
						'value'       => '',
						'description' => esc_html__( 'Enter measurement units (Example: %, px, points, etc. Note: graph value and units will be appended to graph title).', 'mrbara' ),
					),
					array(
						'type'        => 'colorpicker',
						'heading'     => esc_html__( 'Color', 'mrbara' ),
						'param_name'  => 'color',
						'value'       => '',
						'description' => esc_html__( 'Select single bar background color.', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file . ', 'mrbara' ),
					),
				),
			)
		);

		// Button
		vc_map(
			array(
				'name'        => esc_html__( 'MrBara Button', 'mrbara' ),
				'description' => esc_html__( 'A flat button with modal style', 'mrbara' ),
				'base'        => 'mrbara_button',
				'category'    => esc_html__( 'MrBara', 'mrbara' ),
				'params'      => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Text', 'mrbara' ),
						'param_name'  => 'title',
						'admin_label' => true,
						'value'       => esc_html__( 'Text on the button', 'mrbara' ),
					),
					array(
						'type'        => 'vc_link',
						'heading'     => esc_html__( 'URL (link)', 'mrbara' ),
						'param_name'  => 'link',
						'value'       => '',
						'description' => esc_html__( 'Add link to button', 'mrbara' ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Alignment', 'mrbara' ),
						'param_name'  => 'align',
						'value'       => array(
							esc_html__( 'Inline', 'mrbara' ) => 'inline',
							esc_html__( 'Left', 'mrbara' )   => 'left',
							esc_html__( 'Right', 'mrbara' )  => 'right',
							esc_html__( 'Center', 'mrbara' ) => 'center',
						),
						'description' => esc_html__( 'Button alignment', 'mrbara' ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Color Style', 'mrbara' ),
						'param_name'  => 'color',
						'value'       => array(
							esc_html__( 'Default', 'mrbara' ) => '',
							esc_html__( 'Lighten', 'mrbara' ) => 'lighten',
							esc_html__( 'Darken', 'mrbara' )  => 'darken',
						),
						'description' => esc_html__( 'Button color style. It bases on primary color of theme.', 'mrbara' ),
					),
					array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Button Shadow', 'mrbara' ),
						'param_name' => 'shadow',
						'value'      => array(
							esc_html__( 'Yes', 'mrbara' ) => 'yes',
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'mrbara' ),
					),
				),
			)
		);

		// Product attribute
		vc_map(
			array(
				'name'        => esc_html__( 'Attributes Swatches', 'mrbara' ),
				'description' => esc_html__( 'Show product attributes as swatches', 'mrbara' ),
				'base'        => 'mrbara_pa_swatches',
				'category'    => esc_html__( 'MrBara', 'mrbara' ),
				'params'      => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Title', 'mrbara' ),
						'param_name'  => 'title',
						'value'       => esc_html__( 'Available:', 'mrbara' ),
						'description' => esc_html__( 'Main title content', 'mrbara' ),
					),
					array(
						'type'        => 'textarea',
						'holder'      => 'div',
						'heading'     => esc_html__( 'Attributes', 'mrbara' ),
						'param_name'  => 'content',
						'value'       => '',
						'description' => esc_html__( 'Each attribute in one line, separate values by symbol |. The color hex code must lead with #', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'mrbara' ),
					),
				),
			)
		);


		// Add newsletter shortcode
		vc_map(
			array(
				'name'     => esc_html__( 'Newsletter', 'mrbara' ),
				'base'     => 'mrbara_newsletter',
				'class'    => '',
				'category' => esc_html__( 'MrBara', 'mrbara' ),
				'params'   => array(
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Style', 'mrbara' ),
						'param_name' => 'style',
						'value'      => array(
							esc_html__( 'Style 1', 'mrbara' )  => 'style1',
							esc_html__( 'Style 2', 'mrbara' )  => 'style2',
							esc_html__( 'Style 3', 'mrbara' )  => 'style3',
							esc_html__( 'Style 4', 'mrbara' )  => 'style4',
							esc_html__( 'Style 5', 'mrbara' )  => 'style5',
							esc_html__( 'Style 6', 'mrbara' )  => 'style6',
							esc_html__( 'Style 7', 'mrbara' )  => 'style7',
							esc_html__( 'Style 8', 'mrbara' )  => 'style8',
							esc_html__( 'Style 9', 'mrbara' )  => 'style9',
							esc_html__( 'Style 10', 'mrbara' ) => 'style10',
						),
					),
					array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Light Skin', 'mrbara' ),
						'param_name' => 'light_skin',
						'value'      => '',
					),
					array(
						'type'       => 'attach_image',
						'heading'    => esc_html__( 'Background Image', 'mrbara' ),
						'param_name' => 'bg_image',
						'value'      => '',
						'dependency' => array(
							'element' => 'style',
							'value'   => array( 'style10' ),
						),
					),
					array(
						'type'        => 'colorpicker',
						'heading'     => esc_html__( 'Background Color', 'mrbara' ),
						'param_name'  => 'bg_color',
						'value'       => '',
						'description' => esc_html__( 'Select an color for background', 'mrbara' ),
						'dependency'  => array(
							'element' => 'style',
							'value'   => array( 'style7', 'style10' ),
						),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'TextBox Skin', 'mrbara' ),
						'param_name'  => 'textbox_skin',
						'description' => esc_html__( 'Select a skin for textbox', 'mrbara' ),
						'value'       => array(
							esc_html__( 'Light', 'mrbara' ) => 'light',
							esc_html__( 'Gray', 'mrbara' )  => 'gray',
						),
						'dependency'  => array(
							'element' => 'style',
							'value'   => array( 'style6', 'style2', 'style5', 'style7', 'style8', 'style9', 'style10' ),
						),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Sub Title', 'mrbara' ),
						'param_name' => 'sub_title',
						'value'      => '',
						'dependency' => array(
							'element' => 'style',
							'value'   => array( 'style3' ),
						),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Title', 'mrbara' ),
						'param_name' => 'title',
						'value'      => '',
						'dependency' => array(
							'element' => 'style',
							'value'   => array( 'style1', 'style3', 'style5', 'style6', 'style7', 'style8', 'style10' ),
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Title', 'mrbara' ),
						'param_name'  => 'title-pc',
						'value'       => esc_html__( 'get|10%|discount', 'mrbara' ),
						'description' => esc_html__( 'Enter the title in this format "A|B|C and the B element is primary color.', 'mrbara' ),
						'dependency'  => array(
							'element' => 'style',
							'value'   => array( 'style2', 'style9' ),
						),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Font Size', 'mrbara' ),
						'param_name' => 'title_font_size',
						'group'      => esc_html__( 'Title Options', 'mrbara' ),
						'value'      => '',
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Font Family', 'mrbara' ),
						'param_name' => 'title_font_family',
						'group'      => esc_html__( 'Title Options', 'mrbara' ),
						'value'      => $this->get_font_family(),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Font Style', 'mrbara' ),
						'param_name' => 'title_font_style',
						'group'      => esc_html__( 'Title Options', 'mrbara' ),
						'value'      => array(
							esc_html__( '400 Normal', 'mrbara' )   => '',
							esc_html__( '300 Light', 'mrbara' )    => '300',
							esc_html__( '600 SemiBold', 'mrbara' ) => '600',
							esc_html__( '700 Bold', 'mrbara' )     => '700',
						),
					),
					array(
						'type'       => 'textarea_html',
						'heading'    => esc_html__( 'Description', 'mrbara' ),
						'param_name' => 'content',
						'value'      => '',
						'dependency' => array(
							'element' => 'style',
							'value'   => array(
								'style3',
								'style4',
								'style5',
								'style6',
								'style7',
								'style8',
								'style9',
								'style10',
							),
						),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Mailchimp Form', 'mrbara' ),
						'param_name' => 'form',
						'value'      => $form_ids,
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'mrbara' ),
					),
				),
			)
		);

		vc_map(
			array(
				'name'     => esc_html__( 'Image Box', 'mrbara' ),
				'base'     => 'mrbara_image_box',
				'class'    => '',
				'category' => esc_html__( 'MrBara', 'mrbara' ),
				'params'   => array(
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Style', 'mrbara' ),
						'param_name' => 'style',
						'value'      => array(
							esc_html__( 'Style 1', 'mrbara' ) => '1',
							esc_html__( 'Style 2', 'mrbara' ) => '2',
						),
					),
					array(
						'type'       => 'attach_image',
						'heading'    => esc_html__( 'Image', 'mrbara' ),
						'param_name' => 'image',
						'value'      => '',
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Image Size', 'mrbara' ),
						'param_name'  => 'image_size',
						'value'       => '',
						'description' => esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 770x520 (Width x Height)).', 'mrbara' ),
					),
					array(
						'type'       => 'vc_link',
						'heading'    => esc_html__( 'Title', 'mrbara' ),
						'param_name' => 'link',
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Font Size', 'mrbara' ),
						'param_name' => 'title_font_size',
						'group'      => esc_html__( 'Title Options', 'mrbara' ),
						'value'      => '',
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Font Family', 'mrbara' ),
						'param_name' => 'title_font_family',
						'group'      => esc_html__( 'Title Options', 'mrbara' ),
						'value'      => $this->get_font_family(),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Font Style', 'mrbara' ),
						'param_name' => 'title_font_style',
						'group'      => esc_html__( 'Title Options', 'mrbara' ),
						'value'      => array(
							esc_html__( '400 Normal', 'mrbara' )   => '',
							esc_html__( '600 SemiBold', 'mrbara' ) => '600',
							esc_html__( '300 Light', 'mrbara' )    => '300',
							esc_html__( '700 Bold', 'mrbara' )     => '700',
						),
					),
					array(
						'type'       => 'textarea_html',
						'heading'    => esc_html__( 'Description', 'mrbara' ),
						'param_name' => 'content',
						'value'      => '',
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Enable Box Shadow', 'mrbara' ),
						'param_name'  => 'box_shadow',
						'value'       => '',
						'description' => esc_html__( 'Check this option to enable box shadow when hover', 'mrbara' ),

					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file . ', 'mrbara' ),
					),
				),
			)
		);

		vc_map(
			array(
				'name'     => esc_html__( 'Call To Action', 'mrbara' ),
				'base'     => 'mrbara_cta',
				'class'    => '',
				'category' => esc_html__( 'MrBara', 'mrbara' ),
				'params'   => array(
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Title', 'mrbara' ),
						'param_name' => 'title',
						'value'      => '',
					),
					array(
						'type'       => 'vc_link',
						'heading'    => esc_html__( 'View More Link', 'mrbara' ),
						'param_name' => 'link',
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file . ', 'mrbara' ),
					),
				),
			)
		);

		// CTA 2
		vc_map(
			array(
				'name'        => esc_html__( 'Call To Action 2', 'mrbara' ),
				'description' => esc_html__( 'CTA with button and design options', 'mrbara' ),
				'base'        => 'mrbara_cta_2',
				'category'    => esc_html__( 'MrBara', 'mrbara' ),
				'params'      => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Subtitle', 'mrbara' ),
						'param_name'  => 'subtitle',
						'value'       => '',
						'description' => esc_html__( 'Subtitle text', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Title', 'mrbara' ),
						'param_name'  => 'title',
						'value'       => '',
						'admin_label' => true,
						'description' => esc_html__( 'Title text', 'mrbara' ),
					),
					array(
						'type'       => 'vc_link',
						'heading'    => esc_html__( 'Link', 'mrbara' ),
						'param_name' => 'link',
						'value'      => '',
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'mrbara' ),
					),
					array(
						'type'       => 'css_editor',
						'heading'    => esc_html__( 'CSS', 'mrbara' ),
						'param_name' => 'css',
						'group'      => esc_html__( 'Design options', 'mrbara' ),
					),
				),
			)
		);

		// Banner
		vc_map(
			array(
				'name'        => esc_html__( 'Banner Medium', 'mrbara' ),
				'description' => esc_html__( 'Eye catching banner', 'mrbara' ),
				'base'        => 'mrbara_banner',
				'category'    => esc_html__( 'MrBara', 'mrbara' ),
				'params'      => array(
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Style', 'mrbara' ),
						'param_name' => 'style',
						'value'      => array(
							esc_html__( 'Style 1', 'mrbara' ) => '1',
							esc_html__( 'Style 2', 'mrbara' ) => '2',
							esc_html__( 'Style 3', 'mrbara' ) => '3',
						),
					),
					array(
						'type'       => 'attach_image',
						'heading'    => esc_html__( 'Image', 'mrbara' ),
						'param_name' => 'image',
						'value'      => '',
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Title', 'mrbara' ),
						'param_name'  => 'title',
						'value'       => '',
						'admin_label' => true,
						'description' => esc_html__( 'Title text', 'mrbara' ),
					),
					array(
						'type'       => 'vc_link',
						'heading'    => esc_html__( 'Link', 'mrbara' ),
						'param_name' => 'link',
						'value'      => '',
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Banner Text', 'mrbara' ),
						'param_name'  => 'text',
						'value'       => '',
						'description' => esc_html__( 'Used to display a short text on left/right side of image', 'mrbara' ),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Banner Text Color', 'mrbara' ),
						'param_name' => 'text_color',
						'value'      => array(
							esc_html__( 'Primary Color', 'mrbara' ) => 'primary',
							esc_html__( 'Gray Color', 'mrbara' )    => 'gray',
						),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Banner Text Position', 'mrbara' ),
						'param_name' => 'text_position',
						'value'      => array(
							esc_html__( 'Left', 'mrbara' )  => 'left',
							esc_html__( 'Right', 'mrbara' ) => 'right',
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Banner Text Offset Top', 'mrbara' ),
						'param_name'  => 'text_top',
						'value'       => '75',
						'description' => esc_html__( 'Offset top in pixel', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'mrbara' ),
					),
					array(
						'type'       => 'css_editor',
						'heading'    => esc_html__( 'CSS', 'mrbara' ),
						'param_name' => 'css',
						'group'      => esc_html__( 'Design options', 'mrbara' ),
					),
				),
			)
		);

		// Banner
		vc_map(
			array(
				'name'        => esc_html__( 'Banner Large', 'mrbara' ),
				'description' => esc_html__( 'Eye catching banner', 'mrbara' ),
				'base'        => 'mrbara_banner_large',
				'category'    => esc_html__( 'MrBara', 'mrbara' ),
				'params'      => array(
					array(
						'type'        => 'textarea',
						'heading'     => esc_html__( 'Title', 'mrbara' ),
						'param_name'  => 'content',
						'value'       => '',
						'admin_label' => true,
						'description' => esc_html__( 'Title text', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Title Font Size', 'mrbara' ),
						'param_name'  => 'font_size',
						'value'       => '',
						'description' => esc_html__( 'Enter font size in pixels (Example: 16px)', 'mrbara' ),

					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Title Line Height', 'mrbara' ),
						'param_name' => 'line_height',
						'value'      => '',
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Title Letter Spacing', 'mrbara' ),
						'param_name'  => 'letter_spacing',
						'value'       => '',
						'description' => esc_html__( 'Enter letter spacing in pixels (Example: 1px)', 'mrbara' ),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Title Font Family', 'mrbara' ),
						'param_name' => 'font_family',
						'value'      => $this->get_font_family(),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Title Font Style', 'mrbara' ),
						'param_name' => 'font_style',
						'value'      => array(
							esc_html__( '400 Normal', 'mrbara' )   => '',
							esc_html__( '600 SemiBold', 'mrbara' ) => '600',
							esc_html__( '300 Light', 'mrbara' )    => '300',
							esc_html__( '700 Bold', 'mrbara' )     => '700',
						),

					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Subtitle', 'mrbara' ),
						'param_name'  => 'subtitle',
						'value'       => '',
						'description' => esc_html__( 'Used to display a short text on below banner title', 'mrbara' ),
					),
					array(
						'type'       => 'vc_link',
						'heading'    => esc_html__( 'Link', 'mrbara' ),
						'param_name' => 'link',
						'value'      => '',
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'mrbara' ),
					),
					array(
						'type'       => 'css_editor',
						'heading'    => esc_html__( 'CSS', 'mrbara' ),
						'param_name' => 'css',
						'group'      => esc_html__( 'Design options', 'mrbara' ),
					),
					array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Light Skin', 'mrbara' ),
						'param_name' => 'light_skin',
						'group'      => esc_html__( 'Design options', 'mrbara' ),
						'value'      => '',
					),
					array(
						'type'       => 'colorpicker',
						'heading'    => esc_html__( 'Background Color Overlay', 'mrbara' ),
						'param_name' => 'bg_color_overlay',
						'group'      => esc_html__( 'Design options', 'mrbara' ),
						'value'      => '',
					),
					array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Enable Parallax', 'mrbara' ),
						'param_name' => 'parallax',
						'group'      => esc_html__( 'Design options', 'mrbara' ),
						'value'      => '',
					),

				),
			)
		);

		// Promotions
		vc_map(
			array(
				'name'        => esc_html__( 'Promotion Medium', 'mrbara' ),
				'description' => esc_html__( 'Display Medium Promotions', 'mrbara' ),
				'base'        => 'mrbara_promotion_medium',
				'category'    => esc_html__( 'MrBara', 'mrbara' ),
				'params'      => array(
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Style', 'mrbara' ),
						'param_name' => 'style',
						'value'      => array(
							esc_html__( 'Style 1', 'mrbara' ) => '',
							esc_html__( 'Style 2', 'mrbara' ) => '2',
							esc_html__( 'Style 3', 'mrbara' ) => '3',
						),
					),
					array(
						'type'       => 'attach_image',
						'heading'    => esc_html__( 'Image', 'mrbara' ),
						'param_name' => 'image',
						'value'      => '',
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Min Height', 'mrbara' ),
						'param_name'  => 'min_height',
						'value'       => '',
						'description' => esc_html__( 'Specify height of promotion or leave it empty to use the height of promotion. Enter height in pixels (Example: 195px)', 'mrbara' ),
					),
					array(
						'type'        => 'textarea_html',
						'heading'     => esc_html__( 'Promotions Title', 'mrbara' ),
						'param_name'  => 'content',
						'value'       => '',
						'description' => esc_html__( 'Enter the Promotion Title', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Old Price', 'mrbara' ),
						'param_name'  => 'old_price',
						'value'       => '',
						'description' => esc_html__( 'Enter the regular price', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'New Price', 'mrbara' ),
						'param_name'  => 'new_price',
						'value'       => '',
						'description' => esc_html__( 'Enter the sale price', 'mrbara' ),
					),
					array(
						'type'        => 'colorpicker',
						'heading'     => esc_html__( 'New Price Color', 'mrbara' ),
						'param_name'  => 'new_price_color',
						'value'       => '',
						'description' => esc_html__( 'Select an color for new price', 'mrbara' ),
					),
					array(
						'type'       => 'vc_link',
						'heading'    => esc_html__( 'Link', 'mrbara' ),
						'param_name' => 'link',
						'value'      => '',
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Promotion Skin', 'mrbara' ),
						'param_name' => 'skin',
						'value'      => array(
							esc_html__( 'Light', 'mrbara' ) => 'light',
							esc_html__( 'Dark', 'mrbara' )  => 'dark',
						),
					),
					array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Border', 'mrbara' ),
						'param_name' => 'border',
						'value'      => '',
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Banner Content Position', 'mrbara' ),
						'param_name' => 'text_position',
						'value'      => array(
							esc_html__( 'Left', 'mrbara' )   => 'left',
							esc_html__( 'Center', 'mrbara' ) => 'center',
						),
					),
					array(
						'type'       => 'css_editor',
						'heading'    => esc_html__( 'CSS', 'mrbara' ),
						'param_name' => 'css',
						'group'      => esc_html__( 'Design options', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'mrbara' ),
					),
				),
			)
		);

		// Promotions
		vc_map(
			array(
				'name'        => esc_html__( 'Promotion Large', 'mrbara' ),
				'description' => esc_html__( 'Display Large Promotions', 'mrbara' ),
				'base'        => 'mrbara_promotion_large',
				'category'    => esc_html__( 'MrBara', 'mrbara' ),
				'params'      => array(
					array(
						'type'       => 'attach_image',
						'heading'    => esc_html__( 'Image', 'mrbara' ),
						'param_name' => 'image',
						'value'      => '',
					),
					array(
						'type'        => 'colorpicker',
						'heading'     => esc_html__( 'Background Color', 'mrbara' ),
						'param_name'  => 'bg_color',
						'value'       => '',
						'description' => esc_html__( 'Select an color for background promotion', 'mrbara' ),
					),
					array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Border', 'mrbara' ),
						'param_name' => 'border',
						'value'      => '',
					),
					array(
						'type'        => 'textarea_html',
						'heading'     => esc_html__( 'Promotions Title', 'mrbara' ),
						'param_name'  => 'content',
						'value'       => '',
						'description' => esc_html__( 'Enter The Promotion Title', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Promotions Subtitle', 'mrbara' ),
						'param_name'  => 'subtitle',
						'value'       => '',
						'description' => esc_html__( 'Enter Promotion Subtitle', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Old Price', 'mrbara' ),
						'param_name'  => 'old_price',
						'value'       => '',
						'description' => esc_html__( 'Enter the regular price', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'New Price', 'mrbara' ),
						'param_name'  => 'new_price',
						'value'       => '',
						'description' => esc_html__( 'Enter the sale price', 'mrbara' ),
					),
					array(
						'type'       => 'vc_link',
						'heading'    => esc_html__( 'Link', 'mrbara' ),
						'param_name' => 'link',
						'value'      => '',
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'mrbara' ),
					),
				),
			)
		);

		// Testimonial
		if ( post_type_exists( 'testimonial' ) && taxonomy_exists( 'testimonial_category' ) ) {
			$categories = get_terms( 'testimonial_category' );
			$cats       = array( esc_html__( 'All Categories', 'mrbara' ) => '' );
			foreach ( $categories as $category ) {
				$cats[ $category->name ] = $category->slug;
			}
			vc_map(
				array(
					'name'        => esc_html__( 'Testimonials', 'mrbara' ),
					'description' => esc_html__( 'Testimonial carousel', 'mrbara' ),
					'base'        => 'mrbara_testimonials',
					'category'    => esc_html__( 'MrBara', 'mrbara' ),
					'params'      => array(
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Number', 'mrbara' ),
							'param_name'  => 'number',
							'value'       => 3,
							'admin_label' => true,
							'description' => esc_html__( 'Number of testimonials', 'mrbara' ),
						),
						array(
							'type'       => 'dropdown',
							'heading'    => esc_html__( 'Category', 'mrbara' ),
							'param_name' => 'category',
							'value'      => $cats,
						),
						array(
							'type'        => 'dropdown',
							'heading'     => esc_html__( 'Alignment', 'mrbara' ),
							'param_name'  => 'align',
							'value'       => array(
								esc_html__( 'Left', 'mrbara' )   => 'left',
								esc_html__( 'Right', 'mrbara' )  => 'right',
								esc_html__( 'Center', 'mrbara' ) => 'center',
							),
							'description' => esc_html__( 'Testimonials alignment', 'mrbara' ),
						),
						array(
							'type'       => 'checkbox',
							'heading'    => esc_html__( 'Show stars', 'mrbara' ),
							'param_name' => 'show_stars',
							'value'      => array( esc_html__( 'Yes', 'mrbara' ) => 'yes' ),
						),
						array(
							'type'       => 'checkbox',
							'heading'    => esc_html__( 'Show Avatar', 'mrbara' ),
							'param_name' => 'show_avatar',
							'value'      => array( esc_html__( 'Yes', 'mrbara' ) => 'yes' ),
						),
						array(
							'type'       => 'checkbox',
							'heading'    => esc_html__( 'Show navigation', 'mrbara' ),
							'param_name' => 'show_nav',
							'value'      => array( esc_html__( 'Yes', 'mrbara' ) => 'yes' ),
						),
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Auto play', 'mrbara' ),
							'param_name'  => 'autoplay',
							'value'       => 5000,
							'description' => esc_html__( 'Set auto play speed in mili-second. Enter 0 to disable auto play.', 'mrbara' ),
						),
						array(
							'type'        => 'dropdown',
							'heading'     => esc_html__( 'Navigation style', 'mrbara' ),
							'param_name'  => 'nav_style',
							'value'       => array(
								esc_html__( 'Rounded', 'mrbara' ) => 'rounded',
								esc_html__( 'Plain', 'mrbara' )   => 'plain',
							),
							'description' => esc_html__( 'Navigation arrows style', 'mrbara' ),
							'dependency'  => array(
								'element'   => 'show_nav',
								'value'     => array( 'yes' ),
								'not_empty' => true,
							),
						),
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
							'param_name'  => 'el_class',
							'value'       => '',
							'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'mrbara' ),
						),
					),
				)
			);
		}

		vc_map(
			array(
				'name'        => esc_html__( 'Testimonials 2', 'mrbara' ),
				'description' => esc_html__( 'Testimonial carousel', 'mrbara' ),
				'base'        => 'mrbara_testimonials_2',
				'class'       => '',
				'category'    => esc_html__( 'MrBara', 'mrbara' ),
				'params'      => array(
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Style', 'mrbara' ),
						'param_name' => 'style',
						'value'      => array(
							esc_html__( 'Style 1', 'mrbara' ) => '1',
							esc_html__( 'Style 2', 'mrbara' ) => '2',
						),
					),
					array(
						'type'        => 'textfield',
						'holder'      => 'div',
						'heading'     => esc_html__( 'Number Of Testimonials', 'mrbara' ),
						'param_name'  => 'number',
						'value'       => 'All',
						'description' => esc_html__( 'How many testimonials to show ? Enter number or word "All" . ', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'holder'      => 'div',
						'heading'     => esc_html__( 'Slider autoplay', 'mrbara' ),
						'param_name'  => 'autoplay',
						'value'       => '0',
						'description' => esc_html__( 'Duration of animation between slides (in ms). Enter the value is 0 or empty if you want the slider is not autoplay', 'mrbara' ),
					),
					array(
						'type'        => 'checkbox',
						'holder'      => 'div',
						'heading'     => esc_html__( 'Hide navigation', 'mrbara' ),
						'param_name'  => 'navigation',
						'value'       => array( esc_html__( 'Yes', 'mrbara' ) => 'false' ),
						'description' => esc_html__( 'If "YES" prev / next control will be removed . ', 'mrbara' ),
					),
					array(
						'type'        => 'textfield',
						'holder'      => 'div',
						'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
						'param_name'  => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file . ', 'mrbara' ),
					),
				),
			)
		);

		if ( post_type_exists( 'portfolio_project' ) && taxonomy_exists( 'portfolio_category' ) ) {
			$categories = get_terms( 'portfolio_category' );
			$cats       = array( esc_html__( 'All Categories', 'mrbara' ) => '' );
			foreach ( $categories as $category ) {
				$cats[ $category->name ] = $category->slug;
			}
			vc_map(
				array(
					'name'        => esc_html__( 'Portfolio Slider', 'mrbara' ),
					'description' => esc_html__( 'Show portfolio as slider', 'mrbara' ),
					'base'        => 'mrbara_portfolio_slider',
					'class'       => '',
					'category'    => esc_html__( 'MrBara', 'mrbara' ),
					'params'      => array(
						array(
							'type'       => 'attach_image',
							'heading'    => esc_html__( 'Image', 'mrbara' ),
							'param_name' => 'image',
							'value'      => '',
						),
						array(
							'type'        => 'textfield',
							'holder'      => 'div',
							'heading'     => esc_html__( 'Number Of Portfolio', 'mrbara' ),
							'param_name'  => 'number',
							'value'       => '6',
							'description' => esc_html__( 'How many Portfolio to show?. ', 'mrbara' ),
						),
						array(
							'type'       => 'dropdown',
							'heading'    => esc_html__( 'Category', 'mrbara' ),
							'param_name' => 'category',
							'value'      => $cats,
						),
						array(
							'type'       => 'textfield',
							'holder'     => 'div',
							'heading'    => esc_html__( 'Portfolio Title Length (words)', 'mrbara' ),
							'param_name' => 'excerpt_title',
							'value'      => 4,
						),
						array(
							'type'       => 'textfield',
							'holder'     => 'div',
							'heading'    => esc_html__( 'Excerpt Length (words)', 'mrbara' ),
							'param_name' => 'excerpt_length',
							'value'      => 20,
						),
						array(
							'type'        => 'textfield',
							'holder'      => 'div',
							'heading'     => esc_html__( 'Slider autoplay', 'mrbara' ),
							'param_name'  => 'autoplay',
							'value'       => '0',
							'description' => esc_html__( 'Duration of animation between slides (in ms). Enter the value is 0 or empty if you want the slider is not autoplay', 'mrbara' ),
						),
						array(
							'type'        => 'checkbox',
							'holder'      => 'div',
							'heading'     => esc_html__( 'Hide pager', 'mrbara' ),
							'param_name'  => 'pager',
							'value'       => array( esc_html__( 'Yes', 'mrbara' ) => 'false' ),
							'description' => esc_html__( 'If "YES" pager control will be removed . ', 'mrbara' ),
						),
						array(
							'type'        => 'textfield',
							'holder'      => 'div',
							'heading'     => esc_html__( 'Extra class name', 'mrbara' ),
							'param_name'  => 'el_class',
							'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file . ', 'mrbara' ),
						),
					),
				)
			);

		}

	}

	/**
	 * Get Font Family
	 *
	 * @return array|string
	 */
	function get_font_family() {

		$output = array(
			esc_html__( 'Default', 'mrbara' ) => '',
			'Prata'                           => 'Prata',
			'Montserrat'                      => 'Montserrat',
			'Oswald'                          => 'Oswald',
		);

		return apply_filters( 'mrbara_vc_addons_font_family', $output );
	}

	/**
	 * Return setting UI for get products param type
	 *
	 * @param  array  $settings
	 * @param  string $value
	 *
	 * @return string
	 */
	function get_product_categories() {
		// Generate dependencies if there are any
		$output     = array();
		$args       = array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => '0',
		);
		$categories = get_categories( $args );
		if ( ! is_wp_error( $categories ) && $categories ) {
			foreach ( $categories as $category ) {
				if ( $category ) {
					$output[] = array(
						'value' => $category->slug,
						'label' => $category->name,
					);
				}
			}
		}

		return $output;
	}

	/**
	 * Return setting UI for get products param type
	 *
	 * @param  array  $settings
	 * @param  string $value
	 *
	 * @return string
	 */
	function get_products() {
		// Generate dependencies if there are any
		global $wpdb;
		$post_meta_infos = $wpdb->get_results( "SELECT a.ID AS id, a.post_title AS title
					FROM {$wpdb->posts} AS a
					WHERE a.post_type = 'product'", ARRAY_A );

		$results = array();
		if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
			foreach ( $post_meta_infos as $value ) {
				$data          = array();
				$data['value'] = $value['id'];
				$data['label'] = $value['title'];
				$results[]     = $data;
			}
		}

		return $results;
	}

	/**
	 * Return setting UI for get products param type
	 *
	 * @param  array  $settings
	 * @param  string $value
	 *
	 * @return string
	 */
	function get_products_onsale() {
		// Generate dependencies if there are any
		global $wpdb;
		$post_meta_infos = $wpdb->get_results( "SELECT a.ID AS id, a.post_title AS title
					FROM {$wpdb->posts} AS a
					WHERE a.post_type = 'product'", ARRAY_A );

		$results = array();
		if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
			foreach ( $post_meta_infos as $value ) {
				$data          = array();
				$data['value'] = $value['id'];
				$data['label'] = $value['title'];
				$results[]     = $data;
			}
		}

		return $results;
	}

	function rev_sliders() {

		if ( ! class_exists( 'RevSlider' ) ) {
			return;
		}

		$slider     = new RevSlider();
		$arrSliders = $slider->getArrSliders();

		$revsliders = array();
		if ( $arrSliders ) {
			$revsliders[ esc_html__( 'Choose a slider', 'mrbara' ) ] = 0;
			foreach ( $arrSliders as $slider ) {
				$revsliders[ $slider->getTitle() ] = $slider->getAlias();
			}
		} else {
			$revsliders[ esc_html__( 'No sliders found', 'mrbara' ) ] = 0;
		}

		return $revsliders;
	}

	/**
	 * Get categories
	 *
	 * @return array|string
	 */
	function get_categories( $taxonomy = 'category' ) {
		$output[ esc_html__( 'All', 'mrbara' ) ] = '';
		$args                                    = array(
			'taxonomy' => $taxonomy,
		);
		$categories                              = get_categories( $args );
		if ( $categories ) {
			foreach ( $categories as $category ) {
				if ( $category ) {
					$output[ $category->name ] = $category->slug;
				}
			}
		}

		return $output;
	}

	/**
	 * Return setting UI for icon param type
	 *
	 * @param  array  $settings
	 * @param  string $value
	 *
	 * @return string
	 */
	function icon_param( $settings, $value ) {
		// Generate dependencies if there are any
		$icons = array();
		foreach ( $this->icons as $icon ) {
			$icons[] = sprintf(
				'<i data-mr-icon="%1$s" class="%1$s %2$s"></i>',
				$icon,
				$icon == $value ? 'selected' : ''
			);
		}

		return sprintf(
			'<div class="icon_block">
				<span class="icon-preview" ><i class="%s" ></i ></span>
				<input type = "text" class="icon-search" placeholder = "%s">
				<input type = "hidden" name = "%s" value = "%s" class="wpb_vc_param_value wpb-textinput %s %s_field">
				<div class="icon-selector" >%s </div>
			</div > ',
			esc_attr( $value ),
			esc_attr__( 'Quick Search', 'mrbara' ),
			esc_attr( $settings['param_name'] ),
			esc_attr( $value ),
			esc_attr( $settings['param_name'] ),
			esc_attr( $settings['type'] ),
			implode( '', $icons )
		);

	}

}

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_mrbara_sliders extends WPBakeryShortCodesContainer {
	}

	class WPBakeryShortCode_mrbara_sliders_banners extends WPBakeryShortCodesContainer {
	}

	class WPBakeryShortCode_mrbara_info_banners extends WPBakeryShortCodesContainer {
	}

	class WPBakeryShortCode_mrbara_product_categories_group extends WPBakeryShortCodesContainer {
	}


}

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_MrBara_CTA_2 extends WPBakeryShortCode {
	}

	class WPBakeryShortCode_MrBara_Banner extends WPBakeryShortCode {
	}

	class WPBakeryShortCode_mrbara_banner_grid extends WPBakeryShortCode {
	}

	class WPBakeryShortCode_mrbara_slider extends WPBakeryShortCode {
	}

	class WPBakeryShortCode_mrbara_info_section_title extends WPBakeryShortCode {
	}

	class WPBakeryShortCode_mrbara_info_newsletter extends WPBakeryShortCode {
	}

	class WPBakeryShortCode_mrbara_product_categories_box extends WPBakeryShortCode {
	}
}
<?php
/**
 * WOOLU_Integration
 *
 * @package         WooLu
 * @subpackage      WOOLU_Woocommerce
 * @since           1.0.0
 *
 */

// If this file is called directly, call the cops.
defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

if ( ! class_exists( 'WOOLU_Integration' ) ) {

    class WOOLU_Integration extends WC_Integration {

        /**
         * The integration ID
         * @var string
         */
        const ID = 'woolu-integration';

        /**
         * Initialize integration actions.
         */
        public function __construct() {
            $this->id                 = self::ID;
            $this->method_title       = __( 'Magalu', 'woolu' );
            $this->method_description = __( 'Integrate to Magalu to publish products and manage orders inside WooCommerce.', 'woocommerce-correios' );

            // Load the form fields.
            $this->init_form_fields();

            // Load the settings.
            $this->init_settings();

            // Actions
            add_action( 'woocommerce_update_options_integration_' . $this->id, array( $this, 'process_admin_options' ) );
        }

        /**
         * Initialize integration settings fields.
         */
        public function init_form_fields() {
            $this->form_fields = array(
                'api_token' => array(
                    'title'       => __( 'API Token', 'woolu' ),
                    'type'        => 'text',
                    'description' => __( "It's your token from Magalu. You should request it throught oAuth.", 'woolu' ),
                    'default'     => '',
                ),
            );
        }

        /**
         * Options page
         *
         * @return void
         */
        public function admin_options() {
            global $hide_save_button, $woolu_integration_error;

            $this->admin_scripts();

            echo '<div class="woolu-integration-header">';
            echo '<h2>' . esc_html( $this->get_method_title() ) . '</h2>';
            echo wp_kses_post( wpautop( $this->get_method_description() ) );
            echo '<div><input type="hidden" name="section" value="' . esc_attr( $this->id ) . '" /></div>';
            echo '</div>';

            // If is a integration weeoe
            if ( ! empty( $woolu_integration_error ) ) {
                $hide_save_button = true;

                $error_title       = $woolu_integration_error['title'] ?? '';
                $error_description = $woolu_integration_error['description'] ?? '';

                require_once WOOLU_PLUGIN_PATH . '/modules/woocommerce/views/html-integration-error.php';
                return;
            }

            // If token is empty: do the first step
            if ( empty( $this->get_option( 'api_token' ) ) ) {
                $hide_save_button = true;

                $login_url = (new WOOLU_Api_Auth)->get_login_url( self::get_url( [ 'woolu-action' => 'auth' ] ) );

                require_once WOOLU_PLUGIN_PATH . '/modules/woocommerce/views/html-integration-first-step.php';
                return;
            }

            echo '<table class="form-table">' . $this->generate_settings_html( $this->get_form_fields(), false ) . '</table>'; // WPCS: XSS ok.
        }

        /**
         * Admin scripts
         *
         * @return void
         */
        public function admin_scripts() {
            $version = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? uniqid() : SLFW_VERSION;

            $file_url  = WOOLU_PLUGIN_URL . '/modules/woocommerce/assets/build/js/woolu-integration.min.js';
            wp_enqueue_script( 'woolu-integration-script', $file_url, array( 'jquery', 'wp-i18n' ), $version, true );
            wp_set_script_translations( 'woolu-integration-script', 'woolu' );

            $file_url  = WOOLU_PLUGIN_URL . '/modules/woocommerce/assets/build/css/woolu-integration.min.css';
            wp_enqueue_style( 'woolu-integration-style', $file_url, array(), $version );
        }

        /**
         * Get page url
         *
         * @return string
         */
        public static function get_url( $args = [] ) {
            $page_args = array(
                'page'    => 'wc-settings',
                'tab'     => 'integration',
                'section' => self::ID,
            );

            return add_query_arg( array_merge( $args, $page_args ), admin_url( 'admin.php' ) );
        }

    }

}

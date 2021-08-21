<?php
/**
 * WOOLU_Module_Woocommerce
 * Class responsible to manage all WooCommerce stuff
 *
 * Depends: dependence
 *
 * @package         WooLu
 * @subpackage      WOOLU_Module_Woocommerce
 * @since           1.0.0
 *
 */

// If this file is called directly, call the cops.
defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

if ( ! class_exists( 'WOOLU_Module_Woocommerce' ) ) {

    class WOOLU_Module_Woocommerce {

        /**
         * Run
         *
         * @since    1.0.0
         */
        public function run() {
            $module = $this->core->get_module( 'dependence' );

            // Checking Dependences
            $module->add_dependence( 'woocommerce/woocommerce.php', 'WooCommerce', 'woocommerce' );

            if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '5.6', '<' ) ) {
                $notice = __( 'Please update <strong>WooCommerce</strong>. The minimum supported version for <strong>WooLu</strong> is 5.6.', 'woolu' );
                $module->add_dependence_notice( $notice );
            }

            $this->includes = array(
                'traits/trait-has-actions',
                'traits/trait-has-urls',
                'api/class-woolu-api-auth',
                'class-woolu-integration',
            );
        }

        /**
         * Define hooks
         *
         * @since    1.0.0
         * @param    WooLu      $core   The Core object
         */
        public function define_hooks() {
            $this->core->add_action( 'admin_init', array( $this, 'admin_init' ), 99 );

            if ( class_exists( 'WC_Integration' ) ) {
                $this->core->add_filter( 'woocommerce_integrations', array( $this, 'woocommerce_integrations' ), 99 );
            }
        }

        /**
         * Action: 'admin_init'
         *
         * @return void
         */
        public function admin_init() {
            if ( empty( $_GET['woolu-action'] ) ) {
                return;
            }

            $action = sanitize_text_field( $_GET['woolu-action'] );

            // Auth Actions
            if ( in_array( $action, [ 'auth' ], true ) ) {
                $auth = new WOOLU_Api_Auth();
                $action = 'do_' . $action;

                if ( ! method_exists( $auth, $action ) ) {
                    wp_die( __( 'Invalid action.', 'woolu' ), '', [ 'back_link' => true ] );
                }

                $auth->$action();
                return;
            }
        }

        /**
         * Filter: 'woocommerce_integrations'
         *
         * @return void
         */
        public function woocommerce_integrations( $integrations ) {
            array_unshift( $integrations, 'WOOLU_Integration' );
            return $integrations;
        }

    }

}


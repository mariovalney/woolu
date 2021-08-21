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
            );
        }

        /**
         * Define hooks
         *
         * @since    1.0.0
         * @param    WooLu      $core   The Core object
         */
        public function define_hooks() {
        }

    }

}


<?php
/**
 * WOOLU_Has_Actions
 *
 * @package         WooLu
 * @subpackage      WOOLU_Woocommerce
 * @since           1.0.0
 *
 */

// If this file is called directly, call the cops.
defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

if ( ! trait_exists( 'WOOLU_Has_Actions' ) ) {

    trait WOOLU_Has_Actions {

        /**
         * Valida we are in the page we want
         *
         * @param  array $args
         * @return boolean
         */
        private function validate_action_page( $args ) {
            foreach ( $args as $key => $value ) {
                if ( empty( $_GET[ $key ] ) ) {
                    return false;
                }

                $challenge = sanitize_text_field( $_GET[ $key ] );

                if ( $challenge !== $value ) {
                    return false;
                }
            }

            return true;
        }

        /**
         * Check we can run this action
         *
         * @return void
         */
        protected function can_run_action() {}

    }

}

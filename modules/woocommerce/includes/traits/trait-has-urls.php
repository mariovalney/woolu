<?php
/**
 * WOOLU_Has_Urls
 *
 * @package         WooLu
 * @subpackage      WOOLU_Woocommerce
 * @since           1.0.0
 *
 */

// If this file is called directly, call the cops.
defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

if ( ! trait_exists( 'WOOLU_Has_Urls' ) ) {

    trait WOOLU_Has_Urls {

        /**
         * Build a URL
         *
         * @param  string $path
         * @param  array  $args
         * @return string
         */
        public function build_url( $path, $args = [] ) {
            $url = static::BASE_URL ?? '';
            $url = $url . '/' . ltrim( $path, '/' );

            return add_query_arg( $args, $url );
        }

    }

}

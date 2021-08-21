<?php

/**
 * A helper to debug
 *
 * @package  WooLu
 * @since    1.0.0
 */

defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

/**
 * Emulate dd function from laravel
 *
 * @SuppressWarnings(PHPMD)
 */
if ( ! function_exists( 'dd' ) ) {
    function dd( $param ) {
        print_r( $param );
        exit;
    }
}

/**
 * Emulate dump function from
 * laravel but write to logs
 */
if ( ! function_exists( 'dump' ) ) {
    function dump( $param ) {
        error_log( $param );
    }
}

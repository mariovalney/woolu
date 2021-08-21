<?php

/**
 * A helper to debug
 *
 * @package  WooLu
 * @since    1.0.0
 */

defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

/**
 * Compare IDs from arrays
 * Generally used in array sort functions
 */
function woolu_array_cmp_id( $arr1, $arr2 ) {
    $arr1 = (array) $arr1;
    $arr2 = (array) $arr2;

    $arr1 = $arr1['ID'] ?? ( $arr1['id'] ?? 0 );
    $arr2 = $arr2['ID'] ?? ( $arr2['id'] ?? 0 );

    return (int) $arr2 - (int) $arr1;
}

/**
 * Compare titles from arrays
 * Generally used in array sort functions
 */
function woolu_array_cmp_title( $arr1, $arr2 ) {
    $arr1 = (array) $arr1;
    $arr2 = (array) $arr2;

    $arr1 = $arr1['title'] ?? '';
    $arr2 = $arr2['title'] ?? '';

    return strnatcmp( trim( $arr1 ), trim( $arr2 ) );
}

/**
 * Insert before a item by key
 * Add to end, if not found.
 */
function woolu_array_insert_before( $array, $search_key, $new_key, $new_value ) {
    $new_array = [];
    $added = false;
    foreach ( $array as $key => $value ) {
        if ( $key === $search_key ) {
            $new_array[ $new_key ] = $new_value;
            $added = true;
        }

        $new_array[ $key ] = $value;
    }

    if ( ! $added ) {
        $new_array[ $new_key ] = $new_value;
    }

    return $new_array;
}

/**
 * Insert after a item by key
 * Add to end, if not found.
 */
function woolu_array_insert_after( $array, $search_key, $new_key, $new_value ) {
    $new_array = [];
    $added = false;
    foreach ( $array as $key => $value ) {
        $new_array[ $key ] = $value;

        if ( $key === $search_key ) {
            $new_array[ $new_key ] = $new_value;
            $added = true;
        }
    }

    if ( ! $added ) {
        $new_array[ $new_key ] = $new_value;
    }

    return $new_array;
}

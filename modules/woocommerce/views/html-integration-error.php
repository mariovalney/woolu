<?php
/**
 * View for error.
 *
 * @package         WooLu
 * @subpackage      WOOLU_Woocommerce
 */

// If this file is called directly, call the cops.
defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

?>

<div class="woolu-integration-steps">
    <h2 class="step-title"><?php echo esc_html( $error_title ); ?></h2>
    <p class="step-subtitle"><?php echo esc_html( $error_description ); ?></p>

    <a href="<?php echo esc_url( WOOLU_Integration::get_url() ); ?>" class="step-button button-primary">
        <?php esc_html_e( 'Please go back and start again.', 'woolu' ); ?>
    </a>
</div>

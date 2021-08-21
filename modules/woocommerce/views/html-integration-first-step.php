<?php
/**
 * View for first step: when API_TOKEN is empty
 *
 * @package         WooLu
 * @subpackage      WOOLU_Woocommerce
 */

// If this file is called directly, call the cops.
defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

?>

<div class="woolu-integration-steps">
    <h2 class="step-title"><?php esc_html_e( 'Login', 'woolu' ); ?></h2>
    <p class="step-subtitle"><?php esc_html_e( "You should login to your Magalu account to allow us get your API Token. It'll be used for all integrations.", 'woolu' ); ?></p>
    <a href="<?php echo esc_url( $login_url ?? '#' ); ?>" class="step-button button-primary">
        <?php esc_html_e( 'Login', 'woolu' ); ?>
    </a>
</div>

<?php
/**
 * WOOLU_Api_Auth
 *
 * @package         WooLu
 * @subpackage      WOOLU_Woocommerce
 * @since           1.0.0
 *
 */

// If this file is called directly, call the cops.
defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

if ( ! class_exists( 'WOOLU_Api_Auth' ) ) {

    class WOOLU_Api_Auth {

        use WOOLU_Has_Actions;
        use WOOLU_Has_Urls;

        /**
         * The base url
         * @var string
         */
        const BASE_URL = 'https://id.magalu.com';

        /**
         * The client id
         * @var string
         */
        const CLIENT_ID = 'woolu-local';

        /**
         * The client secret
         * @var string
         */
        const CLIENT_SECRET = 'bc52994a-462c-4c78-b950-f07a91505799';

        /**
         * Get login url
         *
         * @return string
         */
        public function get_login_url( $redirect_uri ) {
            $args = array(
                'client_id'     => self::CLIENT_ID,
                'redirect_uri'  => urlencode( $redirect_uri ),
                'response_type' => 'code',
                'scope'         => 'seller_access openid',
                'state'         => wp_create_nonce( 'woolu-login-state' ),
            );

            return $this->build_url( 'auth/realms/master/protocol/openid-connect/auth', $args );
        }

        /**
         * Do the login
         *
         * @return void
         */
        public function do_auth() {
            $this->can_run_action();

            $state = sanitize_text_field( $_GET['state'] ?? '' );
            $code  = sanitize_text_field( $_GET['code'] ?? '' );

            if ( empty( $state ) || empty( $code ) || ! wp_verify_nonce( $state, 'woolu-login-state' ) ) {
                $this->set_integration_error( __( "We weren't able to finish your authentication.", 'woolu' ) );
                return;
            }

            $token_url = $this->build_url( 'auth/realms/master/protocol/openid-connect/token' );

            $args = array(
                'timeout'  => 30,
                'blocking' => true,
                'body'     => array(
                    'grant_type'    => 'authorization_code',
                    'client_id'     => self::CLIENT_ID,
                    'client_secret' => self::CLIENT_SECRET,
                    'code'          => $code,
                    'redirect_uri'  => WOOLU_Integration::get_url( [ 'woolu-action' => 'auth' ] ),
                )
            );

            $response = wp_remote_post( $token_url, $args );

            if ( empty( $response['response'] ) || ( $response['response']['code'] ?? 0 ) !== 200 ) {
                $this->set_integration_error( __( "We weren't able to finish your authentication.", 'woolu' ) );
                return;
            }

            $token = json_decode( $response['body'] ?? '' );
            $token = $token->access_token ?? '';

            // TODO: use the new token
            $this->set_integration_error( $token, 'ACCESS TOKEN' );
        }

        /**
         * Check we can run this action
         *
         * @return void
         */
        protected function can_run_action() {
            $page = array(
                'page'    => 'wc-settings',
                'tab'     => 'integration',
                'section' => WOOLU_Integration::ID,
            );

            if ( $this->validate_action_page( $page ) ) {
                return;
            }

            wp_die( __( 'This action is invalid. Please go back and start again.', 'woolu' ), __( 'Something went wrong', 'woolu' ), [ 'back_link' => true ] );
        }

        /**
         * Check we can run this action
         *
         * @return void
         */
        private function set_integration_error( $error, $title = null ) {
            global $woolu_integration_error;

            $woolu_integration_error = [
                'title'       => $title ?? __( 'Ops...', 'woolu' ),
                'description' => $error,
            ];
        }
    }

}

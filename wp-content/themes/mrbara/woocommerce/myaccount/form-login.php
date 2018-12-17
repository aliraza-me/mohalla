<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$col_class1      = 'col-md-12 col-sm-12';
$col_class2      = 'col-md-12 col-sm-12';
$login           = esc_html__( 'Log in your account', 'mrbara' );
$register        = esc_html__( 'Don\'t have an Account? Register now', 'mrbara' );
$register_button = esc_html__( 'Register', 'mrbara' );

if ( mrbara_theme_option( 'login_page_layout' ) ) {
	$col_class1      = 'col-md-5 col-sm-5';
	$col_class2      = 'col-md-7 col-sm-7';
	$login           = esc_html__( 'Login', 'mrbara' );
	$register        = esc_html__( 'Create an Account', 'mrbara' );
	$register_button = esc_html__( 'Create an Account', 'mrbara' );
}


?>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>
<div id="customer_login" xmlns="http://www.w3.org/1999/html">
	<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

	<div class="row">
		<div class="<?php echo esc_attr( $col_class1 ); ?>">

			<?php endif; ?>

			<h2><?php echo esc_attr( $login ); ?></h2>

			<form method="post" class="woocommerce-form woocommerce-form-login  login">

				<?php do_action( 'woocommerce_login_form_start' ); ?>
				<div class="row">
					<div class="col-md-5 col-sm-6 col-xs-12 col-login col-user-log">
						<div class="form-row form-row-wide">
							<div class="mr-forgot">
								<input type="text" class="input-text" placeholder="<?php esc_html_e( 'Username or email address', 'mrbara' ); ?>" name="username" id="username" value="<?php if ( ! empty( $_POST['username'] ) ) {
									echo esc_attr( $_POST['username'] );
								} ?>" />
								<?php if ( mrbara_theme_option( 'login_page_layout' ) ) : ?>
									<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Forgot?', 'mrbara' ); ?></a>
								<?php endif; ?>
							</div>
						</div>
					</div>
					<div class="col-md-5 col-sm-6 col-xs-12 col-login col-pass-log">
						<div class="form-row form-row-wide">
							<div class="mr-forgot">
								<input class="input-text" type="password" placeholder="<?php esc_html_e( 'Password', 'mrbara' ); ?>" name="password" id="password" />
								<?php if ( mrbara_theme_option( 'login_page_layout' ) ) : ?>
									<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Forgot?', 'mrbara' ); ?></a>
								<?php endif; ?>
							</div>
						</div>
						<?php do_action( 'woocommerce_mrbara_login_form' ); ?>
					</div>
					<?php if ( mrbara_theme_option( 'login_page_layout' ) ) : ?>
						<div class="col-md-12 col-sm-12 col-xs-12 col-login ">
							<div class="mr-remember">
								<input name="rememberme" class="input-checkbox" type="checkbox" id="rememberme" value="forever" />
								<label for="rememberme" class="inline">
									<?php esc_html_e( 'Stay logged in', 'mrbara' ); ?>
								</label>
							</div>
						</div>
					<?php endif; ?>

					<div class="col-md-2 col-sm-12 col-xs-12 col-login col-btn-log">
						<div class="form-row">
							<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
							<div class="btn-log">
								<input type="submit" class="button" name="login" value="<?php esc_attr_e( 'Login', 'mrbara' ); ?>" />
							</div>
						</div>
					</div>

					<?php if ( ! mrbara_theme_option( 'login_page_layout' ) ) : ?>
						<div class="col-md-12 col-sm-12 col-xs-12 col-login">
							<div class="mr-remember">
								<input name="rememberme" class="input-checkbox" type="checkbox" id="rememberme" value="forever" />
								<label for="rememberme" class="inline">
									<?php esc_html_e( 'Keep me logged in', 'mrbara' ); ?>
								</label>
							</div>
							<p class="woocommerce-LostPassword lost_password">
								<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Forgot your password?', 'mrbara' ); ?></a>
							</p>
						</div>
					<?php endif; ?>
					<div class="col-md-12 col-sm-12 col-xs-12 col-login-social">
						<?php do_action( 'woocommerce_login_form' ); ?>
					</div>


				</div>

				<?php do_action( 'woocommerce_login_form_end' ); ?>

			</form>

			<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

		</div>

		<div class="<?php echo esc_attr( $col_class2 ); ?>">

			<h2 class="title-register"><?php echo esc_attr( $register ); ?></h2>

			<form method="post" class="woocommerce-form woocommerce-form-register register">

				<?php do_action( 'woocommerce_register_form_start' ); ?>
				<div class="row">
					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
						<div class="col-md-4 col-sm-4 col-login ">
							<p class="form-row form-row-wide">
								<input type="text" class="input-text" placeholder="<?php esc_html_e( 'Username', 'mrbara' ); ?>" name="username" id="reg_username" value="<?php if ( ! empty( $_POST['username'] ) ) {
									echo esc_attr( $_POST['username'] );
								} ?>" />
							</p>
						</div>
					<?php endif; ?>
					<div class="col-md-4 col-sm-4 col-login">
						<p class="form-row form-row-wide">
							<input type="email" class="input-text" placeholder="<?php esc_html_e( 'Email Address', 'mrbara' ); ?>" name="email" id="reg_email" value="<?php if ( ! empty( $_POST['email'] ) ) {
								echo esc_attr( $_POST['email'] );
							} ?>" />
						</p>
					</div>
					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
						<div class="col-md-4 col-sm-4 col-login">
							<p class="form-row form-row-wide">
								<input type="password" class="input-text" placeholder="<?php esc_html_e( 'Password', 'mrbara' ); ?>" name="password" id="reg_password" />
							</p>
						</div>
					<?php endif; ?>

					<!-- Spam Trap -->
					<div style="<?php echo( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;">
						<label for="trap"><?php esc_html_e( 'Anti-spam', 'mrbara' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" />
					</div>

					<div class="col-md-12 col-sm-12">
						<?php do_action( 'woocommerce_register_form' ); ?>
					</div>
					<div class="col-md-12 col-sm-12 col-login-social">
						<?php do_action( 'register_form' ); ?>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12 col-login">
						<div class="mr-agree">
							<input name="mragree" class="input-checkbox" type="checkbox" id="mragree" value="forever" />
							<label for="mragree" class="inline agree">
								<span><?php esc_html_e( 'Agree to the', 'mrbara' ); ?></span>
								<a class="terms_conditions" href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_terms_page_id' ) ) ) ?>"><?php esc_html_e( 'Terms and Conditions', 'mrbara' ); ?></a>
							</label>
						</div>
					</div>

					<div class="col-md-12 col-sm-12 col-login">
						<div class="form-row">
							<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
							<div class="btn-regis">
								<input type="submit" class="button" name="register" value="<?php echo esc_attr( $register_button ); ?>" />
							</div>
						</div>
					</div>

					<?php do_action( 'woocommerce_register_form_end' ); ?>

				</div>

			</form>

		</div>
	</div>

<?php endif; ?>
</div>
<?php do_action( 'woocommerce_after_customer_login_form' ); ?>

<?php
namespace WP_Rocket\Tests\Unit\inc\ThirdParty\Themes\Divi;

use Brain\Monkey\Functions;
use Mockery;
use WP_Rocket\Engine\Optimization\RUCSS\Controller\UsedCSS;
use WP_Rocket\Tests\Unit\TestCase;
use WP_Rocket\ThirdParty\Themes\Divi;
use WP_Theme;

/**
 * Test class covering \WP_Rocket\ThirdParty\Themes\Divi::disable_divi_jquery_body
 *
 * @group  ThirdParty
 */
class Test_DisableDiviJqueryBody extends TestCase {
	public function setUp(): void {
		parent::setUp();
		define( 'ET_CORE_VERSION','4.10' );
	}

	public function tearDown(): void {
		unset( $GLOBALS['ET_CORE_VERSION'] );

		parent::tearDown();
	}

	public function testDisableDiviJqueryBody() {
		$options_api  = Mockery::mock( 'WP_Rocket\Admin\Options' );
		$options      = Mockery::mock( 'WP_Rocket\Admin\Options_Data' );
		$delayjs_html = Mockery::mock( 'WP_Rocket\Engine\Optimization\DelayJS\HTML' );
		$used_css     = Mockery::mock( UsedCSS::class );

		$theme = new WP_Theme( 'Divi', 'wp-content/themes/' );

		// @phpstan-ignore-next-line
		$theme->set_name( 'Divi' );

		Functions\when( 'wp_get_theme' )->justReturn( $theme );

		$divi = new Divi( $options_api, $options, $delayjs_html, $used_css );
		$delayjs_html->shouldReceive( 'is_allowed' )->once()->andReturn( true );
		$divi->disable_divi_jquery_body();

		$this->assertSame( 10, has_filter( 'et_builder_enable_jquery_body', '__return_false' ) );
	}
}

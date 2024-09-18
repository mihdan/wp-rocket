<?php

namespace WP_Rocket\Tests\Unit\inc\Engine\Common\JobManager\Strategy\Strategies\ResetRetryProcess;

use Mockery;
use WP_Rocket\Engine\Common\JobManager\Strategy\Strategies\ResetRetryProcess;
use WP_Rocket\Engine\Optimization\RUCSS\Jobs\Manager;
use WP_Rocket\Tests\Unit\TestCase;

/**
 * Test class covering \WP_Rocket\Engine\Common\JobManager\Strategy\Strategies\ResetRetryProcess::execute
 *
 * @group Strategy
 */
class TestExecute extends TestCase {
	private $manager;
	private $strategy;

	public function setUp(): void {
		parent::setUp();

		$this->manager  = Mockery::mock( Manager::class );
		$this->strategy = new ResetRetryProcess( $this->manager );
	}

	/**
	 * @dataProvider configTestData
	 */
	public function testShouldBehaveAsExpected( $config, $expected ) {
		$this->manager->shouldReceive( 'add_url_to_the_queue' )
			->once()
			->withArgs(
				[
					$config['row_details']->url,
					$config['row_details']->is_mobile,
				]
			);

		$this->strategy->execute( $config['row_details'], $config['job_details'] );
	}
}
<?php

namespace FlaggedRevs\tests\phpunit;

use MediaWiki\Extension\FlaggedRevs\Rest\DiffHeaderHandler;
use MediaWiki\Rest\LocalizedHttpException;
use MediaWiki\Rest\RequestData;
use MediaWiki\Tests\Rest\Handler\HandlerTestTrait;
use MediaWikiIntegrationTestCase;
use Wikimedia\Message\MessageValue;

/**
 * @covers MediaWiki\Extension\FlaggedRevs\Rest\DiffHeaderHandler
 *
 * @group Database
 */
class DiffHeaderHandlerTest extends MediaWikiIntegrationTestCase {
	use HandlerTestTrait;

	private function newHandler() {
		return new DiffHeaderHandler();
	}

	public function testRun() {
		$page = $this->getExistingTestPage();
		$oldId = $page->getLatest();
		$this->editPage( $page, 'second' );
		$newId = $page->getLatest();
		$request = new RequestData( [ 'pathParams' => [ 'oldId' => $oldId, 'newId' => $newId ] ] );

		$handler = $this->newHandler();
		$response = $this->executeHandler( $handler, $request );

		$this->assertTrue(
			$response->getStatusCode() >= 200 && $response->getStatusCode() < 300,
			'Status should be in 2xx range.'
		);
		$this->assertSame( 'text/html', $response->getHeaderLine( 'Content-Type' ) );

		$html = $response->getBody()->getContents();
		$this->assertStringContainsString( $oldId, $html );
		$this->assertStringContainsString( $newId, $html );
		$this->assertStringStartsWith( '<form id="mw-fr-diff-dataform">', $html );
	}

	public function testRun_BadParam() {
		$request = new RequestData( [ 'pathParams' => [ 'oldId' => 42, 'newId' => 'badinteger' ] ] );

		$handler = $this->newHandler();

		$this->expectExceptionObject(
			new LocalizedHttpException( new MessageValue( 'paramvalidator-badinteger' ), 400 )
		);
		$this->executeHandler( $handler, $request );
	}

	public function testRun_MissParam() {
		$request = new RequestData( [ 'pathParams' => [ 'oldId' => 42 ] ] );

		$handler = $this->newHandler();

		$this->expectExceptionObject(
			new LocalizedHttpException( new MessageValue( 'paramvalidator-missingparam' ), 400 )
		);
		$this->executeHandler( $handler, $request );
	}
}
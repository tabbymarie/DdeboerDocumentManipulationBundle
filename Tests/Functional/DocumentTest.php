<?php

namespace Ddeboer\DocumentManipulationBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Ddeboer\DocumentManipulationBundle\Document\Document;
use Ddeboer\DocumentManipulationBundle\Document\DocumentData;
use Ddeboer\DocumentManipulationBundle\Document\Image;
use Ddeboer\DocumentManipulationBundle\Document\File;

/**
 * @group functional
 */
class DocumentTest extends WebTestCase
{
    protected $manipulators;

    protected $factory;

    public function setup()
    {
        $client = $this->createClient();
        $this->manipulators = $client->getContainer()
            ->get('ddeboer_document_manipulation.manipulator_chain');

        $this->factory = $client->getContainer()
            ->get('ddeboer_document_manipulation.factory');
    }



    public function testAppend()
    {
        $document1 = $this->factory->open('/tmp/output1.pdf');
        $document2 = $this->factory->open('/tmp/output2.pdf');

        $document = $document1
            ->append($document2)
            ->save('/tmp/output3.pdf');

        $this->assertEquals('/tmp/output3.pdf', $document->getFile()->getPathname());

        $document1 = $this->factory->open('/tmp/output1.pdf');
        $document2 = $this->factory->open('/tmp/output4.pdf');
        $document3 = $this->factory->open('/tmp/output3.pdf');
        $image = $this->factory->open('/tmp/image.pdf');

        $document = $document1
            ->append($document2)
            ->append($document3)
            ->append($image)
            ->save('/tmp/output3.2.pdf');
    }

    public function testAppendMultiple()
    {
        $document1 = $this->factory->open(__DIR__.'/../Fixtures/output.pdf');
        $document2 = $this->factory->open(__DIR__.'/../Fixtures/letterhead.pdf');
        $document3 = $this->factory->open('/tmp/output1.pdf');

        $document = $document1
            ->appendMultiple(array($document2, $document3));

        $this->assertEquals('application/pdf', $document->getFile()->getMimeType());
    }

    public function testLayer()
    {
        $foreground = $this->factory->open(__DIR__.'/../Fixtures/output.pdf');
        $background = $this->factory->open(__DIR__.'/../Fixtures/letterhead.pdf');

        $document = $foreground->putInFront($background);

        $this->assertEquals('application/pdf', $document->getFile()->getMimeType());
    }
    

}
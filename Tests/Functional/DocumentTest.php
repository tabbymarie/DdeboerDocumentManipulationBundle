<?php

namespace Ddeboer\DocumentManipulationBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Ddeboer\DocumentManipulationBundle\Document\Document;
use Ddeboer\DocumentManipulationBundle\Document\DocumentData;
use Ddeboer\DocumentManipulationBundle\Document\Image;
use Ddeboer\DocumentManipulationBundle\Document\File;

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

    public function testMergeDocx()
    {
        $document = $this->factory->open(__DIR__.'/../Fixtures/document.docx');
        $data = new DocumentData(array('Name' => 'Bond', 'FirstName' => 'James'));
        $document
            ->merge($data)
            ->save('/tmp/output1.pdf');
    }

    public function testMergeDoc()
    {
        $document = $this->factory->open(__DIR__.'/../Fixtures/document.doc');
        $data = new DocumentData(array('Name' => 'Bond', 'FirstName' => 'James'));
        $document
            ->merge($data)
            ->save('/tmp/output2.pdf');
    }

    public function testAppend()
    {
        $document1 = $this->factory->open('/tmp/output1.pdf');
        $document2 = $this->factory->open('/tmp/output2.pdf');

        $document = $document1
            ->append($document2)
            ->save('/tmp/output3.pdf');

        $document1 = $this->factory->open('/tmp/output1.pdf');
        $document2 = $this->factory->open('/tmp/output2.pdf');
        $document3 = $this->factory->open('/tmp/output3.pdf');

        $document = $document1
            ->append($document2)
            ->append($document3)
            ->save();
    }

    public function testMergeAndAppend()
    {
        $this->factory
            ->open(__DIR__.'/../Fixtures/document.doc')
            ->merge(new DocumentData(array('Name' => 'Bond')))
            ->append($this->factory->open('/tmp/output1.pdf'))
            ->save('/tmp/merge_and_append.pdf');
    }

    public function testMergeImageInDocx()
    {
        $document = $this->factory->open(__DIR__.'/../Fixtures/document.docx');

        $image = Image::fromFilename(__DIR__.'/../Fixtures/photo.jpg');
        $data = new DocumentData();
        $data->set('image:Photo', $image);

        $document
            ->merge($data)
            ->save('/tmp/image.pdf');
    }
}
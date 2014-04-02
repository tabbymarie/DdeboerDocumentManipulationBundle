Ddeboer Document Manipulation Bundle
===================================

Introduction
------------

Use this bundle to perform operations on PDF documents.  The
goal of this bundle to abstract appending, etc. of pdf documents.

### Features

(todo)

Installation
------------


### PDF manipulation using pdftk

Install `pdftk`, and then configure it in your `config.yml`:

```
ddeboer_document_manipulation:
  pdftk:
    binary: /usr/local/bin/pdftk
```

Replace `/usr/local/bin/pdftk` with the path to the `pdftk` binary on your
system.

Customization
-------------

### Create a custom document manipulator

Create your own document manipulator, and implement the `ManipulatorInterface`.
Add your manipulator as a service, and tag that with
`ddeboer_document_manipulation.manipulator`. For instance the standard LiveDocx
manipulator is defined as follows:

```
<service id="ddeboer_document_manipulation.manipulator.pdftk"
         class="Ddeboer\DocumentManipulationBundle\Manipulator\PdftkManipulator">
    <tag name="ddeboer_document_manipulation.manipulator" />
</service>
```
or for .yml

```
      ddeboer_document_manipulation.manipulator.pdftk:
        class: Ddeboer\DocumentManipulationBundle\Manipulator\PdftkManipulator
        arguments: [@ddeboer_document_manipulation.pdftk]
        tags:
            - { name: ddeboer_document_manipulation.manipulator }
```

```
    "repositories": [
        {
			"type": "vcs",
            "url":"git@github.com:tabbymarie/DdeboerDocumentManipulationBundle.git"
        },
        ...
    ],
    "require": {
		"ddeboer/document-manipulation-bundle": "dev-pdfonly",
    }

```


Run tests
---------

Run unit tests:

```
$ phpunit
```

Run functional tests:

```
$ phpunit -c app --group functional vendor/ddeboer/document-manipulation-bundle/Ddeboer/DocumentManipulationBundle/Tests/
```


Documentation
-------------

More extensive documentation will be included in the [Resources/doc directory](http://github.com/ddeboer/DdeboerDocumentManipulationBundle/tree/master/Resources/doc/index.md).
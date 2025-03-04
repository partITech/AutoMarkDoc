<?php

namespace App\Service;

use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Event\DocumentParsedEvent;
use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\Extension\CommonMark\Node\Inline\Image;

/**
 * ImageUrlRewriterExtension is a custom extension for the CommonMark parser.
 * It listens for the DocumentParsedEvent and modifies the URLs of image nodes in the parsed document.
 */
final class ImageUrlRewriterExtension implements ExtensionInterface
{
    private string $project;

    public function __construct(string $project)
    {
        $this->project = SafeUrl::parse($project);
    }


    /**
     * Registers the extension with the environment.
     *
     * @param EnvironmentBuilderInterface $environment The environment builder interface.
     */
    public function register(EnvironmentBuilderInterface $environment): void
    {
        // Register an event listener for the DocumentParsedEvent
        // This event is triggered once the document is fully parsed
        $environment->addEventListener(DocumentParsedEvent::class, [$this, 'onDocumentParsed']);
    }

    /**
     * Handles the DocumentParsedEvent to rewrite image URLs.
     *
     * @param DocumentParsedEvent $event The event object containing the parsed document.
     */
    public function onDocumentParsed(DocumentParsedEvent $event): void
    {
        // Get the parsed document from the event
        $document = $event->getDocument();

        // Create a walker to traverse the document's DOM
        $walker = $document->walker();

        // Traverse the DOM nodes in the document
        while ($walkerEvent = $walker->next()) {
            // Check if the walker is entering an Image node
            if ($walkerEvent->isEntering() && $walkerEvent->getNode() instanceof Image) {
                /** @var Image $image */
                $image = $walkerEvent->getNode();

                // Get the current URL of the image
                $oldUrl = SafeUrl::parse($image->getUrl());

                // Rewrite the URL by appending a query string
                // Example: "/get-image=monimage.png&project=mon-projet"
                $newUrl = '/get-image?img=' . $oldUrl . '&project='.$this->project;

                // Set the new URL for the image node
                $image->setUrl($newUrl);
            }
        }
    }
}

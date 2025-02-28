<?php

namespace App\Service;

use League\CommonMark\Event\DocumentParsedEvent;
use League\CommonMark\Extension\CommonMark\Node\Block\Heading;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;
use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Node\Inline\Text;

/**
 * Extension that captures the nearest H2 heading and attaches it to Link nodes.
 */
class MenuHeadingContextExtension implements ExtensionInterface
{
    public function register(EnvironmentBuilderInterface $environment): void
    {
        // Listen for "document parsed" so we can walk the AST
        $environment->addEventListener(DocumentParsedEvent::class, [$this, 'onDocumentParsed']);
    }

    /**
     * When the document is fully parsed, we walk it to find heading text.
     */
    public function onDocumentParsed(DocumentParsedEvent $event): void
    {
        $document = $event->getDocument();
        $walker = $document->walker();

        // We'll track the latest H2 heading text as we go
        $currentH2Text = '';

        while ($walkEvent = $walker->next()) {
            $node = $walkEvent->getNode();

            // We only want to detect "entering" a node, not leaving
            if (! $walkEvent->isEntering()) {
                continue;
            }

            // 1) If it's a Heading level 2, gather its text
            if ($node instanceof Heading && $node->getLevel() === 2) {
                $currentH2Text = $this->extractText($node);
            }

            // 2) If it's a Link, attach the current heading text
            if ($node instanceof Link) {
                // Store the heading text in node data
                $node->data->set('heading', $currentH2Text);
            }
        }
    }

    /**
     * Extract the plain text from a heading node (including inline children).
     */
    private function extractText(Heading $heading): string
    {
        $textContent = '';

        foreach ($heading->children() as $child) {
            if ($child instanceof Text) {
                $textContent .= $child->getLiteral();
            }
            // If you have more complex inline nodes, handle them here
            // (e.g., Emphasis, Strong, etc. -> also contains children)
        }

        return trim($textContent);
    }
}
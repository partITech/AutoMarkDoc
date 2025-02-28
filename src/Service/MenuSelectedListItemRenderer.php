<?php

namespace App\Service;

use League\CommonMark\Extension\CommonMark\Node\Block\ListItem;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;
use League\CommonMark\Node\Block\AbstractBlock;
use League\CommonMark\Node\Block\Paragraph;
use League\CommonMark\Node\Block\TightBlockInterface;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Util\HtmlElement;
use League\CommonMark\Xml\XmlNodeRendererInterface;

/**
 * Custom renderer for list items in CommonMark.
 *
 * This renderer adds a `selected` class to list items that contain a link
 * matching the currently selected link. It extends both HTML and XML rendering
 * capabilities, making it suitable for multiple output formats.
 */
class MenuSelectedListItemRenderer implements NodeRendererInterface, XmlNodeRendererInterface
{
    /**
     * The currently active link to compare against.
     *
     * @var string
     */
    private string $currentLink;

    /**
     * Constructor.
     *
     * @param string $currentLink The currently selected link.
     */
    public function __construct(string $currentLink)
    {
        $this->currentLink = $currentLink;
    }

    /**
     * Renders a list item node to HTML.
     *
     * If the list item contains a link that matches the `$currentLink`,
     * a `selected` class is added to the `<li>` element.
     *
     * @param Node $node The node to render (must be a ListItem).
     * @param ChildNodeRendererInterface $childRenderer The renderer for child nodes.
     * @return \Stringable The rendered HTML output.
     */
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): \Stringable
    {
        ListItem::assertInstanceOf($node);

        $contents = $childRenderer->renderNodes($node->children());

        $inTightList = ($parent = $node->parent()) && $parent instanceof TightBlockInterface && $parent->isTight();

        if ($this->needsBlockSeparator($node->firstChild(), $inTightList)) {
            $contents = "\n" . $contents;
        }

        if ($this->needsBlockSeparator($node->lastChild(), $inTightList)) {
            $contents .= "\n";
        }

        // Retrieve existing attributes for the <li> element.
        $attrs = $node->data->get('attributes');

        // Check if the list item contains a link and matches the current link
        if ($link = $this->findLink($node)) {
            if ($link->getUrl() === $this->currentLink) {
                $attrs['class'] = ($attrs['class'] ?? '') . ' selected';
            }
        }

        return new HtmlElement('li', $attrs, $contents);
    }

    /**
     * Returns the XML tag name for this node.
     *
     * @param Node $node The node being rendered.
     * @return string The XML tag name.
     */
    public function getXmlTagName(Node $node): string
    {
        return 'item';
    }

    /**
     * Returns the XML attributes for this node.
     *
     * @param Node $node The node being rendered.
     * @return array An empty array (no additional attributes needed).
     */
    public function getXmlAttributes(Node $node): array
    {
        return [];
    }

    /**
     * Determines if a block separator is needed before/after a child node.
     *
     * A separator is needed unless the child is a Paragraph inside a tight list.
     *
     * @param Node|null $child The child node to check.
     * @param bool $inTightList Whether the list is tight.
     * @return bool True if a separator is needed, false otherwise.
     */
    private function needsBlockSeparator(?Node $child, bool $inTightList): bool
    {
        if ($child instanceof Paragraph && $inTightList) {
            return false;
        }

        return $child instanceof AbstractBlock;
    }

    /**
     * Finds the first Link node inside the given ListItem node.
     *
     * It checks direct children first, then looks inside Paragraph nodes.
     *
     * @param Node $node The list item node to search.
     * @return Link|null The found link node, or null if none is found.
     */
    private function findLink(Node $node): ?Link
    {
        foreach ($node->children() as $child) {
            if ($child instanceof Link) {
                return $child;
            }

            if ($child instanceof Paragraph) {
                foreach ($child->children() as $inlineChild) {
                    if ($inlineChild instanceof Link) {
                        return $inlineChild;
                    }
                }
            }
        }

        return null;
    }
}

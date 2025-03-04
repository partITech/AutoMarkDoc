<?php

namespace App\Service;

use League\CommonMark\Extension\CommonMark\Node\Inline\Link;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;
use League\CommonMark\Xml\XmlNodeRendererInterface;

/**
 * Custom renderer for Link nodes that rewrites their HREF to a safe, prefixed URL.
 */
class MenuLinkRenderer implements NodeRendererInterface, XmlNodeRendererInterface
{
    private string $baseUrl;
    private string $fileParam;
    private string $titleParam;

    public function __construct(string $baseUrl, string $fileParam, string $titleParam)
    {
        $this->baseUrl = $baseUrl;
        $this->fileParam = $fileParam;
        $this->titleParam = $titleParam;
    }

    public function render(Node $node, ChildNodeRendererInterface $childRenderer): \Stringable
    {
        // Ensure we're dealing with a Link node
        if (! $node instanceof Link) {
            throw new \InvalidArgumentException('Incompatible node type: ' . get_class($node));
        }

        // Original link (e.g., "intro/quickstart.md")
        $originalUrl = $node->getUrl();
        $encodedUrl = SafeUrl::parse($originalUrl);
//        // 1) Optionally sanitize or forbid directory traversal like ".."
//        //    This is a simple example that just strips out ".."
//        $safeUrl = str_replace('..', '', $originalUrl);
//        // Trim and remove obvious attempts at directory traversal
//        $safeUrl = trim($safeUrl);
//        // Optionally remove any backslashes in case of Windows paths
//        $safeUrl = str_replace('\\', '/', $safeUrl);
//
//
//        // 2) Encode the URL so special chars become safe in query strings
//        $encodedUrl = rawurlencode($safeUrl);

        // 3) Retrieve the heading text from node data (added by HeadingContextExtension)
        $heading = $node->data->get('heading') ?? '';

        // 4) Build the final URL -> e.g. "https://my-controller?docpath=intro%2Fquickstart.md"
        $finalHref = $this->baseUrl . '?' . $this->fileParam . '=' . $encodedUrl . '&'. $this->titleParam . '=' . $heading;

        // Render the link text (child nodes)
        $linkText = $childRenderer->renderNodes($node->children());

        // Preserve any existing attributes (title, class, etc.) but override 'href'
        $attrs = $node->data->get('attributes') ?? [];
        $attrs['href'] = $finalHref;

        // Return an <a> element
        return new HtmlElement('a', $attrs, $linkText);
    }

    public function getXmlTagName(Node $node): string
    {
        return 'link';
    }

    public function getXmlAttributes(Node $node): array
    {
        return [];
    }

}
<?php
namespace App\Service;

use League\CommonMark\Extension\Table\Table;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Node\Node;
use League\CommonMark\Util\HtmlElement;
use League\CommonMark\Renderer\ChildNodeRendererInterface;

class TableRenderer implements NodeRendererInterface
{
    public function render(Node $node, ChildNodeRendererInterface $childRenderer)
    {
        if (!($node instanceof Table)) {
            throw new \InvalidArgumentException('Incompatible node type: ' . get_class($node));
        }

        // Ajoute tes classes ici
        $attrs = ['class' => 'table table-striped table-hover align-middle'];

        return new HtmlElement('table', $attrs, $childRenderer->renderNodes($node->children()));
    }
}

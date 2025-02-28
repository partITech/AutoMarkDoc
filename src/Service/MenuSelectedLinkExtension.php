<?php

namespace App\Service;

use League\CommonMark\Extension\CommonMark\Node\Block\ListItem;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;
use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\Environment\EnvironmentBuilderInterface;


class MenuSelectedLinkExtension implements ExtensionInterface
{
    private array $config;

    /**
     * The $config array might look like:
     * [
     *   'baseUrl' => '/documentation/',
     *   'fileParam' => 'file',
     *   'titleParam' => 'title',
     * ]
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function register(EnvironmentBuilderInterface $environment): void
    {
        // 1) Our custom <li> renderer that adds 'selected' if the link matches
        $environment->addRenderer(
                nodeClass: ListItem::class,
                renderer: new MenuSelectedListItemRenderer($this->config['currentLink']),
                priority: 10
        );

        // 2) Our custom <a> renderer that rewrites the URL to be safe & prefixed
        $environment->addRenderer(
            Link::class,
            new MenuLinkRenderer(
                baseUrl: $this->config['baseUrl'],
                fileParam: $this->config['fileParam'],
                titleParam: $this->config['titleParam'],
            ),
            priority: 10
        );

        $environment->addExtension(new MenuHeadingContextExtension());


    }
}
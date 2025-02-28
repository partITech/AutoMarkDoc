<?php

namespace App\Service;

use DOMDocument;
use DOMXPath;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\Attributes\AttributesExtension;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\CommonMark\Node\Block\BlockQuote;
use League\CommonMark\Extension\CommonMark\Node\Block\ListBlock;
use League\CommonMark\Extension\CommonMark\Node\Block\ListItem;
use League\CommonMark\Extension\DefaultAttributes\DefaultAttributesExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\TableOfContents\TableOfContentsExtension;
use League\CommonMark\Extension\TaskList\TaskListItemMarker;
use League\CommonMark\MarkdownConverter;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Throwable;
use Zenstruck\CommonMark\Extension\GitHub\AdmonitionExtension;
use Zenstruck\CommonMark\Extension\TabbedExtension;

class MarkdownRenderer
{
    private string $fileParam = 'file';
    private string $titleParam = 'title';

    public function __construct(
        #[Autowire('%kernel.project_dir%')] private readonly string $projectDir,
        private readonly CommonMarkConverter $converter,
        private readonly Filesystem $filesystem,
        private readonly Finder $finder,
        private readonly string $documentationPath)
    {
    }

    public function getMarkdownFiles(): array
    {
        $basePath = $this->projectDir . '/' . $this->documentationPath;

        if (!$this->filesystem->exists($basePath)) {
            return [];
        }

        $this->finder->files()->in($basePath)->name('*.md');

        $files = [];
        foreach ($this->finder as $file) {
            $files[$file->getRelativePathname()] = $file->getRealPath();
        }

        return $files;
    }

    public function getMenu(string $currentLink, string $baseUrl): string|false
    {
        $filePath = $this->getMarkdownFile(file: 'menu.md');

        if (!$filePath) {
            return false;
        }

        $rawContent = file_get_contents($filePath);
        $this->converter->getEnvironment()->addExtension(new MenuSelectedLinkExtension(config: ['baseUrl' => $baseUrl, 'currentLink' => $currentLink, 'fileParam' => $this->getFileParam(), 'titleParam' => $this->getTitleParam(),]));

        // Split content on '---'
        $sections = explode('---', $rawContent);

        // Build the final HTML
        // Start the main <ul class="nav flex-column">
        $html = '<ul class="nav flex-column">';

        foreach ($sections as $block) {
            // Trim the block to remove extra whitespace/newlines
            $block = trim($block);

            // If the block is empty (e.g., trailing '---'), skip
            if ($block === '') {
                continue;
            }

            // Convert markdown block to HTML
            try {
                $converted = $this->converter->convert($block);
            } catch (Throwable) {
                continue;
            }


            // By default, $converted is RenderedContentInterface in v2.x.
            // Get the actual HTML string with ->getContent()
            $htmlBlock = $converted->getContent();

            // Wrap each block in <li> ... </li>
            $html .= PHP_EOL . "<li>" . PHP_EOL . $htmlBlock . PHP_EOL . "</li>";
        }

        $html .= PHP_EOL . "</ul>" . PHP_EOL;

        return $html;
    }

    public function getMarkdownFile(string $file): string|false
    {
        $filePath = $this->projectDir . '/' . $this->documentationPath . '/' . $file;

        if (!$this->filesystem->exists($filePath)) {
            return false;
        }


        return $filePath;
    }

    public function getFileParam(): string
    {
        return $this->fileParam;
    }

    public function setFileParam(string $fileParam): MarkdownRenderer
    {
        $this->fileParam = $fileParam;
        return $this;
    }

    public function getTitleParam(): string
    {
        return $this->titleParam;
    }

    public function setTitleParam(string $titleParam): MarkdownRenderer
    {
        $this->titleParam = $titleParam;
        return $this;
    }

    public function renderMarkdownFile(string $file): array|false
    {
        $filePath = $this->getMarkdownFile(file: $file);
        if (!$filePath) {
            return false;
        }
        // Define your configuration, if needed
        $config = ['html_input' => 'allow', 'allow_unsafe_links' => false, 'default_attributes' => [BlockQuote::class => ['class' => 'default-blockquote'], ListBlock::class => ['class' => 'default-list-block'], ListItem::class => ['class' => 'default-list-item'], TaskListItemMarker::class => ['class' => 'default-task-list'],], 'heading_permalink' => [//                'insert' => HeadingPermalinkProcessor::INSERT_NONE,
            'apply_id_to_heading' => true, 'heading_class' => 'heading-item',], 'table_of_contents' => ['html_class' => 'table-of-contents', 'position' => 'top', 'style' => 'bullet', 'min_heading_level' => 1, 'max_heading_level' => 6, 'normalize' => 'as-is', 'placeholder' => null,],


        ];


        // Configure the Environment with all the CommonMark and GFM parsers/renderers
        $environment = new Environment($config);
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new GithubFlavoredMarkdownExtension());
        $environment->addExtension(new AdmonitionExtension());
        $environment->addExtension(new DefaultAttributesExtension());
        $environment->addExtension(new AttributesExtension());
        $environment->addExtension(new HeadingPermalinkExtension());
        $environment->addExtension(TabbedExtension::bootstrapTheme());
        $environment->addExtension(new TableOfContentsExtension());

        $converter = new MarkdownConverter($environment);

        $content = file_get_contents($filePath);
        try {
            $html = $converter->convert($content);
        } catch (Throwable) {
            return ['toc' => null, 'content' => null];
        }

        return $this->separateTableOfContents($html);
    }

    private function separateTableOfContents($html): array
    {
        // Charger le HTML dans DOMDocument
        $dom = new DOMDocument();
        libxml_use_internal_errors(true); // Pour éviter les erreurs liées aux balises HTML mal formées
        $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
        libxml_clear_errors();

        // Récupérer la table des matières
        $xpath = new DOMXPath($dom);
        $tocNode = $xpath->query('//ul[contains(@class, "table-of-contents")]')->item(0);

        // Extraire la table des matières sous forme de HTML
        $tableOfContents = "";
        if ($tocNode) {
            $tableOfContents = $dom->saveHTML($tocNode);
            $tocNode->parentNode->removeChild($tocNode); // Supprimer les TOC du document
        }

        // Récupérer le reste du contenu après suppression des TOC
        $mainContent = $dom->saveHTML();

        return ['toc' => $tableOfContents, 'content' => $mainContent];
    }

}

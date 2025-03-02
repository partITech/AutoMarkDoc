<?php

namespace App\Controller;

use App\Service\DocumentationConfigLoader;
use App\Service\MarkdownRenderer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DocFlowController extends AbstractController
{
    #[Route('/', name: 'app_pf')]
    public function index(Request $request, MarkdownRenderer $markdownRenderer, DocumentationConfigLoader $docConfigLoader): Response
    {
        $title = $request->query->get('title', 'Index');

        $projectName = $docConfigLoader->get('projectName', 'DemoProject');
        $logoUrl = $docConfigLoader->get('logoUrl', '/images/logo.svg');
        $projectSource = $docConfigLoader->get('projectSource', 'https://github.com/partITech/DemoProject');
        $jumbotronSourceLinkCodeLink = $docConfigLoader->get('jumbotronSourceLinkCodeLink', 'https://github.com/partITech/DemoProject');
        $enableSearch = $docConfigLoader->get('enableSearch', true);
        $jumbotron = $docConfigLoader->get('jumbotron', true);
        $jumbotronHeader = $docConfigLoader->get('jumbotronHeader', 'DemoProject, Effortless Documentation for Open Source');
        $jumbotronTextLine = $docConfigLoader->get('jumbotronTextLine', 'Automatically transform your DemoProject ...');
        $jumbotronGetStartedLabel = $docConfigLoader->get('jumbotronGetStartedLabel', 'Get started');
        $jumbotronGetStartedLink = $docConfigLoader->get('jumbotronGetStartedLink', '#main-content');
        $jumbotronSourceLinkCodeLabel = $docConfigLoader->get('jumbotronSourceLinkCodeLabel', 'View on GitHub');
        $jumbotronCodeLang = $docConfigLoader->get('jumbotronCodeLang', 'md');
        $jumbotronCodeContent = $docConfigLoader->get('jumbotronCodeContent', '# DemoProject ...');
        $defaultDoc = $docConfigLoader->get('defaultDoc', 'index.md');


        $currentLink = $request->query->get('file', $defaultDoc);

        if($jumbotron && $currentLink!=$defaultDoc){
            $jumbotron = false;
        }

        $menu = $markdownRenderer->getMenu(currentLink: $currentLink, baseUrl: '/');
        $content = $markdownRenderer->renderMarkdownFile($currentLink);


        return $this->render('AutoMarkDoc/index.html.twig', [
            'projectName' => $projectName,
            'logoUrl' => $logoUrl,
            'menu'    => $menu,
            'content' => $content['content'],
            'toc' => $content['toc'],
            'title'   => $title,
            'jumbotronSourceLinkCodeLabel' => $jumbotronSourceLinkCodeLabel,
            'jumbotronSourceLinkCodeLink' => $jumbotronSourceLinkCodeLink,
            'jumbotronGetStartedLabel' => $jumbotronGetStartedLabel,
            'projectSource'           => $projectSource,
            'enableSearch'            => $enableSearch,
            'jumbotron'               => $jumbotron,
            'jumbotronHeader'         => $jumbotronHeader,
            'jumbotronTextLine'       => $jumbotronTextLine,
            'jumbotronGetStartedLink' => $jumbotronGetStartedLink,
            'jumbotronCodeLang'       => $jumbotronCodeLang,
            'jumbotronCodeContent'    => $jumbotronCodeContent,


        ]);
    }
}

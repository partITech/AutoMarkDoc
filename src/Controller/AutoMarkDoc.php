<?php

namespace App\Controller;

use App\Service\DocumentationConfigLoader;
use App\Service\MarkdownRenderer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

final class AutoMarkDoc extends AbstractController
{

    #[Route('/get-image', name: 'app_automarkdoc_getimage')]
    public function getImage(
        Request $request,
        DocumentationConfigLoader $docConfigLoader
    ): Response
    {
        $img = $request->query->get('img');
        $project = $request->query->get('project');

        // Vérifiez que les paramètres sont présents
        if (!$img || !$project) {
            throw new NotFoundHttpException('Image or project parameter is missing.');
        }
        $docConfigLoader->setProject($project);
        // Validez les paramètres pour éviter les traversées de répertoires
        if (preg_match('/\.\./', $img) || preg_match('/\.\./', $project)) {
            throw new NotFoundHttpException('Invalid path.');
        }

        try{
            $filePath = $docConfigLoader->getFilePath($img);
        }catch (\Exception $e){
            throw new NotFoundHttpException('File not found.');
        }

        return new BinaryFileResponse($filePath);
    }

    #[Route(
        '/{slug}',
        name: 'app_automarkdoc_index',
        requirements: [
            'slug' => '^(?!get-image|image|assets)[^.]*$'
        ],
        defaults: ['slug' => '']
    )]
    public function index(Request $request, MarkdownRenderer $markdownRenderer, DocumentationConfigLoader $docConfigLoader): Response
    {

        $docConfigLoader->setRequest($request);

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
        $title = $request->query->get('title', 'Index');

        if($redirect = $docConfigLoader->redirect($currentLink, $title)){
            return  new RedirectResponse($redirect);
        }

        if($jumbotron && $currentLink!=$defaultDoc){
            $jumbotron = false;
        }
        $markdownRenderer->setDocPath($docConfigLoader->getProjectPath());
        $markdownRenderer->setProject($docConfigLoader->getProjectName());
        $menu = $markdownRenderer->getMenu(currentLink: $currentLink, baseUrl: $docConfigLoader->createUrl($docConfigLoader->getProjectName()));
        $content = $markdownRenderer->renderMarkdownFile($currentLink);


        return $this->render('AutoMarkDoc/index.html.twig', [
            'showSites' => true,
            'sites'=> $docConfigLoader->getSitesList(),
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

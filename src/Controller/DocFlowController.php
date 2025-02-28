<?php

namespace App\Controller;

use App\Service\MarkdownRenderer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DocFlowController extends AbstractController
{
    #[Route('/', name: 'app_pf')]
    public function index(Request $request, MarkdownRenderer $markdownRenderer): Response
    {
        $currentLink = $request->query->get('file', 'index.md');
        $title = $request->query->get('title', 'Index');
        $menu = $markdownRenderer->getMenu(currentLink: $currentLink, baseUrl: '/');
        $content = $markdownRenderer->renderMarkdownFile($currentLink);


        return $this->render('doc_flow/index.html.twig', [
            'menu'    => $menu,
            'content' => $content['content'],
            'toc' => $content['toc'],
            'title'   => $title
        ]);
    }
}

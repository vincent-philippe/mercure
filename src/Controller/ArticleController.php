<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;

#[Route('article')]
class ArticleController extends AbstractController
{
    #[Route('/publish')]
    public function publish(HubInterface $hub): Response
    {
        $update = new Update(
            'https://localhost/pub/articles',
            json_encode(['status' => 'InStock'])
        );

        $hub->publish($update);

        return new Response('published!');
    }

    #[Route('/feed')]
    public function feed(): Response
    {
        return $this->render('article_feed.html.twig');
    }
}
<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\UserInterface\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class IndexController extends AbstractController
{
    public function __construct() {
    }
    #[Route('/', name: 'landing')]
    public function __invoke(Request $request): Response
    {
        return $this->render('views/common/index.html.twig');
    }
}
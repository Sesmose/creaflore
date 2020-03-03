<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BouquetRepository;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController{



    /**
     * @Route("/", name="home")
	 * @param BouquetRepository
	 * @return Response
     */
    public function index(BouquetRepository $bouquetRepository, Request $request): Response
    {
        $derniers = $bouquetRepository->findLatest();
        return $this->render('home.html.twig', [
            'derniers' => $derniers,
        ]);
    }
}
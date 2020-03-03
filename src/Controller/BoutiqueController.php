<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BoutiqueController extends AbstractController{



    /**
     * @Route("/boutique", name="boutique")
	 * @return Response
     */
    public function index(Request $request): Response
    {
       
        return $this->render('boutique.html.twig');
    }
}
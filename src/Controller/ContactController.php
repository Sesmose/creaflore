<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController{



    /**
     * @Route("/contact", name="contact")
	 * @return Response
     */
    public function index(Request $request): Response
    {
       
        return $this->render('contact.html.twig');
    }
}
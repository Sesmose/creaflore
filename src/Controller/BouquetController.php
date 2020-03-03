<?php

namespace App\Controller;

use App\Entity\Bouquet;
use App\Form\Bouquet1Type;
use App\Repository\BouquetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface; // Nous appelons le bundle KNP Paginator


/**
 * @Route("/bouquet")
 */
class BouquetController extends AbstractController
{
/**
 * @var BouquetRepository
 */

    private $repository;
    
    public function __construct(BouquetRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * @Route("/", name="bouquet_index", methods={"GET"})
     */
    public function index(PaginatorInterface $paginator, BouquetRepository $bouquetRepository, Request $request): Response
    {
        $donnees = $this->getDoctrine()->getRepository(Bouquet::class)->findAll();

        $bouquets = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos bouquets)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            12 // Nombre de résultats par page
        );
        
        return $this->render('bouquet/index.html.twig', [
            'bouquets' => $bouquets,
        ]);
    }




    /**
     * @Route("/new", name="bouquet_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $bouquet = new Bouquet();
        $form = $this->createForm(Bouquet1Type::class, $bouquet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bouquet);
            $entityManager->flush();
            return $this->redirectToRoute('bouquet_index');
        }

        return $this->render('bouquet/new.html.twig', [
            'bouquet' => $bouquet,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/bouquet/{slug}-{id}", name="bouquet.show", methods={"GET"}, requirements={"slug": "[a-z0-9\-]*"})
     */
    public function show(Bouquet $bouquet, string $slug): Response
    {
        if($bouquet->getSlug() !== $slug){
            return $this->redirectToRoute('bouquet.show', [
                'id' => $bouquet->getId(),
                'slug' => $bouquet->getSlug(),
            ], 301);
        };
        return $this->render('bouquet/show.html.twig', [
            'bouquet' => $bouquet,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="bouquet_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Bouquet $bouquet): Response
    {
        $form = $this->createForm(Bouquet1Type::class, $bouquet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('bouquet_index');
        }

        return $this->render('bouquet/edit.html.twig', [
            'bouquet' => $bouquet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="bouquet_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Bouquet $bouquet): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bouquet->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($bouquet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('bouquet_index');
    }
}

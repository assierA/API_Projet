<?php


namespace AppBundle\Controller;

use AppBundle\Entity\Categorie;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;

/**
 * @Route("/API/categorie")
 */
class CategorieController extends AbstractFOSRestController
{

    public function getCategorie($id) {
        $categorie = $this->getDoctrine()->getRepository('AppBundle:Categorie')->find($id);
        return $categorie;
    }
    /**
     * @Rest\View()
     * @Rest\Get("/")
     */
    public function getCategoriesAction()
    {
        $categories =  $this->getDoctrine()->getRepository('AppBundle:Categorie')->findAll();
        return $categories;
    }

    /**
     * @Rest\View()
     * @Rest\Get("/{id}")
     */
    public function getCategorieAction(Request $request)
    {
        $categorie = $this->getCategorie($request->get('id'));
        if (empty($categorie)) {
            return new JsonResponse(['message' => 'Categorie non trouvée'], Response::HTTP_NOT_FOUND);
        }
        return $categorie;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Post("/categories")
     */
     public function postCategorieAction(Request $request)
     {
         $categorie = new Categorie();
         $categorie->setIntitule($request->get('intitule'));
         $categorie->setId($request->get('id'));

         $em = $this->get('doctrine.orm.entity_manager');
         $em->persist($categorie);
         $em->flush();

         return $categorie;
     }
}
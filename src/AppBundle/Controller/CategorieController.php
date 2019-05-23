<?php


namespace AppBundle\Controller;

use AppBundle\Entity\Secteur;
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
        $article = $this->getDoctrine()->getRepository('AppBundle:Categorie')->find($id);
        return $article;
    }
    /**
     * @Rest\View()
     * @Rest\Get("/")
     */
    public function getCategoriesAction()
    {
        $articles =  $this->getDoctrine()->getRepository('AppBundle:Categorie')->findAll();
        return $articles;
    }

    /**
     * @Rest\View()
     * @Rest\Get("/{id}")
     */
    public function getCategorieAction(Request $request)
    {
        $article = $this->getCategorie($request->get('id'));
        if (empty($article)) {
            return new JsonResponse(['message' => 'Categorie non trouvée'], Response::HTTP_NOT_FOUND);
        }
        return $article;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Post("/categories")
     */
     public function postArticleAction(Request $request)
     {
         $categorie = new Categorie();
         $categorie->setLibelle($request->get('libelle'));

         $em = $this->get('doctrine.orm.entity_manager');
         $em->persist($categorie);
         $em->flush();

         return $categorie;
     }
}
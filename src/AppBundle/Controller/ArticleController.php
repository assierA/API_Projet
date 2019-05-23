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
 * @Route("/API/article")
 */
class ArticleController extends AbstractFOSRestController
{

    public function getArticle($id) {
        $article = $this->getDoctrine()->getRepository('AppBundle:Article')->find($id);
        return $article;
    }
    /**
     * @Rest\View()
     * @Rest\Get("/")
     */
    public function getArticlesAction()
    {
        $articles =  $this->getDoctrine()->getRepository('AppBundle:Article')->findAll();
        return $articles;
    }

    /**
     * @Rest\View()
     * @Rest\Get("/{id}")
     */
    public function getArticleAction(Request $request)
    {
        $article = $this->getArticle($request->get('id'));
        if (empty($article)) {
            return new JsonResponse(['message' => 'Article non trouvé'], Response::HTTP_NOT_FOUND);
        }
        return $article;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"article"})
     * @Post("/articles")
     */
    public function postArticleAction(Request $request)
    {
        $article = new Article();
        $article->setLibelle($request->get('libelle'));

        $em = $this->get('doctrine.orm.entity_manager');
        $em->persist($article);
        $em->flush();

        return $article;
    }
}
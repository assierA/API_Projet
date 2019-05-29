<?php


namespace AppBundle\Controller;

use AppBundle\Entity\Client;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;

/**
 * @Route("/API/client")
 */
class ClientController extends AbstractFOSRestController
{

    public function getClient($id) {
        $client = $this->getDoctrine()->getRepository('AppBundle:Client')->find($id);
        return $client;
    }
    /**
     * @Rest\View()
     * @Rest\Get("/")
     */
    public function getClientsAction()
    {
        $clients =  $this->getDoctrine()->getRepository('AppBundle:Client')->findAll();
        return $clients;
    }

    /**
     * @Rest\View()
     * @Rest\Get("/{id}")
     */
    public function getClientAction(Request $request)
    {
        $client = $this->getClient($request->get('id'));
        if (empty($client)) {
            return new JsonResponse(['message' => 'Client non trouvé'], Response::HTTP_NOT_FOUND);
        }
        return $client;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Post("/clients")
     */
    public function postClientAction(Request $request)
    {
        $client = new Client();
        $client->setAdministrateur($request->get('administrateur'));
        $client->setMdp($request->get('mdp'));
        $client->setMail($request->get('mail'));
        $client->setNom($request->get('nom'));
        $client->setId($request->get('id'));

        $em = $this->get('doctrine.orm.entity_manager');
        $em->persist($client);
        $em->flush();

        return $client;
    }
}
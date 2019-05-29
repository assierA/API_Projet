<?php


namespace AppBundle\Controller;

use AppBundle\Entity\Client;
use AppBundle\Entity\Commande;
use AppBundle\Controller\ClientController;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;

/**
 * @Route("/API/commande")
 */
class CommandeController extends AbstractFOSRestController
{

    public function getClient($id) {
        $commande = $this->getDoctrine()->getRepository('AppBundle:Commande')->find($id);
        return $commande;
    }
    /**
     * @Rest\View()
     * @Rest\Get("/")
     */
    public function getCommandesAction()
    {
        $commandes =  $this->getDoctrine()->getRepository('AppBundle:Commande')->findAll();
        return $commandes;
    }

    /**
     * @Rest\View()
     * @Rest\Get("/{id}")
     */
    public function getCommandeAction(Request $request)
    {
        $commande = $this->getCommande($request->get('id'));
        if (empty($commande)) {
            return new JsonResponse(['message' => 'Commande non trouvée'], Response::HTTP_NOT_FOUND);
        }
        return $commande;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Post("/commandes")
     */
    public function postCommandeAction(Request $request)
    {
        $commande = new Commande();
        $commande->setValide($request->get('valide'));
        $commande->setDate($request->get('date'));
        $commande->setId($request->get('id'));

        $ctrlClient = new ClientController();
        $commande->setClient($ctrlClient->getClient(($request->get("client"))->get("id")));

        $em = $this->get('doctrine.orm.entity_manager');
        $em->persist($commande);
        $em->flush();

        return $commande;
    }
}
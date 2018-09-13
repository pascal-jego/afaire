<?php

namespace App\Controller;
use App\Entity\Listing;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/", name="listing_")
 */
class ListingController extends Controller
{
    /**
     * @Route("/", name="show")
     */
    public function show(EntityManagerInterface $entityManager)
    {
        $listings = $entityManager->getRepository(Listing::class)->findAll();
        return $this->render("listing.html.twig", compact("listings"));
    }

    /**
     * @Route("/new", methods={"POST"}, name="create")
     */
    public function create(EntityManagerInterface $entityManager,  Request $request)
    {
        $name = $request->get('name');

        if (empty($name)) {
            $this->addFlash("warning", "un nom de liste est obligatoire");
            return $this->redirectToRoute("listing_show");
        }

        $listing = new Listing();
        $listing->setName($name);

        try {

        $entityManager->persist($listing);
        $entityManager->flush();

        $this->addFlash("success", "La liste  « $name » a été créée avec succès");
        } catch (UniqueConstraintViolationException $e) {
            $this->addFlash("warning", "impossible de créer la liste « $name » ");
        }

        return $this->redirectToRoute("listing_show");
    }

}
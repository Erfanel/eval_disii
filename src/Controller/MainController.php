<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(EntityManagerInterface $manager): Response
    {
        $produitRepository = $manager->getRepository(Produit::class);
        $produits = $produitRepository->findBy([], ['id' => 'DESC'],5);

        return $this->render('main/index.html.twig', [
            'produits' => $produits
        ]);
    }

    #[Route('/produits', name: 'produits')]
    public function produits(EntityManagerInterface $manager): Response
    {
        $produitRepository = $manager->getRepository(Produit::class);
        $produits = $produitRepository->findAll([], ['name' => 'ASC']);
        return $this->render('main/produits.html.twig', [
            'produits' => $produits
        ]);
    }

    #[Route('/produits/{produitId}', name: 'produitDetails')]
    public function produitDetails(EntityManagerInterface $manager, $produitId, Request $request): Response
    {
        $produitRepository = $manager->getRepository(Produit::class);
        $produit = $produitRepository->find($produitId);

        $commentaireRepository = $manager->getRepository(Commentaire::class);
        $commentaires = $commentaireRepository->findBy(['produit' => $produitId], ['id' => 'DESC']);

        $commentaireForm = $this->createForm(CommentaireType::class);
        $commentaireForm->handleRequest($request);
        if ($commentaireForm->isSubmitted() && $commentaireForm->isValid()) {
            $commentaire = $commentaireForm->getData();
            $commentaire->setProduit($produit);
            $manager->persist($commentaire);
            $manager->flush();
            $this->addFlash('success', 'Le commentaire a bien été ajouté');
            return $this->redirectToRoute('produitDetails', ['produitId' => $produitId]);
        }

        return $this->render('main/produitDetails.html.twig', [
            'produit' => $produit,
            'commentaires' => $commentaires,
            'commentaireForm' => $commentaireForm->createView()
            
        ]);
    }
}

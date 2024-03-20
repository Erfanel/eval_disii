<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Entity\Commentaire;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'adminHome')]
    public function adminHome(EntityManagerInterface $manager): Response
    {
        $produitRepository = $manager->getRepository(Produit::class);
        $produits = $produitRepository->findBy([], ['id' => 'DESC']);
        return $this->render('admin/adminHome.html.twig', [
            'produits' => $produits,
        ]);
    }

    #[Route('/admin/commentaires', name: 'adminCommentaires')]
    public function adminCommentaires(EntityManagerInterface $manager): Response
    {
        $commentaireRepository = $manager->getRepository(Commentaire::class);
        $commentaires = $commentaireRepository->findAll();

        

        return $this->render('admin/adminCommentaires.html.twig', [
            'commentaires' => $commentaires
        ]);
    }

    #[Route('/admin/commentaires/delete', name: 'commentaireDelete')]
    public function DeleteCommentaire(EntityManagerInterface $manager): Response
    {
        $commentaireId = $_POST['commentaireId'];
        $commentaireRepository = $manager->getRepository(Commentaire::class);
        $commentaire = $commentaireRepository->find($commentaireId);
        $manager->remove($commentaire);
        $manager->flush();
        $this->addFlash('success', 'Le commentaire a bien été supprimé');
        return $this->redirectToRoute('adminCommentaires');

    }

    #[Route('/admin/commentaires/{commentaireId}', name: 'commentaireDetails')]
    public function CommentaireDetails(EntityManagerInterface $manager, $commentaireId): Response
    {   
        $commentaireRepository = $manager->getRepository(Commentaire::class);
        $commentaire = $commentaireRepository->find($commentaireId);
        return $this->render('admin/CommentaireDetails.html.twig', [
            'commentaire' => $commentaire
        ]);

    }

    #[Route('/admin/produits/delete', name: 'produitDelete')]
    public function ProduitDelete(EntityManagerInterface $manager): Response
    {
        $produitId = $_POST['produitId'];
        $produitRepository = $manager->getRepository(Produit::class);
        $produit = $produitRepository->find($produitId);
        $manager->remove($produit);
        $manager->flush();
        $this->addFlash('success', 'Le produit a bien été supprimé');
        return $this->redirectToRoute('adminHome');

    }

    #[Route('/admin/produits/edit/{produitId}', name: 'produitEdit')]
    public function ProduitEdit(EntityManagerInterface $manager, $produitId, Request $request): Response
    {  
        $produitRepository = $manager->getRepository(Produit::class);
        $produit = $produitRepository->find($produitId);

        $produitForm = $this->createForm(ProduitType::class, $produit);
        $produitForm->handleRequest($request);
        if ($produitForm->isSubmitted() && $produitForm->isValid()) {
            $manager->persist($produit);
            $manager->flush();
            $this->addFlash('success', 'Le produit a bien été modifié');
            return $this->redirectToRoute('produitEdit', ['produitId' => $produitId]);
        }
        return $this->render('admin/produitEdit.html.twig', [
            'produit' => $produit,
            'produitForm' => $produitForm->createView()
        ]);
    }

    #[Route('/admin/produits/add', name: 'produitAdd')]
    public function ProduitAdd(EntityManagerInterface $manager, Request $request): Response
    {  
        $produit = new Produit();
        $produitForm = $this->createForm(ProduitType::class, $produit);
        $produitForm->handleRequest($request);
        if ($produitForm->isSubmitted() && $produitForm->isValid()) {
            $manager->persist($produit);
            $manager->flush();
            $this->addFlash('success', 'Le produit a bien été ajouté');
            return $this->redirectToRoute('adminHome');
        }
        return $this->render('admin/produitAdd.html.twig', [
            'produitForm' => $produitForm->createView()
        ]);
    }
}

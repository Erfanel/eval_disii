<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Produit;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $product1 = new Produit();
        $product1->setNom('Montre intelligente FitBit');
        $product1->setStock(10);
        $product1->setDescription('Suivez votre activité quotidienne, votre fréquence cardiaque et obtenez des notifications directement sur votre poignet avec cette montre intelligente FitBit. Parfait pour rester en forme et connecté.');
        $product1->setImage('https://cdn.lesnumeriques.com/optim/produits/653/45561/fitbit-charge-3_26d563cc1ff8bc31__450_400.jpg');
        $manager->persist($product1);

        $product2 = new Produit();
        $product2->setNom(' Casque audio sans fil Sony');
        $product2->setStock(14);
        $product2->setDescription("Plongez dans votre musique avec ce casque audio sans fil Sony. Doté d'une qualité sonore exceptionnelle et d'une autonomie longue durée, il est parfait pour les amateurs de musique en déplacement.");
        $product2->setImage('https://www.sony.fr/image/5d02da5df552836db894cead8a68f5f3?fmt=pjpeg&wid=330&bgcolor=FFFFFF&bgc=FFFFFF');
        $manager->persist($product2);

        $product3 = new Produit();
        $product3->setNom('Ensemble de couteaux de cuisine');
        $product3->setStock(13);
        $product3->setDescription("Équipez votre cuisine avec cet ensemble de couteaux de haute qualité. Fabriqués en acier inoxydable durable, ces couteaux offrent une coupe précise pour toutes vos préparations culinaires.");
        $product3->setImage('https://www.cdiscount.com/pdt2/4/5/6/1/700x700/auc7142088759456/rw/zu-ensemble-couteaux-cuisine-bloc-set-14-chef-alle.jpg');
        $manager->persist($product3);

        $product4 = new Produit();
        $product4->setNom('Tapis de yoga antidérapant');
        $product4->setStock(18);
        $product4->setDescription(" Pratiquez le yoga en toute sécurité avec ce tapis antidérapant. Conçu pour offrir confort et stabilité, il vous accompagne dans vos séances de méditation et de relaxation.");
        $product4->setImage('https://media.handball-store.fr/catalog/product/cache/image/1800x/9df78eab33525d08d6e5fb8d27136e95/s/y/synerfit-fitness_snt026_1.jpg');
        $manager->persist($product4);

        $product5 = new Produit();
        $product5->setNom('Sac à dos étanche');
        $product5->setStock(1);
        $product5->setDescription("Ce sac à dos étanche est idéal pour les aventuriers. Avec plusieurs compartiments et une construction robuste, il protège vos affaires des intempéries et offre un confort maximal.");
        $product5->setImage('https://haloa-emotion.fr/wp-content/uploads/2023/01/sac_a_dos_waterproof_xplor.jpg');
        $manager->persist($product5);

        $product6 = new Produit();
        $product6->setNom('Appareil photo numérique Canon
');
        $product6->setStock(21);
        $product6->setDescription("Capturez des moments inoubliables avec cet appareil photo numérique Canon. Doté d'une résolution élevée et de nombreuses fonctionnalités, il est parfait pour les amateurs de photographie.");
        $product6->setImage('https://i1.adis.ws/i/canon/powershot-sx740-hs-range-bk-frt-800x800_336063634773466?w=800&h=800&fmt=jpg&fmt.options=interlaced&bg=rgb(236,237,237)');
        $manager->persist($product6);

        

        $admin = new User();
        $admin->setEmail('admin@admin.com');
        $adminHash = $this->passwordHasher->hashPassword($admin, 'admin');
        $admin->setPassword($adminHash);
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);
        $manager->flush();
    }
}

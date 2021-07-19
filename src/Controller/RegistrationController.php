<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordHasherInterface $encoder): Response
    // public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            //! on va lefaire el mano
            // $user->setPassword(
            //     $passwordEncoder->encodePassword(
            //         $user,
            //         $form->get('plainPassword')->getData()
            //     )
            // );

            //* On fait appel à l'objet $encoder afin de hacher le mot de passe
            //* hashPassword() : méthode issue de UserPasswordHasherInterface permettant de crée une clé de hachage pour le mot de passe
            $hash = $encoder->hashPassword($user, $user->getPassword());

            // dump($hash);

            //* On affecte à l'entité le mot de passe haché qui sera inséré en BDD
            $user->setPassword($hash);

            $entityManager = $this->getDoctrine()->getManager();

            //! persist va faire : $pdo->prepare("INSERT INTO user VALUES ('$user->getPrenom()', '$user->getEmail()')");
            $entityManager->persist($user);
            
            //! flush va faire : $pdo->execute();
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('home');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}

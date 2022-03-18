<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\LoginAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher,  EntityManagerInterface $entityManager,ValidatorInterface $validator): Response
    {
        if ($request->getMethod() === 'GET'){
            return $this->render('registration/register.html.twig',['errors' => null]);

        }
        $user = new User();

        $user->setUsername($request->get('username'));
        $user->setPassword(
            $userPasswordHasher->hashPassword(
                $user,
                $request->get('password')
            )
        );
        $errors = $validator->validate($user);

        if($errors->count() > 0){
            return $this->render('registration/register.html.twig',['errors' => $errors]);
        }

        $entityManager->persist($user);
        $entityManager->flush();
        return $this->redirectToRoute('app_main');
    }
}

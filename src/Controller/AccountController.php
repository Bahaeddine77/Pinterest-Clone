<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordFormType;
use App\Form\UserformType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_account', methods:'GET')]
    public function show(): Response
    {
        return $this->render('account/show.html.twig', [
            'controller_name' => 'AccountController',
        ]);
    }

    #[Route('/account/edit', name: 'app_account_edit', methods:['GET', 'PUT'])]
    public function edit(Request $request, EntityManagerInterface $em): Response
    {
        $user=$this->getUser();
        $form=$this->createForm(UserformType::class, $user, ['method'=>'PUT']);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
            {
                $em->flush();
                $this->addFlash('success', 'Profile successfully updated !');
                return $this->redirectToRoute('app_account');
            }

        return $this->render('account/edit.html.twig',  ['form'=>$form->createView()]
           
        );
    }

    #[Route('/account/change-password', name: 'app_account_change_password', methods:['GET', 'PATCH'])]
    public function changePassword(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user=$this->getUser();
        $form=$this->createForm(ChangePasswordFormType::class, null, [
            'current_password_is_required'=>true, 
            'method' => 'PATCH'
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid()){
            $user->setPassword(
                $passwordHasher->hashPassword($user, $form['plainPassword']->getData())
            );
            $em->flush();
            $this->addFlash('success', 'Password updated successfully !');
            return $this->redirectToRoute('app_account');

        }


        return $this->render('account/change_password.html.twig',  ['form'=>$form->createView()]);
        
    }

}

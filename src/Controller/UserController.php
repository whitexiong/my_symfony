<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/user/create', name: 'app_user_create')]
    public function create(ManagerRegistry $managerRegistry)
    {
        $dp = $managerRegistry->getManager();

        $user = new User();
        $user->setName('admin');
        $user->setMobile('19982421011');
        $user->setNo('123456');
        $dp->persist($user);
        $dp->flush();
        return new Response('Saved new product with id ' . $user->getId());
    }

    #[Route('/user/list', name: 'app_user_list')]
    public function userList(ManagerRegistry $managerRegistry)
    {
        $dp = $managerRegistry->getManager();
    }

    #[Route('/user/edit/{id}', name: 'app_user_edit')]
    public function update(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $user->setName('New product name!');
        $entityManager->flush();

        return $this->redirectToRoute('product_show', [
            'id' => $user->getId()
        ]);
    }
}

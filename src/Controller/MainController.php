<?php

namespace App\Controller;

use App\Client\telegram\Client;
use App\Entity\Advertising;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_main")
     */
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/telegram", name="app_telegram")
     * @param Client $client
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function telegram(Client $client, EntityManagerInterface $entityManager, Request $request): Response
    {
        $client->setToken('5234577480:AAHu1axLARUpab9jon_1u_0ya2Fm3Fw-pY0');

        $message = $request->toArray();
        $advertising = new Advertising();
        $advertising->setUpdateId($message['update_id']);
        $advertising->setAuthor($message['message']['from']['username']);
        $advertising->setText($message['message']['text']);
        $params = [
            'chat_id' => $message['message']['chat']['id'],
            'text'    => 'ваше повідомлення збережено на дошці оголошень'
        ];
        $client->sendMessage($params);

        $entityManager->persist($advertising);

        $entityManager->flush();
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/advertising", name="app_advertising")
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function advertising(EntityManagerInterface $entityManager): Response
    {
        $repo = $entityManager->getRepository(Advertising::class);
        $advertisings = $repo->findAll();
        $entityManager->flush();
        return $this->render('main/advertising.html.twig', [
            'advertisings' => $advertisings,
        ]);
    }


}

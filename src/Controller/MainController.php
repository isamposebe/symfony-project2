<?php

namespace App\Controller;

use App\Entity\News;
use App\Form\SearchAuthorType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{

    /** Главная страница
     * @param EntityManagerInterface $entityManager Менеджер новостей данных на получения всех новостей
     * @return Response
     */
    #[Route('/main', name: 'app_main', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        /** Сортируем по дате (Возможно выкинуть в сервис)*/
        $newsList = $entityManager->getRepository(News::class);
        $newsList = $newsList->findBy([], ['dateCreated' => 'DESC']);

        /** Построим форму для сокрытия по автору */
        $formSearchAuthor = $this->createForm(SearchAuthorType::class);

        /** Отправляем данные в шаблон
         * @newsList Список новостей
         * @formSearchAuthor Форма для сокрытия данных по автору
         */
        return $this->render('main/index.html.twig', [
            'newsList' => $newsList,
            'formSearchAuthor' => $formSearchAuthor
        ]);
    }
}

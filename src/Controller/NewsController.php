<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\News;
use App\Form\CommentType;
use App\Form\NewsType;
use App\Service\NewsService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[Route('/news')]
class NewsController extends AbstractController
{
    /** Создание новой новости
     * @param Request $request Главное тело для запросов
     * @param EntityManagerInterface $entityManager Менеджер новостей для отправки в базу данных
     * @return Response
     */
    #[IsGranted('ROLE_USER')]
    #[Route('/new', name: 'app_news_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        /** Создадим сущность новости(News) */
        $news = new News();

        /** Автоматически заполним дату(сейчас) и автора новости */
        $news->setDateCreated(new \DateTime('Now'));
        /** @var TYPE_NAME $this */
        $news->setAuthor(author: $this->getUser());

        /** Создадим форму для новой новости */
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        /** Отслеживаем нажата ли кнопка в форме и проверим перед отправкой в базу данных */
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($news);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Your changes were saved!'
            );
            /** Пустая форма для повторного ввода*/
            $form = $this->createForm(NewsType::class);
        }

        /** Отправляем данные в шаблон создания новой новости
         * @form Форма для отображения новостей
         * @message Сообщение для хода выполнения
         */
        return $this->render('news/new.html.twig', [
            'newNewsForm' => $form
        ]);
    }

    /** Страница просмотра определенной новости с добавлением комментариев
     * @param NewsService $newsService Сервис для работы с новостями
     * @param Request $request Тело для запроса
     * @param News $news Данные новости
     * @param EntityManagerInterface $entityManager Работа с базой данных
     * @return Response
     */
    #[Route('/{id}', name: 'app_news_show')]
    public function show(NewsService $newsService, Request $request, News $news, EntityManagerInterface $entityManager): Response
    {
        /** Создаем сущность для нового комментария */
        $comment = new Comment();

        /** Создаем форму для нового комментария */
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        /** Проверяем нажатие кнопки и проверяем данные формы и потом отправляем в базу данных */
        if ($form->isSubmitted() && $form->isValid()) {
            /** Автоматически подставляю дату(сейчас), Автора, № новости
             * И само сообщение(оно подтягивается через ввод пользователя)
             */
            $comment->setDate(date: new \DateTime('Now'));
            /** @var TYPE_NAME $this */
            $comment->setAuthor(author: $this->getUser());
            $comment->setNews(news: $news);

            /** Записываем в базу данных через запрос */
            $entityManager->persist($comment);
            $entityManager->flush();

            /** Пустая форма для повторного ввода*/
            $form = $this->createForm(CommentType::class);
        }

        /** Отправляем данные в шаблон
         * @news Данные новости
         * @commentList Список комментариев для новости
         * @commentNewForm Форма для ввода комментария
         */
        return $this->render('news/show.html.twig', [
            'news' => $news,
            'commentList' => $newsService->listCommentsInNumNews($news),
            'commentNewForm' => $form,
        ]);
    }

    /** Удаление новости и всех её комментариев
     * - Можно переделать сущности, добавить им Анастации и сократить функцию
     * @param NewsService $newsService Работа по новостям
     * @param News $news Данные новости
     * @param Request $request Тело для запросов
     * @param EntityManagerInterface $entityManager Менеджер сущностей
     * - (Работа над базой данных)
     * @return Response
     */
    #[Route('/delete/{id}', name: 'app_news_delete', methods: ['GET', 'POST'])]
    public function delete( NewsService $newsService, News $news, Request $request, EntityManagerInterface $entityManager): Response
    {
        /** Проверяем новость которую надо удалить */
        if ($this->isCsrfTokenValid('delete'.$news->getId(), $request->getPayload()->getString('_token'))) {
            /** Запрос на получение всех комментариев по новости */
            $commentRepository = $newsService->listCommentsInNumNews($news);
            /** Удаляем все комментарии по новости */
            foreach ($commentRepository as $itemComment) {
                if ($itemComment -> getNews() == $news) {
                    $newsService->deleteItem($itemComment);
                }
            }
            /** Удаляем саму новость */
            $newsService->deleteItem($news);
        }
        $entityManager->flush();
        /** Переходим на главную страницу после удаления */
        return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
    }

    /** Удаление комментария
     * @param int $id ID комментария
     * @param NewsService $newsService Работа по новостям
     * @param EntityManagerInterface $entityManager Менеджер сущностей
     * - (Работа над базой данных)
     * @return Response
     */
    #[Route("/ajax_comment_delete/{id}", name: 'app_comment_delete')]
    public function deleteComment(int $id, NewsService $newsService, EntityManagerInterface $entityManager): Response
    {
        /** @comment Получаем комментарий из базы данных через ID*/
        $comment = $newsService->searchCommentID($id);

        /** Удаляем комментарий из базы данных */
        $newsService->deleteItem($comment);
        $entityManager->flush();

        /** Возвращаем об успешном удалении комментария */
        return new Response('Comment deleted', Response::HTTP_OK);
    }
}

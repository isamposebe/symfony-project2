<?php

namespace App\Service;

use App\Entity\Comment;
use App\Entity\News;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\When;


#[When(env: 'dev')]
class NewsService extends AbstractController
{
    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ){}

    /** Запрос на получение всех комментариев по определенной новости
     * @param News $news Данные новости
     * @return array Массив из сущностей Comment
     */
    public function listCommentsInNumNews(News $news): array
    {
        /** Получаем из базы данных список комментариев по новости */
        return $this->entityManager->getRepository(Comment::class)->findBy(
            ['news' => $news],
            ['id' => 'DESC']
        );
    }

    /** Удаление элемента через менеджера сущностей
     *  - НЕ ЗАБУДТЕ В КОНЦЕ ИСПОЛЬЗОВАТЬ $entityManager->flush();
     * @param $item - Элемент сущности
     * @return bool Удаляем элемент
     * - (Удача - true, иначе false)
     */
    public function deleteItem($item): bool
    {
        try {
            $this->entityManager->remove($item);
            return true;
        }catch(\Exception $e){
            return false;
        }
    }

    /** Поиск комментария по ID
     * @param int $id ID комментария
     * @return Comment Получаем комментарий
     */
    public function searchCommentID(int $id): Comment
    {
        return $this->entityManager->getRepository(Comment::class)->find($id);
    }
}
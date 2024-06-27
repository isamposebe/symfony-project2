<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    /**
     * @var int - Идентификатор комментария
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    /**
     * @var string - Основной текст комментария
     */
    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $mainContent;

    /**
     * @var User - Данные об пользователя который написал комментарий
     */
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'comments')]
    private User $author;

    /**
     * @var DateTime - Дата комментария
     */
    #[ORM\Column(type: 'datetime', nullable: false)]
    private DateTime $date;

    /**
     * @var News - Новость к которому написан комментарий
     */
    #[ORM\ManyToOne(targetEntity: News::class, inversedBy: 'comments')]
    private News $news;

    /** Показать идентификатор комментария
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /** Записать автора
     * @param User $author
     * @return void
     */
    public function setAuthor(User $author): void
    {
        $this->author = $author;
    }

    /** Записать дату создания комментария
     * @param DateTime $date - Дата создания комментария
     * @return void
     */
    public function setDate(DateTime $date): void
    {
        $this->date = $date;
    }

    /** Записать новость к которой написан комментарий
     * @param News $news - Данные новости
     * @return void
     */
    public function setNews(News $news): void
    {
        $this->news = $news;
    }

    /** Получить текст комментария
     * @return string - Текст комментария
     */
    public function getMainContent(): string
    {
        return $this->mainContent;
    }

    /** Записать текст комментария
     * @param string $mainContent - Текст комментария
     * @return void
     */
    public function setMainContent(string $mainContent): void
    {
        $this->mainContent = $mainContent;
    }

    /** Получить данные пользователя комментария
     * @return User - Данные пользователя
     */
    public function getAuthor(): User
    {
        return $this->author;
    }

    /** Получить дату создания комментария
     * @return DateTime - Дата создания комментария
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }

    /** Получить данные об новости к которой был написан комментарий
     * @return News
     */
    public function getNews(): News
    {
        return $this->news;
    }
}

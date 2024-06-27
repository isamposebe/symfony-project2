<?php

namespace App\Entity;

use App\Repository\NewsRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

#[ORM\Entity(repositoryClass: NewsRepository::class)]
class News
{
    /**
     * @var int - Идентификатор для новости
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    /**
     * @var string - Текст новости
     */
    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $mainText;

    /**
     * @var User - Данные об пользователе
     */
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'news')]
    private User $author;

    /**
     * @var DateTime - Дата создания новости
     */
    #[ORM\Column(type: 'datetime', nullable: false)]
    private DateTime $dateCreated;

    /** Получить идентификатор новости
     * @return int - Идентификатор новости
     */
    public function getId(): int
    {
        return $this->id;
    }

    /** Записать текст новости
     * @param string $mainText - Текст новости
     * @return void
     */
    public function setMainText(string $mainText): void
    {
        $this->mainText = $mainText;
    }

    /** Получить данные автора новости
     * @return User - Дан8ные пользователя
     */
    public function getAuthor(): User
    {
        return $this->author;
    }

    /** Записать автора новости
     * @param User $author - Данные пользователя
     * @return void
     */
    public function setAuthor(User $author): void
    {
        $this->author = $author;
    }

    /** Получить дату создания новости
     * @return DateTime - Дата новости
     */
    public function getDateCreated(): DateTime
    {
        return $this->dateCreated;
    }

    /** Записать дату создания новости
     * @param DateTime $dateCreated - Дата новости
     * @return void
     */
    public function setDateCreated(DateTime $dateCreated): void
    {
        $this->dateCreated = $dateCreated;
    }

    /** Получить текст новости
     * @return string - Текст новости
     */
    public function getMainText(): string
    {
        return $this->mainText;
    }
}
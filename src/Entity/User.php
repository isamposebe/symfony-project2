<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use DateTime;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USERNAME', fields: ['username'])]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @var int - Идентификатор пользователя
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    /**
     * @var string - Логин пользователя
     */
    #[ORM\Column(length: 180, nullable: false)]
    private string $username;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column(nullable: false)]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column(length: 255, nullable: false)]
    private string $password;

    /**
     * @var string - Фамилия пользователя
     */
    #[ORM\Column(type: 'string', length: 50, nullable: false)]
    private string $surname;

    /**
     * @var string - Имя пользователя
     */
    #[ORM\Column(type: 'string', length: 50, nullable: false)]
    private string $name;

    /**
     * @var string - Мобильный телефон пользователя
     */
    #[ORM\Column(type: 'string', length: 20, nullable: false)]
    private string $mobilePhone;

    /**
     * @var DateTime - Дата рождения
     */
    #[ORM\Column(type: 'datetime', nullable: false)]
    private DateTime $dateBirth;

    /** Показать идентификатор пользователя
     * @return int - Идентификатор пользователя
     */
    public function getId(): int
    {
        return $this->id;
    }

    /** Показать фамилию пользователя
     * @return string - Фамилия пользователя
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /** Записать фамилию пользователя
     * @param string $surname - Фамилия пользователя
     * @return void
     */
    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    /** Получить имя пользователя
     * @return string - Имя пользователя
     */
    public function getName(): string
    {
        return $this->name;
    }

    /** Записать имя пользователя
     * @param string $name - Имя пользователя
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /** Показать мобильный номер пользователя
     * @return string - Номер пользователя
     */
    public function getMobilePhone(): string
    {
        return $this->mobilePhone;
    }

    /** Записать номер пользователя
     * @param string $mobilePhone
     * @return void
     */
    public function setMobilePhone(string $mobilePhone): void
    {

        $this->mobilePhone = $mobilePhone;
    }

    /** Получить логин пользователя
     * @return string - логин пользователя
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /** Записать логин пользователя
     * @param string $username - Логин пользователя
     * @return void
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /** Получить пароль
     * @return string - Пароль пользователя
     */
    function getPassword(): string
    {
        return $this->password;
    }

    /** Записать пароль пользователя
     * @param string $password - Пароль пользователя
     * @return void
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /** Показать дату рождения пользователя
     * @return DateTime - Дата рождения
     */
    public function getDateBirth(): DateTime
    {
        return $this->dateBirth;
    }

    /** Записать дату рождения
     * @param DateTime|null $dateBirth
     * @return void
     */
    public function setDateBirth(?DateTime $dateBirth): void
    {
        $this->dateBirth = $dateBirth;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /** Получить роли пользователя
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**  Записать роли для пользователя
     * @see list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {

    }

}
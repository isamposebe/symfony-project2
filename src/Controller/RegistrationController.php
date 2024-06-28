<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    /** Страница для регистрации нового пользователя
     * @param Request $request Тело для проверки запроса данных в форме
     * @param UserPasswordHasherInterface $userPasswordHasher Хешируем пароль
     * @param EntityManagerInterface $entityManager Менеджер сущностей  (Работа с базой данных)
     * @return Response
     */
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        /** Создаем сущность User */
        $user = new User();

        /** Создаем форму для регистрации */
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        /** Проверяем отправлена форма и валидность данных */
        if ($form->isSubmitted() && $form->isValid()) {
            /** Записываем пароль */
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            /** Сохраняю User */
            $entityManager->persist($user);

            /** Выполняю запрос к базе данных */
            $entityManager->flush();

            /** Переходим в обратно в Login */
            return $this->redirectToRoute('app_login');
        }

        /** Отправляем данные в шаблон регистрации
         * @registrationForm Форма для заполнения
         */
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form
        ]);
    }
}

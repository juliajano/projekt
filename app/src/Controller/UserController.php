<?php
/**
 * User controller.
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Form\UserDataType;
use App\Repository\UserDataRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class TaskController.
 *
 * @Route("/user")
 *
 * @IsGranted("ROLE_ADMIN")
 */
class UserController extends AbstractController
{
    /**
     * Index action.
     *
     * @param Request $request HTTP request
     * @param UserRepository $userRepository
     * @param PaginatorInterface $paginator
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     name="user_index",
     * )
     */
    public function index(Request $request, UserRepository $userRepository, PaginatorInterface $paginator): Response
    {
        $page = $request->query->getInt('page', 1);

        $pagination = $paginator->paginate(
            $userRepository->queryAll(),
            $page,
            UserRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render(
            'user/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/show",
     *     name="user_show",
     * )
     */
    public function show(): Response
    {
        $user = $this->getUser();

        return $this->render(
            'user/show.html.twig',
            ['user' => $user]
        );
    }


    /**
     * ChangePassword action.
     *
     * @param Request $request HTTP request
     * @param User $user
     * @param UserRepository $repository User repository
     * @param UserPasswordEncoderInterface $passwordEncoder
     *
     * @return Response HTTP response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     *
     * @Route(
     *     "/{id}/password",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="user_password",
     * )
     *
     */
    public function changePassword(Request $request, User $user, UserRepository $repository, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        if (!($this->isGranted('ROLE_ADMIN'))) {
            if ($user !== $this->getUser()) {
                $this->addFlash('warning', 'message.forbidden');

                return $this->redirectToRoute('user_index');
            }
        }

        $form = $this->createForm(ChangePasswordType::class, $user, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $repository->saveUser($user);
            $this->addFlash('success', 'message_password_updated_successfully');

            return $this->redirectToRoute('user_index');
        }

        return $this->render(
            'user/editpassword.html.twig',
            [
                'form' => $form->createView(),
                'user' => $user,
            ]
        );
    }

    /**
     * Change UserData action.
     *
     * @param Request            $request
     * @param User               $user
     * @param UserRepository     $userRepository
     * @param UserDataRepository $userDataRepository
     *
     * @return Response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException *
     *
     * * @Route(
     *     "/{id}/edit",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="user_data_edit",
     * )
     */
    public function editData(Request $request, User $user, UserRepository $repository, UserDataRepository $UserDataRepository ): Response
    {
        if (!($this->isGranted('ROLE_ADMIN'))) {
            if ($user !== $this->getUser()) {
                $this->addFlash('warning', 'message.forbidden');

                return $this->redirectToRoute('user_index');
            }
        }
        $userData = $user->getUserData();
        $form = $this->createForm(UserDataType::class, $userData, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $UserDataRepository->save($userData);
            $repository->saveUser($user);

            $this->addFlash('success', 'message_updated_data_successfully');

            return $this->redirectToRoute('user_index');
        }

        return $this->render(
            'user/editdata.html.twig',
            [
                'form' => $form->createView(),
                'user' => $user,
            ]
        );

    }


}
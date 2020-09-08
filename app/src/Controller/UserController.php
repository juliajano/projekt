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
use App\Service\UserDataService;
use App\Service\UserService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
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
 * @IsGranted("ROLE_USER")
 */
class UserController extends AbstractController
{
    /**
     * User service.
     *
     * @var \App\Service\UserService
     */
    private $userService;

    /**
     * UserData service.
     *
     * @var \App\Service\UserDataService
     */
    private $userDataService;

    /**
     * UserController constructor.
     *
     * @param \App\Service\UserService $userService     User service
     * @param UserDataService          $userDataService UserData service
     */
    public function __construct(UserService $userService, UserDataService $userDataService)
    {
        $this->userService = $userService;
        $this->userDataService = $userDataService;
    }

    /**
     * Index action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="user_index",
     * )
     *
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $pagination = $this->userService->createPaginatedList($page);

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
     * @param UserRepository $repository
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response HTTP response
     * @throws ORMException
     * @throws OptimisticLockException
     *
     * @Route(
     *     "/{id}/password",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="user_password",
     * )
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
            $this->userService->saveUser($user);
            $this->addFlash('success', 'message_password_updated_successfully');

            return $this->redirectToRoute('task_index');
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
     * @param UserRepository     $userRepository
     * @param UserDataRepository $userDataRepository
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
    public function editData(Request $request, User $user, UserRepository $repository, UserDataRepository $UserDataRepository): Response
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
            $this->userDataService->save($userData);
            $this->userService->saveUser($user);

            $this->addFlash('success', 'message_updated_data_successfully');

            return $this->redirectToRoute('task_index');
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

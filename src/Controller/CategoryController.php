<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/category", name="app_category")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/add", name="_add", methods={"POST"})
     * @param EntityManagerInterface $entityManager
     * @param UserRepository $userRepository
     * @param Request $request
     * @return Response
     */
    public function add(EntityManagerInterface $entityManager, UserRepository $userRepository, Request $request): Response
    {
        $name = $request->request->get('name');
        $icon = $request->request->get('icon');
        $user = $request->request->get('user');
        $user = $userRepository->findOneBy(['id' => $user]);

        dump($request->request);

        $category = new Category();
        $category->setName($name)
            ->setIcon($icon)
            ->setUser($user)
        ;

        $entityManager->persist($category);
        $entityManager->flush();

        return $this->json([
            'message' => 'Category created, id = ' . $category->getId(),
        ]);
    }


    /**
     * @Route("/add1", name="_add1")
     * @param EntityManagerInterface $entityManager
     * @param UserRepository $userRepository
     * @param Request $request
     * @return Response
     */
    public function add1(EntityManagerInterface $entityManager, UserRepository $userRepository, Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();
            $entityManager->persist($category);
            $entityManager->flush();
            return $this->redirect("/");
        }

        return $this->render('category/add1.html.twig', [
            'category_form' => $form->createView()
        ]);
    }
}

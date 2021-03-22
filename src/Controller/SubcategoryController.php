<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Subcategory;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/subcategory", name="app_subcategory")
 */
class SubcategoryController extends AbstractController
{
    /**
     * @Route("/add", name="_add", methods={"POST"})
     * @param EntityManagerInterface $entityManager
     * @param CategoryRepository $categoryRepository
     * @param Request $request
     * @return Response
     */
    public function add(EntityManagerInterface $entityManager, CategoryRepository $categoryRepository, Request $request): Response
    {
        $name = $request->request->get('name');
        $icon = $request->request->get('icon');
        $color = $request->request->get('color');
        $category = $request->request->get('category');
        $category = $categoryRepository->findOneBy(['id' => $category]);

        dump($request->request);

        $subcategory = new Subcategory();
        $subcategory->setName($name)
            ->setIcon($icon)
//            ->setColor($color)
            ->setCategory($category)
        ;

        $entityManager->persist($subcategory);
        $entityManager->flush();

        return $this->json([
            'message' => 'Subcategory created, id = ' . $subcategory->getId(),
        ]);
    }
}

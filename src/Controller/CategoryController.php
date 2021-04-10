<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Service\FormGenerator;
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
     * @Route("/create", name="_create", methods={"POST"})
     */
    public function create(Request $request, FormGenerator $formGenerator): Response
    {
        return $formGenerator->returnCreateForm(
            $request,
            Category::class,
            CategoryType::class,
            "/",
            "formGenerator/create.html.twig"
        );
    }

    /**
     * @Route("/update/{id}", name="_update", methods={"PATCH", "POST"})
     */
    public function update(Request $request, FormGenerator $formGenerator, $id): Response
    {
//        $this->renderView()
        return $formGenerator->returnUpdateForm(
            $request,
            Category::class,
            CategoryType::class,
            "/",
            "formGenerator/create.html.twig"
        );
    }

    /**
     * @Route("/update/{id}", name="_update", methods={"PATCH", "POST"})
     */
    public function replace(Request $request, FormGenerator $formGenerator, $id): Response
    {
        return $formGenerator->returnReplaceForm(
            $request,
            Category::class,
            CategoryType::class,
            "/",
            "formGenerator/create.html.twig"
        );
    }

    /**
     * @Route("/delete/{id}", name="_update", methods={"DELETE", "POST"})
     */
    public function delete(Request $request, FormGenerator $formGenerator, $id): Response
    {
        return $formGenerator->returnDeleteForm($request, Category::class, "/");
    }

    /**
     * @Route("/get/{id}", name="_update", methods={"GET"})
     */
    public function get_category(Request $request, FormGenerator $formGenerator, $id): Response
    {
        return $this->json(
            $formGenerator->returnRetrieveForm($request, Category::class, "/")
        );
    }
}

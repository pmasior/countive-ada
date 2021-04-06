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
     * @Route("/add", name="_add")
     */
    public function add(Request $request, FormGenerator $formGenerator): Response
    {
        return $formGenerator->returnCreateForm(
            $request,
            Category::class,
            CategoryType::class,
            "/",
            "formGenerator/add.html.twig"
        );
    }
}

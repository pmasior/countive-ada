<?php

namespace App\Controller;

use App\Entity\Subcategory;
use App\Form\SubcategoryType;
use App\Service\FormGenerator;
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
     * @Route("/add", name="_add")
     */
    public function add(Request $request, FormGenerator $formGenerator): Response
    {
        return $formGenerator->returnCreateForm(
            $request,
            Subcategory::class,
            SubcategoryType::class,
            "/",
            "formGenerator/add.html.twig"
        );
    }
}

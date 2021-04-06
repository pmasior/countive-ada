<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Transaction;
use App\Form\TransactionType;
use App\Service\FormGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/transaction", name="app_transaction")
 */
class TransactionController extends AbstractController
{
    /**
     * @Route("/add", name="_add")
     */
    public function add(Request $request, FormGenerator $formGenerator): Response
    {
        return $formGenerator->returnCreateForm(
            $request,
            Transaction::class,
            TransactionType::class,
            "/",
            "formGenerator/add.html.twig"
        );
    }
}

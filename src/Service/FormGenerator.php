<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class FormGenerator
{
    private $entityManager;
    private $formFactory;
    private $twig;

    public function __construct(
        EntityManagerInterface $entityManager,
        FormFactoryInterface $formFactory,
        Environment $twig
    ) {
        $this->entityManager = $entityManager;
        $this->formFactory = $formFactory;
        $this->twig = $twig;
    }

    public function returnCreateForm(
        Request $request,
        String $objectClass,
        String $formClass,
        String $urlIfSuccess,
        String $urlIfFailure
    ): Response {
        $object = new $objectClass();
        $form = $this->formFactory->createBuilder($formClass, $object)->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $object = $form->getData();
            $this->entityManager->persist($object);
            $this->entityManager->flush();
            return new RedirectResponse($urlIfSuccess, 302);
        }

        return new Response($this->twig->render($urlIfFailure, [
            'form' => $form->createView()
        ]));
    }

}
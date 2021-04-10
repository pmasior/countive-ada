<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Twig\Environment;

class FormGenerator
{
    private $entityManager;
    private $formFactory;
    private $twig;
    private $serializer;

    public function __construct(
        EntityManagerInterface $entityManager,
        FormFactoryInterface $formFactory,
        Environment $twig,
        SerializerInterface $serializer
    ) {
        $this->entityManager = $entityManager;
        $this->formFactory = $formFactory;
        $this->twig = $twig;
        $this->serializer = $serializer;
    }

    public function returnRetrieveForm(
        Request $request,
        String $objectClass,
        String $urlIfSuccess
    ) {
        $repository = $this->entityManager->getRepository($objectClass);
        $id = $request->attributes->get('id');
        $object = $repository->findOneBy(['id' => $id]);

        $content = $this->serializer->serialize($object, 'json');
        // TODO: fix and finish
    }

    public function returnCreateForm(
        Request $request,
        String $objectClass,
        String $formClass,
        String $urlIfSuccess,
        String $urlIfFailure
    ): Response {
        $object = new $objectClass();

        return $this->processForm(
            $request,
            $object,
            $formClass,
            $urlIfSuccess,
            $urlIfFailure
        );
    }

    public function returnUpdateForm(
        Request $request,
        String $objectClass,
        String $formClass,
        String $urlIfSuccess,
        String $urlIfFailure
    ): Response {
        $repository = $this->entityManager->getRepository($objectClass);
        $id = $request->attributes->get('id');
        $object = $repository->findOneBy(['id' => $id]);

        return $this->processForm(
            $request,
            $object,
            $formClass,
            $urlIfSuccess,
            $urlIfFailure
        );
    }

    public function returnReplaceForm(
        Request $request,
        String $objectClass,
        String $formClass,
        String $urlIfSuccess,
        String $urlIfFailure
    ) {
        $repository = $this->entityManager->getRepository($objectClass);
        $id = $request->attributes->get('id');
        $object = $repository->findOneBy(['id' => $id]);

        return $this->processForm(
            $request,
            $object,
            $formClass,
            $urlIfSuccess,
            $urlIfFailure
        );
    }

    public function returnDeleteForm(
        Request $request,
        String $objectClass,
        String $urlIfSuccess
    ): Response {
        $repository = $this->entityManager->getRepository($objectClass);
        $id = $request->attributes->get('id');
        $object = $repository->findOneBy(['id' => $id]);
        $this->entityManager->remove($object);
        $this->entityManager->flush();
        return new RedirectResponse($urlIfSuccess, 302);
    }

    private function processForm(
        Request $request,
        $object,
        String $formClass,
        String $urlIfSuccess,
        String $urlIfFailure
    ) {
        $form = $this->formFactory->createBuilder($formClass, $object)->getForm();

        $method = $request->getMethod();
        $form->submit($request->request->get($form->getName()), 'PATCH' !== $method);
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
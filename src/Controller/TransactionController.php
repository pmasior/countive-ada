<?php

namespace App\Controller;

use App\Entity\MethodOfPayment;
use App\Entity\SettlementAccount;
use App\Entity\Subcategory;
use App\Entity\Transaction;
use App\Repository\CategoryRepository;
use App\Repository\CurrencyRepository;
use App\Repository\MethodOfPaymentRepository;
use App\Repository\SettlementAccountRepository;
use App\Repository\SubcategoryRepository;
use App\Repository\TagRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
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
     * @Route("/add", name="_add", methods={"POST"})
     * @param EntityManagerInterface $entityManager
     * @param CurrencyRepository $currencyRepository
     * @param SubcategoryRepository $subcategoryRepository
     * @param TagRepository $tagRepository
     * @param SettlementAccountRepository $settlementAccountRepository
     * @param MethodOfPaymentRepository $methodOfPaymentRepository
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function add(
        EntityManagerInterface $entityManager,
        CurrencyRepository $currencyRepository,
        SubcategoryRepository $subcategoryRepository,
        TagRepository $tagRepository,
        SettlementAccountRepository $settlementAccountRepository,
        MethodOfPaymentRepository $methodOfPaymentRepository,
        Request $request
    ): Response {
        $amount = $request->request->get('amount');
        $currency = $request->request->get('currency');
        $currency = $currencyRepository->findOneBy(['id' => $currency]);
        $addedAt = $request->request->get('added_at');
        $addedAt = new DateTime($addedAt);
        $subcategory = $request->request->get('subcategory');
        $subcategory = $subcategoryRepository->findOneBy(['id' => $subcategory]);
        $tags = $request->request->get('tags');

        $note = $request->request->get('note');
        $settlementAccount = $request->request->get('settlementAccount');
        $settlementAccount = $settlementAccountRepository->findOneBy(['id' => $settlementAccount]);
        $methodOfPayment = $request->request->get('methodOfPayment');
        $methodOfPayment = $methodOfPaymentRepository->findOneBy(['id' => $methodOfPayment]);

        dump($request->request);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setCurrency($currency)
            ->setAddedAt($addedAt)
            ->setSubcategory($subcategory)
            ->setNote($note)
            ->setSettlementAccount($settlementAccount)
            ->setMethodOfPayment($methodOfPayment)
        ;

        if ($tags) {
            foreach ($tags as $tag) {
                $transaction->addTag($tag);
            }
        }

        $entityManager->persist($transaction);
        $entityManager->flush();

        return $this->json([
            'message' => 'Transaction created, id = ' . $transaction->getId(),
        ]);
    }
}

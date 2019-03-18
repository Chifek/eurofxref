<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Eurofx;
use Symfony\Component\HttpFoundation\Response;

class EurofxController extends AbstractController
{
    /**
     * @Route("/eurofx", name="eurofx", methods={"GET"})
     */
    public function index()
    {
        try {
            $em = $this->container->get('doctrine')->getManager();
            $moneyRepository = $em->getRepository(Eurofx::class);
            $cbrMoney = $moneyRepository->findAll();

            return $cbrMoney;
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage());
        }
    }

    /**
     * @Route("/eurofx/exchange", name="eurofxchange", methods={"POST"})
     */
    public function exchange(Request $request)
    {
        try {
            $em = $this->container->get('doctrine')->getManager();
            $moneyRepository = $em->getRepository(Eurofx::class);
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage());
        }
        $data = json_decode($request->getContent(), true);
        $from = strtoupper($data['from']);
        $fromNominal = (integer)$data['from_nominal'];
        $to = strtoupper($data['to']);

        $moneyFrom = $moneyRepository->findOneBy(['charcode' => $from]);
        if (!$moneyFrom) {
            throw $this->createNotFoundException(
                'No currency found for charCode ' . $from
            );
        }

        $moneyTo = $moneyRepository->findOneBy(['charcode' => $to]);
        if (!$moneyTo) {
            throw $this->createNotFoundException(
                'No currency found for ' . $to
            );
        }

        $firstCurrency = 1 / (integer)$moneyFrom->getRate();
        $secondCurrency = 1 / (integer)$moneyTo->getRate();
        if (!empty($firstCurrency) && !empty($secondCurrency)) {
            $total = $fromNominal * $firstCurrency / $secondCurrency;
            $result = $fromNominal . ' ' . $moneyFrom->getCharcode() . ' = ' . $total . ' ' . $moneyTo->getCharcode();

            return $result;
        } else {
            throw $this->createNotFoundException(
                'Something went wrong. '
            );
        }
    }
}

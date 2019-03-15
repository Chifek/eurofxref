<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Eurofx;

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

            $arrayCollection = array();

            foreach ($cbrMoney as $money) {
                $arrayCollection[] = array(
                    'id' => $money->getId(),
                    'charCode' => $money->getCharcode(),
                    'rate' => $money->getRate(),
                );
            }

            return new JsonResponse($arrayCollection);
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

            $total = $fromNominal * $firstCurrency / $secondCurrency;
            $result = $fromNominal . ' ' . $moneyFrom->getCharcode() . ' будет равен в ' . $total . ' ' . $moneyTo->getCharcode();
            return new JsonResponse($result);
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage());
        }
    }
}

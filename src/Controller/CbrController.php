<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Cbr;

class CbrController extends AbstractController
{
    /**
     * @Route("/cbr", name="cbr", methods={"GET"})
     */
    public function index()
    {
        try {
            $em = $this->container->get('doctrine')->getManager();
            $moneyRepository = $em->getRepository(Cbr::class);
            $cbrMoney = $moneyRepository->findAll();

            $arrayCollection = array();

            foreach ($cbrMoney as $money) {
                $arrayCollection[] = array(
                    'id' => $money->getId(),
                    'numCode' => $money->getNumcode(),
                    'charCode' => $money->getCharcode(),
                    'nominal' => $money->getNominal(),
                    'name' => $money->getName(),
                    'value' => $money->getValue(),
                    'date' => $money->getDate(),
                );
            }

            return new JsonResponse($arrayCollection);
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage());
        }
    }

    /**
     * @Route("/cbr/exchange", name="exchange", methods={"POST"})
     */
    public function exchange(Request $request)
    {
        try {
            $em = $this->container->get('doctrine')->getManager();
            $moneyRepository = $em->getRepository(Cbr::class);

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

            $firstCurrency = (integer)$moneyFrom->getValue() / (integer)$moneyFrom->getNominal();
            $secondCurrency = (integer)$moneyTo->getValue() / (integer)$moneyTo->getNominal();

            $total = $fromNominal * $firstCurrency / $secondCurrency;
            $result = $fromNominal . ' ' . $moneyFrom->getName() . ' будет равен в ' . $total . ' ' . $moneyTo->getName();
            return new JsonResponse($result);
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage());
        }
    }
}

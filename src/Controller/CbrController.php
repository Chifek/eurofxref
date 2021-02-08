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
     * @return mixed
     */
    public function index()
    {
        try {
            $em = $this->container->get('doctrine')->getManager();
            $moneyRepository = $em->getRepository(Cbr::class);
            $cbrMoney = $moneyRepository->findAll();

            return $cbrMoney ?? 'Records not found';
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @Route("/cbr/exchange", name="exchange", methods={"POST"})
     * @return array|JsonResponse|null|object
     */
    public function exchange(Request $request)
    {
        try {
            $em = $this->container->get('doctrine')->getManager();
            $moneyRepository = $em->getRepository(Cbr::class);
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage());
        }
        $data = $request->request->all();
        if (!empty($data)) {
            $from = strtoupper($data['from']);
            $fromNominal = (integer)$data['from_nominal'];
            $to = strtoupper($data['to']);
            if (!empty($from) && !empty($fromNominal) && !empty($to)) {
                $moneyFrom = $moneyRepository->findOneBy(['charcode' => $from]);
                if (!$moneyFrom) {
                    $result['error'] = true;
                    $result['message'] = 'No currency found for charCode ' . $from;
                    return $result;
                }
                $moneyTo = $moneyRepository->findOneBy(['charcode' => $to]);
                if (!$moneyTo) {
                    $result['error'] = true;
                    $result['message'] = 'No currency found for ' . $to;
                    return $result;
                }
                $firstCurrency = (integer)$moneyFrom->getValue() / (integer)$moneyFrom->getNominal();
                $secondCurrency = (integer)$moneyTo->getValue() / (integer)$moneyTo->getNominal();
                if (!empty($firstCurrency) && !empty($secondCurrency)) {
                    $total = $fromNominal * $firstCurrency / $secondCurrency;

                    $result['error'] = false;
                    $result['message'] = $fromNominal . ' ' . $moneyFrom->getName() . ' будет равен в ' . $total . ' ' . $moneyTo->getName();

                    return $result;
                } else {
                    $result['error'] = true;
                    $result['message'] = 'Something went wrong';
                    return $result;
                }
            }
        } else {
            $result['error'] = true;
            $result['message'] = 'Need to send "from", "from_nominal", "to" params';
            return $result;
        }
    }
}

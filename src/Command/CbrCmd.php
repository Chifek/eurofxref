<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\DependencyInjection\ContainerInterface;
use App\Entity\Cbr;

class CbrCmd extends Command
{
    protected static $defaultName = 'app:get-info-cbr';
    private $container;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = "https://www.cbr.ru/scripts/XML_daily.asp";

        $crawler = new Crawler();

        $crawler->addXmlContent(
            file_get_contents(
                $url
            )
        );

        $nodeValues['NumCode'] = $crawler->filter('ValCurs Valute NumCode')->each(function (Crawler $node, $i) {
            return $node->text();
        });
        $nodeValues['CharCode'] = $crawler->filter('ValCurs Valute CharCode')->each(function (Crawler $node, $i) {
            return $node->text();
        });
        $nodeValues['Nominal'] = $crawler->filter('ValCurs Valute Nominal')->each(function (Crawler $node, $i) {
            return $node->text();
        });
        $nodeValues['Name'] = $crawler->filter('ValCurs Valute Name')->each(function (Crawler $node, $i) {
            return $node->text();
        });
        $nodeValues['Value'] = $crawler->filter('ValCurs Valute Value')->each(function (Crawler $node, $i) {
            return $node->text();
        });

        $em = $this->container->get('doctrine')->getManager();
        $productRepository = $em->getRepository(Cbr::class);
        $products = $productRepository->findAll();

        if (count($products) > 0) {
            foreach ($products as $product) {
                $em->remove($product);
            }
            $em->flush();
        }

        for ($i = 0; $i < count($nodeValues['Value']); $i++) {
            $data[$i]['NumCode'] = $nodeValues['NumCode'][$i];
            $data[$i]['CharCode'] = $nodeValues['CharCode'][$i];
            $data[$i]['Nominal'] = $nodeValues['Nominal'][$i];
            $data[$i]['Name'] = $nodeValues['Name'][$i];
            $data[$i]['Value'] = $nodeValues['Value'][$i];

            $em = $this->container->get('doctrine')->getManager();

            $cbr = new Cbr();
            $cbr->setNumcode($nodeValues['NumCode'][$i]);
            $cbr->setCharCode($nodeValues['CharCode'][$i]);
            $cbr->setNominal($nodeValues['Nominal'][$i]);
            $cbr->setName($nodeValues['Name'][$i]);
            $cbr->setValue((floatval($nodeValues['Value'][$i])));
            $cbr->setDate(new \DateTime());

            $em->persist($cbr);
            $em->flush();
        }

        var_dump($data);
        die;
    }
}
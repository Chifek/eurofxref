<?php

namespace App\Command;

use App\Entity\Eurofx;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class GetEurofxrefDaily extends Command
{
    protected static $defaultName = 'app:get-info-eurofx';
    private $container;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $XML = simplexml_load_file("http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml");

        $em = $this->container->get('doctrine')->getManager();
        $productRepository = $em->getRepository(Eurofx::class);
        $money = $productRepository->findAll();
        if (count($money) > 0) {
            foreach ($money as $product) {
                $em->remove($product);
            }
            $em->flush();
        }

        foreach ($XML->Cube->Cube->Cube as $rate) {
            $em = $this->container->get('doctrine')->getManager();

            $euroFx = new Eurofx();
            $euroFx->setCharCode($rate["currency"]);
            $euroFx->setRate((floatval($rate["rate"])));

            $em->persist($euroFx);
            $em->flush();
        }
        $output->writeln('Success! The data recorded into BD. You can get all data via REST API with route "/eurofx" method: GET');
    }
}
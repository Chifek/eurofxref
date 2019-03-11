<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;

class GetEurofxrefDaily extends Command
{
    protected static $defaultName = 'app:get-info-ecb';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = "https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml";

        $crawler = new Crawler();

        $crawler->addXmlContent(
            file_get_contents(
                $url
            )
        );

        $nodeValues['Cube'] = $crawler->filter('/gesmes:Envelope/Cube/Cube/Cube')->each(function (Crawler $node, $i) {
            return $node->text();
        });
//        $nodeValues['CharCode'] = $crawler->filter('ValCurs Valute CharCode')->each(function (Crawler $node, $i) {
//            return $node->text();
//        });
//        $nodeValues['Nominal'] = $crawler->filter('ValCurs Valute Nominal')->each(function (Crawler $node, $i) {
//            return $node->text();
//        });
//        $nodeValues['Name'] = $crawler->filter('ValCurs Valute Name')->each(function (Crawler $node, $i) {
//            return $node->text();
//        });
//        $nodeValues['Value'] = $crawler->filter('ValCurs Valute Value')->each(function (Crawler $node, $i) {
//            return $node->text();
//        });

//        for ($i = 0; $i < count($nodeValues['Value']); $i++) {
//            $data[$i]['NumCode'] = $nodeValues['NumCode'][$i];
//            $data[$i]['CharCode'] = $nodeValues['CharCode'][$i];
//            $data[$i]['Nominal'] = $nodeValues['Nominal'][$i];
//            $data[$i]['Name'] = $nodeValues['Name'][$i];
//            $data[$i]['Value'] = $nodeValues['Value'][$i];
//        }
//        var_dump($crawler);die;
        var_dump($nodeValues);die;
//        var_dump($r);die;
    }
}
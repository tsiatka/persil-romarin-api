<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Data;
use App\Repository\CaracteristiqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Options\PieChart\PieSlice;

class ViewStatController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/view/stat/{id}", name="view_stat")
     */
    public function index(int $id): Response
    {


        $data = $this->em->getRepository(Data::class)->findOneBy(["id" => $id]);
        $dataName = $data->getNomData();
        $caracteristiques = $data->getCaracteristiques();

        $countData = [];
        foreach ($caracteristiques as $caracteristique) {
            $countData[] = $caracteristique->getContenu();
        }


        $stats = [];
        $stats[] = ['Stats', 'Pourcentage'];
        foreach (array_count_values($countData) as $key => $value) {
            $stats[] = [$key, $value * 100 / count($caracteristiques)];
        }
        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            $stats
        );
        return $this->render('view_stat/index.html.twig', [
            'dataName' => $dataName,
            'pieChart' => $pieChart,
        ]);
    }
}

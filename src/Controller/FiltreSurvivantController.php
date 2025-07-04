<?php


namespace App\Controller;

use App\Form\FiltreType;
use App\Repository\SurvivantRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class FiltreSurvivantController extends AbstractController
{
    #[Route('/filtre/survivant', name: 'app_filtre_survivant')]
    public function index(SurvivantRepository $repository, Request $request): Response
    {
        $form = $this->createForm(FiltreType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $minPower = $data['minPower'] ?? 0;
            $race = $data['race'] ?? null;

            $survivants = $repository->filterForm($minPower, $race);
        } else {
            $survivants = $repository->findAll();
        }



        return $this->render('filtre_survivant/filtreSurvivant.html.twig', [
            'survivants' => $survivants,
            'filtreform' => $form->createView(),
        ]);
    }
}

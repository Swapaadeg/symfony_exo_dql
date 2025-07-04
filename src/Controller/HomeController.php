<?php

namespace App\Controller;

use App\Repository\SurvivantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class HomeController extends AbstractController
{

    #[Route('/', name: 'app_home')]
    public function index(SurvivantRepository $repository, Request $request): Response
    {
        //recuperation de la requête GET qu'on stocke dans $filter
        $filter = $request->get('filter','all');

        switch ($filter) {
            case 'za':
                $survivants = $repository->filterZa();
                break;
            
            case 'nain':
                $survivants = $repository->filterNain('Nain');
                break;

            case 'elfe':
                $survivants = $repository->filterElf25('Elfe', 25);
                break;

            case 'archer':
                $survivants = $repository->filterArcher('Humain', 'Archer');
                break;

            default:
                $survivants = $repository->findAll();
        }

        return $this->render('home/index.html.twig', [
            'survivants' => $survivants,
        ]);
    }
}

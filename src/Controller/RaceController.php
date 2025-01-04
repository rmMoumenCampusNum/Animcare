<?php

namespace App\Controller;

use App\Entity\Race;
use App\Repository\RaceRepository;
use http\Client\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


class RaceController extends AbstractController
{

    #[Route('/races', name: 'liste_race', methods: ['GET'])]
    public function races(RaceRepository $raceRepository): JsonResponse {
        $races = $raceRepository->findAll();
        return $this->json($races);
    }

    #[Route('races/{id}', name: 'race', methods: ['GET'])]
    public function raceById(RaceRepository $raceRepository, int $id): JsonResponse {
        $race = $raceRepository->find($id);
        return $this->json($race);
    }

    #[Route('/races', name:'ajouter_race', methods: ['POST'])]
    public function ajouterRace(\Symfony\Component\HttpFoundation\Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['nom']) || !isset($data['type'])) {
            return new JsonResponse(['error' => 'Données manquantes'], 400);
        }

        $race = new Race();
        $race->setNom($data['nom']);
        $race->setType($data['type']);

        $entityManager->persist($race);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Race ajoutée avec succès'], 201);
    }

    #[Route('/races/{id}', name: 'supprimer_race', methods: ['DELETE'])]
    public function deleteRace(EntityManagerInterface $entityManager, RaceRepository $raceRepository, int $id): JsonResponse{
        $race = $raceRepository->find($id);

        if (!$race && !$race->getId() <= 253){
            return new JsonResponse(['message' => "Désolé. Vous ne pouvez pas supprimer cette race car elle fait partie des races initialement présentes dans la base de données."]);
        } else if (!$race){
                return new JsonResponse(["message" => "Race introuvable"], 400);
        } else {
            $entityManager->remove($race);
            $entityManager->flush();
        }

        return new JsonResponse(['message' => 'Race supprimée avec succès'], 201);
    }


}
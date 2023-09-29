<?php

namespace App\Controller;

use App\Entity\Challenge;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DetailDefisController extends AbstractController
{
    /**
     * Contrôleur pour afficher les détails d'un défi
     *
     * @param int $challengeId L'identifiant du défi à afficher
     * @Route("/detail-defis/{challengeId}", name="app_details_defi")
     * @return Response La réponse HTTP contenant les détails du défi
     */
    public function main($challengeId)
    {
        // Récupère le défi à partir de l'ID en utilisant le référentiel Doctrine
        $challenge = $this->getDoctrine()->getRepository(Challenge::class)->find($challengeId);
        
        // Rend le modèle 'detail-defis.html.twig' en passant les détails du défi
        return $this->render('detail-defis.html.twig', ['detailDefis' => $challenge]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Kid;
use App\Repository\KidRepository;
use App\Form\KidType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/kid', name: 'kid_')]
class KidController extends AbstractController
{
    #[Route('/new', name: 'new')]
    public function new(
        Request $request,
        KidRepository $kidRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $kid = new Kid();

        $form = $this->createForm(KidType::class, $kid);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $kidName = $form->get('kid')->getData();
            $kid = $kidRepository->findOneByName($kidName);
            $entityManager->persist($kid);
            $entityManager->flush();

            $this->addFlash('success',
            'L\'enfant '. $kid->getName() . ' a bien été ajouté');

            return $this->redirectToRoute('kid_new');
        }

        return $this->renderForm('kid/new.html.twig', [
            'form' => $form,
        ]);
    }
}

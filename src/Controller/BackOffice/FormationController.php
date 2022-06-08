<?php

namespace App\Controller\BackOffice;

use App\Entity\Formation;
use App\Form\FormationType;
use App\Repository\FormationRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class FormationController
 * @package APP\Controller\BackOffice
 * @Route("/admin/formations")
 */

class FormationController extends AbstractController
{

    /**
     * @Route(name="formation_manage")
     * @param FormationRepository $formationRepository
     * @return Response
     */
    public function manage(Formationrepository $formationRepository): Response
    {
        $formations = $formationRepository->findAll();

        return $this->render("back_office/formation/manage.htm.twig",[
            "formations" => $formations
        ]);

    }

    /**
     * @Route("/create", name="formation_create")
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    public function create(Request $request , ManagerRegistry $doctrine): Response
    {
        $formation = new Formation();
        $form = $this->createForm(FormationType::class, $formation)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine->getManager()->persist($formation);
            $doctrine->getManager()->flush();
            $this->addFlash("success", "La formation a été ajoutée avec succès !");

            return $this->redirectToRoute("formation_manage");
        }

        return $this->render("back_office/formation/create.html.twig", [
            "form" => $form->createView()
        ]);
    }
    /**
     * @Route("/{id}/update", name="formation_update")
     * @param Formation $formation
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    public function update(Formation $formation, Request $request, ManagerRegistry $doctrine): Response
    {
        $form = $this -> createForm(FormationType::class, $formation)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine->getManager()->flush();
            $this -> addFlash("success", "La Formation a été modifiée avec succès !");

            return $this -> redirectToRoute("formation_manage");
        }

        return $this -> render("back_office/formation/update.html.twig", [
            "form" => $form->createView()
        ]);
    }
    /**
     * @Route("/{id}/delete", name="formation_delete")
     * @param Formation $formation
     * @param ManagerRegistry $doctrine
     * @return RedirectResponse
     */
    public function delete(Formation $formation,ManagerRegistry $doctrine): RedirectResponse
    {
        $doctrine->getManager()->remove($formation);
        $doctrine->getManager()->flush();
        $this->addFlash("success", "La Formation a été supprimée avec succès !");

        return $this->redirectToRoute("formation_manage");
    }
}
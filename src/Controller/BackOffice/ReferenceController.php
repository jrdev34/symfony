<?php

namespace App\Controller\BackOffice;

use App\Entity\Reference;
use App\Form\ReferenceType;
use App\Repository\ReferenceRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class ReferenceController
 * @package APP\Controller\BackOffice
 * @Route("/admin/references")
 */

class ReferenceController extends AbstractController
{

    /**
     * @Route(name="reference_manage")
     * @param ReferenceRepository $referenceRepository
     * @return Response
     */
    public function manage(ReferenceRepository $referenceRepository): Response
    {
        $references = $referenceRepository->findAll();

        return $this->render("back_office/reference/manage.htm.twig",[
            "references" => $references
        ]);

    }

    /**
     * @Route("/create", name="reference_create")
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    public function create(Request $request , ManagerRegistry $doctrine): Response
    {
        $reference = new Reference();
        $form = $this->createForm(ReferenceType::class, $reference)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine->getManager()->persist($reference);
            $doctrine->getManager()->flush();
            $this->addFlash("success", "La compétence a été ajoutée avec succès !");

            return $this->redirectToRoute("reference_manage");
        }

        return $this->render("back_office/reference/create.html.twig", [
            "form" => $form->createView()
        ]);
    }
    /**
     * @Route("/{id}/update", name="reference_update")
     * @param Reference $reference
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    public function update(Reference $reference, Request $request, ManagerRegistry $doctrine): Response
    {
        $form = $this -> createForm(ReferenceType::class, $reference)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine->getManager()->flush();
            $this -> addFlash("success", "La compétence a été modifiée avec succès !");

            return $this -> redirectToRoute("reference_manage");
        }

        return $this -> render("back_office/reference/update.html.twig", [
            "form" => $form->createView()
        ]);
    }
    /**
     * @Route("/{id}/delete", name="reference_delete")
     * @param Reference $reference
     * @param ManagerRegistry $doctrine
     * @return RedirectResponse
     */
    public function delete(Reference $reference,ManagerRegistry $doctrine): RedirectResponse
    {
        $doctrine->getManager()->remove($reference);
        $doctrine->getManager()->flush();
        $this->addFlash("success", "La compétence a été supprimée avec succès !");

        return $this->redirectToRoute("reference_manage");
    }
}
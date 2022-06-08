<?php

namespace App\Controller\BackOffice;

use App\Entity\Skill;
use App\Form\SkillType;
use App\Repository\SkillRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class SkillController
 * @package APP\Controller\BackOffice
 * @Route("/admin/skills")
 */

class SkillController extends AbstractController
{

    /**
     * @Route(name="skill_manage")
     * @param SkillRepository $skillRepository
     * @return Response
     */
    public function manage(Skillrepository $skillRepository): Response
    {
        $skills = $skillRepository->findAll();

        return $this->render("back_office/skill/manage.htm.twig",[
            "skills" => $skills
        ]);

    }

    /**
     * @Route("/create", name="skill_create")
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    public function create(Request $request , ManagerRegistry $doctrine): Response
    {
        $skill = new Skill();
        $form = $this->createForm(SkillType::class, $skill)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine->getManager()->persist($skill);
            $doctrine->getManager()->flush();
            $this->addFlash("success", "La compétence a été ajoutée avec succès !");

            return $this->redirectToRoute("skill_manage");
        }

        return $this->render("back_office/skill/create.html.twig", [
            "form" => $form->createView()
        ]);
    }
    /**
     * @Route("/{id}/update", name="skill_update")
     * @param Skill $skill
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    public function update(Skill $skill, Request $request, ManagerRegistry $doctrine): Response
    {
        $form = $this -> createForm(SkillType::class, $skill)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine->getManager()->flush();
            $this -> addFlash("success", "La compétence a été modifiée avec succès !");

            return $this -> redirectToRoute("skill_manage");
        }

        return $this -> render("back_office/skill/update.html.twig", [
            "form" => $form->createView()
        ]);
    }
    /**
     * @Route("/{id}/delete", name="skill_delete")
     * @param Skill $skill
     * @param ManagerRegistry $doctrine
     * @return RedirectResponse
     */
    public function delete(Skill $skill,ManagerRegistry $doctrine): RedirectResponse
    {
        $doctrine->getManager()->remove($skill);
        $doctrine->getManager()->flush();
        $this->addFlash("success", "La compétence a été supprimée avec succès !");

        return $this->redirectToRoute("skill_manage");
    }
}
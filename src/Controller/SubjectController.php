<?php

namespace App\Controller;

use App\Entity\Subject;
use App\Form\SubjectType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function PHPUnit\Framework\throwException;

class SubjectController extends AbstractController
{
    /**
     * @Route("/subjects", name="subject_index")
     */
    public function subjectIndex()
    {
        $subjects = $this->getDoctrine()->getRepository(Subject::class)->findAll();     //access to data source
        return $this->render("subject/index.html.twig",                                 //render to View
        [
            'subjects' => $subjects
        ]);
    }

    /**
     * @Route("/subject/detail/{id}", name="subject_detail")
     */
    public function subjectDetail($id)
    {
        $subject = $this->getDoctrine()->getRepository(Subject::class)->find($id);
        if ($subject == null)
        {
            $this->addFlash("Error","Subject not found");
            return $this->redirectToRoute("subject_index");
        }
        return $this->render("subject/detail.html.twig",
        [
            'subject' => $subject
        ]);
    }

    /**
     * @Route("/subject/delete/{id}", name="subject_delete")
     */
    public function subjectDelete($id)
    {
        $subject = $this->getDoctrine()->getRepository(Subject::class)->find($id);
        if ($subject == null)
        {
            $this->addFlash("Error", "Delete Subject Failed!");
        }
        else
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($subject);
            $manager->flush();
            
            $this->addFlash("Success", "Delete Subject Succeed!");
        }
        return $this->redirectToRoute("subject_index");
    }

    /**
     * @Route("/subject/add", name="subject_add")
     */
    public function subjectAdd(Request $request)
    {
        $subject = new Subject();
        $form = $this->createForm(SubjectType::class, $subject);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {            
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($subject);
            $manager->flush();

            $this->addFlash("Success", "Add Subject Succeed!");
            return $this->redirectToRoute("subject_index");
        }

        return $this->renderForm("subject/add.html.twig",
        [
            'form' => $form
        ]);
    }

    /**
     * @Route("/subject/edit/{id}", name="subject_edit")
     */
    public function subjectEdit(Request $request, $id)
    {
        $subject = $this->getDoctrine()->getRepository(Subject::class)->find($id);
        $form = $this->createForm(SubjectType::class, $subject);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {        
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($subject);
            $manager->flush();

            $this->addFlash("Success", "Edit Subject Succeed!");
            return $this->redirectToRoute("subject_index");
        }

        return $this->renderForm("subject/edit.html.twig",
        [
            'form' => $form
        ]);
    }
}

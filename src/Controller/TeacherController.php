<?php

namespace App\Controller;

use App\Entity\Teacher;
use App\Form\TeacherType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeacherController extends AbstractController
{
    /**
     * @Route("/teachers", name="teacher_index")
     */
    public function teacherIndex()
    {
        $teachers = $this->getDoctrine()->getRepository(Teacher::class)->findAll();
        return $this->render("teacher/index.html.twig", ['teachers' => $teachers]);
    }

    /**
     * @Route("/teacher/detail/{id}", name="teacher_detail")
     */
    public function teacherDetail($id)
    {
        $teacher = $this->getDoctrine()->getRepository(Teacher::class)->find($id);
        if($teacher == null)
        {
            $this->addFlash("Error", "Teacher not found!");
            return $this->redirectToRoute("teacher_index");
        }
        return $this->render("teacher/detail.html.twig", ['teacher' => $teacher]);
    }

    /**
     * @Route("/teacher/delete/{id}", name="teacher_delete")
     */
    public function teacherDelete($id)
    {
        $teacher = $this->getDoctrine()->getRepository(Teacher::class)->find($id);
        
        if($teacher == null)
        {
            $this->addFlash("Error", "Teacher not found!");
        }
        else
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($teacher);
            $manager->flush();

            $this->addFlash("Success", "Teacher delete succeed!");
        }
        return $this->redirectToRoute("teacher_index");   
    }
    
    /**
     * @Route("/teacher/add", name="teacher_add")
     */
    public function teacherAdd(Request $request)
    {
        $teacher = new Teacher();
        $form = $this->createForm(TeacherType::class, $teacher);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($teacher);
            $manager->flush();

            $this->addFlash("Success", "Add Teacher Succeed!");
            return $this->redirectToRoute("teacher_index");
        }

        return $this->renderForm("teacher/add.html.twig",
        [
            'form' => $form
        ]);
    }

    /**
     * @Route("/teacher/edit/{id}", name="teacher_edit")
     */
    public function teacherEdit(Request $request, $id)
    {
        $teacher = $this->getDoctrine()->getRepository(Teacher::class)->find($id);
        $form = $this->createForm(TeacherType::class, $teacher);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($teacher);
            $manager->flush();

            $this->addFlash("Success", "Edit Teacher Succeed!");
            return $this->redirectToRoute("teacher_index");
        }

        return $this->renderForm("teacher/edit.html.twig",
        [
            'form' => $form
        ]);
    }
}

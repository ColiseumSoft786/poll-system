<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Info;
use App\Entity\Question;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class PollController extends AbstractController
{


    /**
     * @Route("/", name="poll_home_page")
     */
    public function index()
    {
//        $session = New Session();
//        $session->set('_security.main.target_path','admin_question_list');
        $q = $this->getDoctrine()->getRepository(Question::class)->findAll();
        return $this->render('poll/index.html.twig',
            array(
                'Questions' => $q
            ));
    }


    /**
     * @Route("/partialview", name="partial_view_check")
     */
    public function CheckLoginLogout()
    {
        return $this->render('poll/loginlogout.html.twig');
    }

    /**
     * @Route("/answers/{id}", name="poll_answers_list")
     */
    public function answers($id)
    {
        $que = $this->getDoctrine()->getRepository(Question::class)->find($id);
        $ans = $this->getDoctrine()->getRepository(Answer::class)->findby(
        array(
            'Question' => $id
        ));
        return $this->render('poll/answers.html.twig',
            array(
                'Answers' => $ans,
                'Question' => $que
            ));
    }



    /**
     * @Route("/client/answers/receive", name="poll_answers_receive")
     */
    public function receiveanswers(Request $request)
    {
        if ($request->getMethod() == "POST"){
            $em = $this->getDoctrine()->getManager();
            $info = new Info();
            $info->setEmail($request->get('email'));
            $ansid = $this->getDoctrine()->getRepository(Answer::class)->find($request->get('radio'));
            $info->setAnswer($ansid);
            $info->setQuestion($ansid->getQuestion());
//            $question = $this->getDoctrine()->getRepository(Question::class)->find($request->get('question'));
//            $info->setQuestion($question);
            $em->persist($info);
            $em->flush();
            return $this->redirectToRoute('poll_home_page');
        }
    }





//    admin panel actions and routs

    /**
     * @Route("/admin/statements", name="admin_question_list")
     */
    public function ViewStatements()
    {
        if ($this->getUser()) {
            $ans = $this->getDoctrine()->getRepository(Question::class)->findAll();
            return $this->render('admin/statements.html.twig',
                array(
                    'Statements' => $ans
                ));
        }
        return $this->redirectToRoute('poll_home_page');

    }


    /**
     * @Route("/admin/statements/update/{id}", name="admin_question_update")
     */
    public function UpdateStatements(Request $request,$id)
    {
        if ($this->getUser()) {
            if ($request->getMethod() == "POST"){
                $em = $this->getDoctrine()->getManager();
                $que = $em->getRepository(Question::class)->find($id);
                $que->setTitle($request->get('title'));
                $que->setStatment($request->get('statement'));
                $em->flush();
                return $this->redirectToRoute('admin_question_list');
            }
            $q = $this->getDoctrine()->getRepository(Question::class)->find($id);
            return $this->render('admin/statementsupdate.html.twig',
                array(
                    'Question' => $q
                ));
        }
        return $this->redirectToRoute('poll_home_page');
    }



    /**
     * @Route("/admin/statements/delete/{id}", name="admin_question_delete")
     */
    public function DeleteStatements($id)
    {
        if ($this->getUser()) {
            $em = $this->getDoctrine()->getManager();
            $que = $em->getRepository(Question::class)->find($id);
            $em->remove($que);
            $em->flush();
            return $this->redirectToRoute('admin_question_list');
        }
        return $this->redirectToRoute('poll_home_page');

    }



    /**
     * @Route("/insert", name="admin_insert_answers")
     */
    public function InsertMultipleQuestionAnswers(Request $request)
    {
        if ($this->getUser()) {
            if ($request->getMethod() == "POST"){
                $em = $this->getDoctrine()->getManager();
                $q = new Question();
                $q->setTitle($request->get('title'));
                $q->setStatment($request->get('statment'));
                $em->persist($q);
//            $em->flush();
                $color = $request->get('color');
                $answer = $request->get('answer');
//            $answer = $_POST['answer'];
                for ($i=0; $i < count($color); $i++){
                    $a = new Answer();
                    $a->setColor($color[$i]);
                    $a->setAns($answer[$i]);
                    $a->setQuestion($q);
                    $em->persist($a);
                    $em->flush();
                }
                /*print_r($request->get('color'));
                print_r($request->get('answer'));*/
//            return new Response("");
                return $this->redirectToRoute('admin_question_list');
            }
            return $this->render('admin/insertanswer.html.twig');
        }
        return $this->redirectToRoute('poll_home_page');
    }


    /**
     * @Route("/admin/answers/{id}", name="admin_answers_list")
     */
    public function ViewAnswers($id)
    {
        if ($this->getUser()) {
            $que = $this->getDoctrine()->getRepository(Question::class)->find($id);
            $ans = $this->getDoctrine()->getRepository(Answer::class)->findby(
                array(
                    'Question' => $id
                ));
            $info = $this->getDoctrine()->getRepository(Info::class)->findBy(
                array(
                    'Question' => $id
                ));
            return $this->render('admin/answers.html.twig',
                array(
                    'Answers' => $ans,
                    'Question' => $que,
                    'Info' => $info
                ));
        }
        return $this->redirectToRoute('poll_home_page');

    }

    /**
     * @Route("/admin/answers/update/{id}", name="admin_answers_update")
     */
    public function UpdateAnswers(Request $request,$id)
    {
        if ($this->getUser()) {
            if ($request->getMethod() == "POST"){
                $em = $this->getDoctrine()->getManager();
                $ans = $em->getRepository(Answer::class)->find($id);
                $ans->setColor($request->get('color'));
                $ans->setAns($request->get('answer'));
                $em->flush();
                return $this->redirectToRoute('admin_answers_list',
                    array(
                        'id' => $ans->getQuestion()->getId()
                    ));
            }
            $answer = $this->getDoctrine()->getRepository(Answer::class)->find($id);
            return $this->render('admin/answersupdate.html.twig',
                array(
                    'Answers' => $answer
                ));
        }
        return $this->redirectToRoute('poll_home_page');
    }

    /**
     * @Route("/admin/answers/delete/{id}", name="admin_answers_delete")
     */
    public function DeleteAnswers($id)
    {
        if ($this->getUser()) {
            $em = $this->getDoctrine()->getManager();
            $ans = $em->getRepository(Answer::class)->find($id);
            $em->remove($ans);
            $em->flush();
            return $this->redirectToRoute('admin_answers_list',
                array(
                    'id' => $ans->getQuestion()->getId()
                ));
        }
        return $this->redirectToRoute('poll_home_page');
    }




}

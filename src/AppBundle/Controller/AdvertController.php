<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Advert;
//use Doctrine\DBAL\Types\TextType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\HttpFoundation\Request;


class AdvertController extends Controller {

  /**
   * @Route("/", name="Adverts")
   */
  public function indexAction(Request $request) {
    return $this->render('advert/index.html.twig', [
      'content' => 'Show all',
    ]);
  }

  /**
   * @Route("/advert/create", name="Create advert")
   */
  public function createAction(Request $request) {
    $user = $this->container->get('security.token_storage')->getToken()->getUser();

    $advert = new Advert;

    $form = $this->createFormBuilder($advert)
      ->add('title', TextType::class, array('attr' => ['class' => 'form-control']))
      ->add('description', TextareaType::class, array('attr' => ['class' => 'form-control']))
      ->add('save', SubmitType::class, array('label' => 'Save', 'attr' => ['class' => 'btn btn-primary']))
      ->getForm();

    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()) {
      $title = $form['title']->getData();
      $description = $form['description']->getData();
      $now = new\DateTime('now');

      $advert->setTitle($title);
      $advert->setDescription($description);
      $advert->setPublishDate($now);
      $advert->setUserId($user->getId());

      $em = $this->getDoctrine()->getManager();
      $em->persist($advert);
      $em->flush();

      $this->addFlash(
        'notice', 'Advert added'
      );

      return $this->redirectToRoute('adverts_list');
    }

    return $this->render('advert/create.html.twig', [
      'content' => 'Create',
      'form' => $form->createView(),
    ]);
  }

  /**
   * @Route("/advert/edit", name="Edit advert")
   */
  public function editAction(Request $request) {
    return $this->render('advert/edit.html.twig', [
      'content' => 'Edit',
    ]);
  }


  /**
   * @Route("/advert/view", name="View advert")
   */
  public function viewAction(Request $request) {
    return $this->render('advert/view.html.twig', [
      'content' => 'View'
    ]);
  }

  /**
   * @Route("/advert/list", name="adverts_list")
   */
  public function listAction(Request $request) {
    $adverts = $this->getDoctrine()
      ->getRepository('AppBundle:Advert')
      ->findAll();

    return $this->render('advert/list.html.twig', [
      'content' => 'List',
      'adverts' => $adverts
    ]);
  }
}

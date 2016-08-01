<?php

namespace GimnasioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="overview")
     */
    public function indexAction()
    {
        return $this->render('GimnasioBundle:Default:index.html.twig');
    }

    /**
     * @Route("/gimnastas", name="abml-gimnastas")
     */
    public function gimnastasAction(Request $request)
    {
        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT a FROM GimnasioBundle:Gimnasta a";
        if ($request->get("tipo") && $request->get("dato")) {
            $dql.= " where " . " a." . $request->get("tipo") . " = ".  $request->get("dato");
        }
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        // parameters to template
        return $this->render('GimnasioBundle:Default:gimnastas.html.twig', array('pagination' => $pagination));

    }
}

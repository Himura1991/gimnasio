<?php

namespace GimnasioBundle\Controller;

use GimnasioBundle\Entity\Gimnasta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;

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
     * @Route("/socios", name="abml-gimnastas")
     */
    public function gimnastasAction(Request $request)
    {
        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT a FROM GimnasioBundle:Gimnasta a";
        if ($request->get("tipo") && $request->get("dato")) {
            $dato = $request->get('dato');
            $dql.= " where " . " a." . $request->get("tipo") . " like ". "'%$dato%'" ;
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
    /**
     * @Route("/socios/create", name="create-gimnastas")
     */
    public function createGimnastaAction(Request $request) {
        return $this->render('GimnasioBundle:Default:new_gimnasta.html.twig');
    }

    /**
     * @Route("/socios/agregar", name="agregar-gimnastas")
     * @Method({"POST"})
     */
    public function agregarGimnastaAction(Request $request) {
        $gimnasta = new Gimnasta();

        $gimnasta->setDni($request->get("dni"));
        $gimnasta->setEmail($request->get("email"));
        $gimnasta->setName($request->get("name"));
        $gimnasta->setFechaIngreso(date("d-m-Y", strtotime($request->get("beginDate"))));
        $gimnasta->setFechaPago(date("d-m-Y", strtotime($request->get("payDate"))));
        $gimnasta->setHabilitado(1);
        $gimnasta->setFoto("");
        $em = $this->getDoctrine()->getManager();

        // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($gimnasta);

        // actually executes the queries (i.e. the INSERT query)
        $em->flush();

        return new JsonResponse("{'response' : 'OK'}", 200);
    }

    /**
     * @Route("/socios/eliminar/{id}", name="eliminar-gimnastas")
     * @Method({"GET"})
     */
    public function deleteAction(Request $request, $id) {
        $gimnasta = $this->getDoctrine()
            ->getRepository('GimnasioBundle:Gimnasta')
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($gimnasta);
        $em->flush();
        // tells Doctrine you want to (eventually) save the Product (no queries yet)

        return $this->redirectToRoute('abml-gimnastas', array(), 301);
    }

    /**
     * @Route("/socios/editar/{id}", name="editar-gimnastas")
     * @Method({"GET"})
     */
    public function editAction(Request $request, $id) {
        $gimnasta = $this->getDoctrine()
            ->getRepository('GimnasioBundle:Gimnasta')
            ->find($id);

        return $this->render('GimnasioBundle:Default:editar.html.twig', array('gimnasta' => $gimnasta));
    }

    /**
     * @Route("/socios/editar/{id}", name="editar2-gimnastas")
     * @Method({"POST"})
     */
    public function applyEditAction(Request $request, $id) {
        $gimnasta = $this->getDoctrine()
            ->getRepository('GimnasioBundle:Gimnasta')
            ->find($id);

        $gimnasta->setDni($request->get("dni"));
        $gimnasta->setEmail($request->get("email"));
        $gimnasta->setName($request->get("name"));
        $gimnasta->setFechaIngreso(date("d-m-Y", strtotime($request->get("beginDate"))));
        $gimnasta->setFechaPago(date("d-m-Y", strtotime($request->get("payDate"))));


        $em = $this->getDoctrine()->getManager();
        $em->persist($gimnasta);
        $em->flush();

        return new JsonResponse("{'response' : 'OK'}", 200);
    }
}

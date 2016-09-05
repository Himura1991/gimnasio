<?php

namespace GimnasioBundle\Controller;

use GimnasioBundle\Entity\Calendario;
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
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare("SELECT * FROM gimnastas WHERE  STR_TO_DATE(fecha_pago, '%d-%m-%Y') < NOW() - INTERVAL 30 DAY");
        $statement->execute();
        $results = $statement->fetchAll();


        return $this->render('GimnasioBundle:Default:index.html.twig', array('pagination' => $results ));
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
     * @Route("/socios/pago/{id}", name="marcar_pago")
     * @Method({"GET"})
     */
    public function marcarPagoAction(Request $request, $id)
    {
        $gimnasta = $this->getDoctrine()
            ->getRepository('GimnasioBundle:Gimnasta')
            ->find($id);

        $gimnasta->setFechaPago(date("d-m-Y"));


        $em = $this->getDoctrine()->getManager();
        $em->persist($gimnasta);
        $em->flush();

        return $this->redirect($this->generateUrl('overview'));
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

    /**
     * @Route("/calendario", name="calendario")
     * @Method({"GET"})
     */
    public function calendarioAction(Request $request) {
        $em = $this->getDoctrine()->getEntityManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare("SELECT * FROM calendario ORDER BY horario ASC");
        $statement->execute();
        $results = $statement->fetchAll();


        return $this->render('GimnasioBundle:Default:calendario.html.twig', array('pagination' => $results));
    }

    /**
     * @Route("/calendario/new", name="create2-calendario")
     * @Method({"POST"})
     */
    public function createHorarioPostAction(Request $request) {
        $horario = new Calendario();

        $horario->setHorario($request->get("horario"));
        $horario->setLunes($request->get("lunes"));
        $horario->setMartes($request->get("martes"));
        $horario->setMiercoles($request->get("miercoles"));
        $horario->setJueves($request->get("jueves"));
        $horario->setViernes($request->get("viernes"));
        $horario->setSabado($request->get("sabado"));

        $em = $this->getDoctrine()->getManager();

        // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($horario);

        // actually executes the queries (i.e. the INSERT query)
        $em->flush();

        $url = $this->generateUrl('calendario');

        return new JsonResponse('{"redirect":'.$url.'}');
    }


    /**
     * @Route("/calendario/editar/{id}", name="editar2-calendario")
     * @Method({"POST"})
     */
    public function applyEditHorarioAction(Request $request, $id) {
        $horario = $this->getDoctrine()
            ->getRepository('GimnasioBundle:Calendario')
            ->find($id);

        $horario->setHorario($request->get("horario"));
        $horario->setLunes($request->get("lunes"));
        $horario->setMartes($request->get("martes"));
        $horario->setMiercoles($request->get("miercoles"));
        $horario->setJueves($request->get("jueves"));
        $horario->setViernes($request->get("viernes"));
        $horario->setSabado($request->get("sabado"));

        $em = $this->getDoctrine()->getManager();
        $em->persist($horario);
        $em->flush();

        $url = $this->generateUrl('calendario');

        return new JsonResponse('{"redirect":'.$url.'}');
    }

    /**
     * @Route("/calendario/create", name="create-horario")
     */
    public function createHorarioAction(Request $request) {
        return $this->render('GimnasioBundle:Default:new_horario.html.twig');
    }

    /**
     * @Route("/calendario/eliminar/{id}", name="eliminar-horario")
     * @Method({"GET"})
     */
    public function deleteCalendarAction(Request $request, $id) {
        $gimnasta = $this->getDoctrine()
            ->getRepository('GimnasioBundle:Calendario')
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($gimnasta);
        $em->flush();
        // tells Doctrine you want to (eventually) save the Product (no queries yet)

        return $this->redirectToRoute('calendario', array(), 301);
    }

    /**
     * @Route("/calendario/editar/{id}", name="editar-horario")
     * @Method({"GET"})
     */
    public function editCalendarioAction(Request $request, $id) {
        $horario = $this->getDoctrine()
            ->getRepository('GimnasioBundle:Calendario')
            ->find($id);

        return $this->render('GimnasioBundle:Default:editar_calendario.html.twig', array('horario' => $horario));
    }
}

<?php

namespace App\Controller;

use App\Entity\Invoice;
use App\Form\InvoiceType;
use App\Repository\InvoiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Service\ConfiguredSerializer;
/**
 * @Route("/api")
 */
class InvoiceController extends Controller
{
    
    /**
     * @Route("/factures", name="invoice_index", methods="GET")
     */
    public function index(InvoiceRepository $invoiceRepository, ConfiguredSerializer $configuredSerializer)
    {
        $invoices = $invoiceRepository->findAll();
        
        //on utilise un service créé par nos soin pour configurer le serializer
        $json = $configuredSerializer->getConfiguredSerializer()->serialize($invoices, 'json');

        return new Response($json);
    }

    /**
     * @Route("/new", name="invoice_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $invoice = new Invoice();
        $form = $this->createForm(InvoiceType::class, $invoice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($invoice);
            $em->flush();

            return $this->redirectToRoute('invoice_index');
        }

        return $this->render('invoice/new.html.twig', [
            'invoice' => $invoice,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="invoice_show", methods="GET")
     */
    public function show(Invoice $invoice): Response
    {
        return $this->render('invoice/show.html.twig', ['invoice' => $invoice]);
    }

    /**
     * @Route("/{id}/edit", name="invoice_edit", methods="GET|POST")
     */
    public function edit(Request $request, Invoice $invoice): Response
    {
        $form = $this->createForm(InvoiceType::class, $invoice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('invoice_edit', ['id' => $invoice->getId()]);
        }

        return $this->render('invoice/edit.html.twig', [
            'invoice' => $invoice,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="invoice_delete", methods="DELETE")
     */
    public function delete(Request $request, Invoice $invoice): Response
    {
        if ($this->isCsrfTokenValid('delete'.$invoice->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($invoice);
            $em->flush();
        }

        return $this->redirectToRoute('invoice_index');
    }
}

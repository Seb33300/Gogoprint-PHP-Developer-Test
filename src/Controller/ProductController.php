<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Pages;
use App\Entity\PaperFormat;
use App\Entity\PaperType;
use App\Entity\ProductConfiguration;
use App\Form\CartType;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Rest\RouteResource("Product", pluralize=false)
 */
class ProductController extends AbstractFOSRestController implements ClassResourceInterface
{
    /**
     * @Rest\View
     */
    public function getOptionsAction()
    {
        return [
            'paper_format' => $this->getDoctrine()->getRepository(PaperFormat::class)->findAll(),
            'papes' => $this->getDoctrine()->getRepository(Pages::class)->findAll(),
            'paper_type' => $this->getDoctrine()->getRepository(PaperType::class)->findAll(),
        ];
    }

    /**
     * @Rest\QueryParam(name="paper_format_id", requirements="\d+", strict=true, nullable=false, description="Paper format id.")
     * @Rest\QueryParam(name="pages_id", requirements="\d+", strict=true, nullable=false, description="Pages id.")
     * @Rest\QueryParam(name="paper_type_id", requirements="\d+", strict=true, nullable=false, description="Paper type id.")
     *
     * @Rest\View
     */
    public function getPricesAction(ParamFetcherInterface $paramFetcher)
    {
        return $this->getProductConfiguration($paramFetcher)->getProductConfigurationQuantityPrices();
    }

    /**
     * @Rest\RequestParam(name="paper_format_id", requirements="\d+", strict=true, nullable=false, description="Paper format id.")
     * @Rest\RequestParam(name="pages_id", requirements="\d+", strict=true, nullable=false, description="Pages id.")
     * @Rest\RequestParam(name="paper_type_id", requirements="\d+", strict=true, nullable=false, description="Paper type id.")
     * @Rest\RequestParam(name="quantity", requirements="\d+", strict=true, nullable=false, description="Quantity to print.")
     * @Rest\RequestParam(name="date", requirements="\d{4}-\d{2}-\d{2}", strict=true, nullable=false, description="Production date.")
     *
     * @Rest\View
     */
    public function postCartAction(ParamFetcherInterface $paramFetcher)
    {
        $productConfiguration = $this->getProductConfiguration($paramFetcher);

        $form = $this->createForm(CartType::class);

        $form->submit([
            'productConfiguration' => $productConfiguration->getId(),
            'quantity' => $paramFetcher->get('quantity'),
            'date' => $paramFetcher->get('date'),
        ]);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($form->getData());
            $this->getDoctrine()->getManager()->flush();

            return $form->getData();
        }

        return $form;
    }

    protected function getProductConfiguration(ParamFetcherInterface $paramFetcher)
    {
        /** @var ProductConfiguration $productConfiguration */
        $productConfiguration = $this->getDoctrine()->getRepository(ProductConfiguration::class)->findOneBy([
            'paperFormat' => $paramFetcher->get('paper_format_id'),
            'pages' => $paramFetcher->get('pages_id'),
            'paperType' => $paramFetcher->get('paper_type_id'),
        ]);

        if (!$productConfiguration) {
            throw new NotFoundHttpException('Product configuration not found.');
        }

        return $productConfiguration;
    }
}

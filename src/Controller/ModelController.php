<?php

namespace App\Controller;

use App\Entity\Contact2;
use App\Notification\ContactNotification;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Model;
use App\Repository\ModelRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Knp\Component\Pager\PaginatorInterface;
use App\Form\ContactType;

class ModelController extends AbstractController
{
    /**
     * @var ManagerRegistry
     * @var ModelRepository
     */
    private $registry, $repository;

    /**
     * ModelController constructor.
     * @param ModelRepository $repository
     * @param ManagerRegistry $registry
     */
    public function __construct(ModelRepository $repository, ManagerRegistry $registry)
    {
        $this->repository = $repository;
        $this->registry   = $registry;
    }

    /**
     * @Route("/models/{name}", name="model_list")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @param $name
     * @return Response
     */
    public function getModelList(PaginatorInterface $paginator, Request $request, $name): Response
    {
        $models = $paginator->paginate($this->repository->findModelkitPng($name), $request->query->getInt('page', 1), 9);

        return $this->render('pages/model/model_list.html.twig', [
            'pagination' => $paginator,
            'models'     => $models
        ]);
    }

    /**
     * @Route("/models/{slug}-{id}", name="model_show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Model $model
     * @param string $slug
     * @param Request $request
     * @param ContactNotification $notification
     * @return Response;
     */
    public function show(Model $model, string $slug, Request $request, ContactNotification $notification): Response
    {
        if ($model->getSlug() !== $slug) {
            return $this->redirectToRoute('model_show', [
                'id'   => $model->getId(),
                'slug' => $model->getSlug()
            ], 301);
        }

        $contact = new Contact2();
        $contact->setModel($model);
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $notification->notify($contact);
            $this->addFlash('success', 'Email envoyé');
            return $this->redirectToRoute('model_show', [
                'id'   => $model->getId(),
                'slug' => $model->getSlug()
            ]);
        }

        return $this->render('pages/model/model_show.html.twig', [
            'model'    => $model,
            'form'     => $form->createView()
        ]);
    }
}

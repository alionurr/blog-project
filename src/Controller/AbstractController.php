<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;

abstract class AbstractController
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var
     */
    protected $entityManager;

    /**
     * @var
     */
    protected $twig;

    /**
     * AbstractController constructor.
     * @param Request $request
     * @param $entityManager
     * @param $twig
     */
    public function __construct(Request $request, $entityManager, $twig)
    {
        $this->request = $request;
        $this->entityManager = $entityManager;
        $this->twig = $twig;
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @return mixed
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }



}
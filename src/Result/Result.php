<?php


namespace App\Result;


class Result
{
    private int $httpCode;
    private $viewModel;

    public function __construct(int $httpCode = 200) {
        $this->httpCode = $httpCode;
    }

    /**
     * @return int
     */
    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    /**
     * @param int $httpCode
     */
    public function setHttpCode(int $httpCode): void
    {
        $this->httpCode = $httpCode;
    }

    /**
     * @return mixed
     */
    public function getViewModel()
    {
        return $this->viewModel;
    }

    /**
     * @param mixed $viewModel
     */
    public function setViewModel($viewModel): void
    {
        $this->viewModel = $viewModel;
    }
}
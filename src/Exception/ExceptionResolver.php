<?php


namespace App\Exception;


use App\ViewModel\ResponseViewModel\ErrorResponseViewModel;

class ExceptionResolver
{

    private static function getDefaultModel() {
        $viewModel = new ErrorResponseViewModel();
        $viewModel->setInternalCode(1);
        $viewModel->setMessage('Unknown error occured');
        return $viewModel;

    }

    public static function resolveError(\Exception $ex): ErrorResponseViewModel {
        $viewModel = new ErrorResponseViewModel();
        if($ex instanceof ApiException) {
            $viewModel->setHttpCode($ex->getHttpCode());
            $viewModel->setInternalCode($ex->getCode());
            $viewModel->setMessage($ex->getMessage());
        } else {
            $viewModel = self::getDefaultModel();
        }
        return $viewModel;
    }
}
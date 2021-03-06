<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Utilities\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function sendToView($view, $title, array $variables = [])
    {
        $attributes = array_merge(['title' => $title], $variables);

        return view($view, $attributes);
    }

    protected function ajaxSuccess($message, $redirect = false, $reload = false)
    {
        $response = new Response($message, Response::SUCCESS, $redirect, $reload);

        return new JsonResponse($response);
    }

    protected function ajaxWarning($message, $redirect = false, $reload = false)
    {
        $response = new Response($message, Response::WARNING, $redirect, $reload);

        return new JsonResponse($response, 500);
    }

    protected function ajaxError($message, $redirect = false, $reload = false)
    {
        $response = new Response($message, Response::ERROR, $redirect, $reload);

        return new JsonResponse($response, 500);
    }

    protected function sendError($message)
    {
        Session::flash('error', $message);

        return Redirect::back();
    }
}

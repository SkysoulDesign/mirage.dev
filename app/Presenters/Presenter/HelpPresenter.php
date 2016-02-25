<?php

namespace App\Presenters\Presenter;

use App\Presenters\Presenter;
use Illuminate\Routing\Route;
use Illuminate\Routing\RouteCollection;
use Illuminate\Routing\Router;

class HelpPresenter extends Presenter
{

    /**
     * Present Full Url
     * @return string
     */
    public function route()
    {
        /**
         * if Requires parameters, decode it along
         */
        if ($this->model->route_parameters) {

            $parameters = collect(json_decode($this->model->route_parameters, true));
            $route = route($this->model->route, $parameters->toArray());
            $final = '';

            $parameters->each(function ($param) use (&$final, $route) {
                $final = str_replace($param, '<b class="color blue">' . $param . '</b>', $route);
            });

            return $final;

        }

        return route($this->model->route);
    }

    /**
     * Present Full Url
     * @return string
     */
    public function methods()
    {
        return app(Router::class)->getRoutes()->getByName($this->model->route)->getMethods();
    }

    /**
     * Present Response
     * @return string
     */
    public function parameters()
    {
        return $this->model->parameters ? str_replace('Required -', '<b class="color red">Required:</b>', json_decode($this->model->parameters, true)) : [];
    }

    /**
     * Present Response
     * @return string
     */
    public function response()
    {
        return $this->format_response($this->model->response);
    }

    /**
     * Format Response
     * @param $response
     * @return string
     */
    protected function format_response($response)
    {
        return str_replace('Array', '', print_r(json_decode($response, true), true));
    }

    /**
     * Present Response
     * @return string
     */
    public function response_error()
    {
        return $this->format_response($this->model->response_error);
    }

}
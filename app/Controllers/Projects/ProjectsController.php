<?php
namespace AvinGroup\App\Controllers\Projects;

use AvinGroup\App\Controllers\Controller;
use AvinGroup\App\Services\Projects\ProjectsService;
use Exception;

(defined('ABSPATH')) || exit;

class ProjectsController extends Controller
{

    protected $service;

    public function __construct()
    {

        $this->service = new ProjectsService;

    }

    public function single($request)
    {

        try {

            wp_send_json_success($this->service->single($request), 200);

        } catch (Exception $e) {

            wp_send_json_error([
                'massage' => $e->getMessage(),
             ], 400);

        }

    }

    public function filters()
    {

        try {

            wp_send_json_success($this->service->filters(), 200);

        } catch (Exception $e) {

            wp_send_json_error([
                'massage' => $e->getMessage(),
             ], 400);

        }

    }

}

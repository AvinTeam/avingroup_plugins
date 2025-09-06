<?php
namespace AvinGroup\App\Controllers\Projects;

use AvinGroup\App\Controllers\Controller;
use AvinGroup\App\Services\Projects\ProjectsSingleService;
use Exception;

(defined('ABSPATH')) || exit;

class ProjectsSingleController extends Controller
{

    protected $projectsSingleService;

    public function __construct()
    {

        $this->projectsSingleService = new ProjectsSingleService;

    }

    public function index($request)
    {

        try {

            wp_send_json_success($this->projectsSingleService->index($request), 200);

        } catch (Exception $e) {

            wp_send_json_error([
                'massage' => $e->getMessage(),
             ], 400);

        }

    }

}

<?php
namespace AvinGroup\App\Controllers\Clients;

use AvinGroup\App\Controllers\Controller;
use AvinGroup\App\Services\Clients\ClientsService;
use Exception;

(defined('ABSPATH')) || exit;

class ClientsController extends Controller
{

    protected $service;

    public function __construct()
    {

        $this->service = new ClientsService;

    }

    public function index($request)
    {

        try {

            wp_send_json_success($this->service->index($request), 200);

        } catch (Exception $e) {

            wp_send_json_error([
                'massage' => $e->getMessage(),
             ], 400);

        }

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

}
<?php
namespace AvinGroup\App\Controllers\Clients;

use AvinGroup\App\Controllers\Controller;
use AvinGroup\App\Services\Clients\ClientsService;
use Exception;

(defined('ABSPATH')) || exit;

class ClientsController extends Controller
{

    protected $optionsService;

    public function __construct()
    {

        $this->optionsService = new ClientsService;

    }

    public function index($request)
    {

        try {

            wp_send_json_success($this->optionsService->index($request), 200);

        } catch (Exception $e) {

            wp_send_json_error([
                'massage' => $e->getMessage(),
             ], 400);

        }

    }

}

<?php
namespace AvinGroup\App\Controllers\Options;

use AvinGroup\App\Controllers\Controller;
use AvinGroup\App\Services\Options\OptionsService;
use Exception;

(defined('ABSPATH')) || exit;

class OptionsController extends Controller
{

    protected $optionsService;

    public function __construct()
    {

        $this->optionsService = new OptionsService;

    }

    public function index()
    {

        try {

            wp_send_json_success($this->optionsService->index(), 200);

        } catch (Exception $e) {

            wp_send_json_error([
                'massage' => $e->getMessage(),
             ], 400);

        }

    }

}

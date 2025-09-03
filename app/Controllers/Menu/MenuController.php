<?php
namespace AvinGroup\App\Controllers\Menu;

use AvinGroup\App\Controllers\Controller;
use AvinGroup\App\Services\Menu\MenuService;
use Exception;

(defined('ABSPATH')) || exit;

class MenuController extends Controller
{

    protected $MenuService;

    public function __construct()
    {

        $this->MenuService = new MenuService;

    }

    public function index()
    {

        try {

            wp_send_json_success($this->MenuService->index(), 200);

        } catch (Exception $e) {

            wp_send_json_error([
                'massage' => $e->getMessage(),
             ], 400);

        }

    }

}

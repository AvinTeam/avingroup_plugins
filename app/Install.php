<?php
namespace AvinGroup\App\Core;

(defined('ABSPATH')) || exit;

class Install
{
    private $wpdb;
    private string $db_name_key;

    public function __construct()
    {
        $this->db_name_key = config('app.key');
        global $wpdb;
        $this->wpdb = $wpdb;
        add_action('after_switch_theme', [ $this, 'install' ]);

    }

    public function install()
    {

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        dbDelta($this->db_sites());
        dbDelta($this->db_site_product());
        $this->add_categories();

    }

    private function prefix($DB)
    {
        return $this->wpdb->prefix . $this->db_name_key . $DB;
    }

    private function db_sites()
    {

        $table_name = $this->prefix('sites');

        $table_collate = $this->wpdb->collate;

        return "CREATE TABLE IF NOT EXISTS `$table_name` (
                `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                `url` text NOT NULL,
                `title` varchar(255) DEFAULT NULL,
                `email` varchar(255) DEFAULT NULL,
                `mobile` varchar(12) DEFAULT NULL,
                PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=$table_collate";
    }

    private function db_site_product()
    {

        $table_name = $this->prefix('site_product');

        $site_table = $this->prefix('sites');

        $post_table = $this->wpdb->posts;

        $table_collate = $this->wpdb->collate;

        return "CREATE TABLE IF NOT EXISTS `$table_name` (
                `product_id` BIGINT UNSIGNED NOT NULL,
                `site_id` BIGINT UNSIGNED NOT NULL,
                `type` varchar(30) NOT NULL,
                `version` VARCHAR(30) NULL,
                `status` ENUM('active', 'notActive') NOT NULL DEFAULT 'active',
                PRIMARY KEY (product_id, site_id),
                FOREIGN KEY (product_id) REFERENCES $post_table(ID) ON DELETE CASCADE,
                FOREIGN KEY (site_id) REFERENCES $site_table(id) ON DELETE CASCADE
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=$table_collate";
    }

    private function add_categories()
    {
        $main_categories = [
            'plugins'      => 'افزونه ها',
            'themes'    => 'پوسته ها',
         ];

        foreach ($main_categories as $slug => $name) {
            $term = term_exists($slug, 'cat_product');
            if (! $term) {
                wp_insert_term($name, 'cat_product', [
                    'slug'        => $slug,
                    'description' => $name,
                 ]);
            }
        }

    }
}

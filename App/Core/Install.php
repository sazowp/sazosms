<?php
namespace SazoWP\App\Core;

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
        // add_action('after_switch_theme', [ $this, 'install' ]);

    }

    public function install()
    {
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($this->db_project_relations());
    }

    private function prefix($DB)
    {
        return $this->wpdb->prefix . $this->db_name_key . $DB;
    }

    private function db_project_relations()
    {

        $table_name = $this->prefix('project_relations');

        $post_table = $this->wpdb->posts;

        $table_collate = $this->wpdb->collate;

        return "CREATE TABLE IF NOT EXISTS `$table_name` (
                    `id` BIGINT unsigned NOT NULL AUTO_INCREMENT,
                    `project_id` BIGINT UNSIGNED NOT NULL,
                    `client_id` BIGINT UNSIGNED DEFAULT NULL,
                    `partner_id` BIGINT UNSIGNED DEFAULT NULL,
                    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,

                    PRIMARY KEY (id),
                    KEY project_id (project_id),
                    KEY client_id (client_id),
                    KEY partner_id (partner_id),

                    CONSTRAINT fk_project FOREIGN KEY (project_id) REFERENCES $post_table(ID) ON DELETE CASCADE,
                    CONSTRAINT fk_client FOREIGN KEY (client_id) REFERENCES $post_table(ID) ON DELETE SET NULL,
                    CONSTRAINT fk_partner FOREIGN KEY (partner_id) REFERENCES $post_table(ID) ON DELETE CASCADE
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=$table_collate";
    }
}

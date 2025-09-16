<?php
namespace SazoWP\App\Core\DB;

(defined('ABSPATH')) || exit;

class DB
{
    protected $wpdb;
    protected $table;
    public $query;
    protected $lastInsertId;
    protected bool $isAll = false;

    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
    }

    public function setTable(string $table): static
    {

        $this->table = $this->wpdb->prefix . $table;
        return $this;
    }
    public function getTable(): string
    {
        return $this->table;
    }

    public function getLastQuery(): string
    {
        return $this->query;
    }

    public function db_insert(array $data): int | false
    {
        $formats = array_map([ $this, 'getFormat' ], $data);

        $result = $this->wpdb->insert(
            $this->table,
            $data,
            $formats
        );

        $this->query        = $this->wpdb->last_query;
        $this->lastInsertId = $this->wpdb->insert_id;

        return $result ? $this->lastInsertId : false;
    }

    public function db_get(array $conditions, string $output = OBJECT): object | array | null
    {
        $where       = $this->buildWhere($conditions);
        $this->query = "SELECT * FROM `{$this->table}` WHERE {$where}";
        return $this->get_row($this->query, $output);
    }

    public function db_select(array $conditions = [  ], string $output = OBJECT): array | object | null
    {

        $where = $this->buildWhere($conditions[ 'data' ] ?? [  ]);

        if (isset($conditions[ 'where' ]) && ! empty($conditions[ 'where' ])) {
            $where .= " AND {$conditions[ 'where' ]}";
        }

        if (isset($conditions[ 's' ])) {
            $where .= $this->wpdb->prepare(" AND %i LIKE %s", $conditions[ 's' ][ 0 ], '%' . $conditions[ 's' ][ 1 ] . '%');
        }

        $columns = $conditions[ 'columns' ] ?? '*';

        $query = "SELECT {$columns} FROM `{$this->table}` WHERE {$where}";

        if (! empty($conditions[ 'order' ])) {
            $order = $conditions[ 'order' ];
            $query .= " ORDER BY `{$order[ 'column' ]}` {$order[ 'direction' ]}";
        }

        if (! empty($conditions[ 'limit' ])) {
            $limit  = absint($conditions[ 'limit' ]);
            $offset = ! empty($conditions[ 'offset' ]) ? absint($conditions[ 'offset' ]) : 0;
            $query .= " LIMIT {$offset}, {$limit}";
        }

        $this->query = $query;

        return $this->get_results($query, $output);

    }

    public function db_update(array $data, array $where): int | false
    {
        $dataFormats  = array_map([ $this, 'getFormat' ], $data);
        $whereFormats = array_map([ $this, 'getFormat' ], $where);

        $result = $this->wpdb->update(
            $this->table,
            $data,
            $where,
            $dataFormats,
            $whereFormats
        );

        $this->query = $this->wpdb->last_query;
        return $result;
    }

    public function db_delete(array $where): int | false
    {
        $whereFormats = array_map([ $this, 'getFormat' ], $where);

        $result = $this->wpdb->delete(
            $this->table,
            $where,
            $whereFormats
        );

        $this->query = $this->wpdb->last_query;
        return $result;

    }

    public function db_num($where): int | string
    {

        if ($this->isAll && empty($where)) {
            $where = '1=1';
        } else if (empty($where)) {
            $where = '1=0';
        }

        $this->query = "SELECT COUNT(*) FROM `{$this->table}` WHERE {$where}";
        $count       = $this->get_var($this->query);

        return absint($count);

    }

    protected function db_empty(): bool
    {
        $this->query = "TRUNCATE TABLE `{$this->table}`";
        $result      = $this->wpdb->query($this->query);
        return (bool) $result;
    }

    private function buildWhere(array $conditions): string
    {

        $where = '1=1';
        foreach ($conditions as $key => $value) {
            $where .= $this->wpdb->prepare(
                ' AND %i = ' . $this->getFormat($value),
                $key,
                $value
            );
        }
        return $where;
    }

    private function getFormat($value): string
    {
        return match (gettype($value)) {
            'integer' => '%d',
            'double' => '%f',
            default => '%s'
        };
    }

    public function get_row($query = null, $output = OBJECT, $y = 0)
    {
        return $this->wpdb->get_row($query, $output, $y);
    }

    public function get_results($query = null, $output = OBJECT)
    {
        return $this->wpdb->get_results($query, $output);
    }

    public function get_var($query = null, $x = 0, $y = 0)
    {
        return $this->wpdb->get_var($query, $x, $y);
    }

}

<?php

/* =-=-=-= Copyright © 2023 Cruder =-=-=-=-=- 
  |           APACHE-2.0 LICENSE            |
  |   https://github.com/musicman3/Cruder   |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace Cruder\Sqlite;

use Cruder\Pdo;

/**
 * CRUD Sqlite Adapter
 *
 * @package Cruder
 * @author Cruder Team
 * @copyright © 2023 Cruder
 * @license Apache-2.0
 * 
 */
class SqliteAdapter extends Methods {

    protected $table = FALSE;
    protected $crud = [];
    protected $request = '';
    protected $output = [];
    protected $set = '';
    protected $method_chain = '';
    protected $action = FALSE;
    protected $debug = FALSE;

    /**
     * Create, Update and Delete Builder (INSERT INTO, UPDATE, DELETE FROM)
     * 
     * @param string $assistant assistant data
     * @return bool
     */
    protected function createUpdateDeleteBuilder(string $assistant): mixed {

        $this->request = $this->requestNormalization($assistant . ' ' . $this->method_chain);
        $this->output = $this->outputNormalization($this->crud);

        Pdo::action($this->request, $this->output);
        $this->reset();

        return true;
    }

    /**
     * Read Builder (SELECT)
     * 
     * @param string $assistant assistant data
     * @return mixed query data
     */
    protected function readBuilder(string $assistant): mixed {

        $this->request = $this->requestNormalization($assistant . ' FROM ' . $this->table . ' ' . $this->method_chain);
        $this->output = $this->outputNormalization($this->crud);

        $query = false;

        if ($this->action == 'getAssoc') {
            $query = Pdo::getAssoc($this->request, $this->output);
        }
        if ($this->action == 'getValue') {
            $query = Pdo::getValue($this->request, $this->output);
        }
        if ($this->action == 'getIndex') {
            $query = Pdo::getIndex($this->request, $this->output);
        }
        if ($this->action == 'getObj') {
            $query = Pdo::getObj($this->request, $this->output);
        }
        if ($this->action == 'getColCount') {
            $query = Pdo::getColCount($this->request, $this->output);
        }
        if ($this->action == 'getRowCount') {
            $query = Pdo::getRowCount($this->request, $this->output);
        }
        if ($this->action == 'lastInsertId') {
            $query = Pdo::lastInsertId();
        }

        $this->reset();
        return $query;
    }

    /**
     * Builder's assistant
     * 
     * @param string $data input data
     * @return string assistant data
     */
    protected function assistant(string $data): mixed {

        $separator = ', ';

        if ($this->action == 'create' || $this->action == 'update' || $this->action == 'delete' || $this->action == 'drop') {
            $separator = '=?, ';
        }

        foreach ($this->crud as $key => $val) {
            if ($key == 0) {
                break;
            }
            $data .= $key . $separator;
        }
        unset($val);

        return rtrim($data, ', ');
    }

    /**
     * Final Data
     * 
     * @param string $data input data
     * @return mixed query data
     */
    protected function finalData(string $data): mixed {

        $assistant = $this->assistant($data);

        if ($this->action == 'create' || $this->action == 'update' || $this->action == 'delete' || $this->action == 'drop') {
            $output = $this->createUpdateDeleteBuilder($assistant);
        } else {
            $output = $this->readBuilder($assistant);
        }

        return $output;
    }

    /**
     * Reset after completion
     * 
     */
    protected function reset(): void {
        $this->table = false;
        $this->crud = [];
        $this->debugFormatLine($this->debug, $this->request);
        $this->request = '';
        $this->output = [];
        $this->set = '';
        $this->method_chain = '';
        $this->action = FALSE;
    }
}

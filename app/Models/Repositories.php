<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class Repositories extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'repository';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "id",
        "name",
        "url",
        "created_date",
        "last_push_date",
        "description",
        "stars",
        "status"
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /** Process sycnup repositories 
     * Repository Status:
     * 1 - New
     * 2 - Updated
     */

    public function processRepositories($repos) {

        try {
            foreach($repos as $r) {
                if ($this->find($r['id'])) {
                    $r['status'] = 2;
                    $this->save($r);
                } else {
                    $r['status'] = 1;
                    $this->insert($r);
                }
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}

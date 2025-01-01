<?php

namespace App\Models;

use CodeIgniter\Model;

class Campaigns extends Model
{
    protected $table            = 'campaigns';
    protected $primaryKey       = 'camp_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['camp_id','campaign_name','description','client','supervisor'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
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

    public function getFilteredCampaign($filterSupervisor = null, $filterCampaignName = null, $filterClient = null) {
        if ($filterSupervisor) {
            $this->where('supervisor', $filterSupervisor);
        }
        if ($filterCampaignName) {
            $this->like('campaign_name', $filterCampaignName);
        }
        if ($filterClient) {
            $this->like('client', $filterClient);
        }
        return $this->paginate(3);
    }

    public function isCampaignExists($campignName) {
        return $this->where('campaign_name', $campignName)->first() !== null;
    }

    public function createCampaign($campaignName, $campaignDescription, $client, $supervisor) {
        $this->save([
            'campaign_name' => $campaignName,
            'description' => $campaignDescription,
            'client' => $client,
            'supervisor' => $supervisor
        ]);
    }

    public function getCampaignById($id) {
        return $this->where('camp_id', $id)->first();
    }

    public function updateCampaign($id, $campaignName, $campaignDescription, $client, $supervisor) {
        $this->update($id, [
            'campaign_name' => $campaignName,
            'description' => $campaignDescription,
            'client' => $client,
            'supervisor' => $supervisor
        ]);
    }

    public function deleteCampaign($id) {
        $this->delete($id);
    }
}

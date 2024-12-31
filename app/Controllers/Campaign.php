<?php

namespace App\Controllers;
use App\Models\Users;
use App\Models\Campaigns;

class Campaign extends BaseController
{
    public function __construct() {
        $this->model = new Campaigns();
        $this->users = new Users();
    }

    public function index() {
        
        $filterSupervisor = $this->request->getGet('filterSupervisor') ?? null;
        $filterCampaignName = $this->request->getGet('searchCampaignName') ?? null;
        $filterClient = $this->request->getGet('searchClient') ?? null;

        $campaigns = $this->model->getFilteredCampaign($filterSupervisor, $filterCampaignName, $filterClient);
        $access_supervisor = $this->users->getUserByRole(2);

        $data['page'] = 'campaign';
        $data['data'] = ['campaigns' => $campaigns, 'filteraccess' => $access_supervisor];
        $data['pager'] = $this->model->pager;

        echo view('template', $data);
    
        // return view('header').
        //        view('campaign',['campaigns' => $campaigns]).
        //        view('footer');
    }

    public function createcampaign() {
        $access_supervisor = $this->users->getUserByRole(2);
        // print_r($data);
        $data['page'] = 'createcampaign';
        $data['data'] = ['supervisors'=>$access_supervisor];
        echo view('template', $data);
        // return view('header').view('createcampaign',['supervisors'=>$data]).view('footer');
    }

    public function addcampaign() {
        $campaignName = $this->request->getPost('campaignname');
        $campaignDescription = $this->request->getPost('description');
        $client = $this->request->getPost('client');
        $supervisor = $this->request->getPost('supervisor');

        $campaignNameExists = $this->model->where('campaign_name',$campaignName)->first();
        // print_r($campaignNameExists['campaign_name']);

        if ($this->model->isCampaignExists($campaignName)) {
            session()->setFlashData('error', 'Campaign Name Exists');
            return redirect()->to('/createcampaignpage');
        } 

        $this->model->createCampaign($campignName, $campaignDescription, $client, $supervisor);
        return redirect()->to('/campaign');
        
    }

    public function geteditcampaign($id) {
        $campaign = $this->model->getCampaignById($id);

        $access_supervisor = $this->users->getUserByRole(2);

        $data['page'] = 'editcampaign';
        $data['data'] = ['supervisors' => $campaign, 'campaigns' => $access_supervisor];
        echo view('template', $data);
        // print_r($user);
        // return view('header').view('editcampaign',['supervisors'=>$supervisor, 'campaigns'=>$data]).view('footer');
    }

    public function editcampaign($id) {
        $campaignName = $this->request->getPost('campaignname');
        $campaignDescription = $this->request->getPost('description');
        $client = $this->request->getPost('client');
        $supervisor = $this->request->getPost('supervisor');
        // print_r($id);
        $this->model->updateCampaign($id, $campignName, $campaignDescription, $client, $supervisor);
        return redirect()->to('/campaign');
    }

    public function deletecampaign($id) {
        $this->model->deleteCampaign($id);
        return redirect()->to('/campaign');
    }
}
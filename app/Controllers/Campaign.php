<?php

namespace App\Controllers;
use App\Models\Users;
use App\Models\Campaigns;

class Campaign extends BaseController
{
    public function __construct() {
        $this->model = new Campaigns();
    }

    public function campaignpage() {
        $pager = service('pager');

        $users = new Users();
        $access_supervisor = $users->where('role',2)->find();

        $filterSupervisor = $this->request->getGet('filterSupervisor');
        $filterCampaignName = $this->request->getGet('searchCampaignName');
        $filterClient = $this->request->getGet('searchClient');

        $query = $this->model;
        if($filterCampaignName) {
            $query->like('campaign_name', "$filterCampaignName%", 'after');
        }
        if($filterClient) {
            $query->like('client', "$filterClient%", 'after');
            }
        if($filterSupervisor) {
            $query->where('supervisor', $filterSupervisor);
        }
        $campaigns = $this->model->paginate(3);
        $data['page'] = 'campaign';
        $data['data'] = ['campaigns' => $campaigns, 'filteraccess' => $access_supervisor];
        $data['pager'] = $this->model->pager;

        echo view('template', $data);
    
        // return view('header').
        //        view('campaign',['campaigns' => $campaigns]).
        //        view('footer');
    }

    public function createcampaign() {
        $users = new Users();
        $access_supervisor = $users->where('role',2)->find();
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

        if ($campaignNameExists) {
            session()->setFlashData('error', 'Campaign Name Exists');
            return redirect()->to('/createcampaignpage');
        } else {

            $data = $this->model->save([
                'campaign_name' => $campaignName,
                'description' => $campaignDescription,
                'client' => $client,
                'supervisor' => $supervisor
            ]);

            return redirect()->to('/campaign');
        }
    }

    public function geteditcampaign($id) {
        $supervisor = $this->model->where('camp_id',$id)->first();

        $users = new Users();
        $access_supervisor = $users->where('role',2)->find();

        $data['page'] = 'editcampaign';
        $data['data'] = ['supervisors'=>$supervisor, 'campaigns'=>$access_supervisor];
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
        $this->model->update($id, [
            'campaign_name' => $campaignName,
            'description' => $campaignDescription,
            'client' => $client,
            'supervisor' => $supervisor
        ]);
        return redirect()->to('/campaign');
    }

    public function deletecampaign($id) {
        $this->model->delete($id);
        return redirect()->to('/campaign');
    }
}
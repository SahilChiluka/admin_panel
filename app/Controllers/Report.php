<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Report extends BaseController {

    public function curlRequest($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($curl), true);
        return $response;
    }

    public function postCurlRequest($url, $data) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $response = curl_exec($ch);
        return $response;
    }

    public function index($id) {
        $pager=service('pager');

        if($id == 'sql') {
            $url = 'http://localhost:3000/mysql/get/overallReport';
        } else if ($id == 'mongo') {
            $url = 'http://localhost:5000/mongo/get/overallReport';
        } else {
            $url = 'http://localhost:8000/elasticsearch/get/overallReport';
        }

        $response = $this->curlRequest($url);
        // print_r($response);
        $callType = [];
        $disposeType = [];
        foreach($response as $data) {
            if(!in_array($data['callType'],$callType)) {
                array_push($callType, $data['callType']);
            }
            if($data['disposeType'] != 'null') {
                if(!in_array($data['disposeType'],$disposeType)) {
                    array_push($disposeType, $data['disposeType']);
                } 
            } 
        }
        // print_r($callType);

        $agentName = $this->request->getVar('agentName');
        $campaignName = $this->request->getVar('campaignName');
        $processName = $this->request->getVar('processName');
        $leadsetId = $this->request->getVar('leadsetId');
        $calltype = $this->request->getVar('callType');
        $disposetype = $this->request->getVar('disposeType');

        $data = [];
        if($agentName || $campaignName || $processName || $leadsetId || $calltype || $disposetype) {
            // $data = [];
            !empty($agentName) ? $data['agentName'] = $agentName : null;
            !empty($campaignName) ? $data['campaignName'] = $campaignName : null;
            !empty($processName) ? $data['processName'] = $processName : null;
            !empty($leadsetId) ? $data['leadsetID'] = (int)$leadsetId : null;
            !empty($calltype) ? $data['callType'] = $calltype : null;
            !empty($disposetype) ? $data['disposeType'] = $disposetype : null;

            if($id == 'sql') {
                $url = 'http://localhost:3000/mysql/filter';
            } else if ($id == 'mongo') {
                $url = 'http://localhost:5000/mongo/filter';
            } else {
                $url = 'http://localhost:8000/elasticsearch/filter';
            }

            $response = $this->postCurlRequest($url, $data);
            $response = json_decode($response, true); 
        }
 
        // pagination
        $page= $this->request->getVar('page') ? (int)$this->request->getVar('page') : 1; //limit  ie ?page=1 would be set to page=0;
        $perPage =  5;
        $total = count($response);
        $perPageData = array_slice($response, $page*$perPage, $perPage);
        $pager->makeLinks($page,$perPage,$total);
        // echo $page;

        $data['page'] = 'reports';
        $data['data'] = ['calls' => $perPageData, 'callType' => $callType, 'disposeType' => $disposeType];
        $data['pager'] = $pager;
        $data['nid'] = $id;
        echo view('template',$data);
        // print_r($data);

    }

    public function hourly($id) {
        if($id == 'sql') {
            $url = 'http://localhost:3000/mysql/get/hourlyReport';
        } else if ($id == 'mongo') {
            $url = 'http://localhost:5000/mongo/get/hourlyReport';
        } else {
            $url = 'http://localhost:8000/elasticsearch/get/hourlyReport';
        }

        $response = $this->curlRequest($url);

        $data['page'] = 'hourlyReports';
        $data['data'] = ['hourlyCalls' => $response];
        $data['nid'] = $id;
        echo view('template',$data);

    }

    public function downloadLogger($id) {

        if($id == 'sql') {
            $url = 'http://localhost:3000/mysql/get/overallReport';
        } else if ($id == 'mongo') {
            $url = 'http://localhost:5000/mongo/get/overallReport';
        } else {
            $url = 'http://localhost:8000/elasticsearch/get/overallReport';
        }
        // echo $id;
        $filename = 'Logger_Data_'. $id . date('Ymd') . '.csv';

        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; ");

        $response = $this->curlRequest($url);

        $file = fopen('php://output', 'w');

        for($i=0; $i < 1; $i++) {
            $headers = array_keys($response[$i]);
        }

        // $header = array("ID", "Agent Name","Campaign Name", "Process Name", "Leadset ID", "Reference UUID", "Customer UUID", 
        // "Call Type", "Ringing", "Call", "Hold", "Mute", "Transfer", "Conference", "Duration", "Dispose Time", "Dispose Type", "Dispose Name", "Date Time");

        fputcsv($file, $headers);

        foreach ($response as $call) {
            fputcsv($file, array($call['id'],$call['agentName'],$call['campaignName'],$call['processName'],
                $call['leadsetID'],$call['referenceUUID'],$call['customerUUID'],$call['callType'],
                gmdate('H:i:s',$call['ringing']),gmdate('H:i:s',$call['callTime']),gmdate('H:i:s',$call['hold']),
                gmdate('H:i:s',$call['mute']),gmdate('H:i:s',$call['transfer']),gmdate('H:i:s',$call['conference']),
                gmdate('H:i:s',$call['duration']),gmdate('H:i:s',$call['disposeTime']),$call['disposeType'],$call['disposeName'],
                date('Y-m-d H:i:s',timestamp: strtotime($call['datetime']))));
        }

        fclose($file);
    }

    public function downloadHourlyReport($id) {

        if($id == 'sql') {
            $url = 'http://localhost:3000/mysql/get/hourlyReport';
        } else if ($id == 'mongo') {
            $url = 'http://localhost:5000/mongo/get/hourlyReport';
        } else {
            $url = 'http://localhost:8000/elasticsearch/get/hourlyReport';
        }
        
        $response = $this->curlRequest($url);
        // print_r($response);

        $filename = 'HourlyCalls_Data_'. $id . date('Ymd') . '.csv';

        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; ");
 
        $file = fopen('php://output', 'w');

        for($i=0; $i < 1; $i++) {
            $headers = array_keys($response[$i]);
        }

        // $header = array("Date", "Hour", "Total Calls", "Total Duration", "Total Call Time", "Total Hold Time",
        // "Total Mute Time", "Total Transfer Time", "Total Conference Time", "Total Ringing Time");

        fputcsv($file, $headers);

        foreach($response as $calls) {
            fputcsv($file, array($calls['hour'],$calls['call_count'],
            gmdate('H:m:s',$calls['total_ringing']),gmdate('H:m:s',$calls['total_calltime']),
            gmdate('H:m:s',$calls['total_hold']),gmdate('H:m:s',$calls['total_mute']),
            gmdate('H:m:s',$calls['total_transfer']),gmdate('H:m:s',$calls['total_conference']),
            gmdate('H:m:s',$calls['total_duration'])));
        } 

        fclose($file);
    }

    // public function filter($id) {
    //     $pager=service('pager');
        
    //     $url = 'http://localhost:3000/mysql/filter';

    //     $agentName = $this->request->getVar('agentName');
    //     $campaignName = $this->request->getVar('campaignName');
    //     $processName = $this->request->getVar('processName');
    //     $leadsetId = $this->request->getVar('leadsetId');
    //     $callType = $this->request->getVar('callType');
    //     $disposeType = $this->request->getVar('disposeType');

    //     $data = [];

    //     !empty($agentName) ? $data['agentName'] = $agentName : null;
    //     !empty($campaignName) ? $data['campaignName'] = $campaignName : null;
    //     !empty($processName) ? $data['processName'] = $processName : null;
    //     !empty($leadsetId) ? $data['leadsetId'] = $leadsetId : null;
    //     !empty($callType) ? $data['callType'] = $callType : null;
    //     !empty($disposeType) ? $data['disposeType'] = $disposeType : null;

    //     $response = $this->postCurlRequest($url, $data);
    //     $data = json_decode($response, true);
    //     // print_r($data);

    //     $page= $this->request->getVar('page') ? (int)$this->request->getVar('page') : 1; //limit  ie ?page=1 would be set to page=0;
    //     $perPage =  5;
    //     $total = count($data);

    //     $perPageData = array_slice($data, $page*$perPage, $perPage);
    //     $pager->makeLinks($page,$perPage,$total);
    //     // echo $page;
    //     $data['page'] = 'reports';
    //     $data['data'] = ['calls' => $perPageData, 'callType' => $callType, 'disposeType' => $disposeType];
    //     $data['pager'] = $pager;
    //     $data['nid'] = $id;
    //     echo view('template',$data); 
    // }

}

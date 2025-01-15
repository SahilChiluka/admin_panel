<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Report extends BaseController {
    public function index() {
        $pager=service('pager');

        $curl = curl_init();
        $url = 'http://localhost:3000/mysql/get/overallReport';
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($curl), true);

        $page= (int) (($this->request->getVar('page') !== null) ? $this->request->getVar('page'):1) - 1; //limit  ie ?page=1 would be set to page=0;
        $perPage =  7;
        $total = count($response);

        $perPageData = array_slice($response, $page*$perPage, $perPage);

        $pager->makeLinks($page,$perPage,$total);
        // echo $page;
        $data['page'] = 'overallReport';
        $data['data'] = ['calls' => $perPageData];
        $data['pager'] = $pager;
        echo view('template',$data); 
    }

    public function sqlhourly() {
        $curl = curl_init();
        $url = 'http://localhost:3000/mysql/get/hourlyReport';
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($curl), true);
        $data['page'] = 'hourlyReport';
        $data['data'] = ['hourlyCalls' => $response];
        echo view('template',$data);
    }

    public function mongoHourly() {
        $curl = curl_init();
        $url = 'http://localhost:5000/mongo/get/hourlyReport';
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($curl), true);
        // print_r($response);
        $data['page'] = 'mongoHourlyReport';
        $data['data'] = ['hourlyCalls' => $response];
        echo view('template',$data);
    }

    public function elasticHourly() {
        $curl = curl_init();
        $url = 'http://localhost:8000/elasticsearch/get/hourlyReport';
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($curl), true);
        // print_r($response['aggregations']['group_by_hour']['buckets']);
        $response = $response['aggregations']['group_by_hour']['buckets'];
        $data['page'] = 'elasticHourlyReport';
        $data['data'] = ['hourlyCalls' => $response];
        echo view('template',$data);
    }

    public function downloadOverall() {
        $filename = 'Allcalls_data' . date('Ymd') . '.csv';

        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; ");

        // get data 
        $curl = curl_init();
        $url = 'http://localhost:3000/mysql/get/overallReport';
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($curl), true);

        // file creation 
        $file = fopen('php://output', 'w');

        $header = array("ID", "Agent Name","Campaign Name", "Process Name", "Leadset ID", "Reference UUID", "Customer UUID", 
        "Call Type", "Ringing", "Call", "Hold", "Mute", "Transfer", "Conference", "Duration", "Dispose Time", "Dispose Type", "Dispose Name", "Date Time");

        fputcsv($file, $header);

        foreach ($response as $key => $line) {
            fputcsv($file, $line);
        }

        fclose($file);
    }

    public function downloadSqlHourlyReport() {
        // get data 
        $curl = curl_init();
        $url = 'http://localhost:3000/mysql/get/hourlyReport';
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($curl), true);
        // print_r($response);

        $hourlyData = [];
        foreach($response as $i => $value) {
            foreach ($value as $key => $val) {
                if($key == 'date') {
                    $hourlyData[$i][$key] = date('Y-m-d', timestamp: strtotime($val));
                }
                if($key == 'hour') {
                    $hourlyData[$i][$key] = date('h', timestamp: strtotime($val)) . "-" . date('h', timestamp: strtotime($val)) + 1;
                }
                if($key == 'total_calls') {
                    $hourlyData[$i][$key] = $val;
                }
                if($key == 'total_ringing_time') {
                    $hourlyData[$i][$key] = gmdate('H:m:s',$val);
                }
                if($key == 'total_call_time') {
                    $hourlyData[$i][$key] = gmdate('H:m:s',$val);
                }
                if($key == 'total_hold_time') {
                    $hourlyData[$i][$key] = gmdate('H:m:s',$val);
                }
                if($key == 'total_mute_time') {
                    $hourlyData[$i][$key] = gmdate('H:m:s',$val);
                }
                if($key == 'total_transfer_time') {
                    $hourlyData[$i][$key] = gmdate('H:m:s',$val);
                }
                if($key == 'total_conference_time') {
                    $hourlyData[$i][$key] = gmdate('H:m:s',$val);
                }
                if($key == 'total_duration') {
                    $hourlyData[$i][$key] = gmdate('H:m:s',$val);
                }
            }
        }
        // print_r($hourlyData);

        $filename = 'SqlHourlyCalls_data' . date('Ymd') . '.csv';

        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; ");

        // file creation 
        $file = fopen('php://output', 'w');

        $header = array("Date", "Hour", "Total Calls", "Total Duration", "Total Call Time", "Total Hold Time",
        "Total Mute Time", "Total Transfer Time", "Total Conference Time", "Total Ringing Time");

        fputcsv($file, $header);

        foreach($hourlyData as $key => $value) {
            fputcsv($file, $value);
        } 

        fclose($file);
    }

    public function downloadMongoHourlyReport() {
        // get data 
        $curl = curl_init();
        $url = 'http://localhost:5000/mongo/get/hourlyReport';
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($curl), true);
        //print_r($response);

        $hourlyData = [];
        foreach($response as $i => $value) {
            foreach ($value as $key => $val) {
                if($key == 'hour') {
                    $hourlyData[$i][$key] = $val;
                }
                if($key == 'call_count') {
                    $hourlyData[$i][$key] = $val;
                }
                if($key == 'total_ringing') {
                    $hourlyData[$i][$key] = gmdate('H:m:s',$val);
                }
                if($key == 'total_calltime') {
                    $hourlyData[$i][$key] = gmdate('H:m:s',$val);
                }
                if($key == 'total_hold') {
                    $hourlyData[$i][$key] = gmdate('H:m:s',$val);
                }
                if($key == 'total_mute') {
                    $hourlyData[$i][$key] = gmdate('H:m:s',$val);
                }
                if($key == 'total_transfer') {
                    $hourlyData[$i][$key] = gmdate('H:m:s',$val);
                }
                if($key == 'total_conference') {
                    $hourlyData[$i][$key] = gmdate('H:m:s',$val);
                }
                if($key == 'total_duration') {
                    $hourlyData[$i][$key] = gmdate('H:m:s',$val);
                }
            }
        }
        // print_r($hourlyData);

        $filename = 'MongoHourlyCalls_data' . date('Ymd') . '.csv';

        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; ");

        // file creation 
        $file = fopen('php://output', 'w');

        $header = array("Total Calls", "Total Duration", "Total Call Time", "Total Hold Time",
        "Total Mute Time", "Total Transfer Time", "Total Conference Time", "Total Ringing Time","Hour");

        fputcsv($file, $header);

        foreach($hourlyData as $key => $value) {
            fputcsv($file, $value);
        } 

        fclose($file);
    }
}

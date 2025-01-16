<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="<?= base_url('assets/css/bootstrap_min.css') ?>" rel="stylesheet"  crossorigin="anonymous">
    <!-- <link href="<?= base_url('assets/css/bootstrap4.css') ?>" rel="stylesheet" crossorigin="anonymous"> -->
    <link href="<?= base_url('assets/css/select2_min.css') ?>" rel="stylesheet" />
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
    <script src="<?= base_url('assets/js/bootstrap_bundle_min.js') ?>" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/js/jquery_min.js') ?>"></script>
    <link rel="stylesheet" href="<?= base_url('assets/css/fontAwesome.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-light">
  <div class="container-fluid">
    <p class="navbar-brand">SlashRTC</p>
    <div class="collapse navbar-collapse justify-content-end">
      <div class="dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?= session('name') ?>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="<?= base_url('Home/logout') ?>">Logout</a></li>
        </ul>
      </div>
    </div>
  </div>
</nav>

<div class="d-flex gap-4 align-items-center justify-content-center">
    <a class="link" href="<?= base_url('/') ?>">Dashboard</a>
    <a class="link" href="<?= base_url('/') ?>">Live</a>

    <div class="report-menu">
      <a class="link" href="#">Report</a>
      <ul class="report-list">
        <div class="nested-menu">
         <li><a href="#">Logger</a>
            <ul class="nested-list">
              <li><a href="<?= base_url('Report/index/sql') ?>">SQL Logger Report</a></li>
              <li><a href="<?= base_url('Report/index/mongo') ?>">Mongo Logger Report</a></li>
              <li><a href="<?= base_url('Report/index/elastic') ?>">Elastic Logger Report</a></li>
            </ul>
         </li>
        </div>
        <div class="nested-menu">
          <li><a href="#">Hourly</a>
            <ul class="nested-list">
              <li><a href="<?= base_url('Report/hourly/sql') ?>">SQL Hourly Report</a></li>
              <li><a href="<?= base_url('Report/hourly/mongo') ?>">Mongo Hourly Report</a></li>
              <li><a href="<?= base_url('Report/hourly/elastic') ?>">Elastic Hourly Report</a></li>
            </ul>
          </li>
        </div>
      </ul>
    </div>

    <a class="link" href="<?= base_url('/') ?>">Conversations</a>
    <a class="link" href="<?= base_url('/') ?>">Contacts</a>

    <div class="operations-menu">
        <a class="link" href="#">Operations</a>
        <ul class="operations-list">
            <li><a href="<?= base_url('Home/userpage') ?>">Users</a></li>
            <li><a href="<?= base_url('Campaign/index') ?>">Campaigns</a></li>
            <li><a href="<?= base_url('ChatController/Chat') ?>">Chat</a></li>
        </ul>
    </div>
    
    <a class="link" href="<?= base_url('/') ?>">Advanced Settings</a>
</div>
<div class="container">
    <div class="d-flex gap-3">
        <h4>Calls</h4>
        <a href="<?= base_url('/Report/downloadLogger/').$nid ?>">Download</a>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
            Filter
        </button>
    </div>
        <table class="table table-bordered">
            <thead class="thead-light" style="font-size: 12px;">
                <tr>
                    <th>Agent Name</th>
                    <th>Campaign Name</th>
                    <th>Process Name</th>
                    <th>Leadset ID</th>
                    <th>Reference UUID</th>
                    <th>Customer UUID</th>
                    <th>Call Type</th>
                    <th>Ringing</th>
                    <th>Call</th>
                    <th>Hold</th>
                    <th>Mute</th>
                    <th>Transfer</th>
                    <th>Conference</th>
                    <th>Duration</th>
                    <th>Dispose Time</th>
                    <th>Dispose Type</th>
                    <th>Dispose Name</th>
                    <th>Date Time</th>
                </tr>
            </thead>
            <tbody style="font-size: 12px;">
                <?php foreach($calls as $call) { ?>
                    <tr>
                        <td><?= $call['agentName']; ?></td>
                        <td><?= $call['campaignName']; ?></td>
                        <td><?= $call['processName']; ?></td> 
                        <td><?= $call['leadsetID']; ?></td>
                        <td><?= $call['referenceUUID']; ?></td> 
                        <td><?= $call['customerUUID']; ?></td>
                        <td><?= $call['callType']; ?></td>
                        <td><?= gmdate('H:i:s',$call['ringing']); ?></td>
                        <td><?= gmdate('H:i:s',$call['callTime']); ?></td>
                        <td><?= gmdate('H:i:s',$call['hold']); ?></td>
                        <td><?= gmdate('H:i:s',$call['mute']); ?></td>
                        <td><?= gmdate('H:i:s',$call['transfer']); ?></td>
                        <td><?= gmdate('H:i:s',$call['conference']); ?></td>
                        <td><?= gmdate('H:i:s',$call['duration']); ?></td>
                        <td><?= gmdate('H:i:s',$call['disposeTime']); ?></td>
                        <td><?= $call['disposeType']; ?></td>
                        <td><?= $call['disposeName']; ?></td>
                        <td><?= date('Y-m-d H:i:s',timestamp: strtotime($call['datetime'])); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            <?= $pager->links() ?>
        </div>
    </div>


<!-- Filter -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Filter</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
            <form action="<?= base_url('Report/index/').$nid ?>" method="GET">
                <input type="search" name="agentName" placeholder="Search By Agent Name" size="30">
                <br>
                <br>
                <input type="search" name="campaignName" placeholder="Search By Campaign Name" size="30">
                <br>
                <br>
                <input type="search" name="processName" placeholder="Search By Process Name" size="30">
                <br>
                <br>
                <input type="search" name="leadsetId" placeholder="Search By Leadset ID" size="30">
                <br>
                <br>
                <select name="callType" id="">
                    <option value="">Select Call Type</option>
                    <?php for ($i=0; $i<count($callType); $i++) { ?>
                        <option value="<?= $callType[$i]; ?>"><?= $callType[$i]; ?> </option>
                    <?php } ?>
                </select>
                <br>
                <br>
                <select name="disposeType" id="">
                    <option value="">Select Dispose Type</option>
                    <?php for ($i=0; $i<count($disposeType); $i++) { ?>
                        <option value="<?= $disposeType[$i]; ?>"><?= $disposeType[$i]; ?> </option>
                    <?php } ?>
                </select>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
      </form>
    </div>
    </div>
  </div>
</div>
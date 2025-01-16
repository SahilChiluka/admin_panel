<div class="container">
    <div class="d-flex gap-3">
        <h4>Calls</h4>
        <a href="<?= base_url('/Report/downloadLogger/').$nid ?>">Download</a>
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
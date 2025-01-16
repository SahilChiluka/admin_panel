<div class="container">
<div class="d-flex gap-3">
        <h4>Hourly Calls Report</h4>
        <a href="<?= base_url('/Report/downloadHourlyReport/').$nid ?>">Download</a>
    </div>
        <table class="table table-bordered">
            <thead class="thead-light" style="font-size: 12px;">
                <tr>
                    <th>Hour</th>
                    <th>Total Calls</th>
                    <th>Total Ringing Time</th>
                    <th>Total Call Time</th>
                    <th>Total Hold Time</th>
                    <th>Total Mute Time</th>
                    <th>Total Transfer Time</th>
                    <th>Total Conference Time</th>
                    <th>Total Duration</th>
                </tr>
            </thead>
            <tbody style="font-size: 12px;">
                <?php foreach($hourlyCalls as $calls) { ?>
                    <tr>
                        <td><?= $calls['hour'] ."-".$calls['hour']+1?></td>
                        <td><?= $calls['call_count']; ?></td> 
                        <td><?= gmdate('H:i:s',$calls['total_ringing']); ?></td>
                        <td><?= gmdate('H:i:s',$calls['total_calltime']); ?></td> 
                        <td><?= gmdate('H:i:s',$calls['total_hold']); ?></td>
                        <td><?= gmdate('H:i:s',$calls['total_mute']); ?></td>
                        <td><?= gmdate('H:i:s',$calls['total_transfer']); ?></td>
                        <td><?= gmdate('H:i:s',$calls['total_conference']); ?></td>
                        <td><?= gmdate('H:i:s',$calls['total_duration']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
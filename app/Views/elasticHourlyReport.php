<div class="container">
    <div class="d-flex gap-3">
        <h4>Hourly Calls Report</h4>
        <a href="<?= base_url('/Report/downloadElasticHourlyReport') ?>">Download</a>
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
                        <td><?= gmdate('H', ($calls['key']/1000)) ?> - <?= gmdate('H', ($calls['key']/1000))+1 ?></td>
                        <td><?= $calls['doc_count'] ?></td>
                        <td><?= gmdate('H:m:s',$calls['total_ringing']['value']) ?></td>
                        <td><?= gmdate('H:m:s',$calls['total_calltime']['value']) ?></td>
                        <td><?= gmdate('H:m:s',$calls['total_hold']['value']) ?></td>
                        <td><?= gmdate('H:m:s',$calls['total_mute']['value']) ?></td>
                        <td><?= gmdate('H:m:s',$calls['total_transfer']['value']) ?></td>
                        <td><?= gmdate('H:m:s',$calls['total_conference']['value']) ?></td>
                        <td><?= gmdate('H:m:s',$calls['total_duration']['value']) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
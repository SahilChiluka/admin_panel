<div class="container">
        <h4>Hourly Calls</h4>
        <table class="table table-bordered">
            <thead class="thead-light" style="font-size: 12px;">
                <tr>
                    <th>Date</th>
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
                        <td><?= date('Y-m-d', timestamp: strtotime($calls['date'])) ?></td>
                        <td><?= date('h', timestamp: strtotime($calls['hour'])) . "-" . date('h', timestamp: strtotime($calls['hour'])) + 1 ?></td>
                        <td><?= gmdate('H:m:s',$calls['total_calls']); ?></td> 
                        <td><?= gmdate('H:m:s',$calls['total_ringing_time']); ?></td>
                        <td><?= gmdate('H:m:s',$calls['total_call_time']); ?></td> 
                        <td><?= gmdate('H:m:s',$calls['total_hold_time']); ?></td>
                        <td><?= gmdate('H:m:s',$calls['total_mute_time']); ?></td>
                        <td><?= gmdate('H:m:s',$calls['total_transfer_time']); ?></td>
                        <td><?= gmdate('H:m:s',$calls['total_conference_time']); ?></td>
                        <td><?= gmdate('H:m:s',$calls['total_duration']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
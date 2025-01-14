<div class="container">
        <h4>Calls</h4>
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
                        <td><?php echo $call['agentName']; ?></td>
                        <td><?php echo $call['campaignName']; ?></td>
                        <td><?php echo $call['processName']; ?></td> 
                        <td><?php echo $call['leadsetID']; ?></td>
                        <td><?php echo $call['referenceUUID']; ?></td> 
                        <td><?php echo $call['customerUUID']; ?></td>
                        <td><?php echo $call['callType']; ?></td>
                        <td><?php echo $call['ringing']; ?></td>
                        <td><?php echo $call['callTime']; ?></td>
                        <td><?php echo $call['hold']; ?></td>
                        <td><?php echo $call['mute']; ?></td>
                        <td><?php echo $call['transfer']; ?></td>
                        <td><?php echo $call['conference']; ?></td>
                        <td><?php echo $call['duration']; ?></td>
                        <td><?php echo $call['disposeTime']; ?></td>
                        <td><?php echo $call['disposeType']; ?></td>
                        <td><?php echo $call['disposeName']; ?></td>
                        <td><?php echo $call['datetime']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
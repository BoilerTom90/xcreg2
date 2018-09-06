<br/>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="btn-group">
                    <a class="btn btn-primary" href="EventsAddForm.php">Add Event</a>
            </div>
        </div>
    </div>
    <div class="row"></br></div>
</div>

<div class="container">
<div class="panel panel-primary">
<div class="panel-heading">Event Listing</div>
<div class="panel-body">
    <div class="row">
        <div class="col-xs-12">
            <?php DisplayStatusMessage($status_msg); ?>
            <div class="table-responsive">
                <table class="table table-condensed table-bordered table-hover set-bg" id="sortable-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Operation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                           $eventsObj = new EventsTable();
                           $events = $eventsObj->ReadAll();
                           if (!empty($events)) {
                              foreach ($events as $ev) {
                                 $ev_id = $ev['id'];
                                 echo "<tr>";
                                 echo "<td>" . $ev['ev_name'] . "</td>";
                                 echo "<td>" . $ev['ev_date'] . "</td>";
                                 echo "<td>" . "<a class=\"btn btn-primary btn-xs\" href=\"EventsModifyForm.php?event_id=$ev_id\">Click to Manage</a>" . "</td>";
                                 echo "</tr>";
                              }
                           }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> <!-- panel-body -->
</div> <!-- panel default -->
</div>


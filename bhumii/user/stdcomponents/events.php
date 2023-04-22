<?php
$dashBoardJson = json_decode(file_get_contents("../json/dashboard.json"), true);
?>
<div class="p-2">
    <section class="container mt-4 card">
        <h3 class="text-center">Class Recordings</h3>
        <div class="table-responsive">
            <table class="table mt-4">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Events</th>
                        <th scope="col">Date</th>
                        <th scope="col">Mentor</th>
                        <th scope="col">Link</th>
                        <th scope="col">Recordings</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for ($i = 0; $i < count($dashBoardJson['events']); $i++) {
                        echo "<tr>";
                        echo "<td>" . ($i + 1) . "</td>";
                        echo "<td>" . $dashBoardJson['events'][$i]['event'] . "</td>";
                        echo "<td>" . $dashBoardJson['events'][$i]['date'] . "</td>";
                        echo "<td>" . $dashBoardJson['events'][$i]['mentor'] . "</td>";
                        echo "<td><a href='" . $dashBoardJson['events'][$i]['link'] . "' target='_blank' class='btn btn-success'>Buy</a></td>";
                        echo "<td><a href='" . $dashBoardJson['events'][$i]['recording'] . "' target='_blank' class='btn btn-success'>View</a></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
</div>
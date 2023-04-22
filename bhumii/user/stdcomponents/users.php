<?php
include "../constant.php";
$allJson = json_decode(file_get_contents('../json/users.json'), true);
?>
<div class="p-2">
    <div class="white-box text-end">
        <a href="<?= $baseUrl ?>" class="newPreLoadContent btn btn-success text-white" data-load="addUser.php">
            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 32 32">
                <path fill="currentColor" d="M17 15V8h-2v7H8v2h7v7h2v-7h7v-2z" />
            </svg>
            Add new user
        </a>
    </div>
    <div class="white-box">
        <div class="d-md-flex mb-3">
            <h3 class="box-title mb-0">Users</h3>
        </div>
        <div class="table-responsive">
            <table class="table no-wrap" id="bDataTable">
                <thead>
                    <tr>
                        <th class="border-top-0">#</th>
                        <th class="border-top-0">Name</th>
                        <th class="border-top-0">Username</th>
                        <th class="border-top-0">Phone</th>
                        <th class="border-top-0">Course</th>
                        <th class="border-top-0">Created at</th>
                        <th class="border-top-0">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($allJson as $key => $value) {
                        $i++;
                        echo '<tr>';
                        echo '<td>' . $i . '</td>';
                        echo '<td>' . $value['name'] . '</td>';
                        echo '<td>' . $value['email'] . '</td>';
                        echo '<td>' . ($value['phone'] == '' ? '-' : $value['phone']) . '</td>';
                        echo '<td>' . $value['course'] . '</td>';
                        echo '<td>' . date("d-m-Y", strtotime($value['created_at'])) . '</td>';
                        echo '<td class="p-1">
                            <a href="#" class="newPreLoadContent btn btn-danger text-white" data-load="editUser.php?id=' . $key . '">
                                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="20px" height="20px" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="currentColor" d="m18.988 2.012l3 3L19.701 7.3l-3-3zM8 16h3l7.287-7.287l-3-3L8 13z"/><path fill="currentColor" d="M19 19H8.158c-.026 0-.053.01-.079.01c-.033 0-.066-.009-.1-.01H5V5h6.847l2-2H5c-1.103 0-2 .896-2 2v14c0 1.104.897 2 2 2h14a2 2 0 0 0 2-2v-8.668l-2 2V19z"/></svg>
                            </a>
                        </td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(".newPreLoadContent").off("click").on("click", function(e) {
        e.preventDefault();
        console.log("clicked");
        var $this = $(this);
        var $dataLoad = $(this).data("load");
        if ($dataLoad) {
            $(".preloader").show();
            $.ajax({
                url: `components/${$dataLoad}`,
                success: function(data) {
                    $(".preloader").hide();
                    $("#dynamic-content").html(data);
                },
            });
        }
    });
</script>
<?php
$db = new Connection();
$conn = $db->getConnection();
if ($classId != "0") {
    $sql = "SELECT * FROM `class` WHERE `id` = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $classId);
    $stmt->execute();
    $class = $stmt->fetch();
    $sql = "SELECT * FROM lesson where classid=:classid";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':classid', $classId);
    $stmt->execute();
    $lessons = $stmt->fetchAll();
?>
    <div class="p-2">
        <section class="white-box card">
            <div class="row">
                <div class="col-md-6 gx-5 mb-4">
                    <div class="bg-image hover-overlay ripple shadow-2-strong" data-mdb-ripple-color="light">
                        <img src="<?php echo "/user/admin/uploads/images/" . $class['images']  ?>" alt="" class="img-fluid" />
                    </div>
                </div>
                <div class="col-md-6 gx-5 mb-4">
                    <h4><strong>Hello <?php // echo $_SESSION['fullname']; ?></strong></h4>
                    <p class="text-muted">
                        <strong>
                            <?php echo $class['title']; ?>
                        </strong>
                    </p>
                    <?php
                    echo htmlspecialchars_decode($class['content']);
                    ?>
                </div>
            </div>
        </section>
    </div>
    <div class="p-2">
        <section class="white-box card">
            <h4 class="mb-5"><strong>Course Modules</strong></h4>
            <div class="row">
                <?php
                for ($i = 0; $i < count($lessons); $i++) {
                ?>
                    <div class="col-lg-4 col-sm-6 mb-4">
                        <div class="card">
                            <div class="bg-image hover-overlay ripple" style="width: 100%">
                                <iframe style="width: 100%;height: 100%;min-height: 250px" id="video" src="<?php echo getEmbedLink($lessons[$i]['youtube']) ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $lessons[$i]['title'] ?></h5>
                                <p class="card-text">
                                    <?php echo htmlspecialchars_decode($lessons[$i]['content']) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </section>
    </div>
<?php
}

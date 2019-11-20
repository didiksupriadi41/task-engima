<div class="content">
    <div class="container">
        <div class="detail-wrapper">
            <div class="row">
                <div class="col-2">
                    <?php
                        echo ($data["movie"]["poster"] == null) ?
                        '<img class="detail-poster" src="'. BASEURL .'img/no_img_placeholder.jpg">' :
                        '<img class="detail-poster" src="'
                        . $data["movie"]["poster"]
                        .'">';
                    ?>
                    <!-- <img src=<?php echo $data["movie"]["poster"] ?> 
                        class="detail-poster"
                    > -->
                </div>
                <div class="col-6 detail-detail px-auto">
                    <div class="detail-title">
                        <?php echo $data["movie"]["title"] ?>
                    </div>
                        <div class="detail-stats">
                            <?php $categories = array();
                            foreach ($data["movie"]["category"] as $category) {
                                $categories[] = $category["name"];
                            }
                                echo implode(", ", $categories);
                            ?> | <?php echo $data["movie"]["duration"] ?> mins
                        </div>
                        <div class="detail-date">
                            Release date: 
                            <?php $date = date_create($data["movie"]["release"]);
                                echo date_format($date, "d F, Y")?>
                        </div>
                        <!-- <?php
                        if ($data['key']) {
                            echo '<a href="https://www.youtube.com/watch?v=' . $data["key"].
                            '" target="_blank">Link to Trailer</a>';
                        } else {
                            echo '<p>No trailer found</p>';
                        }
                        ?> -->
                        <div class="row double-rating">
                            <div class="detail-rating">
                                <img src=<?php echo BASEURL . "img/star.png" ?> 
                                width="20" height="20">
                                <span><?php echo $data["movie"]["ratingDB"] ?></span> 
                                /10 (TheMovieDB)
                            </div>
                            <div class="detail-rating">
                                <img src=<?php echo BASEURL . "img/star.png" ?> 
                                width="20" height="20">
                                <span><?php echo $data["movie"]["ratingUSER"] ?></span> 
                                /10 (User Rating)
                            </div>
                        </div>
                        <div class="detail-desc">
                            <p><?php echo $data["movie"]["description"] ?></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="detail-box">
                            <div class="detail-box-content">
                                <h3>Schedules</h3>
                                <div class="row">
                                    <div class="col-3">Date</div>
                                    <div class="col-2">Time</div>
                                    <div class="col-3">Available Seats</div>
                                </div>
                                <?php
                                foreach ($data["schedule"] as $movie) {
                                    $dateTime = explode(' ', $movie["dateTime"]);
                                    $dateBefore = date_create($dateTime[0]);
                                    $date = date_format($dateBefore, "d F, Y");
                                    $seats = $movie["seatsLeft"];
                                    ?>
                                <hr>
                                <div class="row">
                                    <div class="col-3"><?php echo $date ?></div>
                                    <div class="col-2">
                                    <?php
                                        echo date(
                                            "h:i A",
                                            strtotime($dateTime[1])
                                        )
                                    ?>
                                    </div>
                                    <div class="col-2 col-seat">
                                        <span><?php echo $seats ?> seats</span>
                                    </div>
                                <div class="col-3">
                                    <?php
                                        date_default_timezone_set('Asia/Jakarta');
                                    if ($seats == 0
                                        || strtotime($movie["dateTime"]) < time()
                                    ) {
                                        ?>
                                    <div class="detail-availability">
                                        <span>Not Available</span> 
                                        <img src=<?php echo BASEURL .
                                        "img/not-available.png" ?>
                                            width="15" height="15">
                                        </div>
                                        <?php
                                    } else {
                                        ?>
                                    <div class="detail-availability">
                                        <a href="buy?<?php echo "schedule-id=" .
                                        $movie["idSchedule"] . "&movie-id=" .
                                        $movie["idMovie"] ?>">
                                            Book Now 
                                            <img src=<?php echo BASEURL .
                                            "img/chevron.png" ?> 
                                                width="15" 
                                                height="15"
                                            >
                                        </a>
                                    </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                                    <?php
                                }
                                ?>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="detail-box">
                        <div class="detail-box-content">
                            <h3>Reviews</h3>
                            <?php
                                $count = count($data["review"]);
                            foreach ($data["review"] as $review) {
                                if (--$count <= 0) {
                                    ?>
                            <div class="row">
                                <div class="col-2">
                                    <img src=<?php echo BASEURL .
                                    $review["picture"] ?> 
                                        class="avatar"
                                    >
                                </div>
                                <div class="col-8 review-detail px-auto">
                                    <div class="review-name">
                                        <?php echo $review["username"] ?>
                                    </div>
                                    <div class="review-rating">
                                        <img width="10" height="10" src=
                                            <?php echo BASEURL . "img/star.png" ?> 
                                        >
                                        <span> 
                                            <?php echo $review["value"] ?>
                                        </span> 
                                        /10
                                    </div>
                                    <div class="review-content">
                                        <?php echo $review["text"] ?>
                                    </div>
                                </div>
                            </div>
                                    <?php
                                } else {
                                    ?>
                        <div class="row">
                            <div class="col-2">
                                <img src=<?php echo BASEURL . $review["picture"] ?> 
                                    class="avatar"
                                >
                            </div>
                            <div class="col-8 review-detail px-auto">
                                <div class="review-name">
                                    <?php echo $review["username"] ?>
                                </div>
                                <div class="review-rating">
                                    <img src=<?php echo BASEURL . "img/star.png" ?> 
                                        width="10" height="10"
                                    >
                                    <span> <?php echo $review["value"] ?></span> /10
                                </div>
                                <div class="review-content">
                                    <?php echo $review["text"] ?>
                                </div>
                            </div>
                        </div>
                        <hr>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
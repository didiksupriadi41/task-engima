<div class="content">
    <div class="container">
        <h1 class="main-title">Hello, 
            <span><?php echo $data['username']?></span>!
        </h1>
        <h2 class="sub-title">Now Playing</h2>


        <div class="main-movie-wrapper">
            <?php
                $count = count($data['movie']);
                $rowCount = ceil($count/5);
                $i = 0;
            for ($j=0; $j<$rowCount; $j++) {
                echo '<div class="row row-movie">';
                for ($k=0; $k<5 && $i<$count; $k++) {
                    $poster = ($data["movie"][$i]["poster"] == null) ?
                    '<i class="no_image_holder"></i>' :
                    '<img class="home-poster" src="'
                    . $data["movie"][$i]["poster"]
                    .'">';
                    echo '
                        <div class="col-2">
                            <a class="movie-link" href="' . BASEURL . 'movie/detail?id=' .
                                $data["movie"][$i]["idMovie"] . '">
                                <div class="movie-home-wrapper">
                                    <div class="home-poster-wrapper">'
                                        . $poster
                                    . '</div>
                                    <div class="home-movie-title">'.
                                $data["movie"][$i]["title"] .'</div>
                                    <div class="home-rating-wrapper">
                                        <img class="home-star" src="' . BASEURL .
                                            'img/star.png">
                                        <span class="home-rating">'.
                                            $data["movie"][$i]["rating"] .
                                        '</span>
                                    </div>
                                </div>
                            </a>
                        </div>';
                    $i++;
                }
                echo '</div>';
            }
            ?>
            </div>
        </div>
    </div>
</div>

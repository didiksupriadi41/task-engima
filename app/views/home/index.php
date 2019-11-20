<div class="content">
    <div class="container">
        <h1 class="main-title">Hello, 
            <span><?php echo $data['username']?></span>!
        </h1>
        <h2 class="sub-title">Now Playing</h2>

        <div class="main-movie-wrapper" id="main-movie-wrapper-id">
            <?php
                $count = count($data['movie']);
                $rowCount = ceil($count/5);
                $i = 0;
            for ($j=0; $j<$rowCount; $j++) {
                // echo '<div class="row row-movie">';
                for ($k=0; $k<5 && $i<$count; $k++) {
                    $poster = ($data["movie"][$i]["poster"] == null) ?
                    '<img class="home-poster" src="'. BASEURL .'img/no_img_placeholder.jpg">' :
                    // '<i class="no_image_holder"></i>' :
                    '<img class="home-poster" src="'
                    . $data["movie"][$i]["poster"]
                    .'">';
                    // <div class="col-2">
                    echo '
                            <div class="movie-home-wrapper">
                                <a class="movie-link" href="' . BASEURL . 'movie/detail?id=' .
                                    $data["movie"][$i]["idMovie"] . '">
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
                                </a>
                            </div>';
                        // </div>';
                    $i++;
                }
                // echo '</div>';
            }
            ?>
            </div>
            <input 
                id="input-page" 
                type="text" 
                value="<?php echo $data["page"]?>" 
                hidden
            />
            <input 
                id="page-count" 
                type="text" 
                value="<?php echo $data["pageCount"]?>" 
                hidden
            />
            <div id="pagination">
                <button id="btn-prev">Back</button>
                <div id="btn-page-wrapper">
                    <?php
                        $pagination = 5;
                    if ($pagination > (int) $data["pageCount"]) {
                        $pagination = (int) $data["pageCount"];
                    }
                    for ($i = 0; $i < $pagination; $i++) { ?>
                            <button class="btn-page"><?php echo $i+1?></button>
                        <?php
                    }
                    ?>
                </div>
                <button id="btn-next">Next</button>
            </div>
        </div>
    </div>
</div>

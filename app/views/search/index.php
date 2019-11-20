<div class="content">
    <div class="container">
        <h3 class="search-result">Showing search result for keyword "<?php
            echo $data["keyword"]?>"
        </h3>
        <h4 class="search-count"><?php echo $data["count"]?> results available</h4>
        <div class="search-wrapper" id="search-wrapper-id">
            <?php foreach ($data["movie"] as $movie) {
                $poster = ($movie["poster"] == null) ?
                    '<img class="search-poster" src="'. BASEURL .'img/no_img_placeholder.jpg">' :
                    '<img class="search-poster" src="'
                    . $movie["poster"]
                    .'" >';
                ?>
                <div class="row">
                    <div class="col-2">
                        <!-- <img 
                            src=<?php echo $poster?> 
                            width="110" 
                            height="150" 
                            class="search-poster"
                        > -->
                        <?php echo $poster?>
                    </div>
                    <div class="col-7 search-detail px-auto">
                        <div class="search-title"><?php echo $movie["title"]?></div>
                        <div class="search-rating">
                            <img 
                                src=<?php echo BASEURL . "img/star.png" ?> 
                                width="10" 
                                height="10"
                            > 
                        <?php echo $movie["rating"]?>
                        </div>
                        <p><?php echo $movie["description"]?></p>
                    </div>
                    <div class="search-view">
                        <a href="<?php echo BASEURL . "movie/detail?id=" .
                            $movie["idMovie"]?>"
                        >
                            View details 
                            <img 
                                src=<?php echo BASEURL . "img/chevron.png" ?> 
                                width="15" 
                                height="15"
                            >
                        </a>
                    </div>
                </div>
            <?php } ?>
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
        <input 
            id="keyword" 
            type="text" 
            value="<?php echo $data["keyword"]?>" 
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
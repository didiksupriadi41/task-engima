        </div>
    </div>
</body>
<?php
        if (array_key_exists("js", $data)) {
            echo "<script src=" . BASEURL . $data["js"] . "></script>";
        }
        ?>
</html>
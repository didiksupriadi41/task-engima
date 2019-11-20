<?php namespace models;

class VideoModel
{
    private $db;

    // public function __construct()
    // {
    //     $this->db = new \core\Database;
    // }
    public function getTrailerByID($id)
    {
        $curl = curl_init();
        $url = "https://api.themoviedb.org/3/movie/$id/videos?language=en-US&api_key=" . API_KEY;
            
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "{}",
        ));

        $response = json_decode(curl_exec($curl), true);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            // echo "cURL Error #:" . $err;
            return "";
        } elseif (isset($response["status_code"])) {
            // if ($response["status_code"] == 34) {
            return "";
            // }
        } else {
            $results = $response['results'];
            $key = "";
            if (!empty($results)) {
                $found = false;
                $i = 0;
                // var_dump('start ' . sizeof($results) . ' !found=' . !$found);
                while (!$found && $i < sizeof($results)) {
                    $video = $results[$i];
                    // var_dump($video);
                    if ($video['type'] == "Trailer" && $video['site'] == 'YouTube') {
                        $found = true;
                        $key = $video['key'];
                    }
                    $i++;
                }
                // var_dump('end');
            }
            return $key;
        }
    }
}

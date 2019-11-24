<?php namespace controllers;

class Api extends \core\Controller
{

    public function validate()
    {
        $data = new \stdClass();
        $data->status = 200;
        if ($this->model('RegisterModel')->validate()) {
            $data->result = true;
        } else {
            $data->result = false;
        }
        $response = json_encode($data);
        echo $response;
    }
    
    public function reduceSeat()
    {
        $data = new \stdClass();
        $data->status = 200;
        $data->result = $this->model('BookModel')->reduceSeatLeft($_POST['schedule-id']);
        echo json_encode($data);
    }

    public function search()
    {
        $keyword = $_GET['q'];
        $page = 1;
        if (array_key_exists("page", $_GET)) {
            $page = $_GET['page'];
        }
        $arrMovie = $this->model('MovieModel')->searchMovie($keyword, $page);

        echo json_encode($arrMovie["movies"]);
    }

    public function deleteReview()
    {
        $auth = new \core\Auth;
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $auth->checkAuthenticated();
            $data = new \stdClass();
            $data->status = 200;
            if ($this->model('RatingModel')->delete()) {
                // $this->model('MovieModel')->updateRating();
                $data->result = true;
            } else {
                $data->result = false;
            }
        }
        
        $response = json_encode($data);
        echo $response;
    }

    public function home()
    {
        $page = 1;
        if (array_key_exists("page", $_GET)) {
            $page = $_GET['page'];
        }

        $arrMovie = $this->model('MovieModel')->getPlayingMovie($page);

        echo json_encode($arrMovie["movies"]);
    }

    public function getTransaction()
    {
        $data = new \stdClass();
        $data->status = 200;
        $data->result ['movie'] = $this->model('MovieModel')->getSingleMovie($_GET['movie-id']);
        $data->result ['schedule'] = $this->model('ScheduleModel')->getScheduleByID();
        echo json_encode($data);
    }

    public function wsdl()
    {
        $data = new \stdClass();
        $data->status = 200;
        $xml_post_string = $_POST["envelope"];

        $soapUrl = "http://ma.kam-itb.com:8080/soap-test/bankService";
        
        $headers = array(
                    "Content-type: text/xml;charset=\"utf-8\"",
                    "Accept: text/xml",
                    "Cache-Control: no-cache",
                    "Pragma: no-cache",
                    "SOAPAction: http://connecting.website.com/WSDL_Service/GetPrice",
                    "Content-length: ".strlen($xml_post_string),
                );

        $url = $soapUrl;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // converting
        $response = curl_exec($ch);
        curl_close($ch);
        
        // converting
        $response1 = str_replace("S:", "", $response);
        $response2 = str_replace("ns2:", "", $response1);
        
        // convertingc to XML
        $parser = simplexml_load_string($response2);
        $data->return = $parser;

        echo (json_encode($data));
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('Data');
        $this->load->helper('url');

    }

    function rp($rp){
        $a = (string) $rp;
        $b = explode(".", $a);
        $rp = $b[0];
        $koma = (count($b) > 1) ? $b[1] : "";

        $rupiah = "";
        $p = strlen($rp);

        while ($p > 3) {
            $rupiah = "." . substr($rp, -3) . $rupiah;
            $rp = substr($rp, 0, $p - 3);
            $p = strlen($rp);
        }

        if ($koma == "" || $koma == "0" || $koma == "00") {
            $rupiah = $rp . $rupiah;
        } else {
            $rupiah = $rp . $rupiah . "," . $koma;
        }

        if ($rupiah == "0" || $rupiah == "0,00") {
            $rupiah = "";
        }

        return $rupiah;
    }

    public function index(){
        $this->load->view('welcome_message');
    }

    public function pages($judul = ''){
        if ($judul == "kategoribyproduk") {
            $sData = array();
            $data = $this->Data->kategoribyproduk();
            if ($data) { // Check if data exists
                foreach ($data as $rs) {
                    $arr_row = array();
                    $arr_row['id'] = (int) $rs->idkategori;
                    $arr_row['nama'] = (string) $rs->kategori; // Ensure it's a string
                    $sData[] = $arr_row;
                }
            }
            header('Content-Type: application/json');
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
            echo json_encode($sData, JSON_PRETTY_PRINT);

        } else if ($judul == "produkbykategori") {
            $sData = array();
            $id = $this->input->get('id');
            if ($id) { // Validate input
                $data = $this->Data->produkbykategori($id);
                if ($data) { // Check if data exists
                    foreach ($data as $rs) {
                        $arr_row = array();
                        $arr_row['id'] = (int) $rs->id;
                        $arr_row['idkategori'] = (int) $rs->idkategori;
                        $arr_row['judul'] = (string) $rs->judul;
                        $arr_row['harga'] = "Rp. " . $this->rp($rs->harga);
                        $arr_row['hargax'] = $rs->harga;
						$arr_row['thumbnail'] = (string) $rs->thumbnail;
                        $sData[] = $arr_row;
                    }

                }
            }
            header('Content-Type: application/json');

            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
            echo json_encode($sData, JSON_PRETTY_PRINT);
        }
        else if($judul=="cabang"){
        	$data = $this->Data->cabang();
        	$sData=array();
        	foreach ($data as $rs) {
                        $arr_row = array();
                        $arr_row['id'] = (int) $rs->id;
                        $arr_row['nama'] = $rs->nama."";
                        $arr_row['alamat'] = $rs->alamat."";
                        $arr_row['kota'] = $rs->kota."";
                        $arr_row['propinsi'] = $rs->propinsi."";
						$arr_row['kodepos'] = $rs->kodepos."";
						$arr_row['telp'] = $rs->telp."";
						$arr_row['email'] = $rs->email."";
                        $sData[] = $arr_row;
                    }
            header('Content-Type: application/json');
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
            echo json_encode($sData, JSON_PRETTY_PRINT);
        }else if($judul=="cekprodukbycabang"){
        	$data=$this->db->query("select * from stokcabang where idproduk='".$this->input->get('idproduk')."' and idcabang='".$this->input->get('idcabang')."'")->result();
        	if($data){
        		echo"OK";
        	}

        }else if($judul=="login"){
            $sData = array ();
            $status = "OK";
            $sData = array (
                "response_status"=>$status,
                "response_message"=>'',
                "data"=>array()
            );
            $username=$this->input->get('username');
            $password=$this->input->get('password');
            $data=$this->data->login($username,$password);

        }

        	header('Content-Type: application/json');
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

        	}
    }
}
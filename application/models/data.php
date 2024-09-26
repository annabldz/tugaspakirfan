<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

	class Data extends CI_Model {
		public function kategoribyproduk(){
			$data=$this->db->query("select distinct idkategori,kategori from produk where st='1' and thumbnail <>''");
			$this->db->close();
			return $data->result();
			header('Content-Type: application/json');

            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
            echo json_encode($sData, JSON_PRETTY_PRINT);
		}

		public function produkbykategori($id){
			$query = $this->db->query("SELECT * FROM produk WHERE idkategori = ? AND thumbnail <> '' AND st = '1' LIMIT 5", array($id));
			$this->db->close();
			return $data->result();
		}

		public function cabang (){
			$data=$this->db->query("select * from cabang");
			$this->db->close();
			return $data->result();
		}
        // Return the query result
        return $query->result();
        header('Content-Type: application/json');
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
            echo json_encode($sData, JSON_PRETTY_PRINT);
		}

		public function login($username, $password){
			$data=$this->db->query("select * from signin where userid='".$username."' and pass='".$password."'");
			$this->db->close();
			return $data->result();;
		}
	}


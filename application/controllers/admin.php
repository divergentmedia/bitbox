<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->helper("html");
		$this->load->spark('curl/1.3.0');

		$this->load->library("session");
		$this->load->library('Basic401Auth');
		$this->basic401auth->require_login();
	}

	public function index()
	{
	
		$data['collections'] = $this->doctrine->em->getRepository("Entity\Collection")->findAll();
		$this->load->view("adminHome", $data);

	}


	public function addFolder() {

		$folderSecret = $this->input->post("secret");
		$folderPath = $this->input->post("folderPath");
		$collection = new Entity\Collection();
		$collection->setPath($folderPath);
		$collection->setSecret($folderSecret);
		$this->doctrine->em->persist($collection);
		$this->doctrine->em->flush();

		$queryString = array("method"=>"add_folder", "dir"=>$folderPath, "secret"=>$folderSecret, "selective_sync"=>1);

		$this->curl->simple_get('http://' . $this->config->item('btSyncUser') . ":" . $this->config->item('btSyncPassword') . '@' . $this->config->item('btAddress') . '/api?'. http_build_query($queryString));

		redirect("/admin");

	}

	public function shareFile() {

		$collectionId = $this->input->post("collection");
		$path = $this->input->post("path");
		$filename = $this->input->post("file");
		if(!$filename) {
			return;
		}


		$existingEntry = $this->doctrine->em->getRepository("Entity\Sharing")->findOneBy(array("path"=>$path, "filename"=>$filename));

		if($existingEntry) {
			$hash = $existingEntry->getHash();
			$collection = $existingEntry->getCollection();
		}
		else {
			$sharedFile = new Entity\Sharing();
			$collection = $this->doctrine->em->find("Entity\Collection", $collectionId);
			$sharedFile->setCollection($collection);
			$sharedFile->setPath($path);
			$sharedFile->setFilename($filename);
			$this->doctrine->em->persist($sharedFile);
			$this->doctrine->em->flush();
			$hash = sha1("monkeybox!#@$!%!" . $sharedFile->getId());
			$sharedFile->setHash($hash);
			$this->doctrine->em->persist($sharedFile);
			$this->doctrine->em->flush();
		}



		$queryString = array("method"=>"set_file_prefs", "secret"=>$collection->getSecret(), "path"=>$path . "/" . $filename, "download"=>1);
		$result = json_decode($this->curl->simple_get('http://' . $this->config->item('btSyncUser') . ":" . $this->config->item('btSyncPassword') . '@' . $this->config->item('btAddress') . '/api?'. http_build_query($queryString)));

		if($result[0]->download == 1) {
			$status="success";	
		}
		else {
			$status="fail";
		}
		echo json_encode(array("hash"=>$hash, "status"=>$status));			

	}

	public function browse($collectionId) {

		$collection = $this->doctrine->em->find("Entity\Collection", $collectionId);

		if(!$collection) {
			redirect("/admin");
			return;
		}
		
		$segment_array = $this->uri->segment_array();
        $controller = array_shift( $segment_array );
        $method = array_shift( $segment_array );
		array_shift( $segment_array ); //discard collection Id
        
        $root = $collection->getPath();

		$path_in_url = '';
        
        foreach ( $segment_array as $segment ) {
        	$path_in_url.= urldecode($segment).'/';
        }

        $absolute_path = $root.'/'.$path_in_url;
        $absolute_path = rtrim( $absolute_path ,'/' );
        
		$queryString = array("method"=>"get_files", "secret"=>$collection->getSecret(), "path"=>$path_in_url);
		

		$result = $this->curl->simple_get('http://' . $this->config->item('btSyncUser') . ":" . $this->config->item('btSyncPassword') . '@' . $this->config->item('btAddress') . '/api?'. http_build_query($queryString));

		$resultArray = json_decode($result);
		if(!is_array($resultArray)) {
			return;
		}


		$dirs = array();
		$files = array();

		foreach($resultArray as $entry) {

			$file = $entry->name;
			$type = $entry->type;
			if($entry->state == "deleted") {
				continue;
			}
			if ( $file != "." && $file != ".." && substr($file, 0,1) != ".") {
				if($type == "file") {
					$files[]['name'] = $file;
				}
				else {
					$dirs[]['name'] = $file;
				}
                        
                sort( $dirs );
                sort( $files );
                
                
            }   
        }
		if ( $path_in_url != '' )
			array_unshift ( $dirs, array( 'name' => '..' ));
        // send the view
        $data = array(
            'path_in_url' => $path_in_url,
            'dirs' => $dirs,
            'files' => $files,
            'collectionId' =>$collectionId,
            'collectionPath' =>$absolute_path
            );
        $this->load->view( 'browse', $data );

	}

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
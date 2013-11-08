<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Download extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

	}


	public function checkAvailability($target) {
		if(!$target) {
			echo "error";
			die;
		}

		$targetFile = $this->doctrine->em->getRepository("Entity\Sharing")->findOneBy(array("hash"=>$target));

		$targetPath = $targetFile->getCollection()->getPath() . "/" . $targetFile->getPath() . $targetFile->getFilename();

		if(file_exists(($targetPath))) {
			echo "ready";
			return;
		}
		else {
			echo "pending";
			return;
		}

	}

	public function getFile($target)
	{
		if(!$target) {
			show_404();
			return;
		}

		$targetFile = $this->doctrine->em->getRepository("Entity\Sharing")->findOneBy(array("hash"=>$target));

		$targetPath = $targetFile->getCollection()->getPath() . "/" . $targetFile->getPath() . $targetFile->getFilename();

		if(file_exists(($targetPath))) {

			header("X-Sendfile: $targetPath");
	    	header("Content-Type: application/octet-stream");
	    	header("Content-Disposition: attachment; filename=\"".$targetFile->getFilename()."\"");
	    	return;

		}
		else {
			if(file_exists($targetPath . ".!sync")) {
				$this->load->view("syncProgress", array("targetId"=>$target));
			}
			else {
				$this->load->view("noFile");
			}


		}

	}

}

/* End of file download.php */
/* Location: ./application/controllers/download.php */
<?php

namespace Wagaia;

class Logger
{

	public $error = false;
	public $log = false;

	public function abort($code=false)
	{

		$code = $code ? $code : 404;

		switch($code) {

			case 'no_results':
			$this->log = "Aucun résultat pour cette recherche";
			break;
			case 404:
			$this->log = "La page n'existe pas";
			break;

			default :

			$this->log = $code;
		}

		$this->error = true;

		return $this;

	}

	public function alert($log=false)
	{
		if($log) {
			$this->log = $log;
		}

		if($this->log) {

			echo '<div class="pi-section"><br /><div class="alert pi-alert-'.($this->error ? 'danger':'success').'">'.$this->log."<br /><br /></div></div>";
		}
	}




}

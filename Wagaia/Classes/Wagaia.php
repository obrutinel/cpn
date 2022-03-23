<?php

namespace Wagaia;

class Wagaia extends Database
{
	public $url;
	public $ariane = [];
	public $list = [];

	function __construct() {
		parent::__construct();
	}

	function reset() {
		unset($_SESSION['nav']);

	}

	public function slider($type='slide', $check = true, $idParent = null)
	{
		global $lg, $data;
		
		if(empty($idParent)) $idParent = $data->page_id;
//echo "select a.image, b.titre, b.texte, b.sous_titre, b.link_url, b.link_text from ".Tables::$pages." a left join ".Tables::$pages_data." b on a.id = b.page_id where IFNULL(a.temp, 0) = 0 and a.parent='".$idParent."' and a.type='".$type."' and b.lg='".$lg."' order by a.position";
		$slider= $this->select("select a.image, b.titre, b.texte, b.sous_titre, b.link_url, b.link_text from ".Tables::$pages." a left join ".Tables::$pages_data." b on a.id = b.page_id where IFNULL(a.temp, 0) = 0 and a.parent='".$idParent."' and a.type='".$type."' and b.lg='".$lg."' order by a.position");

		if ($check) {
			$slides = [];
			if (!empty($slider)) {
				foreach($slider as $slide ) {

					if (srcImage($slide->image)) {
						$slides[] = $slide;
					}
				}
			}
			$data->slider = $slides;
		} else {
			$data->slider = $slider;
		}
		
		return $data;
	}

	public function sticky($check=true)
	{
		global $lg, $data;

		$query = "select a.image, a.titre, a.parent, concat_ws('/', (select e.nav_url from wagaia_pages_data e where e.page_id = a.parent and b.lg='".$lg."'), b.nav_url) as full_url, (select e.parent from ".Tables::$pages." e where e.id = a.parent) as root_category_id, (select e.nav_url from ".Tables::$pages_data." e where e.page_id = root_category_id) as root_category_url, (select d.titre from wagaia_pages d where a.parent = d.id) as category from ".Tables::$pages." a join ".Tables::$pages_data." b on a.id=b.page_id join wagaia_sticky c on b.id = c.page_id where IFNULL(a.temp, 0) = 0 and b.lg='".$lg."' order by c.position";

		$sticky= $this->select($query);
		$data->query = $query;

		if ($check) {
			$slides = [];
			if (!empty($sticky)) {
				foreach($sticky as $slide ) {

					if (srcImage($slide->image)) {
						$slides[] = $slide;
					}
				}
			}
			$data->sticky = $slides;
		} else {
			$data->sticky = $sticky;
		}
		return $data;
	}



	function globalNav() {

		global $website_lg;


		if (!array_key_exists('nav', $_SESSION) or empty($_SESSION['nav'])) {

			$_SESSION['nav']['pulled'] = 'from_db';

			foreach($website_lg as $lg) {

				$d = $this->select('select nav_title, is_primary, nav_url, nav_direct_link, link_url, pull_children, type, page_id, parent from wagaia_pages_data a join wagaia_pages b on b.id=a.page_id where IFNULL(b.temp, 0) = 0 and (b.is_primary=1 or b.is_nav=1) and a.lg="'.$lg.'" order by b.position, a.id', 'page_id');

				if($d) {
					foreach ($d as $k => $v) {
						if (!is_null($v->pull_children)) {
							$v->children = $this->select('select nav_title, nav_url, image, page_id, parent, type from wagaia_pages_data a join wagaia_pages b on b.id=a.page_id where IFNULL(b.temp, 0) = 0 and b.parent='.$v->page_id.' and a.lg="'.$lg.'" order by b.position');
						}
					}
				}
				$_SESSION['nav'][$lg] = $d;
			}

		} else {
			$_SESSION['nav']['pulled'] = 'from_session';
		}

		return $_SESSION['nav'];
	}


	function is_localhost()
	{

		return in_array($_SERVER['HTTP_HOST'], array('localhost','localhost:4554','wagaia'));
	}


		public function request()
		{
			$url = parse_url($_SERVER['REQUEST_URI']);
			$url = trim((WEB_FOLDER ? str_replace('/'.WEB_FOLDER.'', null, $url['path']) : $url['path']),'/');

			$this->url['original'] = $url;
			$this->url['explode'] = explode('/', $url);
			$this->url['terms'] = count($this->url['explode']);
			$this->url['last'] = $this->url['explode'][$this->url['terms']-1];
			$this->url['first'] = $this->url['explode'][0];

			return $this->url;

		}


		public static function metatags($data)
		{
			$p = $meta = new \stdClass();

			$p->title = (!empty($data->meta_titre)?$data->meta_titre:(!empty($data->titre)?$data->titre:$data->libelle));
			$p->desc = (!empty($data->meta_desc)?$data->meta_desc:(!empty($data->descriptif)?$data->descriptif:null));
			$p->keys = (!empty($data->meta_key)?$data->meta_key:null);

			return $p;
		}


		/*--------------------------------------
		| FILS D'ARIANE // BREADCRUMBS
		| -------------------------------------- */

		public function getPage($id)
		{
			global $lg;

			return $this->get("select a.id, a.type, a.parent, a.image, a.color, b.titre, b.intro, b.sous_titre, b.texte, b.nav_url, b.link_url, b.link_text from ".Tables::$pages." a left join ".Tables::$pages_data." b on a.id = b.page_id where COALESCE(a.temp,0) = 0 AND b.page_id=".$id." and b.lg='".$lg."'");
		}

		public function find($table, $id = NULL)
		{

			if (!empty($id)) {
				$page = $this->getPage($id);

				if ($page) {
					$this->ariane[] = ['titre'=>$page->titre, 'url'=>$page->nav_url, 'type'=>$page->type];
				}
				if (!empty($page->parent)) {
					$this->find($page->parent);
				}

			}
			return $this;
		}

		public function ariane($page_id = null)
		{
			global $data;

			$target = empty($page_id) ? $data->parent : $page_id;

			$this->ariane[] = ['titre' => $data->titre, 'url' => $data->nav_url, 'type' => $data->type];

			$this->find($target);

			return array_reverse($this->ariane);
		}

		public function chainUrl($page_id = null)
		{
			$this->ariane = [];
			$chain = $this->ariane($page_id);
			$urls = array_column($chain, 'url');

			return implode('/', $urls);
		}
		
		public function getMore($table, $page_id) {
			
			global $db, $data;
			
			$data->more = $db->get("SELECT * FROM wagaia_".$table." WHERE id = ".$page_id);
			
			return $data;
		}
		
		public function getNextPrev($type, $page_id) {
			
			global $db, $data;
			
			$page = $db->get("SELECT position FROM ".Tables::$pages." WHERE id = ".$page_id);
			
			$data->next = $db->get("SELECT * FROM ".Tables::$pages." a LEFT JOIN ".Tables::$pages_data." b ON b.page_id = a.id WHERE a.type LIKE '".$type."' AND a.position > ".$page->position." ORDER BY a.position");
			$data->prev = $db->get("SELECT * FROM ".Tables::$pages." a LEFT JOIN ".Tables::$pages_data." b ON b.page_id = a.id WHERE a.type LIKE '".$type."' AND a.position < ".$page->position." ORDER BY a.position DESC");
			
			return $data;
		}

		public function getByType($type=null, $parent=null, $more=null)
		{
			global $lg;
			
			if(!empty($more)) {
				
				$sql = "SELECT a.image, a.image2, a.type, a.parent, a.icon, a.color, a.pictos, a.date, b.*, z.* FROM ".Tables::$pages." a 
							LEFT JOIN ".Tables::$pages_data." b ON a.id = b.page_id
							LEFT JOIN wagaia_".$type." z ON z.id = a.id
							WHERE IFNULL(a.temp, 0) = 0 AND a.type = '{$type}' ".($parent ? " AND a.parent = '{$parent}'" : null)." AND b.lg = '{$lg}' ORDER BY a.position";

			}
			else {
			
				$sql = "SELECT a.image, a.image2, a.type, a.parent, a.icon, a.color, a.pictos, a.date, b.* FROM ".Tables::$pages." a 
							LEFT JOIN ".Tables::$pages_data." b ON a.id = b.page_id
							WHERE IFNULL(a.temp, 0) = 0 AND a.type = '{$type}' ".($parent ? " AND a.parent = '{$parent}'" : null)." AND b.lg = '{$lg}' ORDER BY a.position";
							
			}

			$this->list = $this->select($sql);

			return $this;
		}
		
		public function getByParent($parent)
		{
			global $lg;
			
			$sql = "SELECT a.image, a.type, a.parent, a.icon, b.* FROM ".Tables::$pages." a 
						LEFT JOIN ".Tables::$pages_data." b ON a.id = b.page_id
						WHERE IFNULL(a.temp, 0) = 0 AND a.parent = ".$parent." AND b.lg = '{$lg}' ORDER BY a.position";
							
			$this->list = $this->select($sql);

			return $this;
		}		

		public function withAttachments()
		{
			if (!empty($this->list)) {
				foreach($this->list as $v) {
					$v->attachments = $this->select("select * from ".Tables::$attachments." where page_data_id=".$v->id);
				}
			}

			return $this->list;
		}

		
		public function breadcrumb($page_id, $separator = '', $class = '') {
			
			global $lg;
			$tab = array();
			$output = '';
			
			if(empty($page_id)) $page_id = 1;
			
			$sql = "SELECT a.parent, b.page_id, b.titre, b.nav_title, b.nav_url FROM ".Tables::$pages." a LEFT JOIN ".Tables::$pages_data." b ON a.id = b.page_id WHERE a.id = ".$page_id;
			$tab[] = $pages = $this->get($sql);
			
			for($i=0; $i<5; $i++) {
				if($pages->parent != NULL) {
					$sql = "SELECT a.parent, b.page_id, b.titre, b.nav_title, b.nav_url FROM ".Tables::$pages." a LEFT JOIN ".Tables::$pages_data." b ON a.id = b.page_id WHERE a.id = ".$pages->parent;
					$tab[] = $pages = $this->get($sql);
				}
				else break;
			}
			
			$tab = array_reverse($tab);

			if(!empty($tab)) {
				
				$i == 0;
				$len = count($tab);
				//$output .= '<ol class="'.$class.'">';
				
				foreach($tab as $index => $page) {


					if($index == 0) {
						$output .= '<li class="'.$class.'"><a href="'.HTTP.'"><i class="fa fa-home" aria-hidden="true"></i></a>'.$separator.'</li>';
					}
					elseif ($index == $len - 1) {
						$output .= '<li class="'.$class.' active">'.$page->nav_title.'</li>';
					}
					else {
						$output .= '<li class="'.$class.'"><a href="'.HTTP.$page->nav_url.'">'.$page->nav_title.'</a>'.$separator.'</li>';
					}
						
				}
				
				//$output .= '</ol>';
			}

			
			return $output;
		}

	}
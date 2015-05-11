<?php

class Pagination 
{

	/*$_records vlerat nga db
	$_max_per_page numri maksimal per faqe i caktuar ne faqen catalogue
	$_number_of_pages numri faqeve
	$_number_of_records numri i te dhenave
	$_current merre url
	$_key faqe perkatese
	$_url merret nga metoda getCurrent qe gjendet ne klassen Url*/
	private $_records;
	private $_max_per_page;
	private $_number_of_pages;
	private $_number_of_records;
	private $_current;
	private $_offset=0;
	private static $_key='faqe';
	public $_url;


	/* konstruktori qe merr dy parametra 
	$rows te dehnat nga db
	$max numri i caktuar te dhenave qe do te shfaqen*/
	public function __construct($rows, $max=10)
	{
		$this->_records=$rows;
		$this->_number_of_records=count($this->_records);
		$this->_max_per_page=$max;
		$this->_url=Url::getCurrentUrl(self::$_key);
	    $current=Url::getParam(self::$_key);
	    $this->_current = !empty($current) ? $current : 1;
		$this->numberOfPages();
		$this->getOffset();
	}

	/* numri i faqeve*/
	private function numberOfPages()
	{
		 $this->_number_of_pages = ceil($this->_number_of_records / $this->_max_per_page);
	}

	/* caktohet prej ku me fillu vektroi*/
	private function getOffset()
	{

		 $this->_offset=($this->_current - 1) * $this->_max_per_page;
	}

	/* metoda qe merre te dhenat nga db varesisht nga numri max per faqe*/
	public function getRecords()
	{

		$out= array();

		if($this->_number_of_pages > 1)
		{
			$last=($this->_offset + $this->_max_per_page);

			for ($i=$this->_offset; $i < $last; $i++) 
			{ 
				if ($i < $this->_number_of_records) 
				{
					$out[] = $this->_records[$i];
				}
			}

		} else {
			$out=$this->_records;
		}

		return $out;

	}

	/* metoda qe cakton linqet perpara, mbrapa, fillimi, fundi*/
	public function getLinks()
	{

		if($this->_number_of_pages > 1)
		{
			$out = array();


			//linku i pare
			if ($this->_current > 1)
			{
				$out[]="<a href=\"".$this->_url."\">Fillimi</a>";
			
			} else {

				$out[] = "<span>Fillimi</span>";

			}

			//linku mbrapa
			if ($this->_current > 1)
			 {

				//faqja mbrapa
				$id=($this->_current  - 1 );

				$url = $id > 1 ? $this->_url."&amp;".self::$_key."=".$id : $this->_url;

				$out[]="<a href=\"{$url}\">Mbrapa</a>";
			} else {
				$out[] = "<span>Mbrapa</span>";
			}

			//linku para
			if ($this->_current != $this->_number_of_pages)
			{
				//numri i faqes para
				$id=$this->_current + 1;

				$url=$this->_url."&amp;".self::$_key."=".$id;
				$out[]="<a href=\"{$url}\">Para</a>";
			} else {
				$out[]="<span>Para</span>";
			}

			//faqja e fundit
			if($this->_current != $this->_number_of_pages)
			{
				$url=$this->_url."&amp;".self::$_key."=".$this->_number_of_pages;
				$out[]="<a href=\"{$url}\">Fundi</a>";

			} else {
				$out[]="<span>Fundi</span>";
			}

			return "<li>".implode("</li><li>",$out)."</li>";

		}
	}

	/* Metoda qe mbush em te dhena listen*/
	public function getPagination()
	{
		$links = $this->getLinks();
		if (!empty($links)) 
		{
			$out = "<ul class=\"paging\">";
			$out .= $links;
			$out .= "</ul>";
			return $out;
		}
	}

}

?>
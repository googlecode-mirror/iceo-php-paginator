<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Iceo_paginator_base
{
	public $total_pages;
	public $window_size;
	
	function __construct()
	{
		/*
		 * Since extended class(es) override default_config()
		 * method, we need to specifically call this class' default_config().
		 */
		Iceo_paginator_base::default_config();
	}
	
	private function default_config()
	{
		/*
		 * When setting up this configuration parameter for datasets, you can
		 * calculate total_pages value as (int)((number_of_records - 1) / records_per_page) + 1
		 * 
		 * Here, number_of_records is, well, total number of records in dataset,
		 * and records_per_page is, well, number of records you will list on one page, ok?
		 */
		$config['total_pages'] = 10;
		$config['window_size'] = 3;
		
		/*
		 * Since extended class(es) override initialize()
		 * method, we need to specifically call this class' initialize().
		 */
		Iceo_paginator_base::initialize($config);
	}
	
	public function initialize($config = array())
	{
		if(is_array($config))
		{
			if(isset($config['total_pages']))
				$this->total_pages = $config['total_pages'];
			
			if(isset($config['window_size']))
				$this->window_size = $config['window_size'];
		}
	}
	
	public function create_links($current_page = 1)
	{
		$result = array();
		
		// Basic sanity check
		if($this->total_pages <= 0)
		{
			$this->total_pages = 1;
		}
		if($this->window_size <= 0 || $this->window_size > $this->total_pages)
		{
			$this->window_size = $this->total_pages;
		}
		if($current_page <= 0)
		{
			$current_page = 1;
		}
		if($current_page > $this->total_pages)
		{
			$current_page = $this->total_pages;
		}
		
		/*
		 * Now we have attributes that more or less have sane values,
		 * let's calculate parameters that will help us generate 
		 * resulting pagination array.
		 */
		// $delta is number of link to the left and right 
		// of current page link
		$delta = (int) (($this->window_size - 1) / 2);
		// Here we calculate exactly how many links there are 
		// $before and $after the current page link
		if($this->window_size == (2 * $delta + 1))
		{
			$before = $after = $delta;
		}
		else
		{
			/*
			 * In case $window_size is an even number
			 * this will set one more page link *after*
			 * current page link in paginator.
			 * 
			 * If you prefer to have more links before
			 * current page link, put these the other way
			 * around.
			 */
			$before = $delta;
			$after = $delta + 1;
		}
		
		/*
		 * Page numbers/indexes at the start and end of
		 * our 'window', which is collection of links user
		 * sees between 'prev' and 'next' links
		 */
		$window_start = $current_page - $before;
		$window_end = $current_page + $after;
		
		// Handle border situations when current page is near
		// the start and and of page collection.
		if($window_start <= 0)
		{
			$window_end = $window_end - ($window_start - 1);
			$window_start = 1;
		}
		if($window_end > $this->total_pages)
		{
			$window_start = $window_start - ($window_end - $this->total_pages);
			$window_end = $this->total_pages;
		}
		
		// Generate 'first' link state
		if($current_page == 1)
		{
			$result['first'] = 'disabled';
		}
		else
		{
			$result['first'] = '1';
		}
		
		// Generate 'prev' link state
		$prev_page = $current_page - 1;
		if($prev_page < 1) $prev_page = 1;
		if($current_page == 1)
		{
			$result['prev'] = 'disabled';
		}
		else
		{
			$result['prev'] = $prev_page;
		}
		
		// Generate page links between 'prev' and 'next'
		$page_links = array();
		for($i = $window_start; $i <= $window_end; $i++)
		{
			if ($i == $current_page)
			{
				$page_links[] = array('number'=>$i, 'link'=>'disabled');
			}
			else
			{
				$page_links[] = array('number'=>$i, 'link'=>$i);
			}
		}
		
		$result['page_links'] = $page_links;
		
		// Generate 'next' link state
		$next_page = $current_page + 1;
		if($next_page > $this->total_pages) $next_page = $this->total_pages;
		if($current_page == $this->total_pages)
		{
			$result['next'] = 'disabled';
		}
		else
		{
			$result['next'] = $next_page;
		}
		
		// Generate 'last' link state
		if($current_page == $this->total_pages)
		{
			$result['last'] = 'disabled';
		}
		else
		{
			$result['last'] = $this->total_pages;
		}
		
		return $result;
	}
}

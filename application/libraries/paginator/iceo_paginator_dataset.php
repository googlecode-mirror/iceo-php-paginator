<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

require_once (APPPATH.'libraries/paginator/iceo_paginator_base.php');

class Iceo_paginator_dataset extends Iceo_paginator_base
{
	// Number of rows from dataset you intend to show on each page
	public $rows_per_page;
	// Total number of rows in dataset
	public $total_rows;
	// link that will be prepended to calculated offset
	public $base_link;
	
	function __construct()
	{
		parent::__construct();

		Iceo_paginator_dataset::default_config();
	}
	
	private function default_config()
	{
		// Make up some numbers
		$config['rows_per_page'] = 10;
		$config['total_rows'] = 197;
		$config['window_size'] = 5;
		$config['base_link'] = '';
		
		Iceo_paginator_dataset::initialize($config);
	}
	
	public function initialize($config = array())
	{
		if(is_array($config))
		{
			parent::initialize($config);
			
			if(isset($config['base_link']))
				$this->base_link = $config['base_link'];
			
			if(isset($config['rows_per_page']))
				$this->rows_per_page = $config['rows_per_page'];
			
			if(isset($config['total_rows']))
				$this->total_rows = $config['total_rows'];
		}
		
		// Calculate how many pages of content there are based on
		// number of rows in dataset and number of rows that are
		// going to be shown on each page
		$this->total_pages = (int)(($this->total_rows - 1) / $this->rows_per_page) + 1;
	}
	
	/*
	 * $offset is offset into dataset, i.e. 0, 15, 30, 45, ...
	 */
	public function create_links($offset = 0)
	{
 		// Calculate current page based on $offset and number of rows per page
		$current_page = (int)($offset / $this->rows_per_page) + 1;
		// Call base paginator link creation method.
		// We will process it's result afterwords to fit our
		// dataset navigation intentions.
		$pagination = parent::create_links($current_page);
		
		/*
		 * Go through generated page numbers
		 * and replace them with equivalent row offsets
		 */
		$page_links = array();
		
		foreach ($pagination as $key => $pagination_item)
		{
			/*
			 * We use is_array() here to distinguish
			 * between 'page_links' and navigation links.
			 */
			if(is_array($pagination_item))
			{
				// Only $pagination['page_links'] is array
				foreach ($pagination_item as $page_link)
				{
					// This converts page number to row offset.
					$link_offset = ($page_link['number'] - 1) * $this->rows_per_page;
					// We chose to show row offset here instead of page number.
					// Comment this out if you want page number instead
					//$page_link['number'] = $link_offset;
					
					// Only change link if it is not disabled
					if($page_link['link'] != 'disabled')
					{
						$page_link['link'] = $this->build_link($link_offset);
					}
					
					$page_links[] = $page_link;
				}
			}
			else
			{
				// Elements that are not array are 'first', 'prev', 'next' and 'last'
				if($pagination_item != 'disabled')
				{
					// Page number to row offset.
					$pagination_item = ($pagination_item - 1) * $this->rows_per_page;
					$pagination_item = $this->build_link($pagination_item);
					$pagination[$key] = $pagination_item;
				}
			}
		}
		
		$pagination['page_links'] = $page_links;
		
		return $pagination;
	}
	
	private function build_link($offset)
	{
		/*
		 * This should create complete link to next page
		 * i.e. /index.php/paginator/test/45.
		 * 
		 * So choose your base_links wisely, offset comes at the end.
		 * 
		 * Or rewrite this to whatever you need it to be.
		 */
		return $this->base_link.$offset;
	}
}

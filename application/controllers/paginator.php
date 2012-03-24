<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paginator extends CI_Controller
{
	// num of records per page
	private $limit = 10;
	
	function __construct()
	{
		parent::__construct();
		
		// Could do this in config/autoload.php also.
		$this->load->helper('url');
		/*
		 * Load library in order to be able
		 * to instantiate class Iceo_paginator_base.
		 * Other way is to autoload it in config/autoload.php
		 * like we did for this example.
		 */
		//$this->load->library('paginator/iceo_paginator_base');
		
		/*
		 * Just to do it in different way, we will load 
		 * Iceo_paginator_dataset library here in 
		 * constructor, instead of in config/autoload.php 
		 */
		// 
		$this->load->library('paginator/iceo_paginator_dataset');
	}
	
	function index($offset = 1)
	{
		// Just add more examples at the end of the link list
		$content =
			anchor('paginator/barebones', 'barebones').'<br>'.
			anchor('paginator/barebones_dataset', 'barebones_dataset').'<br>'.
			anchor('paginator/full_with_css_style', 'Full pagination styled with CSS').'<br>'.
			anchor('paginator/short_with_css_style', 'Short pagination styled with CSS').'<br>'.
			anchor('paginator/minimal_with_css_style', 'Minimal pagination styled with CSS').'<br>'.
			anchor('paginator/more_with_css_style', 'Minimal pagination styled with CSS and with more information').'<br>'.
			anchor('paginator/full_with_css_style_mw', 'Full pagination styled with different CSS').'<br>'.
			anchor('paginator/full_with_css_style_tnt', 'Full pagination styled with different CSS and without &lt;ul&gt;').'<br>'.
			''
			;
		
		$template_data['content'] = $content;
		$this->load->view('paginator/mainPage',$template_data);
	}
	
	/*
	 * Prints out nicely formatted array returned by paginator.
	 * 
	 * View this by visiting /index.php/paginator/barebones URI.
	 * 
	 * To see what happens when different current page is requested,
	 * view this by entering current page number after 'barebones',
	 * i.e. /index.php/paginator/barebones/2
	 */
	function barebones($offset = 1)
	{
		$base_paginator = new Iceo_paginator_base();
		$base_result = $base_paginator->create_links($offset);
		
		$template_data['content'] = 
						'<pre>'.print_r($base_result,true).'</pre>';
		$this->load->view('paginator/mainPage',$template_data);
	}
	
	/*
	 * Prints out nicely formatted array returned by html/dataset paginator.
	 * 
	 * View this by visiting /index.php/paginator/barebones_dataset URI.
	 * 
	 * To see what happens when different dataset offset is requested,
	 * view this by entering current offset after 'barebones_dataset',
	 * i.e. /index.php/paginator/barebones_dataset/10
	 */
	function barebones_dataset($offset = 0)
	{
		$dataset_paginator = new Iceo_paginator_dataset();
		$dataset_result = $dataset_paginator->create_links($offset);
		
		$template_data['content'] = 
						'<pre>'.print_r($dataset_result,true).'</pre>';
		$this->load->view('paginator/mainPage',$template_data);
	}
	
	/*
	 * Generates pagination view with functional links and
	 * page number starting with page number 0.
	 * 
	 * Page numbering starts with 0, and not wiht 1 as in 
	 * iceo_paginator_base, since we are hacking 
	 * iceo_paginator_dataset which enumerates row offsets 
	 * from 0.
	 */
	function full_with_css_style($page = 0)
	{
		/*
		 * In this example we want to use a feature
		 * that Iceo_paginator_dataset implements: it
		 * converts links to full urls.
		 * 
		 * On the other hand, we don't want to work
		 * with datasets and row offsets, but only with
		 * simple pages. Easy way to do this is to set
		 * rows_per_page to 1 and total_rows to number
		 * of pages in our content.
		 * Now rows_per_page and total_rows have different
		 * meaning: they don't refer to rows but to pages.
		 * 
		 * Other way would be to extend Iceo_paginator_base
		 * and add just functionality for building full links.
		 * But why do that when someone already did the job? ;o)
		 * 
		 * NOTE: downside of this approach is that pages start at 0
		 * and not at 1. This is sideffect of row offsets starting 
		 * at offset 0.
		 */
		$paginator = new Iceo_paginator_dataset();
		$paginator->rows_per_page = 1;
		$paginator->total_rows = 11;
		$paginator->base_link = site_url('paginator/full_with_css_style').'/';
		$paginator->initialize();
		
		$result = $paginator->create_links($page);
		
		/*
		 * Now we will pass paginator result array to CodeIgniter
		 * templating engine and create nice, CSS styled, HTML that
		 * contains our pagination.
		 * 
		 * In listPagination.php template you have following variables
		 * at your disposal for rendering:
		 * 	- $first
		 * 	- $prev
		 * 	- $page_links
		 * 	- $prev
		 * 	- $last
		 * To cut the story short, those are all elements of paginator 
		 * result array, right?
		 */
		$pagination_html = $this->load->view('paginator/listPaginationFull', $result, true);
		
		/*
		 * This step is here so we don't have to repeat 
		 * html/header/body tags in every view template.
		 */
		$template_data['content'] = $pagination_html;
		$this->load->view('paginator/mainPage',$template_data);
	}
	
	function full_with_css_style_mw($page = 0)
	{
		$paginator = new Iceo_paginator_dataset();
		$paginator->rows_per_page = 1;
		$paginator->total_rows = 11;
		$paginator->base_link = site_url('paginator/full_with_css_style_mw').'/';
		$paginator->initialize();
		
		$result = $paginator->create_links($page);
		
		$pagination_html = $this->load->view('paginator/listPaginationFullMW', $result, true);
		
		$template_data['content'] = $pagination_html;
		$this->load->view('paginator/mainPage',$template_data);
	}
	
	function full_with_css_style_tnt($page = 0)
	{
		$paginator = new Iceo_paginator_dataset();
		$paginator->rows_per_page = 1;
		$paginator->total_rows = 11;
		$paginator->base_link = site_url('paginator/full_with_css_style_tnt').'/';
		$paginator->initialize();
		
		$result = $paginator->create_links($page);
		
		$pagination_html = $this->load->view('paginator/listPaginationFullTNT', $result, true);
		
		$template_data['content'] = $pagination_html;
		$this->load->view('paginator/mainPage',$template_data);
	}
	
	/*
	 * Generates pagination view with functional links and
	 * page number starting with page number 0. Does not
	 * provide first and last links.
	 * 
	 * Doing same thing with iceo_paginator_dataset as in full_with_css_style.
	 */
	function short_with_css_style($page = 0)
	{
		$paginator = new Iceo_paginator_dataset();
		$paginator->rows_per_page = 1;
		$paginator->total_rows = 11;
		$paginator->base_link = site_url('paginator/short_with_css_style').'/';
		$paginator->initialize();
		
		$result = $paginator->create_links($page);
		
		// Only difference from full_with_css_style is view template...
		$pagination_html = $this->load->view('paginator/listPaginationShort', $result, true);
		
		$template_data['content'] = $pagination_html;
		$this->load->view('paginator/mainPage',$template_data);
	}
	
	/*
	 * Generates minimal pagination view with functional links
	 * and page number starting with page number 0. Has only
	 * prev and next links and current page number.
	 * 
	 * Doing same thing with iceo_paginator_dataset as in full_with_css_style.
	 */
	function minimal_with_css_style($page = 0)
	{
		$paginator = new Iceo_paginator_dataset();
		$paginator->rows_per_page = 1;
		$paginator->total_rows = 11;
		// window_size of 1 makes paginator generate a minimal pagination.
		$paginator->window_size = 1;
		$paginator->base_link = site_url('paginator/minimal_with_css_style').'/';
		$paginator->initialize();
		
		$result = $paginator->create_links($page);
		
		// Only difference from full_with_css_style is view template...
		$pagination_html = $this->load->view('paginator/listPaginationShort', $result, true);
		
		$template_data['content'] = $pagination_html;
		$this->load->view('paginator/mainPage',$template_data);
	}
	
	/*
	 * Generates minimal pagination view with functional links
	 * and page number starting with page number 0. Has only
	 * prev and next links and current page number.
	 * 
	 * Besides that, we provide some more information to view
	 * template and to the end user too.
	 * 
	 * Doing same thing with iceo_paginator_dataset as in full_with_css_style.
	 */
	function more_with_css_style($page = 0)
	{
		/*
		 * One way of providing additional information about
		 * pagination to view template is to configure
		 * paginator via configuration array, and then to
		 * send that array to view template so we can print
		 * out addition information!
		 */
		$paginator_config = array();
		$paginator_config['rows_per_page'] = 1;
		$paginator_config['total_rows'] = 11;
		// window_size of 1 makes paginator generate a minimal pagination.
		$paginator_config['window_size'] = 1;
		$paginator_config['base_link'] = site_url('paginator/more_with_css_style').'/';
		
		$paginator = new Iceo_paginator_dataset();
		$paginator->initialize($paginator_config);
		
		$result = $paginator->create_links($page);
		// The trick is to add configuration parameters to 
		// template variable 'config'
		$result['config'] = $paginator_config;
		
		// Only difference from full_with_css_style is view template...
		$pagination_html = $this->load->view('paginator/listPaginationMore', $result, true);
		
		$template_data['content'] = $pagination_html;
		$this->load->view('paginator/mainPage',$template_data);
	}
}
?>
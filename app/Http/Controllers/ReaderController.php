<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Session;

class ReaderController extends Controller
{
	// Number of lines per page
	public $lines_per_page;
	// Whole file data stored in array
	public $file_data = [];
	
	/*
	* Class construct
	*/
	public function __construct(Request $request)
	{
		// Initiate value of lines_per_page from .env file
		$this->lines_per_page = env('LINES_PER_PAGE', 10);
		
		// Initiate file_data array with the whole file contents
		$this->file_data = $this->get($request->file);
	}

	/*
	*
	* Get data from file
	*
	* Return whole file data array
	*/
	public function get($file)
	{
		// Check if the actual file exist
		if(trim($file) != '' && file_exists($file))
		{
			// Get whole file data array
			$lines = file($file);
			
			// Initiate file lines counter
			$count = 1;
			
			// Initiate file pages counter
			$page = 1;
			
			// Initiate returned data array
			$data = [];
			
			// Loop on file lines
			foreach($lines as $key => $line)
			{
				// check if not empty line
				if(trim($line) != '')
				{
					// Save line data in two dimentional array [page][count]
					$data[$page][$count] = mb_convert_encoding($line, 'UTF-8', 'UTF-8');
					
					// check if the current line is page end line
					if($count%($this->lines_per_page) == 0)
					{
						// Add one to pages counter
						$page = $page + 1;
					}
					
					// Add one to lines counter
					$count = $count + 1;
				}
			}
		}
		
		// If the actual file not exist
		else $data[1][1] = 'File not exist !';
		
		// Returned data
		return $data;
	}
	
	/*
	*
	* Type cases
	*
	* Return avoid
	*/
	public function cases($type = 'first', $pages_count)
	{
		// Switch on request type
		switch($type)
		{
			case 'first':
				// Save first page session
				Session::put('page', 1);
				break;
			case 'next':
				// If the last visited page is the last page then the current page is the first page
				// Else the current page is the last visited page + 1
				$page = (Session::has('page') && Session::get('page') < ($pages_count))? (Session::get('page'))+1:1;
				
				// Save next page session
				Session::put('page', $page);
				break;
			case 'previous':
				// If the last visited page is the first page then the current page is the last page
				// Else the current page is the last visited page - 1
				$page = (Session::has('page') && (Session::get('page'))-1 > 0)? Session::get('page')-1:$pages_count;
				
				// Save previous page session
				Session::put('page', $page);
				break;
			case 'last':
				// Save last page session
				Session::put('page', $pages_count);
				break;
			default:
				// Save first page session
				Session::put('page', 1);
		}
	}
	
	/*
	*
	* Request date depend on type {first, next, previous, last} and file directory
	*
	* Return json data response
	*/
	public function read(Request $request)
    {		
		// If the data not fetched from file yet.
		if(!empty($this->file_data)) $read = new ReaderController($request);
		
		// Switch current page type to get page number
		$this->cases($request->type, count($this->file_data));
		
		// Get current page data
		$data = $this->file_data[Session::get('page')];
		
		// Response the json of current page data
		return response()->json($data, 201);
    }
}
<?php

namespace Api;

/**
 * Enables pagination on API controllers. This controller accepts request in the form of <br>
 * <b>/$endpoint?search={text}&sort={property/column}&limit=x&offset=y&order=(asc|desc)</b>
 * <br><br>
 * To generate paginated output, explicitly return data using the Response_Paginated wrapper.
 * @author Melcher
 */
class Controller_Paginated extends Controller_Auth {
	
	/**
	 * Rows offset 
	 * @var int 
	 */
	protected $offset = null;
	
	/**
	 * Row limit
	 * @var int 
	 */
	protected $limit = null;
	
	/**
	 * Ordering
	 * @var string Either 'asc' for ascending or 'desc' for descending order. 
	 */
	protected $order = 'asc';
	
	/**
	 * Secondary sorting column.
	 * @var string
	 */
	protected $sort_secondary;
	
	/**
	 * Search string. 
	 * @var string 
	 */
	protected $search;
	
	protected $default_sort_key = 'id';
	
	/**
	 * Columns that will be ignored when defined as sorting key. <br>
	 * Essentially acts as a blacklist.
	 * @var array 
	 */
	protected $unsortable_columns = [];
	
	/**
	 * Whitelist of sortable columns. If not set, all columns can be sorted <br>
	 * with exception those in the `$unsortable_columns` array.
	 * @var array 
	 */
	protected $sortable_columns;
	
	/**
	 * Columns that will be searched when a search query is executed.
	 * @var array 
	 */
	protected $searchable_columns;
	
	public function before() {
		parent::before();
		
		// Set pagination values based on query - or use defaults instead.	
		$this->offset = \Input::get('offset', 0);
		$this->limit = \Input::get('limit', PHP_INT_MAX);
		$this->search = \Input::get('search');
		
		// Only set order when appropriate
		if(in_array(($order_param = \Input::get('order')), ['asc', 'desc'])){
			$this->order =$order_param;
		}	
	}
	
	/**
	 * Execute given query with the pagination details as requested.
	 * @param mixed $query The query
	 * @return array [$raw_query_results, $tota_row_count]
	 */
	protected final function paginate_query($query) : array {
		// Determine sort here instead of in before() method. This solves 
		// loads of problems
		$sort = \Input::get('sort', $this->default_sort_key);
		
		/* Apply search query to this SQL query. 
		Searches only apply on the currently sorted column defined by 'sort'. */
		if(isset($this->search) && ($this->search != '')) {
			$query->where_open();

			// Default behavior: search on sorted column
			$query = $query->where($sort, 'LIKE', '%' . $this->search . '%');
			
			# Perform additional searching			
			if (!empty($this->searchable_columns)) {
				$search_cols = $this->searchable_columns;
			} else if (!empty($this->sortable_columns)) {
				$search_cols = $this->sortable_columns;
			} 
			
			if (!empty($search_cols)) {
				$query->or_where_open();
				foreach ($search_cols as $col) {
					$query->or_where($col, 'LIKE', '%' . $this->search . '%');
				}
				$query->or_where_close();
			}

			$query->where_close();
		}
		
		// Reset sort key whenever it was defined as an unsortable column. 
		if(in_array($sort, $this->unsortable_columns)) {
			$sort = $this->default_sort_key;
		}
		
		// Reset sort key whenever it was not explicitly defined as sortable.
		if(!empty($this->sortable_columns) && !in_array($sort, $this->sortable_columns)) {
			$sort = $this->default_sort_key;
		}
		
		// Apply order
		$query->order_by($sort, $this->order);
		
		// Apply second order. This prevents unexpected behavior for some queries.
		if(isset($this->sort_secondary) && trim($this->sort_secondary) != '') {
			$query->order_by($this->sort_secondary);
		}
		
		// Apply query type specific actions
		try {
			if($query instanceof \Orm\Query) {
				$count = $query->count();
				$query
					->rows_offset($this->offset)
					->rows_limit($this->limit);			
				$result = $query->get();
			} else if($query instanceof \Database_Query_Builder_Select) {					
				$query
					->offset($this->offset)
					->limit($this->limit);			
				$result = $query->execute()->as_array();
				$count = \DB::count_last_query();
			} else {
				throw new FuelException("Query type unsupported for pagination");
			}	
		} catch (\Fuel\Core\Database_Exception $ex) {
			/* Catch faulty queries which may be created 
			by using non-existant properties as sort key */
			$result = [];
			$count = 0;
			throw $ex;
		}		
		return [$result, $count];
	}
	
	/**
	 * Paginate query and fetch into Response_Paginated class.
	 * @param mixed $query
	 * @return \Api\Response_Paginated
	 */
	protected final function paginate_fetch_into($query) : Response_Paginated {
		$arr = $this->paginate_query($query);
		return new Response_Paginated($arr[0], $arr[1]);
	}
}
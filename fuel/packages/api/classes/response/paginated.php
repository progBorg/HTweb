<?php

namespace Api;

/**
 * A paginated API response.
 * @author Melcher
 */
class Response_Paginated extends Response_Base {
	/**
	 * Total number of rows in table.
	 * @var int 
	 */
	public $total = 0;
	
	/**
	 * Total number of rows contained in this response.
	 * @var int
	 */
	public $current = 0;
	
	/**
	 * The actual row data.
	 * @var array
	 */
	public $rows = [];
	
	public function __construct(array $data, int $total = 0) {
		if(isset($data)) {
			if(isset($total)) {
				$this->total = $total;
			} else {
				$this->total = sizeof($data);
			}
			$this->current = sizeof($data);
			$this->rows = array_values($data);
		}
		
		
	}
}
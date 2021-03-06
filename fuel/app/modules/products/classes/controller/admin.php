<?php

namespace Products;

class Controller_Admin extends \Controller_Core_Theme {
	
	public function before() {
		$this->permission = Context_Products::MGMT_PERM;
		parent::before();
	}
	
	public function action_index() {
		$this->push_js('products-modals');
		
		$this->title = __('product.title');
		$this->title_page = __('product.title');
		$this->title_sub = __('privileges.perm.manage');
		$data['products'] = Model_Product::query()->where('settled', 0)->get();			
		$this->content = \View::forge('admin/index', $data);
	}
	
	public function action_create() {
		$this->push_js('products-modals');
		$this->title = __('product.title');
		$this->title_page = __('product.name');
		$this->title_sub = __('actions.create');		
		$this->content = \Presenter::forge('create', 'admin');
	}
}


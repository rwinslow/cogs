<?php
class Server_404 extends Frontend_Controller
{
	public function index()
	{
		/**
		 * Run parent index to:
		 *     - Get contact info
		 */
		parent::index();
		
		$this->prepend_to_title('Page Not Found');
		Cogs::view('Server_404_View');
		Cogs::render($this);
	}
}

/* End of Server_404 controller */
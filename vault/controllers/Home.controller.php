<?php
class Home extends Frontend_Controller
{
	public function index()
	{
		/**
		 * Run parent index to:
		 *     - Get contact info
		 */
		parent::index();

		Cogs::view('Home_View');
		Cogs::render($this);
	}
}

/* End of Home controller */
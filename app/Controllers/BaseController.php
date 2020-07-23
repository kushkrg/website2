<?php
namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use App\Libraries\GitHubHelper;
use CodeIgniter\Controller;

class BaseController extends Controller
{

	protected $data = []; // parameters for view components
	protected $id;   // identifier for our content

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = [];

    /**
     * @var GitHubHelper
     */
	protected $gitter;

	/**
	 * Initialization.
	 *
	 */
	public function __construct()
	{
		$this->config = config('App');
		$this->data['mybb_forum_url'] = $this->config->mybbForumURL;
		$this->errors = [];
		$this->gitter = new GitHubHelper();
	}

    /**
     * Render this page
     *
     * @param string $view The view file to render
     *
     * @return string
     */
	protected function render(string $view)
	{
	    $data = $this->data;

		if ( ! isset($data['pagetitle']))
        {
            $data['pagetitle'] = $data['title'];
        }

        $this->response->noCache();
        // Prevent some security threats, per Kevin
        // Turn on IE8-IE9 XSS prevention tools
        $this->response->setHeader('X-XSS-Protection', '1; mode=block');
        // Don't allow any pages to be framed - Defends against CSRF
        $this->response->setHeader('X-Frame-Options', 'DENY');
        // prevent mime based attacks
        $this->response->setHeader('X-Content-Type-Options', 'nosniff');

		// finally, assemble the browser page!
		echo view($view, $data);
	}
}

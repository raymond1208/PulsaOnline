<?php

class ReportController extends \BaseController {

	public function getIndex()
	{
		$user = Sentry::getUser();

		if ($user->hasAccess('report.best-seller-product'))
		{
			return View::make('admin.report.best-seller-product');
		}
	}
}

<?php

class AvelcaSettingController extends BaseController {


	public function postUpdateAnnouncement()
	{
		$rules = array(
			'message' => 'required'
			);
		
		return SettingController::updateSetting(Input::get('category'), $rules);
	}
	

}
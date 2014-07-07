<?php
class SettingSeeder extends Seeder
{
	public function run()
	{
		
		DB::table('settings')->where('category','=', 'announcement')->delete();
 
		Setting::create(array('category' => 'announcement', 'meta_data' => '{
			"message": {
				"type": "text",
				"value": "Diskon Hanya bulan ini"
			}
		}'));

	}
}
<?php
/**
 * Created by PhpStorm.
 * User: Jonas
 * Date: 2/22/2017
 * Time: 8:13 AM
 */

class AdminTableSeeder extends DatabaseSeeder{

    public function run(){
        DB::table('admin')->delete();
        //insert some dummy records
        DB::table('admin')->insert(array(
            array('name'=>'John','email'=>'admin1@admin.com','password'=>Hash::make('admin'), 'phone'=>'112312124', 'address'=>'cebu',
                'institution_name'=>'test', 'job_id'=>1),
            array('name'=>'Claude','email'=>'admin2@admin.com','password'=>Hash::make('admin'), 'phone'=>'112312124', 'address'=>'cebu',
                'institution_name'=>'test', 'job_id'=>2),
            array('name'=>'Van','email'=>'admin3@admin.com','password'=>Hash::make('admin'), 'phone'=>'112312124', 'address'=>'cebu',
                'institution_name'=>'test', 'job_id'=>3),
            array('name'=>'Dam','email'=>'admin4@admin.com','password'=>Hash::make('admin') , 'phone'=>'112312124', 'address'=>'cebu',
                'institution_name'=>'test', 'job_id'=>4),
        ));
    }
}
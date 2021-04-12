<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    public function index()
    {
         $services = Service::paginate(5);
         return view('admin.service.index', compact('services'));
    }


    public function store(Request $request)
    {
        $request->validate(
            [
                'service_name' => 'required|unique:services|max:255',
                'service_image' => 'required|mimes:jpg,jpeg,png'
            ],
            [
                'service_name.required' => "กรุณาป้อนชื่อบริการด้วยครับ",
                'service_name.max' => "ห้ามป้อนเกิน 255 ตัวอักษร",
                'service_name.unique' => "มีข้อมูลชื่อบริการนี้อยู่เเล้ว",
                'service_image.required' => "กรุณาใส่ภาพประกอบด้วยครับ",
            ]
        );


        //การเข้ารหัสรูปภาพ
        $service_image = $request->file('service_image');
        //Generate ชื่อภาพ
        $name_gen = hexdec(uniqid());
      
        //ดึงนามสกุลไฟล์ภาพ
        $img_ext = strtolower($service_image->getClientOriginalExtension());

        $img_name = $name_gen.'.'.$img_ext;
        dd($img_name);
    }
}

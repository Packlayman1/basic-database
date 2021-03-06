<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function index()
    {
        // $departments = Department::paginate(3);
        //$departments = DB::table('departments')->paginate(3);
        // $departments = Department::all();
        // $departments = DB::table('departments')->get();

         $departments = Department::paginate(5);
         $trashDepartments = Department::onlyTrashed()->paginate(3);
         return view('admin.department.index', compact('departments','trashDepartments'));

        // $departments = DB::table('departments')
        //     ->join('users', 'departments.user_id', 'users.id')
        //     ->select('departments.*', 'users.name')->paginate(5);
        // return view('admin.department.index', compact('departments'));
    }

    //post
    // dd($request->department_name);
    public function store(Request $request)
    {
        //ตรวจสอบข้อมูล
        $request->validate(
            [
                'department_name' => 'required|unique:departments|max:255'
            ],
            [
                'department_name.required' => "กรุณาป้อนชื่อแผนกด้วยครับ",
                'department_name.max' => "ห้ามป้อนเกิน 255 ตัวอักษร",
                'department_name.unique' => "มีข้อมูลชื่อแผนกนี้อยู่เเล้ว",
            ]
        );

        //บันทึกข้อมูล
        // $department = new Department;
        // $department->department_name = $request->department_name;
        // $department->user_id = Auth::user()->id;
        // $department->save();
        // return redirect()->back()->with('success',"บันทึกข้อมูลเรียบร้อย");


        //query builber
        $data = array();
        $data["department_name"] = $request->department_name;
        $data["user_id"] = Auth::user()->id;
        DB::table('departments')->insert($data);
        return redirect()->back()->with('success', "บันทึกข้อมูลเรียบร้อย");
    }

    public function edit($id)
    {
        // dd($id);
        $departments = Department::find($id);
        //    dd($department->department_name);
        return view('admin.department.edit', compact('departments'));
    }

    public function update(Request $request, $id)
    {

        $request->validate(
            [
                'department_name' => 'required|unique:departments|max:255'
            ],
            [
                'department_name.required' => "กรุณาป้อนชื่อแผนกด้วยครับ",
                'department_name.max' => "ห้ามป้อนเกิน 255 ตัวอักษร",
                'department_name.unique' => "มีข้อมูลชื่อแผนกนี้อยู่เเล้ว",
            ]
        );
        $update = Department::find($id)->update([
            'department_name' => $request->department_name,
            'user_id' => Auth::user()->id
        ]);
        return redirect()->route('department')->with('success', "อัพเดตข้อมูลเรียบร้อย");
        //    $departments = Department::find($id);

        //    return view('admin.department.edit',compact('departments'));
    }

    public function softdelete($id)
    {
     $delete = Department::find($id)->delete();  
     return redirect()->back()->with('success', "ลบข้อมูลเรียบร้อย");
    }

    public function restore($id)
    {
     $restore = Department::withTrashed()->find($id)->restore();  
     return redirect()->back()->with('success', "กู้คืนข้อมูลเรียบร้อย");
    }

    public function delete($id)
    {
     $delete = Department::onlyTrashed()->find($id)->forceDelete();  
     return redirect()->back()->with('success', "ลบข้อมูลถาวรเรียบร้อย");
    }



    
}

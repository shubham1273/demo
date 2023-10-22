<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\Todo;
use App\Http\Requests\TodoRequest;
use Validator;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $todo = Todo::get();

        return response()->json([
            'success' => true, 
            'message' => 'All Todo List',
            'data' => $todo
        ], 
        200);
    }

    public function statusList(Request $request)

    {
     $todo = Todo::where('status',$request->status)->get();

     return response()->json([
        'success' => true, 
        'message' => 'Todo List Of Your Status.',
        'data' => $todo
    ], 
    200);

 }

 public function markTodo(Request $request)

 {
     
   Todo::where('id', $request->id)->update(['status' => $request->status]);

   return response()->json([
    'success' => true, 
    'message' => 'Marked Todo.',
    
], 
200);

}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'                 => 'required|string|regex:/^[\pL\s]+$/u|max:250',

            'task_date'                 => 'required|date_format:"d-m-Y"',
        ]);
        
        $validator->after(function ($validator) use ($request) {
            
        });

        if ($validator->fails()) {
            return response()->json([
                'success' => false, 
                'message' => $validator->errors()->first()
            ], 
            500);
        }


        $data['name'] = $request->name;
        $data['task_date']= $request->task_date;
        $data['status']= 'pending';

        $todo = Todo::create($data);


        return response()->json([
            'success' => true, 
            'message' => 'Task created successfully.',
            'data' => $todo
        ], 
        200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $validator = Validator::make($request->all(), [
        'name'                 => 'required|string|regex:/^[\pL\s]+$/u|max:250',

        'task_date'                 => 'required|date_format:"d-m-Y"',
    ]);
      
      $validator->after(function ($validator) use ($request) {
        
      });

      if ($validator->fails()) {
        return response()->json([
            'success' => false, 
            'message' => $validator->errors()->first()
        ], 
        500);
    }

    $data['name'] = $request->name;
    $data['task_date']= $request->task_date;


    $todo = Todo::where('id', $id)->update($data);


    return response()->json([
        'success' => true, 
        'message' => 'Task updated successfully.'
    ], 
    200);
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Todo::where('id', $id)->delete();

        return response()->json([
            'success' => true, 
            'message' => 'Task deleted successfully.', 

        ], 
                                200);  //
    }
}

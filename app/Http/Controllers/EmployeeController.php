<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Repositories\TaskRepositories;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\EmployeeRepositories;

class EmployeeController extends Controller
{

    public function __construct(protected EmployeeRepositories $employeeRepositories,
        protected TaskRepositories $taskRepositories
    ){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->employeeRepositories->index(['projectsByEmployee'], ['role' => 'employee']);
        return view('employee',compact('data'));    
    }

    public function update(UpdateUserRequest $request, string $id)
    {
        
        $this->employeeRepositories->update($request->validated(),$id);
        return redirect()->route('employees.index');
    }

   
    
}

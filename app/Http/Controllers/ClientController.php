<?php

namespace App\Http\Controllers;

use App\Repositories\ClientRepositories;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct(protected ClientRepositories $clientRepositories)
    {
        
    }
    public function index()
    {
        $data = $this->clientRepositories->index(['projectsByClient'],['role'=>'client']);
        return view('client',compact('data'));
    }

    public function update(Request $request, string $id)
    {
         $data=$request->validate([
            'name'=>'required',
            'email'=>'required'
        ]);
        $this->clientRepositories->update($data ,$id);
        return redirect()->route('clients.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->clientRepositories->destroy($id);
        return redirect()->route('clients.index');
    }
}

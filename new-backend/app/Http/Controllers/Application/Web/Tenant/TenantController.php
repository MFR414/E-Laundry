<?php

namespace App\Http\Controllers\Application\Web\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;
use DB;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tenants = Tenant::orderBy('name', 'asc');

        if(!empty($request->name)){
            $tenants = $tenants->where('name', 'LIKE', '%'.$request->name.'%');
        }

        if(!empty($request->phone_number)){
            $tenants = $tenants->where('phone_number', 'LIKE', '%'.$request->phone_number.'%');
        }

        if(!empty($request->address)){
            $tenants = $tenants->where('address', 'LIKE', '%'.$request->address.'%');
        }

        $tenants = $tenants->paginate(20);

        return view('application.tenants.index',[
            'tenants' => $tenants,
            'active_page' => 'tenants',
            'search_terms'=>[
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('application.tenants.create',[
            'active_page' => 'tenants',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         // Validate
         $validation_rules = [
            'name' => 'required',
            'address' => 'required|unique:users,username,NULL,id,deleted_at,NULL',
            'phone_number' => 'required|numeric|min:10',
        ];

        $this->validate($request,$validation_rules);

        $tenant = Tenant::where('name', $request->name)->first();
        if(empty($tenant)){
            $tenant = new Tenant();
        } else {
            return redirect()->back()->with('error_message', 'Nama cabang ini sudah terpakai, silahkan gunakan nama lain untuk menambahkan cabang baru');
        }

        $tenant = DB::transaction(function () use ($tenant,$request){
            $tenant->name = $request->name;
            $tenant->address = $request->address;
            $tenant->phone_number = $request->phone_number;
            $tenant->save(); 

            return $tenant;
        });

        if(empty($tenant)){
            return redirect()->back()->with('error_message', 'Mohon maaf sistem sedang mengalami masalah, silahkan coba lagi dalam beberapa saat.');
        } else {
            return redirect()
            ->route('application.tenants.index')
            ->with('success_message', 'Berhasil menambahkan cabang '.$tenant->name.'!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tenant = Tenant::find($id);

        if(empty($tenant)){
            return redirect()->back()->with('error_message', 'Mohon maaf data cabang tidak ditemukan, silahkan coba lagi dalam beberapa saat.');
        }

        return view('application.tenants.edit',[
            'tenant' => $tenant,
            'active_page' => 'tenants',
        ]);
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
         // Validate
         $validation_rules = [
            'name' => 'required',
            'address' => 'required|unique:users,username,NULL,id,deleted_at,NULL',
            'phone_number' => 'required|numeric|min:10',
        ];

        $this->validate($request,$validation_rules);

        $tenant = Tenant::find($id);
        if(empty($tenant)){
            return redirect()->back()->with('error_message', 'Mohon maaf data cabang yang dipilih tidak ditemukan, silahkan coba lagi dalam beberapa saat.');
        }

        $tenant = DB::transaction(function () use ($tenant,$request){
            $tenant->name = $request->name;
            $tenant->address = $request->address;
            $tenant->phone_number = $request->phone_number;
            $tenant->save(); 

            return $tenant;
        });

        if(empty($tenant)){
            return redirect()->back()->with('error_message', 'Mohon maaf sistem sedang mengalami masalah, silahkan coba lagi dalam beberapa saat.');
        }else{
            return redirect()
            ->route('application.tenants.index')
            ->with('success_message', 'Berhasil mengupdate data cabang '.$tenant->name.'!');   
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tenant = Tenant::find($id);
        if(empty($tenant)){
            return redirect()->back()->with('error_message', 'Mohon maaf data cabang tidak ditemukan, silahkan coba lagi dalam beberapa saat.');
        }

        $tenantName = $tenant;
        $tenant->delete();

        return redirect()
        ->route('application.tenants.index')
        ->with('success_message', 'Berhasil menghapus data cabang '.$tenantName.'!');
    }
}

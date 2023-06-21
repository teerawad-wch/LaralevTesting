<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    //Index
    public function index()
    {
        $data['customers'] = Customer::orderBy('id', 'desc')->paginate(10);
        return view('customers.index', $data);
    }

    //Costomer Create 
    public function create()
    {
        return view('customers.create');
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    //Costomer Insert
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'name' => 'required',
            'email' => 'required',
            'telephone' => 'required',
            'status' => 'required',

        ]);

        $customer = new Customer;
        $customer->code = $request->code;
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->telephone = $request->telephone;
        $customer->status = $request->status;
        $customer->save();
        return redirect()->route('customers.index')->with('success','Costomer has been created successfully.');
    }
    //Costomer Update
    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required',
            'name' => 'required',
            'email' => 'required',
            'telephone' => 'required',
            'status' => 'required',
        ]);
        $customer = Customer::find($id);
        $customer->code = $request->code;
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->telephone = $request->telephone;
        $customer->status = $request->status;
        $customer->save();

        return redirect()->route('customers.index')->with('success', 'Costomer Has Been updated successfully');
    }
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success','Costomer has been deleted successfully');
    }

    public function multipleUpdate(Request $request)
    {
        $customers = $request->datas;

        foreach ($customers as $customer) {
            Customer::where('id', $customer['id'])->update(['status' => $customer['status']]);
        }
        $responses = [
            'success' => true,
            'message'=> 'Multiple update costomers status successfully'
        ];
        return response()->json($responses);
    }

    public function multipleDelete(Request $request)
    {
        $id = $request->customerId;
        // Delete the selected items
        Customer::whereIn('id', $id)->delete();
        $responses = [
            'success' => true,
            'message'=> 'Multiple delete costomers successfully'
        ];
        return response()->json($responses);
    }



}
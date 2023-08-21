<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Transaction;
use App\Http\Resources\TransactionResource;
use Illuminate\Support\Facades\Validator;

class TransactionController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = auth()->user()->id;
        $transactions = Transaction::where('user_id', $userId)->orderBy('created_at', 'desc')->get();
        return $this->sendResponse(TransactionResource::collection($transactions), 'Transactions retrieved successfully.');
    }

    // /**
    //  * Show the form for creating a new resource.
    //  */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|string',
            'category_id' => 'required|int',
            'amount' => 'required|numeric',
            'date' => 'nullable|datetime',
            'is_income' => 'nullable|boolean'
        ]);
        $input['user_id'] = auth()->user()->id;
        if(!isset($input['date'])) {
            $input['date'] = date('Y-m-d H:i:s'); 
        }

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $transaction = Transaction::create($input);
   
        return $this->sendResponse(new TransactionResource($transaction), 'Transaction created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaction = Transaction::find($id);
  
        if (is_null($transaction)) {
            return $this->sendError('Transaction not found.');
        }
   
        return $this->sendResponse(new TransactionResource($transaction), 'Transaction retrieved successfully.');
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(string $id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'nullable|string',
            'category_id' => 'nullable|int',
            'amount' => 'nullable|numeric',
            'date' => 'nullable|datetime',
            'is_income' => 'nullable|boolean'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        
        if(isset($input['name'])) {
            $transaction->name = $input['name'];
        }
        if(isset($input['category_id'])) {
            $transaction->category_id = $input['category_id'];
        }
        if(isset($input['amount'])) {
            $transaction->amount = $input['amount'];
        }
        if(isset($input['date'])) {
            $transaction->date = $input['date'];
        }
        if(isset($input['is_income'])) {
            $transaction->is_income = $input['is_income'];
        }
        $transaction->save();
   
        return $this->sendResponse(new TransactionResource($transaction), 'Transaction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        
        return $this->index();
    }
}

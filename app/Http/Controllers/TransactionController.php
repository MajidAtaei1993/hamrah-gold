<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // load reletions
            $transactions = Transaction::with(['user'])->orderBy('created_at', 'desc')->paginate(10);

            return response()->json([
                'data' => TransactionResource::collection($transactions),
                'meta' => [
                    'current_page' => $transactions->currentPage(),
                    'first_page_url' => $transactions->url(1),
                    'from' => $transactions->firstItem(),
                    'last_page' => $transactions->lastPage(),
                    'last_page_url' => $transactions->url($transactions->lastPage()),
                    'links' => $transactions->toArray()['links'],
                    'next_page_url' => $transactions->nextPageUrl(),
                    'prev_page_url' => $transactions->previousPageUrl(),
                    'path' => $transactions->path(),
                    'per_page' => $transactions->perPage(),
                    'to' => $transactions->lastItem(),
                    'total' => $transactions->total()
                ],
                // "total" => number_format($totalOrders, 0, '.', ',')
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransactionRequest $request)
    {
        // // get gold price from tgju
        // $tgju = new TgjuController();
        // $goldPrice = $tgju->price();
        $firstUser = User::first();
        try {
            $transaction = Transaction::create([
                // 'user_id' => $request->user_id,
                'user_id' => $firstUser ? $firstUser->id : null,
                'weight' => $request->weight,
                "type" => $request->type,
                // 'price' => $request->type === Transaction::TYPE_BUY ? $goldPrice->buy_price : $goldPrice->sell_price,
                'price' => $request->price,
                'fee' => $request->fee,
            ]);
            return response()->json([ 
                'message' => 'تراکنش با موفقیت ثبت شد',
                'data'    => new TransactionResource($transaction->load('user'))
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        try {
            $resp = Transaction::where('user_id', $transaction->user_id)->with('user')->get();
            return response()->json([
                'message' => "تراکنش استخراج شد",
                "data" => $resp
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}

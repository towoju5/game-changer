<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\PayButtonModel;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('items')
            ->where('user_id', auth()->user()->id)
            ->get();

        return view('dashboard.invoice.index', compact('invoices'));
    }

    public function create()
    {
        return view('dashboard.invoice.create');
    }

    public function store(Request $request)
    {
        $invoiceData = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'items' => 'required|array',
            'items.*.description' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0.01',
        ]);

        $invoice = Invoice::create([
            'customer_name' => $invoiceData['customer_name'],
            'customer_email' => $invoiceData['customer_email'],
            'user_id' => auth()->user()->id,
            'total' => array_reduce($invoiceData['items'], function ($carry, $item) {
                return $carry + ($item['quantity'] * $item['price']);
            }, 0),
        ]);

        foreach ($invoiceData['items'] as $item) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'description' => $item['description'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        return redirect()->route('invoice.list', $invoice);
    }

    public function show($invoice)
    {
        $where = [
            'user_id' => auth()->user()->id,
            'id' => $invoice,
        ];
        $invoice = Invoice::with('items')->where($where)->first();
        return view('dashboard.invoice.show', compact('invoice'));
    }


    public function destroy($invoice)
    {
        $invoice = Invoice::findOrFail($invoice)->delete();
        return redirect()->route('invoice.list')->with('success', 'Invoice deleted successfully');
    }

    public function payButton(Request $request)
    {
        try {
            $request->validate([
                'amount' => 'required|numeric',
                'currency' => 'required|string',
                'marchantId' => 'required|string'
            ]);

            // initiate inoice and checkout the customer.
            $button = new PayButtonModel();
            $button->fill([
                // 'id' => generate_uuid(),
                'amount' => $request->amount,
                'currency' => $request->currency,
                'marchantId' => $request->marchantId,
            ]);

            if($button->save()) {
                return redirect(route('checkout.button', ['payId' => $button->id, 'cmd' => 'invoice', 'utm_source' => 'paybutton']));
            }

            // return response([
            //     'data' => $button
            // ]);
        } catch (\Throwable $th) {
            return response()->json(['data' => $th->getMessage()]);
            return back()->with('error', $th->getMessage());
        }
    }

    public function getButtonInvoice(Request $request)
    {
        try {
            $getButton = PayButtonModel::findorfail(2);
            return response()->json($getButton);
            return view('crypto.invoice', compact([
                'data' => $getButton
            ]));
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}

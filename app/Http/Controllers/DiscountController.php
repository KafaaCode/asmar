<?php

namespace App\Http\Controllers;

use App\Models\discount;
use App\Models\User;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    // عرض كل الخصومات
    public function index()
    {
        $discounts = Discount::with('user')->get();
        return view('discounts.index', compact('discounts'));
    }

    // عرض نموذج إنشاء خصم
    public function create()
    {
        $users = User::all();
        return view('discounts.create', compact('users'));
    }

    // حفظ الخصم في قاعدة البيانات
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
        ]);

        discount::create($request->only('user_id', 'amount'));

        return back()->with('success', 'تم إضافة الخصم بنجاح');
    }


    // عرض نموذج تعديل خصم
    public function edit($id)
    {
        $discount = Discount::findOrFail($id);
        $users = User::all();
        return view('discounts.edit', compact('discount', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        $discount = Discount::findOrFail($id);
        $discount->update(['amount' => $request->amount]);

        return back()->with('success', 'تم تعديل نسبة الخصم بنجاح');
    }


    // حذف الخصم
    public function destroy($id)
    {
        $discount = Discount::findOrFail($id);
        $discount->delete();

        return redirect()->route('discounts.index')->with('success', 'تم حذف الخصم بنجاح');
    }
}

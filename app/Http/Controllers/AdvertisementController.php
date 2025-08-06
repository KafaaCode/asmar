<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdvertisementController extends Controller
{
    public function index()
    {
        $advertisement = Advertisement::first();
        return view('admin.settings.advertisements', compact('advertisement'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'actve' => 'required|boolean',
        ]);

        $data = $request->only(['description', 'actve']);

        // معالجة الصورة إذا وُجدت
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة إن وجدت
            $oldAd = Advertisement::first();
            if ($oldAd && $oldAd->image && File::exists(public_path('uploads/ads/' . $oldAd->image))) {
                File::delete(public_path('uploads/ads/' . $oldAd->image));
            }

            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/ads'), $filename);
            $data['image'] = $filename;
        }

        // حفظ الإعلان - تعديل أو إنشاء جديد
        $advertisement = Advertisement::first();
        if ($advertisement) {
            $advertisement->update($data);
        } else {
            Advertisement::create($data);
        }

        return redirect()->back()->with('success', 'تم الحفظ بنجاح');
    }

    public function destroy($id)
    {
        $advertisement = Advertisement::findOrFail($id);

        if ($advertisement->image && File::exists(public_path('uploads/ads/' . $advertisement->image))) {
            File::delete(public_path('uploads/ads/' . $advertisement->image));
        }

        $advertisement->delete();

        return redirect()->back()->with('success', 'تم حذف الإعلان بنجاح.');
    }
}

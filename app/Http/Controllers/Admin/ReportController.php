<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Report;
use App\Models\User;
use App\Support\Foto;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $f = $request->validate([
            'tanggal' => 'nullable|date_format:Y-m-d',
            'bulan' => 'nullable|date_format:Y-m',
            'siswa' => 'nullable|integer',
            'kategori' => 'nullable|integer',
            'status' => ['nullable', Rule::in(array_keys(Report::ALUR))],
        ]);

        $query = Report::with('user', 'category')->latest();

        if (! empty($f['tanggal'])) {
            $awal = Carbon::parse($f['tanggal']);
            $query->where('created_at', '>=', $awal)->where('created_at', '<', $awal->copy()->addDay());
        }
        if (! empty($f['bulan'])) {
            $awal = Carbon::parse($f['bulan'] . '-01');
            $query->where('created_at', '>=', $awal)->where('created_at', '<', $awal->copy()->addMonth());
        }
        if (! empty($f['siswa'])) {
            $query->where('user_id', $f['siswa']);
        }
        if (! empty($f['kategori'])) {
            $query->where('category_id', $f['kategori']);
        }
        if (! empty($f['status'])) {
            $query->where('status', $f['status']);
        }

        return view('admin.index', [
            'reports' => $query->paginate(10)->withQueryString(),
            'rekap' => Report::selectRaw('status, count(*) as jumlah')->groupBy('status')->pluck('jumlah', 'status'),
            'categories' => Category::orderBy('name')->get(),
            'siswa' => User::where('role', 'siswa')->orderBy('name')->get(['id', 'name', 'classroom']),
            'f' => $f,
        ]);
    }

    public function tanggapi(Request $request, Report $report)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(array_keys(Report::ALUR))],
            'note' => 'required|max:1000',
            'photo' => 'nullable|mimes:jpg,jpeg,png|max:4096',
        ]);

        // Status hanya boleh tetap, atau maju lewat langkah yang sah
        if ($data['status'] !== $report->status && ! $report->bolehKe($data['status'])) {
            return back()->withErrors(['status' => "Laporan berstatus {$report->status} tidak bisa diubah menjadi {$data['status']}."]);
        }

        DB::transaction(function () use ($request, $report, $data) {
            $report->updates()->create([
                'user_id' => $request->user()->id,
                'status' => $data['status'],
                'note' => $data['note'],
                'photo' => $request->hasFile('photo') ? Foto::simpan($request->file('photo')) : null,
            ]);
            $report->status = $data['status'];
            $report->save();
        });

        return back()->with('pesan', 'Tanggapan tersimpan.');
    }
}

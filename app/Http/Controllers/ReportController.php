<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Report;
use App\Models\ReportUpdate;
use App\Support\Foto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $reports = $request->user()->reports()->with('category')->latest()->paginate(10);

        return view('reports.index', compact('reports'));
    }

    public function create()
    {
        return view('reports.create', ['categories' => Category::orderBy('name')->get()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|max:100',
            'location' => 'required|max:100',
            'description' => 'required|max:2000',
            'photo' => 'nullable|mimes:jpg,jpeg,png|max:4096',
        ]);

        $report = DB::transaction(function () use ($request, $data) {
            $report = new Report($data);
            $report->user_id = $request->user()->id;
            if ($request->hasFile('photo')) {
                $report->photo = Foto::simpan($request->file('photo'));
            }
            $report->save();

            $report->updates()->create([
                'user_id' => $request->user()->id,
                'status' => 'baru',
                'note' => 'Laporan dibuat.',
            ]);

            return $report;
        });

        return redirect()->route('laporan.show', $report)->with('pesan', 'Laporan terkirim.');
    }

    public function show(Report $report)
    {
        Gate::authorize('view', $report);
        $report->load('category', 'user', 'updates.user');

        return view('reports.show', compact('report'));
    }

    public function foto(Report $report)
    {
        Gate::authorize('view', $report);
        abort_unless($report->photo, 404);

        return Storage::response($report->photo);
    }

    public function fotoRiwayat(ReportUpdate $update)
    {
        Gate::authorize('view', Report::findOrFail($update->report_id));
        abort_unless($update->photo, 404);

        return Storage::response($update->photo);
    }
}

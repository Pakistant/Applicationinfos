<?php

namespace App\Http\Controllers;

use App\Http\Requests\Kiosk\StoreKioskIssueRequest;
use App\Http\Requests\Kiosk\UpdateKioskIssueRequest;
use App\Models\KioskIssue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KioskIssueController extends Controller
{
    public function publicIndex()
    {
        $issues = KioskIssue::with('author')->where('isActive', true)->latest()->get();

        return view('Front.kiosk.index', compact('issues'));
    }

    public function index()
    {
        $issues = Auth::user()->role === 'admin'
            ? KioskIssue::with('author')->latest()->get()
            : KioskIssue::with('author')->where('author_id', Auth::id())->latest()->get();

        return view('Admin.Kiosk.index', compact('issues'));
    }

    public function create()
    {
        return view('Admin.Kiosk.create');
    }

    public function store(StoreKioskIssueRequest $request)
    {
        $data = $request->validated();
        $data['pdf'] = $request->file('pdf')->store('kiosk', 'public');
        $data['cover'] = $request->file('cover')?->store('kiosk/covers', 'public');
        $data['author_id'] = Auth::id();

        KioskIssue::create($data);

        return to_route('kiosk.index')->with('success', 'Journal ajouté au kiosque.');
    }

    public function show(KioskIssue $kiosk)
    {
        abort_unless($kiosk->isActive || Auth::check(), 404);

        return view('Front.kiosk.show', ['issue' => $kiosk]);
    }

    public function edit(KioskIssue $kiosk)
    {
        $this->ensureCanManage($kiosk);

        return view('Admin.Kiosk.create', ['issue' => $kiosk]);
    }

    public function update(UpdateKioskIssueRequest $request, KioskIssue $kiosk)
    {
        $this->ensureCanManage($kiosk);
        $data = $request->validated();

        if ($request->hasFile('pdf')) {
            Storage::disk('public')->delete($kiosk->pdf);
            $data['pdf'] = $request->file('pdf')->store('kiosk', 'public');
        }
        if ($request->hasFile('cover')) {
            Storage::disk('public')->delete($kiosk->cover);
            $data['cover'] = $request->file('cover')->store('kiosk/covers', 'public');
        }

        $kiosk->update($data);

        return to_route('kiosk.index')->with('success', 'Journal modifié.');
    }

    public function destroy(KioskIssue $kiosk)
    {
        $this->ensureCanManage($kiosk);
        Storage::disk('public')->delete(array_filter([$kiosk->pdf, $kiosk->cover]));
        $kiosk->delete();

        return back()->with('success', 'Journal supprimé du kiosque.');
    }

    private function ensureCanManage(KioskIssue $kiosk): void
    {
        abort_unless(Auth::user()->role === 'admin' || $kiosk->author_id === Auth::id(), 403);
    }
}
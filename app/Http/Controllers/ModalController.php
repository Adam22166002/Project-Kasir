<?php
namespace App\Http\Controllers;
use App\Models\Modal;
use Illuminate\Http\Request;

class ModalController extends Controller
{
    public function index()
    {
        $modals = Modal::all();
        return view('modal.index', compact('modals'));
    }

    public function create()
    {
        return view('modal.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        Modal::create($request->all());

        return redirect()->route('modal.index')->with('success', 'Modal berhasil ditambahkan.');
    }
}

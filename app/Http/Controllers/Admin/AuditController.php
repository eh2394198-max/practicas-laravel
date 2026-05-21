<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Audit;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    public function __construct()
    {
        // Solo el administrador puede ver el historial global de auditoría
        $this->middleware('role:admin');
    }

    /**
     * Muestra la lista general de todas las acciones registradas.
     * PASO 5 de la Práctica: Visualización de bitácora.
     */
    public function index()
    {
        $audits = Audit::latest()->paginate(20);
        return view('admin.audits.index', compact('audits'));
    }

    /**
     * Muestra el detalle de una auditoría específica (valores viejos vs nuevos).
     */
    public function show(Audit $audit)
    {
        return view('admin.audits.show', compact('audit'));
    }
}
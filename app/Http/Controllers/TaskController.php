<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Models\Event;
use App\Models\Tkelas;
use App\Models\Tkelsis;
use App\Models\Tsiswa;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function __construct(private readonly TaskService $taskService)
    {
    }

    public function create($id): View
    {
        $isikelas = Tkelas::findOrFail($id);
        $siswa    = Tsiswa::where('kel', $isikelas->nam)
                        ->orderBy('namlen', 'asc')
                        ->get();

        $mataPelajaran = $this->taskService->getMataPelajaranForGuruDiKelas(
            Auth::guard('guru')->user()->idguru,
            (int) $id
        );

        if ($mataPelajaran->isEmpty()) {
            abort(403, 'Anda tidak terdaftar mengajar di kelas ini.');
        }

        return view('tasks.create', compact('isikelas', 'siswa', 'mataPelajaran'));
    }

    public function store(StoreTaskRequest $request, $id)
    {
        $data = $request->validated();
        $data['mapel'] = $request->resolvedMapel();

        $this->taskService->store(
            $data,
            $request->file('lampiran'),
            $request->resolvedIdGuru(),
            $request->resolvedIdPelajaran()
        );

        return redirect()->back()->with('success', 'Tugas berhasil dibuat');
    }

    public function index(): View
    {
        $tasks = Event::query()
            ->with(['category', 'targets'])
            ->where('kategori_id', 3)
            ->latest('start_at')
            ->paginate(15);

        return view('admin.tasks.index', compact('tasks'));
    }

    public function studentsByClass(Request $request): JsonResponse
    {
        $request->validate(['idkel' => ['required', 'integer']]);

        $students = Tkelsis::query()
            ->where('idkel', $request->integer('idkel'))
            ->with('siswa:id,namlen')
            ->get()
            ->filter(fn ($row) => $row->siswa !== null)
            ->map(fn ($row) => [
                'id'   => $row->siswa->id,
                'nama' => $row->siswa->namlen,
            ])
            ->values();

        return response()->json($students);
    }
}
<?php

namespace App\Http\Controllers\corporate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\corporate\PhysicalAvailability;
use App\Models\corporate\Profitve;
use App\Models\corporate\Verev;
use App\Models\periode\Event;
use Illuminate\Support\Facades\DB;

class CorpVEController extends Controller
{
    public function index(Request $request)
    {
        // Ambil tahun dari request, jika tidak ada, gunakan tahun default
        $selectedYear = $request->input('year', date('Y'));
        // Ambil verevs yang sesuai dengan tahun dari tabel events
        $verevs = Verev::whereHas('event', function ($query) use ($selectedYear) {
            $query->where('year', $selectedYear);
        })->get();
        // Ambil semua events untuk ditampilkan pada dropdown filter
        $events = Event::distinct('year')->pluck('year');

        // Menghitung data berdasarkan event_id yang sama
        $dataSUM = Verev::select(
            'verevs.event_id as event_id',
            \DB::raw('SUM(verevs.value) as count'),
            // \DB::raw('MAX(verevs.updated_at) as latest_updated_at,'),
            \DB::raw('MAX(profitves.value) as total_profit'),
            \DB::raw('MAX(physical_availabilities.value) as total_physical_availabilities')
        )
            ->leftJoin('profitves', 'verevs.event_id', '=', 'profitves.event_id')
            ->leftJoin('physical_availabilities', 'verevs.event_id', '=', 'physical_availabilities.event_id')
            ->whereHas('event', function ($query) use ($selectedYear) {
                $query->where('year', $selectedYear);
            })
            ->groupBy('verevs.event_id')
            ->get();


        $item = Verev::select('updated_at')->latest()->first();
        // dd($item);


        $semesterSums = [];
        $semester = $dataSUM->chunk(6);

        foreach ($semester as $index => $item) {
            $chunkSum = $item->sum('count');
            $chunkMax = $item->sum('total_profit');

            $semesterSums[$index] = [
                'semester' => $index + 1,
                'total_value' => $chunkSum,
                'total_profit' => $chunkMax,
                // You may add other fields you want to sum here
            ];
        }
        // dd($semester);

        // Ambil verevs yang sesuai dengan tahun dari tabel events
        $records = DB::table('verevs')
            ->selectRaw('verevs.job_id as job_id,
                            jobs.name as job_name,
                            SUM(verevs.value) as total_value,
                            (SUM(verevs.value) / (SELECT SUM(value) FROM verevs)) * 100 as percentage')
            ->leftJoin('jobs', 'verevs.job_id', '=', 'jobs.id')
            ->leftJoin('events', 'verevs.event_id', '=', 'events.id') // Adjust the relationship based on your actual database structure
            ->where('events.year', $selectedYear) // Adjust the column name based on your actual database structure
            ->groupBy('job_id')
            ->orderByDesc('total_value')
            ->take(3)
            ->get();


        return view('internaldashboard.corpVE.dashboardCorp-2024', compact('verevs', 'events', 'selectedYear', 'dataSUM', 'semesterSums', 'item', 'records'));
    }
}
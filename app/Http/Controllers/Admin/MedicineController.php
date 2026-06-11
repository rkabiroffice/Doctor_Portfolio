<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function index(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $search = $request->string('search');

        $medicines = Medicine::when($search, fn ($query) => $query->where('name', 'like', '%'.$search.'%'))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.medicines.index', compact('medicines', 'search'));
    }

    public function create()
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.medicines.create');
    }

    public function store(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'generic_name' => ['nullable', 'string', 'max:255'],
            'strength' => ['nullable', 'string', 'max:100'],
            'dosage_form' => ['nullable', 'string', 'max:100'],
            'manufacturer' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        Medicine::create($validated);

        return redirect()->route('admin.medicines.index')->with('success', 'Medicine added successfully.');
    }

    public function edit(Medicine $medicine)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.medicines.edit', compact('medicine'));
    }

    public function update(Request $request, Medicine $medicine)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'generic_name' => ['nullable', 'string', 'max:255'],
            'strength' => ['nullable', 'string', 'max:100'],
            'dosage_form' => ['nullable', 'string', 'max:100'],
            'manufacturer' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $medicine->update($validated);

        return redirect()->route('admin.medicines.index')->with('success', 'Medicine updated successfully.');
    }

    public function destroy(Medicine $medicine)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $medicine->delete();

        return redirect()->route('admin.medicines.index')->with('success', 'Medicine deleted successfully.');
    }

    public function search(Request $request)
    {
        if (! session('admin_logged_in')) {
            return response()->json(['medicines' => []]);
        }

        $search = $request->string('q')->trim();
        if ($search === '' || mb_strlen($search) < 2) {
            return response()->json(['medicines' => []]);
        }

        $medicines = Medicine::where(function ($query) use ($search) {
                $query->whereNotNull('name')
                    ->where('name', 'like', '%'.$search.'%');
            })
            ->orWhere(function ($query) use ($search) {
                $query->whereNull('name')
                    ->where('generic_name', 'like', '%'.$search.'%');
            })
            ->orderBy('name')
            ->limit(10)
            ->get(['id', 'name', 'generic_name', 'strength', 'manufacturer']);

        return response()->json(['medicines' => $medicines]);
    }

    public function export($format)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $medicines = Medicine::orderBy('name')->get();

        if ($format === 'csv') {
            $filename = 'medicines_' . date('Y-m-d_His') . '.csv';
            $handle = fopen('php://output', 'w');
            
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            
            fputcsv($handle, ['Name', 'Generic Name', 'Strength', 'Dosage Form', 'Manufacturer', 'Notes']);
            
            if ($medicines->isEmpty()) {
                fputcsv($handle, ['No data available', '', '', '', '', '']);
            } else {
                foreach ($medicines as $medicine) {
                    fputcsv($handle, [
                        $medicine->name,
                        $medicine->generic_name ?? '',
                        $medicine->strength ?? '',
                        $medicine->dosage_form ?? '',
                        $medicine->manufacturer ?? '',
                        $medicine->notes ?? ''
                    ]);
                }
            }
            
            fclose($handle);
            exit;
        }

        if ($format === 'excel') {
            $filename = 'medicines_' . date('Y-m-d_His') . '.xls';
            
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            
            echo '<table border="1">';
            echo '<thead><tr><th>Name</th><th>Generic Name</th><th>Strength</th><th>Dosage Form</th><th>Manufacturer</th><th>Notes</th></tr></thead>';
            echo '<tbody>';
            
            if ($medicines->isEmpty()) {
                echo '<tr><td colspan="6" style="text-align:center;">No data available</td></tr>';
            } else {
                foreach ($medicines as $medicine) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($medicine->name) . '</td>';
                    echo '<td>' . htmlspecialchars($medicine->generic_name ?? '') . '</td>';
                    echo '<td>' . htmlspecialchars($medicine->strength ?? '') . '</td>';
                    echo '<td>' . htmlspecialchars($medicine->dosage_form ?? '') . '</td>';
                    echo '<td>' . htmlspecialchars($medicine->manufacturer ?? '') . '</td>';
                    echo '<td>' . htmlspecialchars($medicine->notes ?? '') . '</td>';
                    echo '</tr>';
                }
            }
            
            echo '</tbody></table>';
            exit;
        }

        if ($format === 'pdf') {
            $html = '<html><head><style>body{font-family:Arial,sans-serif;font-size:12px;}table{width:100%;border-collapse:collapse;margin-top:20px;}th,td{border:1px solid #ddd;padding:8px;text-align:left;}th{background-color:#f4f4f4;font-weight:bold;}h1{text-align:center;color:#333;}</style></head><body>';
            $html .= '<h1>Medicines Report</h1>';
            $html .= '<p>Generated on: ' . date('d M Y H:i:s') . '</p>';
            $html .= '<table><thead><tr><th>Name</th><th>Generic</th><th>Strength</th><th>Form</th><th>Manufacturer</th></tr></thead><tbody>';
            
            if ($medicines->isEmpty()) {
                $html .= '<tr><td colspan="5" style="text-align:center;">No data available</td></tr>';
            } else {
                foreach ($medicines as $medicine) {
                    $html .= '<tr>';
                    $html .= '<td>' . htmlspecialchars($medicine->name) . '</td>';
                    $html .= '<td>' . htmlspecialchars($medicine->generic_name ?? 'N/A') . '</td>';
                    $html .= '<td>' . htmlspecialchars($medicine->strength ?? 'N/A') . '</td>';
                    $html .= '<td>' . htmlspecialchars($medicine->dosage_form ?? 'N/A') . '</td>';
                    $html .= '<td>' . htmlspecialchars($medicine->manufacturer ?? 'N/A') . '</td>';
                    $html .= '</tr>';
                }
            }
            
            $html .= '</tbody></table></body></html>';
            
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="medicines_' . date('Y-m-d_His') . '.pdf"');
            
            echo $html;
            exit;
        }

        return redirect()->route('admin.medicines.index');
    }

    public function downloadSample($format)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        if ($format === 'csv') {
            $filename = 'medicines_sample_template.csv';
            $handle = fopen('php://output', 'w');
            
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            
            fputcsv($handle, ['Name', 'Generic Name', 'Strength', 'Dosage Form', 'Manufacturer', 'Notes']);
            fputcsv($handle, ['Paracetamol', 'Acetaminophen', '500mg', 'Tablet', 'Square Pharmaceuticals', 'Common pain reliever']);
            fputcsv($handle, ['Amoxicillin', 'Amoxicillin', '250mg', 'Capsule', 'Beximco Pharmaceuticals', 'Antibiotic']);
            fputcsv($handle, ['Omeprazole', 'Omeprazole', '20mg', 'Capsule', 'Incepta Pharmaceuticals', 'Proton pump inhibitor']);
            fputcsv($handle, ['Metformin', 'Metformin HCL', '500mg', 'Tablet', 'Renata Limited', 'Diabetes medication']);
            fputcsv($handle, ['Aspirin', 'Acetylsalicylic Acid', '75mg', 'Tablet', 'ACI Limited', 'Blood thinner']);
            
            fclose($handle);
            exit;
        }

        if ($format === 'excel') {
            $filename = 'medicines_sample_template.xls';
            
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            
            echo '<table border="1">';
            echo '<thead><tr><th>Name</th><th>Generic Name</th><th>Strength</th><th>Dosage Form</th><th>Manufacturer</th><th>Notes</th></tr></thead>';
            echo '<tbody>';
            echo '<tr><td>Paracetamol</td><td>Acetaminophen</td><td>500mg</td><td>Tablet</td><td>Square Pharmaceuticals</td><td>Common pain reliever</td></tr>';
            echo '<tr><td>Amoxicillin</td><td>Amoxicillin</td><td>250mg</td><td>Capsule</td><td>Beximco Pharmaceuticals</td><td>Antibiotic</td></tr>';
            echo '<tr><td>Omeprazole</td><td>Omeprazole</td><td>20mg</td><td>Capsule</td><td>Incepta Pharmaceuticals</td><td>Proton pump inhibitor</td></tr>';
            echo '<tr><td>Metformin</td><td>Metformin HCL</td><td>500mg</td><td>Tablet</td><td>Renata Limited</td><td>Diabetes medication</td></tr>';
            echo '<tr><td>Aspirin</td><td>Acetylsalicylic Acid</td><td>75mg</td><td>Tablet</td><td>ACI Limited</td><td>Blood thinner</td></tr>';
            echo '</tbody></table>';
            exit;
        }

        return redirect()->route('admin.medicines.index');
    }

    public function import(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        // Increased max file size to 10MB
        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,txt,xls,xlsx', 'max:10240']
        ]);

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        
        $imported = 0;

        if (in_array($extension, ['csv', 'txt'])) {
            $handle = fopen($file->getRealPath(), 'r');
            $header = fgetcsv($handle); // Skip the header row
            
            $medicinesChunk = [];
            $chunkSize = 500; // Adjust based on your server memory

            while (($row = fgetcsv($handle)) !== false) {
                // Skip empty rows
                if (count($row) < 1 || empty($row[0])) continue;
                
                // Prepare array for bulk insert
                $medicinesChunk[] = [
                    'name' => $row[0] ?? '',
                    'generic_name' => $row[1] ?? null,
                    'strength' => $row[2] ?? null,
                    'dosage_form' => $row[3] ?? null,
                    'manufacturer' => $row[4] ?? null,
                    'notes' => $row[5] ?? null,
                    'created_at' => now(), // Required when using insert()
                    'updated_at' => now(),
                ];

                // When chunk size is reached, execute 1 bulk insert query
                if (count($medicinesChunk) >= $chunkSize) {
                    Medicine::insert($medicinesChunk);
                    $imported += count($medicinesChunk);
                    $medicinesChunk = []; // Reset the chunk
                }
            }
            
            // Insert any remaining records that didn't fill the last chunk
            if (!empty($medicinesChunk)) {
                Medicine::insert($medicinesChunk);
                $imported += count($medicinesChunk);
            }
            
            fclose($handle);
            
            return redirect()->route('admin.medicines.index')
                            ->with('success', "Successfully imported {$imported} medicines.");
        }

        return redirect()->route('admin.medicines.index')
                        ->with('error', 'Failed to import medicines. Please check your file format.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Search by name or email
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $users = $query->latest()->paginate(10)->withQueryString();
        
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required|numeric|unique:users',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'resumes.*' => 'mimes:pdf|max:5120',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

    
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('images', $imageName, 'public');
                
                UserDocument::create([
                    'user_id' => $user->id,
                    'file_type' => 'image',
                    'file_name' => $imagePath,
                ]);
            }
        }

        
        if ($request->hasFile('resumes')) {
            foreach ($request->file('resumes') as $resume) {
                $resumeName = time() . '_' . uniqid() . '.' . $resume->getClientOriginalExtension();
                $resumePath = $resume->storeAs('resumes', $resumeName, 'public');
                
                UserDocument::create([
                    'user_id' => $user->id,
                    'file_type' => 'resume',
                    'file_name' => $resumePath,
                ]);
            }
        }

    
        return redirect()->route('user.index')->with('success', 'User created successfully');  
    }

    public function show(User $user)
    {
        return view('admin.user.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
    
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id . ',id',
            'phone' => 'required|numeric|unique:users,phone,' . $user->id . ',id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'resumes.*' => 'mimes:pdf|max:5120',
        ]);

        $updated = $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        if ($request->hasFile('images')) {
            $oldImages = UserDocument::where('user_id', $user->id)
                ->where('file_type', 'image')
                ->get();
            
            foreach ($oldImages as $oldImage) {
                Storage::disk('public')->delete($oldImage->file_name);
                $oldImage->delete();
            }
            
            
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('images', $imageName, 'public');
                if ($imagePath) {
                    UserDocument::create([
                    'user_id' => $user->id,
                    'file_type' => 'image',
                    'file_name' => $imagePath,
                ]);
                }
            }
        }

        if ($request->hasFile('resumes')) {
            $oldResumes = UserDocument::where('user_id', $user->id)
                ->where('file_type', 'resume')
                ->get();
            
            foreach ($oldResumes as $oldResume) {
                Storage::disk('public')->delete($oldResume->file_name);
                $oldResume->delete();
            }
        
            foreach ($request->file('resumes') as $resume) {
                $resumeName = time() . '_' . uniqid() . '.' . $resume->getClientOriginalExtension();
                $resumePath = $resume->storeAs('resumes', $resumeName, 'public');
                if ($resumePath) {
                    UserDocument::create([
                        'user_id' => $user->id,
                        'file_type' => 'resume',
                        'file_name' => $resumePath,
                    ]);
                }
            }
        }

        return redirect()->route('user.show', $user)->with('success', 'User updated successfully');
            
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect()->route('user.index')->with('success', 'User deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('user.index')->with('error', 'User deletion failed: ' . $e->getMessage());
        }
    }

    public function exportPdf()
    {
        $users = User::all();
        $pdf = PDF::loadView('admin.user.export', compact('users'));
        return $pdf->download('users.pdf');
    }

    public function exportCsv()
    {
        $users = User::all();

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="users.csv"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['Name', 'Email', 'Phone']);
        foreach ($users as $user) {
            fputcsv($output, [$user->name, $user->email, $user->phone]);
        }
        fclose($output);
        exit;
    }

    public function uploadDetails(User $user)
    {
        return view('admin.user.upload_details', compact('user'));
    }
}

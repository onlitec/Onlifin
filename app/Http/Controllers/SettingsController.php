<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }

    public function users()
    {
        $users = User::with('roles')->paginate(10);
        return view('settings.users.index', compact('users'));
    }

    public function roles()
    {
        $roles = Role::with('permissions')->paginate(10);
        return view('settings.roles.index', compact('roles'));
    }

    public function permissions()
    {
        $permissions = Permission::paginate(10);
        return view('settings.permissions.index', compact('permissions'));
    }

    public function reports()
    {
        return view('settings.reports.index');
    }

    public function backup()
    {
        $backups = collect(glob(storage_path('app/backups/*')))->map(function ($file) {
            return [
                'name' => basename($file),
                'size' => round(filesize($file) / 1024 / 1024, 2), // MB
                'date' => date('Y-m-d H:i:s', filemtime($file))
            ];
        });

        return view('settings.backup.index', compact('backups'));
    }

    public function createBackup()
    {
        try {
            Artisan::call('backup:run');
            return redirect()->back()->with('success', 'Backup criado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao criar backup: ' . $e->getMessage());
        }
    }
} 
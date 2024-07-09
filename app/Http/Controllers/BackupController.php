<?php

namespace App\Http\Controllers;

use ZipArchive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function backup()
    {
         if (!Gate::allows('isAdministrator')) {
                return redirect('/');
            } 
        

        try {
            Artisan::call('backup:run');
            $output = Artisan::output();
            return back()->with('success','Data Berhasil di Backup');
        } catch (\Exception $e) {
            return back()->with('Failed','Data gagal di Backup');
        }
    }
    
    public function restore()
    {
        if (!Gate::allows('isAdministrator')) {
            return redirect('/');
        } 
        $backupDirectory = 'Project_Sistem_Informasi_Inventaris_Barang';
        $files = Storage::disk('local')->files($backupDirectory);

        $newestBackup = end($files);

        if ($newestBackup) {
        
            $backupPath = storage_path('app') . '/' . $newestBackup;

            $extractPath = storage_path('app/extracted_backup');
            $zip = new ZipArchive;
            if ($zip->open($backupPath) === TRUE) {
                $zip->extractTo($extractPath);
                $zip->close();
            } else {
                return back()->with('Failed', 'Gagal mengekstrak file ZIP.');
            }

            $sqlFiles = glob($extractPath . '/db-dumps/*.sql');

            if (count($sqlFiles) > 0) {
                $sqlFile = $sqlFiles[0];
                $sqlFile = str_replace('\\', '/', $sqlFile);

                $command = sprintf(
                    '"D:/laragon/bin/mysql/mysql-8.0.30-winx64/bin/mysql" -u %s -h %s %s < %s',
                    env('DB_USERNAME'),
                    env('DB_HOST'),
                    env('DB_DATABASE'),
                    $sqlFile
                );

                exec($command, $output, $returnCode);

                $output = shell_exec($command . ' 2>&1');

               
                if (!empty($output)) {
                    return back()->with('Failed', 'Gagal melakukan restore database. Silakan periksa log atau hubungi administrator.');
                }

               
                if ($returnCode !== 0) {
                    return back()->with('Failed', 'Gagal melakukan restore database. Silakan periksa log atau hubungi administrator.');
                }
                
                
                $sourcePath = storage_path('app/extracted_backup/laragon/www/pbl_siibala/storage/app/public');
                $destinationPath = storage_path('app/public');
                
                $this->replaceFiles($sourcePath, $destinationPath);
                

                Storage::deleteDirectory('extracted_backup');
                return back()->with('success', 'Database berhasil direstore dan file storage telah diperbarui.');

            } else {
                return back()->with('Failed', 'Tidak ditemukan file SQL yang valid dalam backup.');
            }
        }
        return back()->with('Failed', 'Tidak ada backup yang tersedia untuk direstore.');
    }

private function replaceFiles($source, $destination)
{
    if (!Gate::allows('isAdministrator')) {
                return redirect('/');
            } 
    $files = glob($source . '/*');
    
    foreach ($files as $file) {
        if (is_file($file)) {
            $destFile = $destination . '/' . basename($file);
            copy($file, $destFile);
        } elseif (is_dir($file)) {
            $destDir = $destination . '/' . basename($file);
            if (!is_dir($destDir)) {
                mkdir($destDir, 0755, true);
            }
            $this->replaceFiles($file, $destDir);
        }
    }
}

    
}
